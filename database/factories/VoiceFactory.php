<?php

namespace Database\Factories;

use App\Models\Voice;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Voice>
 */
class VoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => $this->faker->unique()->slug(1),
            'display_name' => $this->faker->firstName(),
            'avatar_url' => $this->faker->optional()->imageUrl(),
            'description' => $this->faker->sentence(),
            'access_type' => $this->faker->randomElement(['free', 'rewarded']),
            'sort_order' => $this->faker->numberBetween(1, 100),
        ];
    }
}
