<?php

namespace Database\Seeders;

use App\Models\Meditation;
use Illuminate\Database\Seeder;

class MeditationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Meditation::query()->delete();

        Meditation::create([
            'id' => 'w001',
            'title' => 'Sleep',
            'description' => 'sleep',
            'category' => 'sleep',
            'duration' => 392,
            'audio_by_voice' => [
                'almee' => 'https://fls-a1f95989-3ceb-4c1f-9c84-418c462b7dbe.laravel.cloud/meditations/sleep/female/almee/sleep_almee_final_1.MP3',
                'nicole' => 'https://fls-a1f95989-3ceb-4c1f-9c84-418c462b7dbe.laravel.cloud/meditations/sleep/female/nicole/sleep_nicole_final_1.MP3',
                'theo' => 'https://fls-a1f95989-3ceb-4c1f-9c84-418c462b7dbe.laravel.cloud/meditations/sleep/male/theo/sleep_theo_final_1.MP3',
                'none' => 'https://fls-a1f95989-3ceb-4c1f-9c84-418c462b7dbe.laravel.cloud/meditations/sleep/no_voice/sleep1.wav',
            ],
            'image_url' => 'https://fls-a1f95989-3ceb-4c1f-9c84-418c462b7dbe.laravel.cloud/avatars/sleep_main.jpg',
            'access_type' => 'free',
            'sort_order' => 1,
        ]);

        Meditation::create([
            'id' => 'w002',
            'title' => 'Sleep',
            'description' => 'sleep',
            'category' => 'sleep',
            'duration' => 392,
            'audio_by_voice' => [
                'almee' => 'https://fls-a1f95989-3ceb-4c1f-9c84-418c462b7dbe.laravel.cloud/meditations/sleep/female/almee/sleep_almee_final_2.MP3',
                'nicole' => 'https://fls-a1f95989-3ceb-4c1f-9c84-418c462b7dbe.laravel.cloud/meditations/sleep/female/nicole/sleep_nicole_final_2.MP3',
                'theo' => 'https://fls-a1f95989-3ceb-4c1f-9c84-418c462b7dbe.laravel.cloud/meditations/sleep/male/theo/sleep_theo_final_2.MP3',
                'none' => 'https://fls-a1f95989-3ceb-4c1f-9c84-418c462b7dbe.laravel.cloud/meditations/sleep/no_voice/sleep2.wav',
            ],
            'image_url' => 'https://fls-a1f95989-3ceb-4c1f-9c84-418c462b7dbe.laravel.cloud/avatars/sleep_main.jpg',
            'access_type' => 'free',
            'sort_order' => 2,
        ]);

        Meditation::create([
            'id' => 'w003',
            'title' => 'Sleep',
            'description' => 'sleep',
            'category' => 'sleep',
            'duration' => 389,
            'audio_by_voice' => [
                'almee' => 'https://fls-a1f95989-3ceb-4c1f-9c84-418c462b7dbe.laravel.cloud/meditations/sleep/female/almee/sleep_almee_final_3.MP3',
                'nicole' => 'https://fls-a1f95989-3ceb-4c1f-9c84-418c462b7dbe.laravel.cloud/meditations/sleep/female/nicole/sleep_nicole_final_3.MP3',
                'theo' => 'https://fls-a1f95989-3ceb-4c1f-9c84-418c462b7dbe.laravel.cloud/meditations/sleep/male/theo/sleep_theo_final_3.MP3',
                'none' => 'https://fls-a1f95989-3ceb-4c1f-9c84-418c462b7dbe.laravel.cloud/meditations/sleep/no_voice/sleep3.wav',
            ],
            'image_url' => 'https://fls-a1f95989-3ceb-4c1f-9c84-418c462b7dbe.laravel.cloud/avatars/sleep_main.jpg',
            'access_type' => 'free',
            'sort_order' => 3,
        ]);

        Meditation::create([
            'id' => 'w004',
            'title' => 'Wake up',
            'description' => 'wake_up',
            'category' => 'wake_up',
            'duration' => 629,
            'audio_by_voice' => [
                'almee' => 'https://fls-a1f95989-3ceb-4c1f-9c84-418c462b7dbe.laravel.cloud/meditations/awake/female/almee/awake_almee_final_1.MP3',
                'nicole' => 'https://fls-a1f95989-3ceb-4c1f-9c84-418c462b7dbe.laravel.cloud/meditations/awake/female/nicole/awake_nicole_final_1.MP3',
                'theo' => 'https://fls-a1f95989-3ceb-4c1f-9c84-418c462b7dbe.laravel.cloud/meditations/awake/male/theo/awake_theo_final_1.MP3',
                'none' => 'https://fls-a1f95989-3ceb-4c1f-9c84-418c462b7dbe.laravel.cloud/meditations/awake/no_voice/awake1.wav',
            ],
            'image_url' => 'https://fls-a1f95989-3ceb-4c1f-9c84-418c462b7dbe.laravel.cloud/avatars/awake_main.jpg',
            'access_type' => 'free',
            'sort_order' => 4,
        ]);

        Meditation::create([
            'id' => 'w005',
            'title' => 'Wake up',
            'description' => 'wake_up',
            'category' => 'wake_up',
            'duration' => 629,
            'audio_by_voice' => [
                'almee' => 'https://fls-a1f95989-3ceb-4c1f-9c84-418c462b7dbe.laravel.cloud/meditations/awake/female/almee/awake_almee_final_2.MP3',
                'nicole' => 'https://fls-a1f95989-3ceb-4c1f-9c84-418c462b7dbe.laravel.cloud/meditations/awake/female/nicole/awake_nicole_final_2.MP3',
                'theo' => 'https://fls-a1f95989-3ceb-4c1f-9c84-418c462b7dbe.laravel.cloud/meditations/awake/male/theo/awake_theo_final_2.MP3',
                'none' => 'https://fls-a1f95989-3ceb-4c1f-9c84-418c462b7dbe.laravel.cloud/meditations/awake/no_voice/awake2.wav',
            ],
            'image_url' => 'https://fls-a1f95989-3ceb-4c1f-9c84-418c462b7dbe.laravel.cloud/avatars/awake_main.jpg',
            'access_type' => 'free',
            'sort_order' => 5,
        ]);

        Meditation::create([
            'id' => 'w006',
            'title' => 'Wake up',
            'description' => 'wake_up',
            'category' => 'wake_up',
            'duration' => 629,
            'audio_by_voice' => [
                'almee' => 'https://fls-a1f95989-3ceb-4c1f-9c84-418c462b7dbe.laravel.cloud/meditations/awake/female/almee/awake_almee_final_3.MP3',
                'nicole' => 'https://fls-a1f95989-3ceb-4c1f-9c84-418c462b7dbe.laravel.cloud/meditations/awake/female/nicole/awake_nicole_final_3.MP3',
                'theo' => 'https://fls-a1f95989-3ceb-4c1f-9c84-418c462b7dbe.laravel.cloud/meditations/awake/male/theo/awake_theo_final_3.MP3',
                'none' => 'https://fls-a1f95989-3ceb-4c1f-9c84-418c462b7dbe.laravel.cloud/meditations/awake/no_voice/awake3.wav',
            ],
            'image_url' => 'https://fls-a1f95989-3ceb-4c1f-9c84-418c462b7dbe.laravel.cloud/avatars/awake_main.jpg',
            'access_type' => 'free',
            'sort_order' => 6,
        ]);

        Meditation::create([
            'id' => 'w007',
            'title' => 'Productivity',
            'description' => 'productivity',
            'category' => 'productivity',
            'duration' => 215,
            'audio_by_voice' => [
                'almee' => 'https://fls-a1f95989-3ceb-4c1f-9c84-418c462b7dbe.laravel.cloud/meditations/productivity/female/almee/prod_almee_final_1.MP3',
                'nicole' => 'https://fls-a1f95989-3ceb-4c1f-9c84-418c462b7dbe.laravel.cloud/meditations/productivity/female/nicole/prod_nicole_final_1.MP3',
                'theo' => 'https://fls-a1f95989-3ceb-4c1f-9c84-418c462b7dbe.laravel.cloud/meditations/productivity/male/theo/prod_theo_final_1.MP3',
                'none' => 'https://fls-a1f95989-3ceb-4c1f-9c84-418c462b7dbe.laravel.cloud/meditations/productivity/no_voice/productivity1.wav',
            ],
            'image_url' => 'https://fls-a1f95989-3ceb-4c1f-9c84-418c462b7dbe.laravel.cloud/avatars/prod_main.jpg',
            'access_type' => 'free',
            'sort_order' => 7,
        ]);

        Meditation::create([
            'id' => 'w008',
            'title' => 'Productivity',
            'description' => 'productivity',
            'category' => 'productivity',
            'duration' => 242,
            'audio_by_voice' => [
                'almee' => 'https://fls-a1f95989-3ceb-4c1f-9c84-418c462b7dbe.laravel.cloud/meditations/productivity/female/almee/prod_almee_final_2.MP3',
                'nicole' => 'https://fls-a1f95989-3ceb-4c1f-9c84-418c462b7dbe.laravel.cloud/meditations/productivity/female/nicole/prod_nicole_final_2.MP3',
                'theo' => 'https://fls-a1f95989-3ceb-4c1f-9c84-418c462b7dbe.laravel.cloud/meditations/productivity/male/theo/prod_theo_final_2.MP3',
                'none' => 'https://fls-a1f95989-3ceb-4c1f-9c84-418c462b7dbe.laravel.cloud/meditations/productivity/no_voice/productivity2.wav',
            ],
            'image_url' => 'https://fls-a1f95989-3ceb-4c1f-9c84-418c462b7dbe.laravel.cloud/avatars/prod_main.jpg',
            'access_type' => 'free',
            'sort_order' => 8,
        ]);

        Meditation::create([
            'id' => 'w009',
            'title' => 'Productivity',
            'description' => 'productivity',
            'category' => 'productivity',
            'duration' => 240,
            'audio_by_voice' => [
                'almee' => 'https://fls-a1f95989-3ceb-4c1f-9c84-418c462b7dbe.laravel.cloud/meditations/productivity/female/almee/prod_almee_final_3.MP3',
                'nicole' => 'https://fls-a1f95989-3ceb-4c1f-9c84-418c462b7dbe.laravel.cloud/meditations/productivity/female/nicole/prod_nicole_final_3.MP3',
                'theo' => 'https://fls-a1f95989-3ceb-4c1f-9c84-418c462b7dbe.laravel.cloud/meditations/productivity/male/theo/prod_theo_final_3.MP3',
                'none' => 'https://fls-a1f95989-3ceb-4c1f-9c84-418c462b7dbe.laravel.cloud/meditations/productivity/no_voice/productivity3.wav',
            ],
            'image_url' => 'https://fls-a1f95989-3ceb-4c1f-9c84-418c462b7dbe.laravel.cloud/avatars/prod_main.jpg',
            'access_type' => 'free',
            'sort_order' => 9,
        ]);
    }
}
