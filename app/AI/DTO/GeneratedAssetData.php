<?php

namespace App\AI\DTO;

final readonly class GeneratedAssetData
{
    /**
     * @param  array<string, mixed>  $metadata
     * @param  array<string, mixed>|null  $providerRequest
     * @param  array<string, mixed>|null  $providerResponse
     */
    public function __construct(
        public string $provider,
        public string $binaryContent,
        public string $mimeType,
        public string $extension,
        public array $metadata = [],
        public ?array $providerRequest = null,
        public ?array $providerResponse = null,
    ) {}
}
