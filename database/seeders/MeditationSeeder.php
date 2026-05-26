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
        Meditation::create([
            'id' => 'wu001',
            'title' => 'Sunrise Gratitude',
            'description' => 'Begin your day with a gentle gratitude practice...',
            'category' => 'wake_up',
            'duration' => 600,
            'audio_by_voice' => [
                'maya' => 'https://cdn.example.com/wu001/maya.mp3',
                'daniel' => 'https://cdn.example.com/wu001/daniel.mp3',
                'aiko' => 'https://cdn.example.com/wu001/aiko.mp3',
                'none' => 'https://cdn.example.com/wu001/ambient.mp3',
            ],
            'image_url' => 'https://cdn.example.com/wu001/cover.jpg',
            'access_type' => 'free',
            'sort_order' => 1,
        ]);
    }
}
