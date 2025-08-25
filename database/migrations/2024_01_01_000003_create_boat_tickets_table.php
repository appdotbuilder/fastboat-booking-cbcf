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
        Schema::create('boat_tickets', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Ticket name (e.g. Bali - Gili)');
            $table->string('origin')->comment('Origin location');
            $table->string('destination')->comment('Destination location');
            $table->text('description')->nullable()->comment('Ticket description');
            $table->decimal('price', 10, 2)->comment('Ticket price');
            $table->integer('duration_hours')->comment('Journey duration in hours');
            $table->boolean('is_active')->default(true)->comment('Ticket availability status');
            $table->timestamps();
            
            $table->index(['is_active', 'price']);
            $table->index('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('boat_tickets');
    }
};