<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGenerationRequest;
use App\Http\Resources\GenerationRequestResource;
use App\Jobs\ProcessGenerationRequestJob;
use App\Models\GenerationRequest;
use App\Services\GenerationOrchestrator;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class GenerationController extends Controller
{
    public function store(StoreGenerationRequest $request, GenerationOrchestrator $orchestrator): JsonResponse
    {
        $generationRequest = $orchestrator->create($request->validated());

        if ($generationRequest->status === GenerationRequest::STATUS_QUEUED) {
            ProcessGenerationRequestJob::dispatch($generationRequest->id)
                ->onQueue($generationRequest->type === GenerationRequest::TYPE_IMAGE ? 'image-generation' : 'audio-generation');
        }

        $generationRequest->load('resultAsset');

        return response()->json([
            'data' => new GenerationRequestResource($generationRequest),
            'meta' => [
                'poll_after_ms' => 2000,
            ],
        ], 202);
    }

    public function show(string $requestId): JsonResponse
    {
        $generationRequest = GenerationRequest::query()
            ->where('public_id', $requestId)
            ->with('resultAsset')
            ->firstOrFail();

        return response()->json([
            'data' => new GenerationRequestResource($generationRequest),
        ]);
    }

    public function result(string $requestId): JsonResponse
    {
        $generationRequest = GenerationRequest::query()
            ->where('public_id', $requestId)
            ->with('resultAsset')
            ->firstOrFail();

        if ($generationRequest->status !== GenerationRequest::STATUS_COMPLETED || $generationRequest->resultAsset === null) {
            return response()->json([
                'error' => 'result_not_ready',
            ], 409);
        }

        return response()->json([
            'data' => [
                'asset_id' => $generationRequest->resultAsset->public_id,
                'download_url' => route('assets.download', ['assetId' => $generationRequest->resultAsset->public_id]),
            ],
        ]);
    }

    public function retry(string $requestId, GenerationOrchestrator $orchestrator): JsonResponse
    {
        $generationRequest = GenerationRequest::query()
            ->where('public_id', $requestId)
            ->firstOrFail();

        $generationRequest = $orchestrator->retry($generationRequest);
        ProcessGenerationRequestJob::dispatch($generationRequest->id)
            ->onQueue($generationRequest->type === GenerationRequest::TYPE_IMAGE ? 'image-generation' : 'audio-generation');

        return response()->json([
            'data' => new GenerationRequestResource($generationRequest),
        ], 202);
    }

    public function events(string $requestId): StreamedResponse
    {
        $generationRequest = GenerationRequest::query()
            ->where('public_id', $requestId)
            ->firstOrFail();

        return response()->stream(function () use ($generationRequest): void {
            $started = microtime(true);

            while (microtime(true) - $started < 30) {
                $fresh = $generationRequest->fresh(['resultAsset']);
                if ($fresh === null) {
                    break;
                }

                echo "event: generation.update\n";
                echo 'data: '.json_encode((new GenerationRequestResource($fresh))->resolve())."\n\n";
                if (ob_get_level() > 0) {
                    ob_flush();
                }
                flush();

                if (in_array($fresh->status, [GenerationRequest::STATUS_COMPLETED, GenerationRequest::STATUS_FAILED], true)) {
                    break;
                }

                usleep(1_500_000);
            }
        }, 200, [
            'Cache-Control' => 'no-cache',
            'Connection' => 'keep-alive',
            'Content-Type' => 'text/event-stream',
            'X-Accel-Buffering' => 'no',
        ]);
    }
}
