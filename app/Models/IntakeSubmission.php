<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class IntakeSubmission extends Model
{
    protected $fillable = [
        'public_id',
        'client_id',
        'age',
        'emotional_state',
        'preferences',
        'language',
        'target_duration_minutes',
        'questionnaire',
        'image_prompt',
        'audio_prompt',
    ];

    protected $casts = [
        'questionnaire' => 'array',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $model): void {
            if (blank($model->public_id)) {
                $model->public_id = (string) Str::ulid();
            }
        });
    }

    public function generationRequests(): HasMany
    {
        return $this->hasMany(GenerationRequest::class);
    }
}
