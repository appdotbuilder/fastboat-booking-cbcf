<?php

namespace Database\Seeders;

use App\Models\BoatTicket;
use Illuminate\Database\Seeder;

class BoatTicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $boatTickets = [
            [
                'name' => 'Bali - Gili Trawangan',
                'origin' => 'Bali (Padang Bai)',
                'destination' => 'Gili Trawangan',
                'description' => 'Fastboat berkualitas tinggi dengan fasilitas modern menuju pulau Gili Trawangan yang eksotis. Nikmati perjalanan yang nyaman dan pemandangan laut yang menakjubkan.',
                'price' => 350000,
                'duration_hours' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Bali - Lombok',
                'origin' => 'Bali (Padang Bai)',
                'destination' => 'Lombok (Bangsal)',
                'description' => 'Perjalanan cepat dari Bali ke Lombok dengan fastboat modern. Cocok untuk wisatawan yang ingin menjelajahi keindahan Lombok.',
                'price' => 300000,
                'duration_hours' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Bali - Nusa Penida',
                'origin' => 'Bali (Sanur)',
                'destination' => 'Nusa Penida',
                'description' => 'Jelajahi pulau Nusa Penida yang menawan dengan fastboat dari Sanur. Destinasi perfect untuk pecinta fotografi dan alam.',
                'price' => 125000,
                'duration_hours' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Gili Trawangan - Lombok',
                'origin' => 'Gili Trawangan',
                'destination' => 'Lombok (Bangsal)',
                'description' => 'Perjalanan singkat dari Gili Trawangan ke Lombok untuk melanjutkan petualangan Anda di pulau seribu masjid.',
                'price' => 85000,
                'duration_hours' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Lombok - Gili Air',
                'origin' => 'Lombok (Bangsal)',
                'destination' => 'Gili Air',
                'description' => 'Nikmati suasana tenang di Gili Air dengan perjalanan fastboat yang nyaman dari Lombok.',
                'price' => 75000,
                'duration_hours' => 1,
                'is_active' => true,
            ],
        ];

        foreach ($boatTickets as $ticket) {
            BoatTicket::create($ticket);
        }
    }
}