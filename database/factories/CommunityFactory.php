<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Community>
 */
class CommunityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->company(),
            'description' => fake()->paragraph(),
            'address' => fake()->streetAddress(),
            'latitude' => fake()->latitude(13.5, 14.0),
            'longitude' => fake()->longitude(100.3, 100.7),
            'is_active' => true,
        ];
    }
}
