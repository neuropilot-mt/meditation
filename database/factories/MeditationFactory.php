<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Meditation;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Meditation>
 */
class MeditationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => Str::uuid(),
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'category_id' => Category::inRandomOrder()->first()?->id ?? Category::factory(),
            'tags' => $this->faker->words(3),
            'duration' => $this->faker->numberBetween(60, 3600),
            'audio_url' => $this->faker->url(),
            'image_url' => $this->faker->imageUrl(),
            'access_type' => $this->faker->randomElement(['free', 'premium']),
            'preview_audio_url' => $this->faker->optional()->url(),
            'sort_order' => $this->faker->numberBetween(1, 100),
        ];
    }
}
