<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Materi;
use Illuminate\Support\Facades\Auth;

class DashboardGuruController extends Controller
{
    public function index()
    {
        $guru = Auth::user();
        
        // Mengambil kelas yang diajar oleh guru ini
        // Menggunakan relasi 'classAsTeacher' yang sudah ada di Model User
        $kelas = $guru->classAsTeacher; 

        // Hitung statistik
        $totalSiswa = $kelas ? $kelas->students()->count() : 0;
        $totalMateri = Materi::where('guru_id', $guru->id)->count();
        $namaKelas = $kelas ? $kelas->name : 'Belum ada kelas';

        return view('guru.dashboard', compact('totalSiswa', 'totalMateri', 'namaKelas', 'kelas'));
    }
}