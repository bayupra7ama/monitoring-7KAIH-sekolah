<?php

namespace App\Exports;

use App\Models\Student;
use App\Models\Jurnal;
use App\Models\ClassRoom; // <-- Tambahan untuk panggil data kelas
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class JurnalBulananExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $kelasId;
    protected $bulan;
    protected $tahun;
    protected $maxPoin;
    private $rowNumber = 1;

    public function __construct($kelasId, $bulan, $tahun, $maxPoin)
    {
        $this->kelasId = $kelasId;
        $this->bulan = $bulan;
        $this->tahun = $tahun;
        $this->maxPoin = $maxPoin;
    }

    public function collection()
    {
        // Ambil semua murid di kelas tersebut
        return Student::where('class_id', $this->kelasId)->orderBy('name')->get();
    }

    // MEMBUAT JUDUL KOLOM (HEADER EXCEL)
    public function headings(): array
    {
        $namaBulan = Carbon::createFromDate($this->tahun, $this->bulan, 1)->isoFormat('MMMM Y');

        // Ambil data Kelas dan Gurunya
        $kelas = ClassRoom::with('teacher')->find($this->kelasId);
        $namaKelas = $kelas ? $kelas->name : '-';
        $namaGuru = ($kelas && $kelas->teacher) ? $kelas->teacher->name : '-';

        return [
            ['REKAPITULASI JURNAL KARAKTER SISWA'],
            ['Kelas', ': ' . $namaKelas],
            ['Wali Kelas', ': ' . $namaGuru],
            ['Bulan', ': ' . $namaBulan],
            [], // Baris kosong sebagai jarak
            ['No', 'NISN', 'Nama Siswa', 'Poin Ceklis', 'Persentase (%)', 'Predikat']
        ];
    }

    // MENGISI DATA KE MASING-MASING KOLOM
    public function map($student): array
    {
        // 1. Hitung Poin (Hanya menghitung yang statusnya TRUE/Berhasil)
        $poinDidapat = Jurnal::where('student_id', $student->id)
            ->whereMonth('tanggal', $this->bulan)
            ->whereYear('tanggal', $this->tahun)
            ->where('status', true)
            ->count();

        // 2. Hitung Persentase & Predikat
        $persentase = $this->maxPoin > 0 ? round(($poinDidapat / $this->maxPoin) * 100) : 0;

        if ($persentase >= 90)
            $predikat = 'Sangat Baik';
        elseif ($persentase >= 75)
            $predikat = 'Baik';
        elseif ($persentase >= 50)
            $predikat = 'Cukup';
        else
            $predikat = 'Perlu Bimbingan';

        // 3. Masukkan ke baris Excel
        return [
            $this->rowNumber++,
            $student->nisn,
            $student->name,
            $poinDidapat,
            $persentase,
            $predikat
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 14]], // Judul Laporan
            2 => ['font' => ['bold' => true]], // Kelas
            3 => ['font' => ['bold' => true]], // Wali Kelas
            4 => ['font' => ['bold' => true]], // Bulan
            6 => ['font' => ['bold' => true]], // Header Tabel (No, NISN, Nama, dll)
        ];
    }
}