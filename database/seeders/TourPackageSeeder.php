<?php

namespace Database\Seeders;

use App\Models\TourPackage;
use Illuminate\Database\Seeder;

class TourPackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tourPackages = [
            [
                'name' => 'Snorkeling Trip Gili Trawangan',
                'description' => 'Paket snorkeling seharian penuh di perairan jernih Gili Trawangan. Jelajahi keindahan bawah laut dengan berbagai jenis ikan tropis dan terumbu karang yang memukau.',
                'price' => 650000,
                'duration_days' => 1,
                'includes' => 'Transport boat, Peralatan snorkeling, Lunch, Pemandu wisata, Asuransi',
                'itinerary' => '08:00 - Penjemputan di hotel, 09:00 - Departure ke Gili, 10:30 - Snorkeling spot 1, 12:00 - Lunch di pantai, 14:00 - Snorkeling spot 2, 16:00 - Return',
                'is_active' => true,
            ],
            [
                'name' => 'Rinjani Hiking Adventure 3D2N',
                'description' => 'Pendakian menantang ke puncak Gunung Rinjani, gunung berapi tertinggi kedua di Indonesia. Nikmati pemandangan danau Segara Anak yang spektakuler.',
                'price' => 2500000,
                'duration_days' => 3,
                'includes' => 'Porter, Guide profesional, Camping equipment, Meals 3x sehari, Transport, Permit',
                'itinerary' => 'Hari 1: Senaru - Pos 1 - Pos 2, Hari 2: Crater rim - Danau Segara Anak, Hari 3: Summit attack - Descent',
                'is_active' => true,
            ],
            [
                'name' => 'Komodo Island Adventure 3D2N',
                'description' => 'Jelajahi habitat asli komodo dragon di Pulau Komodo dan Pulau Rinca. Saksikan reptil raksasa ini dalam habitat alaminya plus snorkeling di Pink Beach.',
                'price' => 3500000,
                'duration_days' => 3,
                'includes' => 'Boat charter, Accommodation, All meals, Park fees, Guide, Snorkeling gear',
                'itinerary' => 'Hari 1: Labuan Bajo - Komodo Island, Hari 2: Rinca Island - Pink Beach, Hari 3: Padar Island - Return',
                'is_active' => true,
            ],
            [
                'name' => 'Deep Sea Fishing Trip',
                'description' => 'Pengalaman memancing laut dalam yang seru di perairan Indonesia. Cocok untuk pemula maupun yang berpengalaman dengan peralatan modern.',
                'price' => 1200000,
                'duration_days' => 1,
                'includes' => 'Boat charter, Fishing equipment, Bait, Captain & crew, Lunch, Cool box',
                'itinerary' => '05:00 - Departure, 06:00 - Fishing spots, 12:00 - Lunch onboard, 15:00 - Return to harbor',
                'is_active' => true,
            ],
            [
                'name' => 'Bali Cultural & Temple Tour',
                'description' => 'Tour budaya Bali mengunjungi pura-pura bersejarah, desa tradisional, dan menyaksikan pertunjukan tari Kecak yang memukau.',
                'price' => 450000,
                'duration_days' => 1,
                'includes' => 'Transport AC, Entrance fees, Lunch, Professional guide, Bottled water',
                'itinerary' => '08:00 - Tanah Lot Temple, 10:30 - Jatiluwih Rice Terrace, 13:00 - Lunch, 15:00 - Uluwatu Temple, 18:00 - Kecak Dance',
                'is_active' => true,
            ],
            [
                'name' => 'Lombok Sasak Village & Waterfall Tour',
                'description' => 'Jelajahi budaya suku Sasak di desa tradisional dan nikmati kesegaran air terjun Sekumpul yang menawan.',
                'price' => 380000,
                'duration_days' => 1,
                'includes' => 'Transport, Guide, Entrance fees, Traditional lunch, Bottled water',
                'itinerary' => '08:00 - Sasak Village Sade, 10:00 - Traditional weaving demo, 12:00 - Local lunch, 14:00 - Sekumpul Waterfall',
                'is_active' => true,
            ],
            [
                'name' => 'Nusa Penida Instagram Tour',
                'description' => 'Tour foto terbaik di Nusa Penida mengunjungi spot-spot Instagram famous seperti Kelingking Beach, Angels Billabong, dan Broken Beach.',
                'price' => 550000,
                'duration_days' => 1,
                'includes' => 'Fast boat, Land transport, Professional photographer, Lunch, Entrance fees',
                'itinerary' => '07:00 - Departure, 08:30 - Kelingking Beach, 11:00 - Angels Billabong, 13:00 - Lunch, 15:00 - Broken Beach',
                'is_active' => true,
            ],
        ];

        foreach ($tourPackages as $package) {
            TourPackage::create($package);
        }
    }
}