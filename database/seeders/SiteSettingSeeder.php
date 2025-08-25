<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'key' => 'hero_title',
                'value' => '🚤 Booking Tiket Fastboat & Wisata Eksotis',
                'type' => 'text',
            ],
            [
                'key' => 'hero_description',
                'value' => 'Jelajahi keindahan Indonesia dengan layanan fastboat terpercaya dan paket wisata eksotis. Dari Bali ke Gili, Lombok, hingga Nusa Penida - petualangan menakjubkan menanti Anda!',
                'type' => 'text',
            ],
            [
                'key' => 'contact_email',
                'value' => 'info@fastboatbooking.com',
                'type' => 'text',
            ],
            [
                'key' => 'contact_phone',
                'value' => '+62 812 3456 7890',
                'type' => 'text',
            ],
            [
                'key' => 'contact_address',
                'value' => 'Jl. Bypass Ngurah Rai No. 123, Sanur, Bali 80228',
                'type' => 'text',
            ],
            [
                'key' => 'bank_account',
                'value' => 'Bank Mandiri 1610003228298 a.n Lalu Yusran Said',
                'type' => 'text',
            ],
        ];

        foreach ($settings as $setting) {
            SiteSetting::create($setting);
        }
    }
}