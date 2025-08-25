<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SiteSettingController extends Controller
{
    /**
     * Display the site settings form.
     */
    public function index()
    {
        $settings = [
            'hero_title' => SiteSetting::get('hero_title', 'Booking Tiket Fastboat & Wisata'),
            'hero_description' => SiteSetting::get('hero_description', 'Jelajahi keindahan Indonesia dengan layanan fastboat terpercaya dan paket wisata eksotis'),
            'hero_image' => SiteSetting::get('hero_image', ''),
            'contact_email' => SiteSetting::get('contact_email', 'info@fastboatbooking.com'),
            'contact_phone' => SiteSetting::get('contact_phone', '+62 123 456 789'),
            'contact_address' => SiteSetting::get('contact_address', 'Bali, Indonesia'),
            'bank_account' => SiteSetting::get('bank_account', 'Mandiri 1610003228298 a.n Lalu Yusran Said'),
        ];
        
        return Inertia::render('admin/site-settings/index', [
            'settings' => $settings,
        ]);
    }

    /**
     * Update site settings.
     */
    public function update(Request $request)
    {
        $request->validate([
            'hero_title' => 'required|string|max:255',
            'hero_description' => 'required|string',
            'hero_image' => 'nullable|string',
            'contact_email' => 'required|email',
            'contact_phone' => 'required|string',
            'contact_address' => 'required|string',
            'bank_account' => 'required|string',
        ]);

        foreach ($request->only([
            'hero_title',
            'hero_description', 
            'hero_image',
            'contact_email',
            'contact_phone',
            'contact_address',
            'bank_account'
        ]) as $key => $value) {
            SiteSetting::set($key, $value);
        }

        return redirect()->back()
            ->with('success', 'Pengaturan situs berhasil diperbarui.');
    }
}