<?php

namespace App\AI\DTO;

final readonly class ImageGenerationRequestData
{
    public function __construct(
        public string $prompt,
        public string $size = '1024x1024',
        public string $quality = 'medium',
        public string $format = 'png',
    ) {}
}
