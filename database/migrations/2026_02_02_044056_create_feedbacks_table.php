<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id();
            // Siapa yang lapor? (Orang Tua)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            // Materi apa yang dilaporkan?
            $table->foreignId('materi_id')->constrained('materis')->onDelete('cascade');
            // Untuk anak yang mana? (Karena 1 ortu bisa banyak anak)
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            
            // Status: Apakah sudah diterapkan di rumah?
            $table->boolean('sudah_diterapkan')->default(false);
            
            // Komentar / Feedback (Opsional)
            $table->text('isi_feedback')->nullable();
            
            // Foto Bukti (Opsional, kalau mau canggih nanti)
            $table->string('foto_bukti')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feedbacks');
    }
};