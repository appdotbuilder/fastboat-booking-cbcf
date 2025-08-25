<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTourPackageRequest;
use App\Http\Requests\UpdateTourPackageRequest;
use App\Models\TourPackage;
use Inertia\Inertia;

class TourPackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tourPackages = TourPackage::latest()->paginate(10);
        
        return Inertia::render('admin/tour-packages/index', [
            'tourPackages' => $tourPackages,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('admin/tour-packages/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTourPackageRequest $request)
    {
        TourPackage::create($request->validated());

        return redirect()->route('admin.tour-packages.index')
            ->with('success', 'Paket wisata berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(TourPackage $tourPackage)
    {
        $tourPackage->load(['bookings' => function ($query) {
            $query->latest()->limit(10);
        }]);
        
        return Inertia::render('admin/tour-packages/show', [
            'tourPackage' => $tourPackage,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TourPackage $tourPackage)
    {
        return Inertia::render('admin/tour-packages/edit', [
            'tourPackage' => $tourPackage,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTourPackageRequest $request, TourPackage $tourPackage)
    {
        $tourPackage->update($request->validated());

        return redirect()->route('admin.tour-packages.index')
            ->with('success', 'Paket wisata berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TourPackage $tourPackage)
    {
        $tourPackage->delete();

        return redirect()->route('admin.tour-packages.index')
            ->with('success', 'Paket wisata berhasil dihapus.');
    }
}