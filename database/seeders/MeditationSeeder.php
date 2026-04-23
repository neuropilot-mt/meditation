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
        Meditation::factory()->count(10)->create();
    }
}
