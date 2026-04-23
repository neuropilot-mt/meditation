<?php

return [
    'storage' => [
        'disk' => env('AI_STORAGE_DISK', env('FILESYSTEM_DISK', 'local')),
        'base_path' => env('AI_STORAGE_BASE_PATH', 'generated'),
    ],

    'image' => [
        'default' => env('AI_IMAGE_DEFAULT_DRIVER', 'openai'),
        'fallbacks' => array_values(array_filter(array_map('trim', explode(',', (string) env('AI_IMAGE_FALLBACK_DRIVERS', ''))))),
        'drivers' => [
            'openai' => [
                'api_key' => env('OPENAI_API_KEY'),
                'model' => env('OPENAI_IMAGE_MODEL', 'gpt-image-1-mini'),
                'base_url' => env('OPENAI_BASE_URL', 'https://api.openai.com/v1'),
                'timeout' => (int) env('OPENAI_TIMEOUT', 90),
            ],
        ],
    ],

    'audio' => [
        'default' => env('AI_AUDIO_DEFAULT_DRIVER', 'elevenlabs'),
        'fallbacks' => array_values(array_filter(array_map('trim', explode(',', (string) env('AI_AUDIO_FALLBACK_DRIVERS', ''))))),
        'drivers' => [
            'elevenlabs' => [
                'api_key' => env('ELEVENLABS_API_KEY'),
                'base_url' => env('ELEVENLABS_BASE_URL', 'https://api.elevenlabs.io/v1'),
                'default_voice_id' => env('ELEVENLABS_DEFAULT_VOICE_ID'),
                'default_model' => env('ELEVENLABS_DEFAULT_MODEL', 'eleven_multilingual_v2'),
                'default_output_format' => env('ELEVENLABS_DEFAULT_OUTPUT_FORMAT', 'mp3_44100_128'),
                'timeout' => (int) env('ELEVENLABS_TIMEOUT', 90),
            ],
        ],
    ],
];
