<?php

namespace App\Services;

final class MeditationPromptBuilder
{
    /**
     * @param  array<string, mixed>  $questionnaire
     * @return array{image_prompt: string, audio_prompt: string}
     */
    public function build(array $questionnaire): array
    {
        $age = (int) data_get($questionnaire, 'age');
        $state = (string) data_get($questionnaire, 'emotional_state');
        $preferences = (string) data_get($questionnaire, 'preferences', 'nature atmosphere');
        $language = (string) data_get($questionnaire, 'language', 'en');
        $duration = (int) data_get($questionnaire, 'target_duration_minutes', 10);

        $imagePrompt = sprintf(
            'Calm meditation artwork for a %d-year-old user. Emotional state: %s. Preferences: %s. Soft natural lighting, peaceful composition, minimalistic, no text, high detail.',
            $age,
            $state,
            $preferences
        );

        $audioPrompt = $this->buildAudioScript(
            age: $age,
            state: $state,
            preferences: $preferences,
            language: $language,
            duration: $duration,
        );

        return [
            'image_prompt' => $imagePrompt,
            'audio_prompt' => $audioPrompt,
        ];
    }

    private function buildAudioScript(
        int $age,
        string $state,
        string $preferences,
        string $language,
        int $duration,
    ): string {
        if ($language === 'ru') {
            return sprintf(
                'Сядьте удобно и мягко закройте глаза. Сделайте медленный вдох через нос и длинный выдох. '.
                'Сейчас вы можете отпустить текущее состояние: %s. Представьте спокойное пространство, которое вам близко: %s. '.
                'Почувствуйте, как тело становится тяжелее и расслабляется. С каждым выдохом отпускайте напряжение из плеч, лица и груди. '.
                'Сделайте паузу и просто наблюдайте дыхание. Если мысли уводят внимание, мягко возвращайтесь к вдоху и выдоху. '.
                'Эта практика рассчитана примерно на %d минут. В завершение поблагодарите себя за заботу о себе. '.
                'Сделайте более глубокий вдох, выдох и плавно откройте глаза.',
                $state,
                $preferences,
                $duration
            );
        }

        return sprintf(
            'Sit comfortably and gently close your eyes. Take a slow inhale through the nose and a long exhale. '.
            'For this moment, allow your current emotional state, %s, to soften. Imagine a calm place shaped by your preferences: %s. '.
            'Feel your body getting heavier and more relaxed. With each exhale, release tension from your jaw, shoulders, and chest. '.
            'Stay with the natural rhythm of your breath. If your attention drifts, kindly bring it back to breathing. '.
            'This practice is designed for about %d minutes and tailored for a %d-year-old listener. '.
            'To finish, take one deeper breath in, breathe out slowly, and open your eyes when ready.',
            $state,
            $preferences,
            $duration,
            $age
        );
    }
}
