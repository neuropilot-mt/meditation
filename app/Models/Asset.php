<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Asset extends Model
{
    protected $fillable = [
        'public_id',
        'generation_request_id',
        'type',
        'provider',
        'disk',
        'path',
        'mime_type',
        'size_bytes',
        'duration_ms',
        'width',
        'height',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $model): void {
            if (blank($model->public_id)) {
                $model->public_id = (string) Str::ulid();
            }
        });
    }

    public function generationRequest(): BelongsTo
    {
        return $this->belongsTo(GenerationRequest::class);
    }
}
