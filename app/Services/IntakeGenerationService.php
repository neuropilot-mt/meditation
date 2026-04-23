<?php

namespace App\Services;

use App\Jobs\ProcessGenerationRequestJob;
use App\Models\GenerationRequest;
use App\Models\IntakeSubmission;
use Illuminate\Support\Facades\DB;

class IntakeGenerationService
{
    public function __construct(
        private readonly MeditationPromptBuilder $promptBuilder,
        private readonly GenerationOrchestrator $generationOrchestrator,
    ) {}

    /**
     * @param  array<string, mixed>  $payload
     * @return array{intake: IntakeSubmission, image_request: GenerationRequest, audio_request: GenerationRequest}
     */
    public function createFromQuestionnaire(array $payload): array
    {
        $clientId = (string) data_get($payload, 'client_id');
        $questionnaire = [
            'age' => (int) data_get($payload, 'questionnaire.age'),
            'emotional_state' => (string) data_get($payload, 'questionnaire.emotional_state'),
            'preferences' => (string) data_get($payload, 'questionnaire.preferences', ''),
            'language' => (string) data_get($payload, 'questionnaire.language', 'en'),
            'target_duration_minutes' => (int) data_get($payload, 'questionnaire.target_duration_minutes', 10),
        ];

        $prompts = $this->promptBuilder->build($questionnaire);

        return DB::transaction(function () use ($payload, $clientId, $questionnaire, $prompts): array {
            $intake = IntakeSubmission::query()->create([
                'client_id' => $clientId,
                'age' => (int) $questionnaire['age'],
                'emotional_state' => (string) $questionnaire['emotional_state'],
                'preferences' => (string) $questionnaire['preferences'],
                'language' => (string) $questionnaire['language'],
                'target_duration_minutes' => (int) $questionnaire['target_duration_minutes'],
                'questionnaire' => $questionnaire,
                'image_prompt' => $prompts['image_prompt'],
                'audio_prompt' => $prompts['audio_prompt'],
            ]);

            $imageRequest = $this->generationOrchestrator->create([
                'client_id' => $clientId,
                'intake_submission_id' => $intake->id,
                'type' => GenerationRequest::TYPE_IMAGE,
                'purpose' => GenerationRequest::PURPOSE_IMAGE,
                'idempotency_key' => data_get($payload, 'idempotency_key')
                    ? data_get($payload, 'idempotency_key').':image'
                    : null,
                'input' => [
                    'prompt' => $prompts['image_prompt'],
                ],
                'options' => [
                    'provider' => data_get($payload, 'providers.image'),
                    'size' => data_get($payload, 'image_options.size', '1024x1024'),
                    'quality' => data_get($payload, 'image_options.quality', 'medium'),
                    'format' => data_get($payload, 'image_options.format', 'png'),
                ],
            ]);

            $audioRequest = $this->generationOrchestrator->create([
                'client_id' => $clientId,
                'intake_submission_id' => $intake->id,
                'type' => GenerationRequest::TYPE_AUDIO,
                'purpose' => GenerationRequest::PURPOSE_AUDIO,
                'idempotency_key' => data_get($payload, 'idempotency_key')
                    ? data_get($payload, 'idempotency_key').':audio'
                    : null,
                'input' => [
                    'text' => $prompts['audio_prompt'],
                    'voice_id' => data_get($payload, 'audio_options.voice_id'),
                ],
                'options' => [
                    'provider' => data_get($payload, 'providers.audio'),
                    'format' => data_get($payload, 'audio_options.format', 'mp3_44100_128'),
                    'model' => data_get($payload, 'audio_options.model', 'eleven_multilingual_v2'),
                ],
            ]);

            ProcessGenerationRequestJob::dispatch($imageRequest->id)->onQueue('image-generation');
            ProcessGenerationRequestJob::dispatch($audioRequest->id)->onQueue('audio-generation');

            return [
                'intake' => $intake,
                'image_request' => $imageRequest,
                'audio_request' => $audioRequest,
            ];
        });
    }
}
