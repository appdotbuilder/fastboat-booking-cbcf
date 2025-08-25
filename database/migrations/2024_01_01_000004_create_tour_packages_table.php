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
        Schema::create('tour_packages', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Tour package name');
            $table->text('description')->comment('Tour package description');
            $table->decimal('price', 10, 2)->comment('Tour package price');
            $table->integer('duration_days')->comment('Tour duration in days');
            $table->text('includes')->nullable()->comment('What is included in the package');
            $table->text('itinerary')->nullable()->comment('Tour itinerary');
            $table->boolean('is_active')->default(true)->comment('Package availability status');
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
        Schema::dropIfExists('tour_packages');
    }
};