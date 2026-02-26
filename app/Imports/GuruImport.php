<?php

namespace App\Imports;

use App\Models\User;
use App\Models\ClassRoom;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class GuruImport implements ToCollection, WithStartRow
{
    // Flag statis agar sistem HANYA mengimport Sheet 1 dan mengabaikan Sheet 2
    private static $sheetProcessed = false;

    public function startRow(): int
    {
        return 5;
    }

    public function collection(Collection $rows)
    {
        // Jika sheet pertama sudah selesai dibaca, langsung stop!
        if (self::$sheetProcessed) {
            return;
        }
        self::$sheetProcessed = true;

        foreach ($rows as $row) {
            $rawName = $row[1] ?? null;

            if (!$rawName || stripos($rawName, 'Nama Pegawai') !== false || stripos($rawName, 'No Urut') !== false) {
                continue;
            }

            // Bersihkan Nama
            $cleanName = preg_replace('/(NIP\.|NI PPPK\.).*/i', '', $rawName);
            $cleanName = trim($cleanName);

            if (empty($cleanName)) continue;

            $phone = null;
            $kelasName = null;

            foreach ($row as $cell) {
                $cellStr = trim((string) $cell);
                
                // Cari Nomor HP
                if (preg_match('/^[0-9 \-\+]{9,15}$/', $cellStr)) {
                    $phone = str_replace([' ', '-', '+'], '', $cellStr);
                    
                    // NORMALISASI: Jika nomor diawali angka 8 (contoh: 813722...), tambahkan angka 0
                    if (str_starts_with($phone, '8')) {
                        $phone = '0' . $phone;
                    }
                } 
                // Cari Nama Kelas
                elseif (stripos($cellStr, 'KELAS') !== false) {
                    $kelasName = trim(str_ireplace('KELAS', '', $cellStr));
                }
            }

            if (!$phone) continue;

            // 1. Cek Duplikat Guru
            $guru = User::where('phone', $phone)->first();
            
            if (!$guru) {
                $guru = User::create([
                    'name' => $cleanName,
                    'phone' => $phone,
                    'email' => strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $cleanName)) . rand(10,99) . '@sekolah.com',
                    'password' => Hash::make('guru12345'),
                    'role' => 'guru',
                ]);
            } else {
                // Jika sudah ada, cukup update namanya agar sesuai data terbaru
                $guru->update(['name' => $cleanName]);
            }

            // 2. Buat atau Update Kelas secara Aman
            if ($kelasName) {
                // Cek apakah guru ini sudah jadi wali kelas di suatu kelas
                $existingClass = ClassRoom::where('teacher_id', $guru->id)->first();
                
                if ($existingClass) {
                    // Update nama kelasnya saja, jangan bikin kelas baru
                    $existingClass->update(['name' => $kelasName]);
                } else {
                    // Bikin kelas baru khusus untuk guru ini
                    ClassRoom::create([
                        'name' => $kelasName,
                        'teacher_id' => $guru->id
                    ]);
                }
            }
        }
    }
}