# Meditation AI Backend MVP (Laravel)

MVP backend for meditation content generation with:
- image generation via `OpenAIImageDriver`
- audio generation via `ElevenLabsAudioDriver`
- async processing via Laravel Queue
- polling + SSE status updates
- intake questionnaire to auto-build prompts for both image and audio

## Quick Start

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan queue:work --queue=image-generation,audio-generation
php artisan serve
```

## Required ENV

```dotenv
OPENAI_API_KEY=...
ELEVENLABS_API_KEY=...
ELEVENLABS_DEFAULT_VOICE_ID=...
```

Optional:

```dotenv
AI_STORAGE_DISK=local
AI_STORAGE_BASE_PATH=generated
OPENAI_IMAGE_MODEL=gpt-image-1-mini
ELEVENLABS_DEFAULT_MODEL=eleven_multilingual_v2
```

## API Endpoints

- `POST /api/v1/intakes` - submit questionnaire and launch image+audio generation
- `GET /api/v1/intakes/{intakeId}` - aggregated status for both generation tasks
- `POST /api/v1/generations` - create generation request
- `GET /api/v1/generations/{requestId}` - get request status
- `GET /api/v1/generations/{requestId}/result` - get result link when completed
- `POST /api/v1/generations/{requestId}/retry` - retry failed request
- `GET /api/v1/generations/{requestId}/events` - SSE status stream
- `GET /api/v1/assets/{assetId}` - asset metadata
- `GET /api/v1/assets/{assetId}/download` - asset binary download

## Create Request Example

```bash
curl -X POST http://127.0.0.1:8000/api/v1/intakes \
  -H "Content-Type: application/json" \
  -d '{
    "client_id": "mobile-ios",
    "idempotency_key": "req-001",
    "questionnaire": {
      "age": 29,
      "emotional_state": "stressed",
      "preferences": "forest sounds, gentle female voice",
      "language": "en",
      "target_duration_minutes": 10
    },
    "providers": {
      "image": "openai",
      "audio": "elevenlabs"
    }
  }'
```

## Architecture Notes

- `app/AI` - provider contracts, DTOs, drivers, `AiManager`
- `app/Services/MeditationPromptBuilder.php` - prompt generation from intake answers
- `app/Services/IntakeGenerationService.php` - intake to image+audio generation orchestration
- `app/Services/GenerationOrchestrator.php` - business flow + provider fallback
- `app/Jobs/ProcessGenerationRequestJob.php` - async worker entry point
- `app/Http/Controllers/Api` - REST and SSE endpoints
- `database/migrations` - generation requests, assets, provider calls
