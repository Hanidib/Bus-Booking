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
            $table->id('bookingId');             // Primary key
            $table->unsignedBigInteger('userId');  // Foreign key to users
            $table->unsignedBigInteger('seatId');  // Foreign key to seats
            $table->unsignedBigInteger('routeId'); // Foreign key to routes

            $table->date('bookingDate');         // Date of booking
            $table->string('status');             // Booking status (e.g. 'confirmed', 'pending')

            $table->timestamps();                 // created_at and updated_at

            // Foreign key constraints
            $table->foreign('userId')->references('userId')->on('users')->onDelete('cascade');
            $table->foreign('seatId')->references('seatId')->on('seats')->onDelete('cascade');
            $table->foreign('routeId')->references('routeId')->on('routes')->onDelete('cascade');
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
