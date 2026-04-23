<?php

namespace App\AI\Drivers;

use App\AI\Contracts\ImageGenerator;
use App\AI\DTO\GeneratedAssetData;
use App\AI\DTO\ImageGenerationRequestData;
use App\AI\Exceptions\AiProviderException;
use Illuminate\Support\Facades\Http;

class OpenAIImageDriver implements ImageGenerator
{
    public function __construct(
        private readonly string $apiKey,
        private readonly string $model,
        private readonly string $baseUrl,
        private readonly int $timeoutSeconds = 90,
    ) {}

    public function generate(ImageGenerationRequestData $requestData): GeneratedAssetData
    {
        if (blank($this->apiKey)) {
            throw new AiProviderException('OpenAI API key is not configured.');
        }

        $payload = [
            'model' => $this->model,
            'prompt' => $requestData->prompt,
            'size' => $requestData->size,
            'quality' => $requestData->quality,
            'response_format' => 'b64_json',
        ];

        $response = Http::baseUrl($this->baseUrl)
            ->withToken($this->apiKey)
            ->timeout($this->timeoutSeconds)
            ->acceptJson()
            ->post('/images/generations', $payload);

        if (! $response->successful()) {
            throw new AiProviderException(
                message: 'OpenAI image generation request failed.',
                statusCode: $response->status(),
                context: ['response' => $response->json()],
            );
        }

        $encodedImage = $response->json('data.0.b64_json');

        if (! is_string($encodedImage) || $encodedImage === '') {
            throw new AiProviderException('OpenAI response does not contain image bytes.');
        }

        $decoded = base64_decode($encodedImage, true);
        if ($decoded === false) {
            throw new AiProviderException('Failed to decode OpenAI image bytes.');
        }

        return new GeneratedAssetData(
            provider: 'openai',
            binaryContent: $decoded,
            mimeType: 'image/png',
            extension: 'png',
            metadata: [
                'model' => $this->model,
                'size' => $requestData->size,
                'quality' => $requestData->quality,
                'revised_prompt' => $response->json('data.0.revised_prompt'),
            ],
            providerRequest: $payload,
            providerResponse: [
                'created' => $response->json('created'),
            ],
        );
    }
}
