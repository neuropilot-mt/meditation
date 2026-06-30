<?php

namespace App\Models;

use Database\Factories\MeditationFactory;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Meditation extends Model
{
    /** @use HasFactory<MeditationFactory> */
    use HasFactory;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'title',
        'description',
        'category',
        'duration',
        'audio_url',
        'image_url',
        'access_type',
        'sort_order',
    ];

    protected $casts = [
        'duration' => 'integer',
        'sort_order' => 'integer',
    ];

    public function voices(): BelongsToMany
    {
        return $this->belongsToMany(Voice::class)
            ->withPivot('audio_url', 'sort_order')
            ->withTimestamps()
            ->orderByPivot('sort_order');
    }

    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('Y-m-d\TH:i:s\Z');
    }
}
