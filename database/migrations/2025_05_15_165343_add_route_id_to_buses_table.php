<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('buses', function (Blueprint $table) {
            $table->unsignedBigInteger('routeId')->nullable();

            // Optional: Add foreign key
            $table->foreign('routeId')->references('routeId')->on('routes')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('buses', function (Blueprint $table) {
            $table->dropForeign(['routeId']);
            $table->dropColumn('routeId');
        });
    }
};
