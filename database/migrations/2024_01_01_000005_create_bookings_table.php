<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_code')->unique()->comment('Unique booking reference code');
            $table->string('full_name')->comment('Customer full name');
            $table->string('email')->comment('Customer email');
            $table->string('phone')->comment('Customer phone number');
            $table->enum('booking_type', ['boat_ticket', 'tour_package'])->comment('Type of booking');
            $table->unsignedBigInteger('boat_ticket_id')->nullable()->comment('Boat ticket ID if boat booking');
            $table->unsignedBigInteger('tour_package_id')->nullable()->comment('Tour package ID if tour booking');
            $table->date('departure_date')->comment('Departure or trip date');
            $table->integer('passenger_count')->comment('Number of passengers');
            $table->decimal('total_price', 12, 2)->comment('Total booking price');
            $table->enum('payment_method', ['bank_transfer', 'office_payment', 'credit_card'])->comment('Payment method');
            $table->enum('payment_status', ['pending', 'paid', 'cancelled'])->default('pending')->comment('Payment status');
            $table->string('qr_code')->nullable()->comment('QR code for check-in validation');
            $table->timestamp('paid_at')->nullable()->comment('Payment confirmation timestamp');
            $table->timestamps();
            
            $table->foreign('boat_ticket_id')->references('id')->on('boat_tickets')->onDelete('cascade');
            $table->foreign('tour_package_id')->references('id')->on('tour_packages')->onDelete('cascade');
            
            $table->index(['payment_status', 'departure_date']);
            $table->index('booking_code');
            $table->index('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};