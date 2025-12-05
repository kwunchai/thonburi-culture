<?php

namespace Database\Factories;

use App\Models\Activity;
use App\Models\ActivityCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ActivityFactory extends Factory
{
    protected $model = Activity::class;

    public function definition(): array
    {
        return [
            'title' => fake()->sentence(4),
            'description' => fake()->paragraph(3),
            'image' => 'activities/' . fake()->uuid() . '.jpg',
            'images' => null,
            'activity_date' => fake()->dateTimeBetween('now', '+3 months'),
            'start_time' => fake()->time('H:i:s'),
            'end_time' => fake()->time('H:i:s'),
            'location' => fake()->address(),
            'category_id' => ActivityCategory::factory(),
            'is_active' => true,
            'sort_order' => fake()->numberBetween(1, 100),
            'views_count' => fake()->numberBetween(0, 1000),
            'meta_data' => null,
            'created_by' => User::factory(),
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }

    public function upcoming(): static
    {
        return $this->state(fn (array $attributes) => [
            'activity_date' => fake()->dateTimeBetween('now', '+1 month'),
        ]);
    }

    public function past(): static
    {
        return $this->state(fn (array $attributes) => [
            'activity_date' => fake()->dateTimeBetween('-1 year', 'now'),
        ]);
    }

    public function popular(): static
    {
        return $this->state(fn (array $attributes) => [
            'views_count' => fake()->numberBetween(1000, 5000),
        ]);
    }
}
