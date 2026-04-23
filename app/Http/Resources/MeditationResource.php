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
            'category_id' => $this->category_id,
            'category' => $this->category->name,
            'tags' => $this->tags,
            'duration' => $this->duration,
            'audio_url' => $this->audio_url,
            'image_url' => $this->image_url,
            'access_type' => $this->access_type,
            'preview_audio_url' => $this->preview_audio_url,
            'sort_order' => $this->sort_order,
            'created_at' => $this->created_at,
        ];
    }
}
