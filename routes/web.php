<?php

use App\Http\Controllers\Admin\BoatTicketController as AdminBoatTicketController;
use App\Http\Controllers\Admin\BookingManagementController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\Admin\TourPackageController as AdminTourPackageController;
use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;

Route::get('/health-check', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toISOString(),
    ]);
})->name('health-check');

// Public routes
Route::controller(BookingController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::post('/booking', 'store')->name('booking.store');
});

// Admin routes (protected by auth middleware)
Route::middleware(['auth', 'verified'])->group(function () {
    // Admin Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Boat Tickets Management
    Route::resource('admin/boat-tickets', AdminBoatTicketController::class, [
        'as' => 'admin'
    ]);
    
    // Tour Packages Management  
    Route::resource('admin/tour-packages', AdminTourPackageController::class, [
        'as' => 'admin'
    ]);
    
    // Bookings Management
    Route::controller(BookingManagementController::class)->group(function () {
        Route::get('admin/bookings', 'index')->name('admin.bookings.index');
        Route::get('admin/bookings/{booking}', 'show')->name('admin.bookings.show');
        Route::patch('admin/bookings/{booking}', 'update')->name('admin.bookings.update');
        Route::delete('admin/bookings/{booking}', 'destroy')->name('admin.bookings.destroy');
    });
    
    // Site Settings
    Route::controller(SiteSettingController::class)->group(function () {
        Route::get('admin/site-settings', 'index')->name('admin.site-settings.index');
        Route::patch('admin/site-settings', 'update')->name('admin.site-settings.update');
    });
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
