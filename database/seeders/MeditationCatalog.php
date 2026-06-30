<?php

namespace Database\Seeders;

final class MeditationCatalog
{
    public static function baseUrl(): string
    {
        return 'https://fls-a1f95989-3ceb-4c1f-9c84-418c462b7dbe.laravel.cloud';
    }

    /**
     * @return array<int, array{id: string, display_name: string, avatar_url: string, description: string, access_type: string, sort_order: int}>
     */
    public static function voices(): array
    {
        $baseUrl = self::baseUrl();

        return [
            [
                'id' => 'nicole',
                'display_name' => 'Nicole',
                'avatar_url' => "{$baseUrl}/avatars/nicole.png",
                'description' => 'Soft-spoken, contemplative voice.',
                'access_type' => 'free',
                'sort_order' => 1,
            ],
            [
                'id' => 'almee',
                'display_name' => 'Almee',
                'avatar_url' => "{$baseUrl}/avatars/almee.png",
                'description' => 'Warm, calming female voice.',
                'access_type' => 'free',
                'sort_order' => 2,
            ],
            [
                'id' => 'theo',
                'display_name' => 'Theo',
                'avatar_url' => "{$baseUrl}/avatars/theo.png",
                'description' => 'Grounded, reassuring male voice.',
                'access_type' => 'free',
                'sort_order' => 3,
            ],
        ];
    }

    /**
     * @return array<int, array{id: string, title: string, description: string, category: string, duration: int, audio_url: string, image_url: string, voices: array{nicole: string, almee: string, theo: string}, access_type: string, sort_order: int}>
     */
    public static function meditations(): array
    {
        $baseUrl = self::baseUrl();

        return [
            [
                'id' => 'w001',
                'title' => 'Sleep',
                'description' => 'sleep',
                'category' => 'sleep',
                'duration' => 392,
                'audio_url' => "{$baseUrl}/meditations/sleep/no_voice/sleep_no_voice_1.MP3",
                'image_url' => "{$baseUrl}/avatars/sleep_main.jpg",
                'voices' => [
                    'nicole' => "{$baseUrl}/meditations/sleep/female/nicole/sleep_nicole_voice.MP3",
                    'almee' => "{$baseUrl}/meditations/sleep/female/almee/sleep_almee_voice.MP3",
                    'theo' => "{$baseUrl}/meditations/sleep/male/theo/sleep_theo_voice.MP3",
                ],
                'access_type' => 'free',
                'sort_order' => 1,
            ],
            [
                'id' => 'w002',
                'title' => 'Sleep',
                'description' => 'sleep',
                'category' => 'sleep',
                'duration' => 392,
                'audio_url' => "{$baseUrl}/meditations/sleep/no_voice/sleep_no_voice_2.MP3",
                'image_url' => "{$baseUrl}/avatars/sleep_main.jpg",
                'voices' => [
                    'nicole' => "{$baseUrl}/meditations/sleep/female/nicole/sleep_nicole_voice.MP3",
                    'almee' => "{$baseUrl}/meditations/sleep/female/almee/sleep_almee_voice.MP3",
                    'theo' => "{$baseUrl}/meditations/sleep/male/theo/sleep_theo_voice.MP3",
                ],
                'access_type' => 'free',
                'sort_order' => 2,
            ],
            [
                'id' => 'w003',
                'title' => 'Sleep',
                'description' => 'sleep',
                'category' => 'sleep',
                'duration' => 389,
                'audio_url' => "{$baseUrl}/meditations/sleep/no_voice/sleep_no_voice_3.MP3",
                'image_url' => "{$baseUrl}/avatars/sleep_main.jpg",
                'voices' => [
                    'nicole' => "{$baseUrl}/meditations/sleep/female/nicole/sleep_nicole_voice.MP3",
                    'almee' => "{$baseUrl}/meditations/sleep/female/almee/sleep_almee_voice.MP3",
                    'theo' => "{$baseUrl}/meditations/sleep/male/theo/sleep_theo_voice.MP3",
                ],
                'access_type' => 'free',
                'sort_order' => 3,
            ],
            [
                'id' => 'w004',
                'title' => 'Wake up',
                'description' => 'wake_up',
                'category' => 'wake_up',
                'duration' => 629,
                'audio_url' => "{$baseUrl}/meditations/awake/no_voice/awake_no_voice.MP3",
                'image_url' => "{$baseUrl}/avatars/awake_main.jpg",
                'voices' => [
                    'nicole' => "{$baseUrl}/meditations/awake/female/nicole/awake_nicole_voice_1.MP3",
                    'almee' => "{$baseUrl}/meditations/awake/female/almee/awake_almee_voice_1.MP3",
                    'theo' => "{$baseUrl}/meditations/awake/male/theo/awake_theo_voice.MP3",
                ],
                'access_type' => 'free',
                'sort_order' => 4,
            ],
            [
                'id' => 'w005',
                'title' => 'Wake up',
                'description' => 'wake_up',
                'category' => 'wake_up',
                'duration' => 629,
                'audio_url' => "{$baseUrl}/meditations/awake/no_voice/awake_no_voice_2.MP3",
                'image_url' => "{$baseUrl}/avatars/awake_main.jpg",
                'voices' => [
                    'nicole' => "{$baseUrl}/meditations/awake/female/nicole/awake_nicole_voice_1.MP3",
                    'almee' => "{$baseUrl}/meditations/awake/female/almee/awake_almee_voice_1.MP3",
                    'theo' => "{$baseUrl}/meditations/awake/male/theo/awake_theo_voice.MP3",
                ],
                'access_type' => 'free',
                'sort_order' => 5,
            ],
            [
                'id' => 'w006',
                'title' => 'Wake up',
                'description' => 'wake_up',
                'category' => 'wake_up',
                'duration' => 629,
                'audio_url' => "{$baseUrl}/meditations/awake/no_voice/awake_no_voice_3.MP3",
                'image_url' => "{$baseUrl}/avatars/awake_main.jpg",
                'voices' => [
                    'nicole' => "{$baseUrl}/meditations/awake/female/nicole/awake_nicole_voice_1.MP3",
                    'almee' => "{$baseUrl}/meditations/awake/female/almee/awake_almee_voice_1.MP3",
                    'theo' => "{$baseUrl}/meditations/awake/male/theo/awake_theo_voice.MP3",
                ],
                'access_type' => 'free',
                'sort_order' => 6,
            ],
            [
                'id' => 'w007',
                'title' => 'Productivity',
                'description' => 'productivity',
                'category' => 'productivity',
                'duration' => 215,
                'audio_url' => "{$baseUrl}/meditations/productivity/no_voice/prod_no_voice_1.MP3",
                'image_url' => "{$baseUrl}/avatars/prod_main.jpg",
                'voices' => [
                    'nicole' => "{$baseUrl}/meditations/productivity/female/nicole/prod_nicole_voice_1.MP3",
                    'almee' => "{$baseUrl}/meditations/productivity/female/almee/prod_almee_voice_1.MP3",
                    'theo' => "{$baseUrl}/meditations/productivity/male/theo/prod_theo_voice_1.MP3",
                ],
                'access_type' => 'free',
                'sort_order' => 7,
            ],
            [
                'id' => 'w008',
                'title' => 'Productivity',
                'description' => 'productivity',
                'category' => 'productivity',
                'duration' => 242,
                'audio_url' => "{$baseUrl}/meditations/productivity/no_voice/prod_no_voice_2.MP3",
                'image_url' => "{$baseUrl}/avatars/prod_main.jpg",
                'voices' => [
                    'nicole' => "{$baseUrl}/meditations/productivity/female/nicole/prod_nicole_voice_1.MP3",
                    'almee' => "{$baseUrl}/meditations/productivity/female/almee/prod_almee_voice_1.MP3",
                    'theo' => "{$baseUrl}/meditations/productivity/male/theo/prod_theo_voice_1.MP3",
                ],
                'access_type' => 'free',
                'sort_order' => 8,
            ],
            [
                'id' => 'w009',
                'title' => 'Productivity',
                'description' => 'productivity',
                'category' => 'productivity',
                'duration' => 240,
                'audio_url' => "{$baseUrl}/meditations/productivity/no_voice/prod_no_voice_3.MP3",
                'image_url' => "{$baseUrl}/avatars/prod_main.jpg",
                'voices' => [
                    'nicole' => "{$baseUrl}/meditations/productivity/female/nicole/prod_nicole_voice_1.MP3",
                    'almee' => "{$baseUrl}/meditations/productivity/female/almee/prod_almee_voice_1.MP3",
                    'theo' => "{$baseUrl}/meditations/productivity/male/theo/prod_theo_voice_1.MP3",
                ],
                'access_type' => 'free',
                'sort_order' => 9,
            ],
        ];
    }

    public static function voiceSortOrder(string $voiceId): int
    {
        return match ($voiceId) {
            'nicole' => 1,
            'almee' => 2,
            'theo' => 3,
        };
    }
}
