<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jurnal extends Model
{
    protected $fillable = [
        'student_id',
        'kebiasaan_id',
        'tanggal',
        'status',
        'keterangan'
    ];

    // Relasi ke Master Kebiasaan (Untuk ambil namanya)
    public function kebiasaan()
    {
        return $this->belongsTo(MasterKebiasaan::class, 'kebiasaan_id');
    }

    // Relasi ke Siswa
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}