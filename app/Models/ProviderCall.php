<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProviderCall extends Model
{
    protected $fillable = [
        'generation_request_id',
        'provider',
        'operation',
        'status',
        'latency_ms',
        'request_payload',
        'response_payload',
        'error_message',
        'attempted_at',
    ];

    protected $casts = [
        'request_payload' => 'array',
        'response_payload' => 'array',
        'attempted_at' => 'datetime',
    ];

    public function generationRequest(): BelongsTo
    {
        return $this->belongsTo(GenerationRequest::class);
    }
}
