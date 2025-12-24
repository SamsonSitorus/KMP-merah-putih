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
            $table->string('name'); // Dewasa, Anak, Mobil pickup, dll
            $table->foreignId('ticket_type_id')->constrained('ticket_types')->cascadeOnDelete();
            $table->unsignedInteger('price');
            $table->timestamps();
            $table->unique(['name']);
            $table->unique(['ticket_type_id', 'name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ticket_prices');
    }
};
