<?php

namespace Database\Factories;

use App\Models\BoatTicket;
use App\Models\Booking;
use App\Models\TourPackage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $bookingType = fake()->randomElement(['boat_ticket', 'tour_package']);
        $passengerCount = fake()->numberBetween(1, 8);
        
        $basePrice = $bookingType === 'boat_ticket' 
            ? fake()->numberBetween(75000, 500000)
            : fake()->numberBetween(250000, 5000000);
            
        return [
            'booking_code' => Booking::generateBookingCode(),
            'full_name' => fake()->name(),
            'email' => fake()->unique()->email(),
            'phone' => fake()->phoneNumber(),
            'booking_type' => $bookingType,
            'boat_ticket_id' => $bookingType === 'boat_ticket' ? BoatTicket::factory() : null,
            'tour_package_id' => $bookingType === 'tour_package' ? TourPackage::factory() : null,
            'departure_date' => fake()->dateTimeBetween('+1 day', '+3 months'),
            'passenger_count' => $passengerCount,
            'total_price' => $basePrice * $passengerCount,
            'payment_method' => fake()->randomElement(['bank_transfer', 'office_payment', 'credit_card']),
            'payment_status' => fake()->randomElement(['pending', 'paid', 'cancelled']),
            'qr_code' => 'QR-' . fake()->unique()->regexify('[A-Z0-9]{12}'),
            'paid_at' => fake()->optional()->dateTimeBetween('-1 month', 'now'),
        ];
    }
}