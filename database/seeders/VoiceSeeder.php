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

        foreach (MeditationCatalog::voices() as $voice) {
            Voice::create($voice);
        }
    }
}
