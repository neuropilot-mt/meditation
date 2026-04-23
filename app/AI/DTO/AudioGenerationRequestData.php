<?php

namespace App\AI\DTO;

final readonly class AudioGenerationRequestData
{
    public function __construct(
        public string $text,
        public ?string $voiceId = null,
        public string $format = 'mp3_44100_128',
        public string $model = 'eleven_multilingual_v2',
    ) {}
}
