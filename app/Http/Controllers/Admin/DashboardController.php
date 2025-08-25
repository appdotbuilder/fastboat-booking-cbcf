<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BoatTicket;
use App\Models\Booking;
use App\Models\TourPackage;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        // Get statistics
        $totalBookings = Booking::count();
        $paidBookings = Booking::paid()->count();
        $pendingBookings = Booking::pending()->count();
        $totalRevenue = Booking::paid()->sum('total_price');
        
        // Recent bookings
        $recentBookings = Booking::with(['boatTicket', 'tourPackage'])
            ->latest()
            ->limit(5)
            ->get();
        
        // Popular packages/tickets
        $popularBoatTickets = BoatTicket::select('boat_tickets.*')
            ->join('bookings', 'boat_tickets.id', '=', 'bookings.boat_ticket_id')
            ->select('boat_tickets.name', DB::raw('COUNT(bookings.id) as booking_count'))
            ->groupBy('boat_tickets.id', 'boat_tickets.name')
            ->orderByDesc('booking_count')
            ->limit(5)
            ->get();
            
        $popularTourPackages = TourPackage::select('tour_packages.*')
            ->join('bookings', 'tour_packages.id', '=', 'bookings.tour_package_id')
            ->select('tour_packages.name', DB::raw('COUNT(bookings.id) as booking_count'))
            ->groupBy('tour_packages.id', 'tour_packages.name')
            ->orderByDesc('booking_count')
            ->limit(5)
            ->get();
        
        // Monthly revenue data
        $monthlyRevenue = Booking::paid()
            ->select(DB::raw("strftime('%m', created_at) as month"), DB::raw('SUM(total_price) as revenue'))
            ->whereYear('created_at', date('Y'))
            ->groupBy(DB::raw("strftime('%m', created_at)"))
            ->orderBy('month')
            ->get();
        
        return Inertia::render('admin/dashboard', [
            'stats' => [
                'totalBookings' => $totalBookings,
                'paidBookings' => $paidBookings,
                'pendingBookings' => $pendingBookings,
                'totalRevenue' => $totalRevenue,
            ],
            'recentBookings' => $recentBookings,
            'popularBoatTickets' => $popularBoatTickets,
            'popularTourPackages' => $popularTourPackages,
            'monthlyRevenue' => $monthlyRevenue,
        ]);
    }
}