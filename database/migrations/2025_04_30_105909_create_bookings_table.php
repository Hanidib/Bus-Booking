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
            $table->id('bookingId');

            $table->unsignedBigInteger('userId');
            $table->foreign('userId')->references('userId')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('seatId');
            $table->foreign('seatId')->references('seatId')->on('seats')->onDelete('cascade');

            $table->date('bookingDate');
            $table->timestamps();
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
