<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'feedbacks';

    protected $fillable = [
        'user_id',
        'materi_id',
        'student_id',
        'sudah_diterapkan',
        'isi_feedback',
        'foto_bukti'
    ];

    public function orangtua()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function materi()
    {
        return $this->belongsTo(Materi::class, 'materi_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}