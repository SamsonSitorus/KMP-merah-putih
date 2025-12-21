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
            $table->foreignId('ticket_stock_id')->constrained('ticket_stocks')->onDelete('cascade');

            // Kolom penumpang (opsional)
            $table->enum('passenger_type', ['Dewasa', 'Anak-anak'])->nullable();

            // Kolom kendaraan (opsional)
            $table->enum('vehicle_type', [
                'Motor',
                'Mobil Sedan',
                'Mobil Box',
                'Mobil Truck',
                'Mobil SUV'
            ])->nullable();

            $table->decimal('price', 10, 2);
            $table->timestamps();

            // Cegah duplikasi kombinasi stok & tipe
            $table->unique(['ticket_stock_id', 'passenger_type', 'vehicle_type']);
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
