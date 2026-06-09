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
        Voice::query()->delete();

        $voices = [
            [
                'id' => 'almee',
                'display_name' => 'Almee',
                'avatar_url' => 'https://fls-a1f95989-3ceb-4c1f-9c84-418c462b7dbe.laravel.cloud/avatars/almee.png',
                'description' => 'Warm, calming female voice.',
                'access_type' => 'free',
                'sort_order' => 1,
            ],
            [
                'id' => 'theo',
                'display_name' => 'Theo',
                'avatar_url' => 'https://fls-a1f95989-3ceb-4c1f-9c84-418c462b7dbe.laravel.cloud/avatars/theo.png',
                'description' => 'Grounded, reassuring male voice.',
                'access_type' => 'free',
                'sort_order' => 2,
            ],
            [
                'id' => 'nicole',
                'display_name' => 'Nicole',
                'avatar_url' => 'https://fls-a1f95989-3ceb-4c1f-9c84-418c462b7dbe.laravel.cloud/avatars/nicole.png',
                'description' => 'Soft-spoken, contemplative voice.',
                'access_type' => 'free',
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
