<?php

namespace App\AI;

use App\AI\Contracts\AudioGenerator;
use App\AI\Contracts\ImageGenerator;
use App\AI\Drivers\ElevenLabsAudioDriver;
use App\AI\Drivers\OpenAIImageDriver;
use InvalidArgumentException;

class AiManager
{
    /**
     * @param  array<string, mixed>  $config
     */
    public function __construct(
        private readonly array $config,
    ) {}

    public function image(string $driver): ImageGenerator
    {
        return match ($driver) {
            'openai' => new OpenAIImageDriver(
                apiKey: (string) data_get($this->config, 'image.drivers.openai.api_key', ''),
                model: (string) data_get($this->config, 'image.drivers.openai.model', 'gpt-image-1-mini'),
                baseUrl: (string) data_get($this->config, 'image.drivers.openai.base_url', 'https://api.openai.com/v1'),
                timeoutSeconds: (int) data_get($this->config, 'image.drivers.openai.timeout', 90),
            ),
            default => throw new InvalidArgumentException("Unsupported image driver [{$driver}]"),
        };
    }

    public function audio(string $driver): AudioGenerator
    {
        return match ($driver) {
            'elevenlabs' => new ElevenLabsAudioDriver(
                apiKey: (string) data_get($this->config, 'audio.drivers.elevenlabs.api_key', ''),
                baseUrl: (string) data_get($this->config, 'audio.drivers.elevenlabs.base_url', 'https://api.elevenlabs.io/v1'),
                defaultVoiceId: (string) data_get($this->config, 'audio.drivers.elevenlabs.default_voice_id', ''),
                defaultModel: (string) data_get($this->config, 'audio.drivers.elevenlabs.default_model', 'eleven_multilingual_v2'),
                defaultOutputFormat: (string) data_get($this->config, 'audio.drivers.elevenlabs.default_output_format', 'mp3_44100_128'),
                timeoutSeconds: (int) data_get($this->config, 'audio.drivers.elevenlabs.timeout', 90),
            ),
            default => throw new InvalidArgumentException("Unsupported audio driver [{$driver}]"),
        };
    }

    /**
     * @return list<string>
     */
    public function candidates(string $type, ?string $preferredDriver = null): array
    {
        $root = $type === 'image' ? 'image' : 'audio';

        $default = (string) data_get($this->config, "{$root}.default");
        $fallbacks = data_get($this->config, "{$root}.fallbacks", []);
        $all = array_values(array_filter([$preferredDriver, $default, ...$fallbacks]));

        return array_values(array_unique($all));
    }
}
