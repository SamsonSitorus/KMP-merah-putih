<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('booking_vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->onDelete('cascade');
            $table->string('vehicle_type');
            $table->string('no_plat');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('booking_vehicles');
    }
};
