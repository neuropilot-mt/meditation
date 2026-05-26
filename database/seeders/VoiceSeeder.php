<?php

namespace Database\Seeders;

use App\Models\Voice;
use Illuminate\Database\Seeder;

class VoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $voices = [
            [
                'id' => 'maya',
                'display_name' => 'Maya',
                'avatar_url' => 'https://cdn.example.com/voices/maya.jpg',
                'description' => 'Warm, calming female voice.',
                'access_type' => 'free',
                'sort_order' => 1,
            ],
            [
                'id' => 'daniel',
                'display_name' => 'Daniel',
                'avatar_url' => 'https://cdn.example.com/voices/daniel.jpg',
                'description' => 'Grounded, reassuring male voice.',
                'access_type' => 'free',
                'sort_order' => 2,
            ],
            [
                'id' => 'aiko',
                'display_name' => 'Aiko',
                'avatar_url' => 'https://cdn.example.com/voices/aiko.jpg',
                'description' => 'Soft-spoken, contemplative voice.',
                'access_type' => 'rewarded',
                'sort_order' => 3,
            ],
            [
                'id' => 'none',
                'display_name' => 'No Voice',
                'avatar_url' => null,
                'description' => 'Ambient only — no narration.',
                'access_type' => 'free',
                'sort_order' => 4,
            ],
        ];

        foreach ($voices as $voice) {
            Voice::create($voice);
        }
    }
}
