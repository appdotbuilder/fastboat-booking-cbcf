<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TourPackage>
 */
class TourPackageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $packageNames = [
            'Snorkeling Adventure',
            'Island Hopping Tour', 
            'Cultural Heritage Tour',
            'Mountain Hiking Trip',
            'Sunset Cruise',
            'Diving Experience',
            'Photography Tour',
            'Local Village Tour'
        ];
        
        return [
            'name' => fake()->randomElement($packageNames) . ' ' . fake()->city(),
            'description' => fake()->paragraphs(3, true),
            'price' => fake()->numberBetween(250000, 5000000),
            'duration_days' => fake()->numberBetween(1, 7),
            'includes' => fake()->paragraph(),
            'itinerary' => fake()->paragraph(),
            'is_active' => fake()->boolean(90),
        ];
    }
}