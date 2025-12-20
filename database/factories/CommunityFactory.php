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
            'latitude' => fake()->latitude(13.5, 14.0),
            'longitude' => fake()->longitude(100.3, 100.7),
            'established_year' => fake()->numberBetween(1950, 2020),
            'population' => fake()->numberBetween(1000, 50000),
            'area_size' => fake()->randomFloat(2, 1, 100),
            'highlights' => fake()->sentence(),
            'is_active' => true,
        ];
    }
}
