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
        Schema::create('users_detail', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        $table->date('tanggal_lahir');
        $table->enum('gender', ['Laki-laki', 'Perempuan']);
        $table->enum('jenis_id', ['KTP', 'SIM', 'Paspor']);
        $table->string('nomor_identitas');
        $table->string('kota_asal');
        $table->string('ZipCode');
        $table->string('foto_profil')->nullable();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_detail');
    }
};
