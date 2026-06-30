<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class MeditationApiTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_meditations_are_returned_with_audio_url_and_voice_urls(): void
    {
        $response = $this->getJson('/api/meditations');

        $response
            ->assertOk()
            ->assertJsonCount(9, 'data')
            ->assertJsonPath('data.0.id', 'w001')
            ->assertJsonPath('data.0.category', 'sleep')
            ->assertJsonPath('data.0.audio_url', 'https://fls-a1f95989-3ceb-4c1f-9c84-418c462b7dbe.laravel.cloud/meditations/sleep/no_voice/sleep_no_voice_1.MP3')
            ->assertJsonPath('data.0.voices.nicole', 'https://fls-a1f95989-3ceb-4c1f-9c84-418c462b7dbe.laravel.cloud/meditations/sleep/female/nicole/sleep_nicole_final_1.MP3')
            ->assertJsonPath('data.0.voices.almee', 'https://fls-a1f95989-3ceb-4c1f-9c84-418c462b7dbe.laravel.cloud/meditations/sleep/female/almee/sleep_almee_voice.MP3')
            ->assertJsonPath('data.0.voices.theo', 'https://fls-a1f95989-3ceb-4c1f-9c84-418c462b7dbe.laravel.cloud/meditations/sleep/male/theo/sleep_theo_final_1.MP3')
            ->assertJsonMissingPath('data.0.voices.none');

        $this->assertSame(
            ['nicole', 'almee', 'theo'],
            array_keys($response->json('data.0.voices'))
        );
    }
}
