<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookingRequest;
use App\Models\BoatTicket;
use App\Models\Booking;
use App\Models\SiteSetting;
use App\Models\TourPackage;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BookingController extends Controller
{
    /**
     * Display the booking form and available tickets/packages.
     */
    public function index()
    {
        $boatTickets = BoatTicket::active()->orderBy('name')->get();
        $tourPackages = TourPackage::active()->orderBy('name')->get();
        
        $heroTitle = SiteSetting::get('hero_title', 'Booking Tiket Fastboat & Wisata');
        $heroDescription = SiteSetting::get('hero_description', 'Jelajahi keindahan Indonesia dengan layanan fastboat terpercaya dan paket wisata eksotis');
        
        return Inertia::render('booking/index', [
            'boatTickets' => $boatTickets,
            'tourPackages' => $tourPackages,
            'heroTitle' => $heroTitle,
            'heroDescription' => $heroDescription,
        ]);
    }

    /**
     * Store a new booking.
     */
    public function store(StoreBookingRequest $request)
    {
        $validated = $request->validated();
        
        // Generate booking code and QR code
        $bookingCode = Booking::generateBookingCode();
        $qrCode = 'QR-' . $bookingCode . '-' . time();
        
        // Calculate total price
        $totalPrice = 0;
        if ($validated['booking_type'] === 'boat_ticket') {
            $ticket = BoatTicket::findOrFail($validated['boat_ticket_id']);
            $totalPrice = $ticket->price * $validated['passenger_count'];
        } else {
            $package = TourPackage::findOrFail($validated['tour_package_id']);
            $totalPrice = $package->price * $validated['passenger_count'];
        }
        
        // Create booking
        $booking = Booking::create([
            ...$validated,
            'booking_code' => $bookingCode,
            'total_price' => $totalPrice,
            'qr_code' => $qrCode,
        ]);
        
        return Inertia::render('booking/success', [
            'booking' => $booking->load(['boatTicket', 'tourPackage']),
        ]);
    }


}