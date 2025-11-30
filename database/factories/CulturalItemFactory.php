<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CulturalItem>
 */
class CulturalItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'category_id' => \App\Models\CulturalCategory::factory(),
            'community_id' => \App\Models\Community::factory(),
            'description' => fake()->paragraph(),
            'latitude' => fake()->latitude(13.5, 14.0),
            'longitude' => fake()->longitude(100.3, 100.7),
            'publish_date' => now(),
            'is_published' => true,
            'is_featured' => false,
            'featured_order' => null,
            'created_by' => \App\Models\User::factory(),
        ];
    }
}
