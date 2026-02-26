<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('materis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guru_id')->constrained('users')->onDelete('cascade'); // Relasi ke Guru
            $table->string('judul');
            $table->text('deskripsi'); // Untuk "Teks penjelasan kebiasaan"
            $table->string('file_pdf')->nullable(); // Untuk "File PDF / modul"
            $table->string('video')->nullable(); // Untuk "Video pendek edukasi"
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('materis');
    }
};