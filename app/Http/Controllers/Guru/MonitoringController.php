<?php

namespace App\Http\Controllers\Guru;

use App\Exports\JurnalBulananExport;
use App\Exports\JurnalSiswaBulananExport;
use App\Http\Controllers\Controller;
use App\Models\Jurnal;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class MonitoringController extends Controller
{
    public function index(Request $request)
    {
        $guru = Auth::user();
        $kelas = $guru->classAsTeacher;

        // Jika guru belum punya kelas
        if (!$kelas) {
            return view('guru.monitoring.empty');
        }

        // 1. Filter Bulan & Tahun (Default: Bulan Ini)
        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');

        // Hitung jumlah hari dalam bulan tersebut (untuk pembagi persentase)
        $totalHari = Carbon::createFromDate($tahun, $bulan)->daysInMonth;
        // Total Poin Maksimal = Jumlah Hari x 7 Kebiasaan
        $maxPoin = $totalHari * 7;

        // 2. Ambil Siswa & Hitung Statistiknya
        $students = $kelas->students()->orderBy('name')->get()->map(function ($student) use ($bulan, $tahun, $maxPoin) {

            // Hitung berapa kali dia mencentang (status = 1) di bulan ini
            $poinDidapat = Jurnal::where('student_id', $student->id)
                ->whereMonth('tanggal', $bulan)
                ->whereYear('tanggal', $tahun)
                ->where('status', true)
                ->count();

            // Hitung Persentase
            $persentase = $maxPoin > 0 ? round(($poinDidapat / $maxPoin) * 100) : 0;

            // Tentukan Predikat
            if ($persentase >= 90)
                $predikat = 'Sangat Baik';
            elseif ($persentase >= 75)
                $predikat = 'Baik';
            elseif ($persentase >= 50)
                $predikat = 'Cukup';
            else
                $predikat = 'Perlu Bimbingan';

            // Attach data ke object student
            $student->statistik = (object) [
                'poin' => $poinDidapat,
                'persentase' => $persentase,
                'predikat' => $predikat
            ];

            return $student;
        });

        return view('guru.monitoring.index', compact('students', 'bulan', 'tahun', 'kelas'));
    }

    public function daily(Request $request)
    {
        $guru = Auth::user();
        $kelas = $guru->classAsTeacher;

        if (!$kelas) {
            return view('guru.monitoring.empty');
        }

        // 1. Tentukan Tanggal (Default Hari Ini)
        $tanggal = $request->date ? Carbon::parse($request->date) : Carbon::today();

        // 2. Ambil Daftar 7 Kebiasaan (Untuk Header Tabel)
        $masterKebiasaans = \App\Models\MasterKebiasaan::all();

        // 3. Ambil Siswa beserta Jurnal-nya pada TANGGAL TERSEBUT
        $students = $kelas->students()->orderBy('name')->get()->map(function ($student) use ($tanggal) {

            // Ambil data jurnal anak ini di tanggal tsb
            // Kita format jadi array [ kebiasaan_id => status ] biar gampang dipanggil di view
            $jurnalHariIni = Jurnal::where('student_id', $student->id)
                ->whereDate('tanggal', $tanggal)
                ->pluck('status', 'kebiasaan_id')
                ->toArray();

            $student->jurnal_harian = $jurnalHariIni;

            // Cek apakah dia mengisi setidaknya 1 checklist?
            $student->sudah_lapor = count($jurnalHariIni) > 0;

            return $student;
        });

        return view('guru.monitoring.daily', compact('students', 'kelas', 'tanggal', 'masterKebiasaans'));
    }

    public function studentDetail(Request $request, $studentId)
    {
        $guru = Auth::user();
        $student = Student::findOrFail($studentId);

        // Pastikan siswa ini muridnya guru tersebut (Security Check)
        if ($student->class->teacher_id != $guru->id) {
            abort(403, 'Anda tidak memiliki akses ke siswa ini.');
        }

        // Filter Bulan & Tahun
        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');
        $totalHari = Carbon::createFromDate($tahun, $bulan)->daysInMonth;

        $masterKebiasaans = \App\Models\MasterKebiasaan::all();

        // 1. Ambil Data Jurnal Bulan Ini
        $jurnals = Jurnal::where('student_id', $student->id)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->where('status', true)
            ->get();

        // 2. Hitung Statistik Per Kebiasaan (Untuk Card di atas)
        // Contoh: Bangun Pagi (20/30), Mandi (25/30)
        foreach ($masterKebiasaans as $master) {
            $count = $jurnals->where('kebiasaan_id', $master->id)->count();
            $master->total_checklist = $count;
            $master->persentase = $totalHari > 0 ? round(($count / $totalHari) * 100) : 0;

            // Tentukan warna progress bar berdasarkan performa
            if ($master->persentase >= 90)
                $master->color = 'bg-green-500';
            elseif ($master->persentase >= 70)
                $master->color = 'bg-blue-500';
            elseif ($master->persentase >= 50)
                $master->color = 'bg-yellow-500';
            else
                $master->color = 'bg-red-500';
        }

        // 3. Siapkan Data Kalender (Tanggal 1 s/d Akhir Bulan)
        // Kita butuh tahu di tanggal X, kebiasaan Y sudah diceklis belum?
        $calendarData = [];
        for ($d = 1; $d <= $totalHari; $d++) {
            $dateStr = sprintf('%s-%02d-%02d', $tahun, $bulan, $d);

            // BARU: Ambil object jurnal utuh, lalu jadikan kebiasaan_id sebagai Key
            $dailyJurnal = $jurnals->where('tanggal', $dateStr)->keyBy('kebiasaan_id');

            $calendarData[$d] = [
                'date' => Carbon::parse($dateStr),
                'jurnals' => $dailyJurnal // Kita lempar seluruh object, bukan cuma array ID
            ];
        }

        return view('guru.monitoring.detail_siswa', compact('student', 'masterKebiasaans', 'calendarData', 'bulan', 'tahun'));
    }

    public function studentDetailDaily(Request $request, $studentId)
    {
        $guru = Auth::user();
        $student = Student::findOrFail($studentId);

        // Pastikan siswa ini muridnya guru tersebut (Security Check)
        if ($student->class->teacher_id != $guru->id) {
            abort(403, 'Anda tidak memiliki akses ke siswa ini.');
        }

        // Tentukan Tanggal (Default Hari Ini)
        $tanggal = $request->date ? Carbon::parse($request->date) : Carbon::today();

        $masterKebiasaans = \App\Models\MasterKebiasaan::all();

        // Ambil Jurnal Harian khusus tanggal tersebut
        $jurnalHariIni = \App\Models\Jurnal::where('student_id', $student->id)
            ->whereDate('tanggal', $tanggal)
            ->get()
            ->keyBy('kebiasaan_id'); // Format agar key-nya menggunakan ID kebiasaan biar gampang dipanggil di view

        return view('guru.monitoring.detail_siswa_harian', compact('student', 'tanggal', 'masterKebiasaans', 'jurnalHariIni'));
    }

    // --- FITUR BARU: EXPORT EXCEL BULANAN ---
    public function exportExcel(Request $request)
    {
        $guru = Auth::user();
        $kelas = $guru->classAsTeacher;

        if (!$kelas) {
            return back()->with('error', 'Anda belum memiliki kelas.');
        }

        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');

        $totalHari = Carbon::createFromDate($tahun, $bulan)->daysInMonth;

        // Asumsi ada 7 master kebiasaan, sesuaikan jika jumlah kebiasaan Mas berbeda
        $jumlahKebiasaan = \App\Models\MasterKebiasaan::count();
        $maxPoin = $totalHari * $jumlahKebiasaan;

        $namaBulan = Carbon::createFromDate($tahun, $bulan, 1)->isoFormat('MMMM');

        // Nama file Excel yang akan terunduh
        $fileName = "Rekap_Jurnal_Kelas_{$kelas->name}_{$namaBulan}_{$tahun}.xlsx";

        return Excel::download(new JurnalBulananExport($kelas->id, $bulan, $tahun, $maxPoin), $fileName);
    }

    // : EXPORT EXCEL PER SISWA ---
    public function exportExcelSiswa(Request $request, $studentId)
    {
        $guru = Auth::user();
        $student = Student::findOrFail($studentId);

        // Security check
        if ($student->class->teacher_id != $guru->id) {
            abort(403, 'Anda tidak memiliki akses ke siswa ini.');
        }

        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');

        $namaBulan = Carbon::createFromDate($tahun, $bulan, 1)->isoFormat('MMMM');

        // Buat nama file yang rapi
        $fileName = "Jurnal_{$student->name}_{$namaBulan}_{$tahun}.xlsx";

        return Excel::download(new JurnalSiswaBulananExport($student->id, $bulan, $tahun), $fileName);
    }
}