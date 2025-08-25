<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BookingManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Booking::with(['boatTicket', 'tourPackage']);
        
        // Filter by payment status
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('payment_status', $request->status);
        }
        
        // Filter by booking type
        if ($request->has('type') && $request->type !== 'all') {
            $query->where('booking_type', $request->type);
        }
        
        // Search by booking code, name, or email
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('booking_code', 'like', "%{$search}%")
                  ->orWhere('full_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        $bookings = $query->latest()->paginate(15);
        
        return Inertia::render('admin/bookings/index', [
            'bookings' => $bookings,
            'filters' => $request->only(['status', 'type', 'search']),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        $booking->load(['boatTicket', 'tourPackage']);
        
        return Inertia::render('admin/bookings/show', [
            'booking' => $booking,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Booking $booking)
    {
        $request->validate([
            'payment_status' => 'required|in:pending,paid,cancelled',
        ]);
        
        $booking->update([
            'payment_status' => $request->payment_status,
            'paid_at' => $request->payment_status === 'paid' ? now() : null,
        ]);
        
        return redirect()->back()
            ->with('success', 'Status pembayaran berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        $booking->delete();

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking berhasil dihapus.');
    }
}