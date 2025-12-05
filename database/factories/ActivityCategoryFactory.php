<?php

namespace Database\Factories;

use App\Models\ActivityCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ActivityCategoryFactory extends Factory
{
    protected $model = ActivityCategory::class;

    public function definition(): array
    {
        $name = fake()->unique()->words(2, true);
        $slug = Str::slug($name) . '-' . fake()->unique()->numberBetween(1000, 9999);
        
        return [
            'name' => ucfirst($name),
            'slug' => $slug,
            'description' => fake()->sentence(),
            'color' => fake()->hexColor(),
            'icon' => 'fas fa-' . fake()->randomElement(['calendar', 'star', 'heart', 'music', 'paint-brush']),
            'is_active' => true,
            'sort_order' => fake()->numberBetween(1, 100),
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}
