<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema; // <--- Jangan lupa tambah ini

class KebiasaanSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Matikan pengecekan Foreign Key sementara
        Schema::disableForeignKeyConstraints();

        // 2. Kosongkan tabel Jurnal dulu (karena ini tabel anaknya)
        // Kalau master diganti, data jurnal lama jadi tidak valid, jadi harus dibersihkan
        DB::table('jurnals')->truncate(); 

        // 3. Baru kosongkan tabel Master Kebiasaan
        DB::table('master_kebiasaans')->truncate();

        // 4. Nyalakan lagi pengecekan Foreign Key
        Schema::enableForeignKeyConstraints();

        // 5. Masukkan Data Baru Request Klien
        $kebiasaans = [
            ['nama_kebiasaan' => 'Bangun pagi', 'icon' => '🌅'],
            ['nama_kebiasaan' => 'Beribadah', 'icon' => '🕌'],
            ['nama_kebiasaan' => 'Berolahraga', 'icon' => '🏃'],
            ['nama_kebiasaan' => 'Makan sehat dan bergizi', 'icon' => '🥗'],
            ['nama_kebiasaan' => 'Gemar belajar', 'icon' => '📚'],
            ['nama_kebiasaan' => 'Bermasyarakat', 'icon' => '🤝'],
            ['nama_kebiasaan' => 'Tidur cepat', 'icon' => '😴'],
        ];

        DB::table('master_kebiasaans')->insert($kebiasaans);
    }
}