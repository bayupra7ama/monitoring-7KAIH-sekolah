<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tabel Master Kebiasaan (Daftar 7 Poin Tetap)
        Schema::create('master_kebiasaans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kebiasaan'); // Contoh: "Bangun Pagi"
            $table->string('icon')->nullable(); // Opsional: nama file icon/emoji
            $table->timestamps();
        });

        // 2. Tabel Jurnal Harian (Rekam Jejak)
        Schema::create('jurnals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('kebiasaan_id')->constrained('master_kebiasaans')->onDelete('cascade');
            
            $table->date('tanggal'); // Laporan tanggal berapa
            $table->boolean('status')->default(false); // 1 = Dilakukan, 0 = Belum
            $table->string('keterangan')->nullable(); // <-- INI YANG BARU (Untuk simpan jam/lauk dll)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jurnals');
        Schema::dropIfExists('master_kebiasaans');
    }
};