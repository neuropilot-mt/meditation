<?php

namespace App\Http\Resources;

use App\Models\GenerationRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IntakeSubmissionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $generationRequests = $this->relationLoaded('generationRequests')
            ? $this->generationRequests
            : collect();

        $imageRequest = $generationRequests?->firstWhere('type', GenerationRequest::TYPE_IMAGE);
        $audioRequest = $generationRequests?->firstWhere('type', GenerationRequest::TYPE_AUDIO);

        $isReady = $imageRequest?->status === GenerationRequest::STATUS_COMPLETED
            && $audioRequest?->status === GenerationRequest::STATUS_COMPLETED;

        return [
            'intake_id' => $this->public_id,
            'client_id' => $this->client_id,
            'questionnaire' => [
                'age' => $this->age,
                'emotional_state' => $this->emotional_state,
                'preferences' => $this->preferences,
                'language' => $this->language,
                'target_duration_minutes' => $this->target_duration_minutes,
            ],
            'prompts' => [
                'image_prompt' => $this->image_prompt,
                'audio_prompt' => $this->audio_prompt,
            ],
            'generation' => [
                'is_ready' => $isReady,
                'image' => $imageRequest ? [
                    'request_id' => $imageRequest->public_id,
                    'status' => $imageRequest->status,
                    'result_url' => $imageRequest->resultAsset ? route('assets.download', ['assetId' => $imageRequest->resultAsset->public_id]) : null,
                    'poll_url' => route('generations.show', ['requestId' => $imageRequest->public_id]),
                ] : null,
                'audio' => $audioRequest ? [
                    'request_id' => $audioRequest->public_id,
                    'status' => $audioRequest->status,
                    'result_url' => $audioRequest->resultAsset ? route('assets.download', ['assetId' => $audioRequest->resultAsset->public_id]) : null,
                    'poll_url' => route('generations.show', ['requestId' => $audioRequest->public_id]),
                ] : null,
            ],
            'created_at' => optional($this->created_at)?->toIso8601String(),
        ];
    }
}
