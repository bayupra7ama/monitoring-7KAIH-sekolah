<?php

namespace App\Http\Controllers\Orangtua;

use App\Http\Controllers\Controller;
use App\Models\MasterKebiasaan;
use App\Models\Jurnal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class JurnalController extends Controller
{
    public function index(Request $request, $studentId)
    {
        $anak = Auth::user()->children()->where('students.id', $studentId)->firstOrFail();

        // 1. Tentukan Tanggal
        $tanggal = $request->date ? Carbon::parse($request->date) : Carbon::today();

        // 2. Tentukan Batas Waktu (5 Hari ke Belakang)
        $batasBawah = Carbon::today()->subDays(5);

        // Validasi: Tidak boleh masa depan
        if ($tanggal->isFuture()) {
            return redirect()->route('orangtua.jurnal.index', ['studentId' => $studentId]);
        }

        // Validasi: Tidak boleh lewat dari 5 hari lalu
        if ($tanggal->lt($batasBawah)) {
            return redirect()->route('orangtua.jurnal.index', [
                'studentId' => $studentId,
                'date' => $batasBawah->format('Y-m-d')
            ])->with('error', 'Maaf, pengisian jurnal sudah ditutup untuk tanggal tersebut (Maksimal 5 hari).');
        }

        $kebiasaans = MasterKebiasaan::all();
        $existingJurnal = Jurnal::where('student_id', $anak->id)
            ->whereDate('tanggal', $tanggal)
            ->get()
            ->keyBy('kebiasaan_id');

        return view('orangtua.jurnal.index', compact('anak', 'tanggal', 'kebiasaans', 'existingJurnal', 'batasBawah'));
    }

    public function store(Request $request, $studentId)
    {
        // 1. Validasi Kepemilikan (Sangat Rapi & Aman)
        $anak = Auth::user()->children()->where('students.id', $studentId)->firstOrFail();

        // 2. Hitung batas waktu dinamis untuk validasi
        $batasBawah = Carbon::today()->subDays(5)->format('Y-m-d');

        // 3. Validasi Request (Tanggal & Array Keterangan)
        $request->validate([
            'tanggal' => [
                'required',
                'date',
                'before_or_equal:today',
                'after_or_equal:' . $batasBawah
            ],
            'keterangan' => 'array',
        ], [
            'tanggal.after_or_equal' => 'Maaf, Anda sudah tidak bisa mengisi jurnal untuk tanggal ini (Lewat batas maksimal).',
            'tanggal.before_or_equal' => 'Maaf, Anda tidak bisa mengisi jurnal untuk tanggal di masa depan.',
        ]);

        $tanggal = $request->tanggal;
        $keteranganInputs = $request->keterangan ?? [];
        $allKebiasaans = \App\Models\MasterKebiasaan::all();

        // 4. Looping & Simpan Data
        foreach ($allKebiasaans as $master) {
            // Ambil teks/jam yang diinput ortu, bersihkan spasi
            $keterangan = isset($keteranganInputs[$master->id]) ? trim($keteranganInputs[$master->id]) : null;

            // Set default status false
            $status = false;

            if (!empty($keterangan)) {
                // Jika form ada isinya, default kita anggap true dulu
                $status = true;

                // --- LOGIKA CEK JAM KHUSUS ---
                if ($master->nama_kebiasaan == 'Bangun pagi') {
                    // Konversi ke format HH:MM biar aman dibandingin
                    $jamBangun = date('H:i', strtotime($keterangan));

                    // Jika bangun lewat dari jam 06:00 pagi, maka dianggap gagal (false)
                    if ($jamBangun > '06:00') {
                        $status = false;
                    }
                } elseif ($master->nama_kebiasaan == 'Tidur cepat') {
                    // Konversi ke format HH:MM
                    $jamTidur = date('H:i', strtotime($keterangan));

                    // Logika: Jika tidur di atas jam 22:00 malam ATAU tidur setelah jam 00:00 (tengah malam)
                    // (Kita anggap jam tidur normal adalah antara 18:00 sore sampai 22:00 malam)
                    if ($jamTidur > '22:00' || $jamTidur < '18:00') {
                        $status = false;
                    }
                }
            }

            // Simpan ke database
            \App\Models\Jurnal::updateOrCreate(
                [
                    'student_id' => $anak->id,
                    'kebiasaan_id' => $master->id,
                    'tanggal' => $tanggal,
                ],
                [
                    'status' => $status,
                    'keterangan' => $keterangan, // Teks jam/lauk tetap tersimpan di DB apapun statusnya
                ]
            );
        }

        return back()->with('success', 'Jurnal berhasil disimpan!');
    }
}