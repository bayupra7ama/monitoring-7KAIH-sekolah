<?php

namespace App\Imports;

use App\Models\Student;
use App\Models\ClassRoom;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class SiswaImport implements ToCollection, WithStartRow
{
    /**
     * Mulai baca dari baris ke-6 untuk melewati Kop Surat / Header Excel
     */
    public function startRow(): int
    {
        return 6;
    }

    public function collection(Collection $rows)
    {
        // Ambil semua data kelas di awal agar pencarian lebih cepat
        $allClasses = ClassRoom::all();

        foreach ($rows as $row) {
            // Biasanya kolom Nama ada di index 1 (Kolom B)
            $name = isset($row[1]) ? trim($row[1]) : null;

            // Abaikan jika nama kosong atau berisi teks header
            if (!$name || stripos($name, 'Nama') !== false || stripos($name, 'Peserta Didik') !== false) {
                continue;
            }

            $nisn = null;
            $classId = null;

            // Scan semua sel di baris ini untuk mencari NISN dan Rombel (Kelas)
            foreach ($row as $cell) {
                $val = trim($cell);

                if (empty($val))
                    continue;

                // 1. CARI NISN: Ciri-cirinya adalah persis 10 digit angka
                if (!$nisn && preg_match('/^\d{10}$/', $val)) {
                    $nisn = $val;
                }

                // 2. CARI KELAS: Coba cocokkan dengan nama kelas di database
                if (!$classId) {
                    $matchedClass = $allClasses->first(function ($c) use ($val) {
                        // Cocokkan nama kelas, abaikan huruf besar/kecil. 
                        // Misalnya di Excel tulisannya "1A" atau "Kelas 1A" atau "Rombel 1A"
                        return strtolower($c->name) === strtolower($val) ||
                            strtolower("Kelas " . $c->name) === strtolower($val) ||
                            strtolower("Rombel " . $c->name) === strtolower($val);
                    });

                    if ($matchedClass) {
                        $classId = $matchedClass->id;
                    }
                }
            }

            // Jika baris ini tidak punya NISN, lewati (karena NISN itu nyawa utamanya)
            if (!$nisn) {
                continue;
            }

            // 3. UPDATE ATAU CREATE DATA SISWA
            // Jika NISN sudah ada, update Nama & Kelasnya. Jika belum, buat baru.
            Student::updateOrCreate(
                ['nisn' => $nisn], // Cari berdasarkan NISN
                [
                    'name' => $name,
                    'class_id' => $classId, // Bisa berisi ID kelas atau Null
                ]
            );
        }
    }
}