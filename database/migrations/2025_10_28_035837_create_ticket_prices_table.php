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
            $table->enum('passenger_type', ['Dewasa', 'Anak-anak']);
            $table->decimal('price', 10, 2);
            $table->timestamps();

            $table->unique(['ticket_stock_id', 'passenger_type']); // biar 1 tipe penumpang per stok
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
