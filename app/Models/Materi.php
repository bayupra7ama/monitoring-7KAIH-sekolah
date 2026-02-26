<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    protected $fillable = [
        'guru_id',
        'judul',
        'deskripsi',
        'file_pdf',
        'video',
    ];

    // Relasi: Materi milik Guru
    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }
    public function feedbacks()
    {
        return $this->hasMany(Feedback::class, 'materi_id');
    }
}