<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BoatTicket>
 */
class BoatTicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $origins = ['Bali (Padang Bai)', 'Bali (Sanur)', 'Lombok (Bangsal)', 'Gili Trawangan', 'Gili Air'];
        $destinations = ['Gili Trawangan', 'Gili Air', 'Lombok (Bangsal)', 'Nusa Penida', 'Bali (Sanur)'];
        
        $origin = fake()->randomElement($origins);
        $destination = fake()->randomElement($destinations);
        
        return [
            'name' => $origin . ' - ' . $destination,
            'origin' => $origin,
            'destination' => $destination,
            'description' => fake()->paragraph(),
            'price' => fake()->numberBetween(75000, 500000),
            'duration_hours' => fake()->numberBetween(1, 4),
            'is_active' => fake()->boolean(90),
        ];
    }
}