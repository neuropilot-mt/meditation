<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class GenerationRequest extends Model
{
    public const TYPE_IMAGE = 'image';

    public const TYPE_AUDIO = 'audio';

    public const PURPOSE_IMAGE = 'meditation_image';

    public const PURPOSE_AUDIO = 'meditation_audio';

    public const STATUS_QUEUED = 'queued';

    public const STATUS_PROCESSING = 'processing';

    public const STATUS_COMPLETED = 'completed';

    public const STATUS_FAILED = 'failed';

    protected $fillable = [
        'public_id',
        'client_id',
        'intake_submission_id',
        'idempotency_key',
        'type',
        'purpose',
        'status',
        'provider_preference',
        'selected_provider',
        'input',
        'options',
        'webhook_url',
        'result_asset_id',
        'error_code',
        'error_message',
        'attempts',
        'started_at',
        'completed_at',
    ];

    protected $casts = [
        'input' => 'array',
        'options' => 'array',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $model): void {
            if (blank($model->public_id)) {
                $model->public_id = (string) Str::ulid();
            }
        });
    }

    public function resultAsset(): BelongsTo
    {
        return $this->belongsTo(Asset::class, 'result_asset_id');
    }

    public function intakeSubmission(): BelongsTo
    {
        return $this->belongsTo(IntakeSubmission::class);
    }

    public function assets(): HasMany
    {
        return $this->hasMany(Asset::class);
    }

    public function providerCalls(): HasMany
    {
        return $this->hasMany(ProviderCall::class);
    }
}
