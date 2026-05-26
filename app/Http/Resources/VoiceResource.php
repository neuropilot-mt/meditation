<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VoiceResource extends JsonResource
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
            'display_name' => $this->display_name,
            'avatar_url' => $this->avatar_url,
            'description' => $this->description,
            'access_type' => $this->access_type,
            'sort_order' => $this->sort_order,
        ];
    }
}
