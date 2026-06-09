<?php

use App\Models\Meditation;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Meditation::query()->where('id', 'w001')->update([
            'audio_by_voice' => [
                'almee' => 'https://fls-a1f95989-3ceb-4c1f-9c84-418c462b7dbe.laravel.cloud/meditations/sleep/female/almee/sleep_almee_voice.MP3',
                'nicole' => 'https://fls-a1f95989-3ceb-4c1f-9c84-418c462b7dbe.laravel.cloud/meditations/sleep/female/nicole/sleep_nicole_final_1.MP3',
                'theo' => 'https://fls-a1f95989-3ceb-4c1f-9c84-418c462b7dbe.laravel.cloud/meditations/sleep/male/theo/sleep_theo_final_1.MP3',
                'none' => 'https://fls-a1f95989-3ceb-4c1f-9c84-418c462b7dbe.laravel.cloud/meditations/sleep/no_voice/sleep_no_voice_1.MP3',
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
