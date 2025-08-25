<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBoatTicketRequest;
use App\Http\Requests\UpdateBoatTicketRequest;
use App\Models\BoatTicket;
use Inertia\Inertia;

class BoatTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $boatTickets = BoatTicket::latest()->paginate(10);
        
        return Inertia::render('admin/boat-tickets/index', [
            'boatTickets' => $boatTickets,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('admin/boat-tickets/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBoatTicketRequest $request)
    {
        BoatTicket::create($request->validated());

        return redirect()->route('admin.boat-tickets.index')
            ->with('success', 'Tiket boat berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(BoatTicket $boatTicket)
    {
        $boatTicket->load(['bookings' => function ($query) {
            $query->latest()->limit(10);
        }]);
        
        return Inertia::render('admin/boat-tickets/show', [
            'boatTicket' => $boatTicket,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BoatTicket $boatTicket)
    {
        return Inertia::render('admin/boat-tickets/edit', [
            'boatTicket' => $boatTicket,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBoatTicketRequest $request, BoatTicket $boatTicket)
    {
        $boatTicket->update($request->validated());

        return redirect()->route('admin.boat-tickets.index')
            ->with('success', 'Tiket boat berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BoatTicket $boatTicket)
    {
        $boatTicket->delete();

        return redirect()->route('admin.boat-tickets.index')
            ->with('success', 'Tiket boat berhasil dihapus.');
    }
}