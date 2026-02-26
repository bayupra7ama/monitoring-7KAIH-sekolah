<?php

namespace App\Exports;

use App\Models\Student;
use App\Models\Jurnal;
use App\Models\MasterKebiasaan;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class JurnalSiswaBulananExport implements FromArray, WithHeadings, ShouldAutoSize, WithStyles
{
    protected $studentId;
    protected $bulan;
    protected $tahun;

    public function __construct($studentId, $bulan, $tahun)
    {
        $this->studentId = $studentId;
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    // MEMBUAT JUDUL KOLOM (KOP SURAT & HEADER TABEL)
    public function headings(): array
    {
        $student = Student::with('class.teacher')->find($this->studentId);
        $namaBulan = Carbon::createFromDate($this->tahun, $this->bulan, 1)->isoFormat('MMMM Y');

        $namaKelas = $student && $student->class ? $student->class->name : '-';
        $namaGuru = ($student && $student->class && $student->class->teacher) ? $student->class->teacher->name : '-';

        // Header Dinamis Sesuai Master Kebiasaan
        $kebiasaans = MasterKebiasaan::all();
        $tableHeader = ['Tanggal'];
        foreach ($kebiasaans as $k) {
            $tableHeader[] = $k->nama_kebiasaan;
        }

        return [
            ['RAPOR JURNAL HARIAN SISWA'],
            ['Nama Siswa', ': ' . ($student ? $student->name : '-')],
            ['NISN', ': ' . ($student ? $student->nisn : '-')],
            ['Kelas', ': ' . $namaKelas],
            ['Wali Kelas', ': ' . $namaGuru],
            ['Bulan', ': ' . $namaBulan],
            ['Keterangan', ': (V) = Dikerjakan Sesuai Waktu | (X) = Tidak Dikerjakan / Expired / Telat | (-) = Belum Diisi'],
            [], // Baris Kosong
            $tableHeader // Header Tabel (Tanggal, Bangun Pagi, Beribadah, dll)
        ];
    }

    // MENGISI DATA KE DALAM TABEL (TANGGAL 1 s/d AKHIR BULAN)
    public function array(): array
    {
        $daysInMonth = Carbon::createFromDate($this->tahun, $this->bulan)->daysInMonth;
        $kebiasaans = MasterKebiasaan::all();

        $jurnals = Jurnal::where('student_id', $this->studentId)
            ->whereMonth('tanggal', $this->bulan)
            ->whereYear('tanggal', $this->tahun)
            ->get();

        $rows = [];

        // Buat patokan batas 5 hari yang lalu dari hari ini
        $batasBawah = Carbon::today()->subDays(5);

        for ($d = 1; $d <= $daysInMonth; $d++) {
            $dateStr = sprintf('%s-%02d-%02d', $this->tahun, $this->bulan, $d);
            $tanggalKalender = Carbon::parse($dateStr);
            $dailyJurnals = $jurnals->where('tanggal', $dateStr)->keyBy('kebiasaan_id');

            // 1. CEK BATAS WAKTU
            $isLewatBatas = $tanggalKalender->copy()->startOfDay()->lt($batasBawah);

            // 2. CEK APAKAH ADA MINIMAL 1 YANG DIISI HARI ITU
            $adaYangDiisi = false;
            foreach ($dailyJurnals as $j) {
                if (!empty($j->keterangan)) {
                    $adaYangDiisi = true;
                    break;
                }
            }

            // Kolom pertama adalah Tanggal
            $row = [$tanggalKalender->isoFormat('D MMM Y')];

            // Loop setiap kebiasaan untuk mengisi kolom ke samping
            foreach ($kebiasaans as $kebiasaan) {
                $jurnal = $dailyJurnals[$kebiasaan->id] ?? null;
                $diisi = $jurnal && !empty($jurnal->keterangan);

                if ($diisi) {
                    // Kalau diisi, cek jamnya (status true/false)
                    $mark = $jurnal->status ? ' (V)' : ' (X)';
                    $row[] = $jurnal->keterangan . $mark;
                } else {
                    // Kalau KOSONG, jalankan logika canggih seperti di web
                    if ($adaYangDiisi || $isLewatBatas) {
                        $row[] = '(X)'; // Tidak dikerjakan atau sudah lewat batas 5 hari
                    } else {
                        $row[] = '-'; // Masih dalam batas 5 hari, ortu belum ngisi
                    }
                }
            }

            $rows[] = $row;
        }

        return $rows;
    }

    // MEMBERI STYLE EXCEL
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 14]], // Judul Laporan
            2 => ['font' => ['bold' => true]], // Nama
            3 => ['font' => ['bold' => true]], // NISN
            4 => ['font' => ['bold' => true]], // Kelas
            5 => ['font' => ['bold' => true]], // Wali Kelas
            6 => ['font' => ['bold' => true]], // Bulan
            7 => ['font' => ['italic' => true, 'color' => ['argb' => 'FFFF0000']]], // Keterangan (V)/(X)
            9 => ['font' => ['bold' => true]], // Header Tabel (Tanggal, Bangun pagi, dll)
        ];
    }
}