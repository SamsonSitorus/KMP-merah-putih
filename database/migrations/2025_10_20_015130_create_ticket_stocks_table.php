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
        Schema::create('ticket_stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('origin_port_id')->constrained('ports')->onDelete('cascade');
            $table->foreignId('destination_port_id')->constrained('ports')->onDelete('cascade');
            $table->date('departure_date');
            $table->time('departure_time')->default('08:00:00');
            $table->integer('stock_roda_4');
            $table->integer('stock_roda_2');
            $table->integer('stock_passenger');
            $table->timestamps();
           $table->unique(['origin_port_id','destination_port_id','departure_date','departure_time'],'uniq_ticket_stock');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_stocks');
    }
};
