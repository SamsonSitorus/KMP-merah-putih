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
        Schema::create('ticket_prices', function (Blueprint $table) {
            $table->id();

            $table->foreignId('ticket_stock_id')
                  ->constrained('ticket_stocks')
                  ->cascadeOnDelete();

            // ENUM jenis penumpang
            $table->enum('passenger_type', [
                'Dewasa',
                'Bayi'
            ])->nullable();

            // ENUM jenis kendaraan
            $table->enum('vehicle_type', [
                'Sepeda Dayung',
                'Sepeda Motor',
                'Becak / Sepeda Motor > 500 cc',
                'Mini Bus Roda 4',
                'Pick Up',
                'Bus Sedang Roda 4',
                'Kendaraan Barang Roda 4'
            ])->nullable();

            $table->integer('price');
            $table->timestamps();

            // Cegah duplikasi kombinasi
            $table->unique([
                'ticket_stock_id',
                'passenger_type',
                'vehicle_type'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_prices');
    }
};
