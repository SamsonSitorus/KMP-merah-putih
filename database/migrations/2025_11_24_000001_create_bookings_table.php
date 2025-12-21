<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('ticket_stock_id')->nullable();
            $table->date('departure_date')->nullable();
            $table->string('departure_time')->nullable();
            $table->integer('dewasa_count')->default(0);
            $table->integer('anak_count')->default(0);
            $table->decimal('total_price', 12, 2)->default(0);
            $table->string('payment_proof_path')->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bookings');
    }
};
    