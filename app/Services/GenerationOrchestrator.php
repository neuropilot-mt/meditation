<?php

namespace App\Services;

use App\AI\AiManager;
use App\AI\DTO\AudioGenerationRequestData;
use App\AI\DTO\ImageGenerationRequestData;
use App\AI\Exceptions\AiProviderException;
use App\Models\Asset;
use App\Models\GenerationRequest;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Throwable;

class GenerationOrchestrator
{
    public function __construct(
        private readonly AiManager $aiManager,
    ) {}

    /**
     * @param  array<string, mixed>  $payload
     */
    public function create(array $payload): GenerationRequest
    {
        $idempotencyKey = data_get($payload, 'idempotency_key');
        $clientId = (string) data_get($payload, 'client_id');

        if (filled($idempotencyKey)) {
            $existing = GenerationRequest::query()
                ->where('client_id', $clientId)
                ->where('idempotency_key', $idempotencyKey)
                ->first();

            if ($existing !== null) {
                return $existing;
            }
        }

        return GenerationRequest::query()->create([
            'client_id' => $clientId,
            'intake_submission_id' => data_get($payload, 'intake_submission_id'),
            'idempotency_key' => $idempotencyKey,
            'type' => data_get($payload, 'type'),
            'purpose' => data_get($payload, 'purpose'),
            'status' => GenerationRequest::STATUS_QUEUED,
            'provider_preference' => data_get($payload, 'options.provider'),
            'input' => data_get($payload, 'input', []),
            'options' => data_get($payload, 'options', []),
            'webhook_url' => data_get($payload, 'webhook_url'),
        ]);
    }

    public function processById(int $generationRequestId): void
    {
        $generationRequest = GenerationRequest::query()->find($generationRequestId);
        if ($generationRequest === null) {
            return;
        }

        $this->process($generationRequest);
    }

    public function process(GenerationRequest $generationRequest): GenerationRequest
    {
        if (in_array($generationRequest->status, [GenerationRequest::STATUS_COMPLETED, GenerationRequest::STATUS_PROCESSING], true)) {
            return $generationRequest;
        }

        $generationRequest->forceFill([
            'status' => GenerationRequest::STATUS_PROCESSING,
            'error_code' => null,
            'error_message' => null,
            'started_at' => now(),
            'attempts' => $generationRequest->attempts + 1,
        ])->save();

        $drivers = $this->aiManager->candidates($generationRequest->type, $generationRequest->provider_preference);
        $lastError = 'No AI provider configured.';

        foreach ($drivers as $driverName) {
            $startedAt = microtime(true);

            try {
                $assetData = $generationRequest->type === GenerationRequest::TYPE_IMAGE
                    ? $this->aiManager->image($driverName)->generate($this->imageDto($generationRequest))
                    : $this->aiManager->audio($driverName)->synthesize($this->audioDto($generationRequest));

                $latencyMs = (int) round((microtime(true) - $startedAt) * 1000);

                $asset = DB::transaction(function () use ($generationRequest, $assetData, $latencyMs): Asset {
                    $disk = (string) config('ai.storage.disk', config('filesystems.default'));
                    $basePath = trim((string) config('ai.storage.base_path', 'generated'), '/');
                    $path = sprintf(
                        '%s/%s/%s/%s.%s',
                        $basePath,
                        $generationRequest->type,
                        now()->format('Y/m/d'),
                        $generationRequest->public_id,
                        $assetData->extension
                    );

                    Storage::disk($disk)->put($path, $assetData->binaryContent);

                    $asset = Asset::query()->create([
                        'generation_request_id' => $generationRequest->id,
                        'type' => $generationRequest->type,
                        'provider' => $assetData->provider,
                        'disk' => $disk,
                        'path' => $path,
                        'mime_type' => $assetData->mimeType,
                        'size_bytes' => strlen($assetData->binaryContent),
                        'duration_ms' => data_get($assetData->metadata, 'duration_ms'),
                        'width' => data_get($assetData->metadata, 'width'),
                        'height' => data_get($assetData->metadata, 'height'),
                        'metadata' => $assetData->metadata,
                    ]);

                    $generationRequest->providerCalls()->create([
                        'provider' => $assetData->provider,
                        'operation' => $generationRequest->type === GenerationRequest::TYPE_IMAGE ? 'image.generate' : 'audio.synthesize',
                        'status' => 'success',
                        'latency_ms' => $latencyMs,
                        'request_payload' => $assetData->providerRequest,
                        'response_payload' => $assetData->providerResponse,
                        'attempted_at' => Carbon::now(),
                    ]);

                    $generationRequest->forceFill([
                        'status' => GenerationRequest::STATUS_COMPLETED,
                        'selected_provider' => $assetData->provider,
                        'result_asset_id' => $asset->id,
                        'completed_at' => now(),
                    ])->save();

                    return $asset;
                });

                $generationRequest->setRelation('resultAsset', $asset);

                return $generationRequest->fresh(['resultAsset']);
            } catch (AiProviderException $exception) {
                $lastError = $exception->getMessage();
                $this->recordFailure($generationRequest, $driverName, $startedAt, $exception->context, $exception->getMessage());
            } catch (Throwable $exception) {
                $lastError = $exception->getMessage();
                $this->recordFailure($generationRequest, $driverName, $startedAt, null, $exception->getMessage());
                Log::error('AI generation failed with unexpected error', [
                    'request_id' => $generationRequest->public_id,
                    'driver' => $driverName,
                    'exception' => $exception,
                ]);
            }
        }

        $generationRequest->forceFill([
            'status' => GenerationRequest::STATUS_FAILED,
            'error_code' => 'provider_failed',
            'error_message' => $lastError,
            'completed_at' => now(),
        ])->save();

        return $generationRequest;
    }

    public function retry(GenerationRequest $generationRequest): GenerationRequest
    {
        $generationRequest->forceFill([
            'status' => GenerationRequest::STATUS_QUEUED,
            'error_code' => null,
            'error_message' => null,
            'selected_provider' => null,
            'result_asset_id' => null,
            'completed_at' => null,
        ])->save();

        return $generationRequest;
    }

    private function imageDto(GenerationRequest $generationRequest): ImageGenerationRequestData
    {
        return new ImageGenerationRequestData(
            prompt: (string) data_get($generationRequest->input, 'prompt', ''),
            size: (string) data_get($generationRequest->options, 'size', '1024x1024'),
            quality: (string) data_get($generationRequest->options, 'quality', 'medium'),
            format: (string) data_get($generationRequest->options, 'format', 'png'),
        );
    }

    private function audioDto(GenerationRequest $generationRequest): AudioGenerationRequestData
    {
        return new AudioGenerationRequestData(
            text: (string) data_get($generationRequest->input, 'text', ''),
            voiceId: data_get($generationRequest->input, 'voice_id'),
            format: (string) data_get($generationRequest->options, 'format', 'mp3_44100_128'),
            model: (string) data_get($generationRequest->options, 'model', 'eleven_multilingual_v2'),
        );
    }

    /**
     * @param  array<string, mixed>|null  $providerResponse
     */
    private function recordFailure(
        GenerationRequest $generationRequest,
        string $driverName,
        float $startedAt,
        ?array $providerResponse,
        string $errorMessage,
    ): void {
        $generationRequest->providerCalls()->create([
            'provider' => $driverName,
            'operation' => $generationRequest->type === GenerationRequest::TYPE_IMAGE ? 'image.generate' : 'audio.synthesize',
            'status' => 'failed',
            'latency_ms' => (int) round((microtime(true) - $startedAt) * 1000),
            'response_payload' => $providerResponse,
            'error_message' => $errorMessage,
            'attempted_at' => Carbon::now(),
        ]);
    }
}
