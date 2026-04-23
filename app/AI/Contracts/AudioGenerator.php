<?php

namespace App\AI\Contracts;

use App\AI\DTO\AudioGenerationRequestData;
use App\AI\DTO\GeneratedAssetData;

interface AudioGenerator
{
    public function synthesize(AudioGenerationRequestData $requestData): GeneratedAssetData;
}
