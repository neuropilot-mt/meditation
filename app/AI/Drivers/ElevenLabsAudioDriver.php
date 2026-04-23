<?php

namespace App\AI\Drivers;

use App\AI\Contracts\AudioGenerator;
use App\AI\DTO\AudioGenerationRequestData;
use App\AI\DTO\GeneratedAssetData;
use App\AI\Exceptions\AiProviderException;
use Illuminate\Support\Facades\Http;

class ElevenLabsAudioDriver implements AudioGenerator
{
    public function __construct(
        private readonly string $apiKey,
        private readonly string $baseUrl,
        private readonly string $defaultVoiceId,
        private readonly string $defaultModel,
        private readonly string $defaultOutputFormat,
        private readonly int $timeoutSeconds = 90,
    ) {}

    public function synthesize(AudioGenerationRequestData $requestData): GeneratedAssetData
    {
        if (blank($this->apiKey)) {
            throw new AiProviderException('ElevenLabs API key is not configured.');
        }

        $voiceId = $requestData->voiceId ?: $this->defaultVoiceId;
        if (blank($voiceId)) {
            throw new AiProviderException('ElevenLabs voice ID is not configured.');
        }

        $outputFormat = $requestData->format ?: $this->defaultOutputFormat;
        $model = $requestData->model ?: $this->defaultModel;

        $payload = [
            'text' => $requestData->text,
            'model_id' => $model,
        ];

        $response = Http::baseUrl($this->baseUrl)
            ->withHeaders([
                'xi-api-key' => $this->apiKey,
                'Accept' => 'audio/mpeg',
            ])
            ->timeout($this->timeoutSeconds)
            ->post("/text-to-speech/{$voiceId}", [
                ...$payload,
                'output_format' => $outputFormat,
            ]);

        if (! $response->successful()) {
            throw new AiProviderException(
                message: 'ElevenLabs text-to-speech request failed.',
                statusCode: $response->status(),
                context: ['response' => $response->json()],
            );
        }

        $audioBytes = $response->body();
        if ($audioBytes === '') {
            throw new AiProviderException('ElevenLabs returned an empty audio body.');
        }

        return new GeneratedAssetData(
            provider: 'elevenlabs',
            binaryContent: $audioBytes,
            mimeType: 'audio/mpeg',
            extension: 'mp3',
            metadata: [
                'model' => $model,
                'voice_id' => $voiceId,
                'output_format' => $outputFormat,
            ],
            providerRequest: [
                ...$payload,
                'voice_id' => $voiceId,
                'output_format' => $outputFormat,
            ],
            providerResponse: [
                'status' => $response->status(),
                'content_length' => strlen($audioBytes),
            ],
        );
    }
}
