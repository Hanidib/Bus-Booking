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
        Schema::create('pnrs', function (Blueprint $table) {
            $table->id('pnrId');
            $table->unsignedBigInteger('bookingId');
            $table->string('pnrCode')->unique();
            $table->date('issuedAt');
            $table->timestamps();

            $table->foreign('bookingId')->references('bookingId')->on('bookings')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pnrs');
    }
};
