<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MeditationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'category' => $this->category,
            'duration' => $this->duration,
            'audio_url' => $this->audio_url,
            'image_url' => $this->image_url,
            'voices' => $this->voices
                ->mapWithKeys(fn ($voice) => [$voice->id => $voice->pivot->audio_url])
                ->all(),
            'access_type' => $this->access_type,
            'sort_order' => $this->sort_order,
            'created_at' => $this->created_at?->format('Y-m-d\TH:i:s\Z'),
        ];
    }
}
