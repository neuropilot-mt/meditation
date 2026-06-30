<?php

use Database\Seeders\MeditationCatalog;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $now = now();

        foreach (MeditationCatalog::voices() as $voice) {
            DB::table('voices')->updateOrInsert(
                ['id' => $voice['id']],
                [...$voice, 'created_at' => $now, 'updated_at' => $now],
            );
        }

        DB::table('voices')->where('id', 'none')->delete();

        foreach (MeditationCatalog::meditations() as $meditation) {
            $voices = $meditation['voices'];
            unset($meditation['voices']);

            if (Schema::hasColumn('meditations', 'audio_by_voice')) {
                $meditation['audio_by_voice'] = json_encode(
                    [...$voices, 'none' => $meditation['audio_url']],
                    JSON_THROW_ON_ERROR
                );
            }

            DB::table('meditations')->updateOrInsert(
                ['id' => $meditation['id']],
                [...$meditation, 'created_at' => $now, 'updated_at' => $now],
            );

            DB::table('meditation_voice')->where('meditation_id', $meditation['id'])->delete();

            foreach ($voices as $voiceId => $audioUrl) {
                DB::table('meditation_voice')->insert([
                    'meditation_id' => $meditation['id'],
                    'voice_id' => $voiceId,
                    'audio_url' => $audioUrl,
                    'sort_order' => MeditationCatalog::voiceSortOrder($voiceId),
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $meditationIds = array_column(MeditationCatalog::meditations(), 'id');
        $voiceIds = array_column(MeditationCatalog::voices(), 'id');

        DB::table('meditation_voice')->whereIn('meditation_id', $meditationIds)->delete();
        DB::table('meditations')->whereIn('id', $meditationIds)->delete();
        DB::table('voices')->whereIn('id', $voiceIds)->delete();
    }
};
