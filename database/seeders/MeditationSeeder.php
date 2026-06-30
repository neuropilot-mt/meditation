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

        foreach (MeditationCatalog::meditations() as $meditationData) {
            $voices = $meditationData['voices'];
            unset($meditationData['voices']);

            $meditation = Meditation::create($meditationData);

            $meditation->voices()->sync(
                collect($voices)
                    ->mapWithKeys(fn (string $audioUrl, string $voiceId): array => [
                        $voiceId => [
                            'audio_url' => $audioUrl,
                            'sort_order' => MeditationCatalog::voiceSortOrder($voiceId),
                        ],
                    ])
                    ->all()
            );
        }
    }
}
