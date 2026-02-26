<?php

namespace App\Http\Controllers\Orangtua;

use App\Http\Controllers\Controller;
use App\Models\Materi;
use App\Models\Feedback;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class DashboardController extends Controller
{
    public function index()
    {
        $orangtua = Auth::user();

        // Ambil data anak-anak dari orang tua ini
        $children = $orangtua->children()->with('class.teacher')->get();

        // Ambil ID kelas anak-anaknya
        $classIds = $children->pluck('class_id')->unique();

        // Cari Guru ID dari kelas-kelas tersebut (Siapa wali kelasnya?)
        $teacherIds = \App\Models\ClassRoom::whereIn('id', $classIds)->pluck('teacher_id')->unique();

        // Tampilkan materi TERBARU dari guru-guru tersebut
        // Kita juga load relasi 'feedbacks' untuk cek apakah orang tua ini sudah pernah komen di materi itu
        $materis = Materi::whereIn('guru_id', $teacherIds)
            ->with([
                'guru',
                'feedbacks' => function ($q) use ($orangtua) {
                    $q->where('user_id', $orangtua->id);
                }
            ])
            ->latest()
            ->take(5) // Ambil 5 materi terbaru untuk dashboard
            ->get();

        // Hitung statistik sederhana
        $totalAnak = $children->count();
        $tugasSelesai = Feedback::where('user_id', $orangtua->id)->where('sudah_diterapkan', true)->count();

        return view('orangtua.dashboard', compact('children', 'materis', 'totalAnak', 'tugasSelesai'));
    }

    public function show($id)
    {
        $materi = Materi::with('guru')->findOrFail($id);

        // Ambil data anak-anak dari orang tua yang login
        // Kita butuh ini agar Orang Tua bisa memilih anak mana yang sudah mengerjakan
        $children = Auth::user()->children;

        // Cek feedback/laporan yang sudah pernah dibuat sebelumnya untuk materi ini
        // Agar nanti di tampilan bisa otomatis ter-centang kalau sudah pernah lapor
        $existingFeedbacks = Feedback::where('user_id', Auth::id())
            ->where('materi_id', $id)
            ->get()
            ->keyBy('student_id'); // Key array pakai ID anak biar gampang dicek

        return view('orangtua.materi.show', compact('materi', 'children', 'existingFeedbacks'));
    }

    // 2. Function Simpan Laporan / Feedback
    // 2. Function Simpan Laporan / Feedback (VERSI PERBAIKAN)
    public function storeFeedback(Request $request, $id)
    {
        $request->validate([
            'student_ids' => 'required|array', // Wajib pilih minimal 1 anak
            'isi_feedback' => 'nullable|string',
        ]);

        $materi = Materi::findOrFail($id);

        // Ambil ID anak-anak dari user yang login (untuk validasi keamanan)
        // pluck('id')->toArray() memastikan kita punya list ID anak yang valid
        $validChildIds = Auth::user()->children->pluck('id')->toArray();

        // Loop setiap anak yang dipilih di form
        foreach ($request->student_ids as $studentId) {

            // Validasi: Pastikan ID yang dikirim benar-benar anak dari user ini
            // Agar orang tidak bisa iseng ganti ID anak orang lain
            if (!in_array($studentId, $validChildIds)) {
                continue; // Skip kalau bukan anaknya
            }

            // Simpan atau Update Data Feedback
            Feedback::updateOrCreate(
                [
                    // Kondisi Pencarian (Kunci Unik)
                    'user_id' => Auth::id(),
                    'materi_id' => $materi->id,
                    'student_id' => $studentId,
                ],
                [
                    // Data yang di-update/insert
                    'sudah_diterapkan' => true,
                    'isi_feedback' => $request->isi_feedback,
                    // HAPUS BARIS 'tanggal' => now(), KARENA TIDAK ADA DI DATABASE
                ]
            );
        }

        return back()->with('success', 'Laporan berhasil disimpan! Terima kasih Ayah/Bunda.');
    }

    public function listMateri(Request $request, $studentId)
    {

        $anak = Auth::user()->children()->where('students.id', $studentId)->first();

        if (!$anak) {
            abort(404, 'Data anak tidak ditemukan atau akses ditolak.');
        }


        $materis = Materi::where('guru_id', $anak->class->teacher_id)
            ->with([
                'feedbacks' => function ($q) use ($anak) {
                    $q->where('student_id', $anak->id); // Cek feedback khusus anak ini
                }
            ])
            ->latest()
            ->paginate(10); // Tampilkan 10 materi per halaman

        return view('orangtua.materi.list', compact('anak', 'materis'));
    }

    public function historyFeedback()
    {
        $feedbacks = Feedback::where('user_id', Auth::id())
            ->with(['student', 'materi.guru']) // Ambil data Anak & Guru pemilik materi
            ->latest() // Urutkan dari yang terbaru
            ->paginate(10);

        return view('orangtua.feedback.index', compact('feedbacks'));
    }
}