<?php

namespace App\Models;

use Database\Factories\VoiceFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voice extends Model
{
    /** @use HasFactory<VoiceFactory> */
    use HasFactory;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'display_name',
        'avatar_url',
        'description',
        'access_type',
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];
}
