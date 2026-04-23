<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GenerationRequestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'request_id' => $this->public_id,
            'client_id' => $this->client_id,
            'intake_submission_id' => $this->intake_submission_id,
            'type' => $this->type,
            'purpose' => $this->purpose,
            'status' => $this->status,
            'selected_provider' => $this->selected_provider,
            'attempts' => $this->attempts,
            'error' => $this->status === 'failed' ? [
                'code' => $this->error_code,
                'message' => $this->error_message,
            ] : null,
            'result' => $this->when($this->relationLoaded('resultAsset') && $this->resultAsset !== null, function (): array {
                return [
                    'asset_id' => $this->resultAsset->public_id,
                    'type' => $this->resultAsset->type,
                    'provider' => $this->resultAsset->provider,
                    'mime_type' => $this->resultAsset->mime_type,
                    'size_bytes' => $this->resultAsset->size_bytes,
                    'download_url' => route('assets.download', ['assetId' => $this->resultAsset->public_id]),
                ];
            }),
            'timestamps' => [
                'created_at' => optional($this->created_at)?->toIso8601String(),
                'started_at' => optional($this->started_at)?->toIso8601String(),
                'completed_at' => optional($this->completed_at)?->toIso8601String(),
            ],
        ];
    }
}
