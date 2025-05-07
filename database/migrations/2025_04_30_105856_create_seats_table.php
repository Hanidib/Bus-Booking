<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('seats', function (Blueprint $table) {
            $table->id('seatId');
            $table->unsignedBigInteger('busId');
            $table->string('seatNumber')->unique();
            $table->boolean('isAvailable')->default(true);
            $table->timestamps();

            $table->foreign('busId')->references('busId')->on('buses')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seats');
    }
};
