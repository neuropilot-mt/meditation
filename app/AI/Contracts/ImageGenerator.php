<?php

namespace App\AI\Contracts;

use App\AI\DTO\GeneratedAssetData;
use App\AI\DTO\ImageGenerationRequestData;

interface ImageGenerator
{
    public function generate(ImageGenerationRequestData $requestData): GeneratedAssetData;
}
