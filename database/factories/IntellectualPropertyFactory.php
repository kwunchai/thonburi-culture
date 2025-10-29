<?php

namespace Database\Factories;

use App\Models\IntellectualProperty;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Factory for IntellectualProperty Model
 */
class IntellectualPropertyFactory extends Factory
{
    protected $model = IntellectualProperty::class;

    public function definition(): array
    {
        $registrationDate = $this->faker->optional(0.7)->dateTimeBetween('-5 years', 'now');
        
        return [
            'title' => $this->faker->unique()->sentence(3),
            'type' => $this->faker->randomElement(array_keys(IntellectualProperty::TYPES)),
            'description' => $this->faker->paragraphs(3, true),
            'owner_id' => User::factory(),
            'owner_type' => 'user',
            'registration_date' => $registrationDate,
            'registration_number' => $registrationDate 
                ? 'IP-' . strtoupper($this->faker->bothify('???-####'))
                : null,
            'status' => $this->faker->randomElement(array_keys(IntellectualProperty::STATUSES)),
            'expiry_date' => $registrationDate 
                ? $this->faker->optional(0.6)->dateTimeBetween('now', '+10 years')
                : null,
            'metadata' => [
                'estimated_value' => $this->faker->numberBetween(10000, 1000000),
                'industry' => $this->faker->randomElement(['Technology', 'Healthcare', 'Education', 'Entertainment']),
                'region' => $this->faker->randomElement(['Bangkok', 'Thonburi', 'Nonthaburi', 'Samut Prakan']),
                'is_public' => $this->faker->boolean(30),
                'tags' => $this->faker->words(5),
            ],
            'attachments' => [],
        ];
    }

    /**
     * Indicate that the IP is a copyright.
     */
    public function copyright(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'copyright',
            'metadata' => array_merge($attributes['metadata'] ?? [], [
                'copyright_holder' => $this->faker->name(),
                'publication_date' => $this->faker->date(),
            ]),
        ]);
    }

    /**
     * Indicate that the IP is a patent.
     */
    public function patent(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'patent',
            'metadata' => array_merge($attributes['metadata'] ?? [], [
                'patent_office' => 'Thai Department of Intellectual Property',
                'claims_count' => $this->faker->numberBetween(5, 30),
            ]),
        ]);
    }

    /**
     * Indicate that the IP is local wisdom.
     */
    public function localWisdom(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'local_wisdom',
            'metadata' => array_merge($attributes['metadata'] ?? [], [
                'community' => $this->faker->randomElement([
                    'Thonburi Community',
                    'Bangkok Noi Community',
                    'Wang Lang Community'
                ]),
                'heritage_type' => $this->faker->randomElement([
                    'Traditional Craft',
                    'Cultural Practice',
                    'Traditional Knowledge'
                ]),
            ]),
        ]);
    }

    /**
     * Indicate that the IP is registered.
     */
    public function registered(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'registered',
            'registration_date' => $this->faker->dateTimeBetween('-3 years', '-1 year'),
            'registration_number' => 'IP-' . strtoupper($this->faker->bothify('???-####')),
            'expiry_date' => $this->faker->dateTimeBetween('+1 year', '+10 years'),
        ]);
    }

    /**
     * Indicate that the IP is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'active',
            'registration_date' => $this->faker->dateTimeBetween('-2 years', 'now'),
            'registration_number' => 'IP-' . strtoupper($this->faker->bothify('???-####')),
        ]);
    }

    /**
     * Indicate that the IP is expiring soon.
     */
    public function expiringSoon(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'active',
            'expiry_date' => $this->faker->dateTimeBetween('now', '+30 days'),
        ]);
    }

    /**
     * Indicate that the IP is expired.
     */
    public function expired(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'expired',
            'expiry_date' => $this->faker->dateTimeBetween('-2 years', '-1 day'),
        ]);
    }
}