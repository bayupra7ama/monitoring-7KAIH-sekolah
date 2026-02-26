<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = ['name', 'nisn', 'class_id'];

    public function parents()
    {
        return $this->belongsToMany(
            User::class,
            'student_parent',
            'student_id',
            'parent_id'
        );
    }

    public function class()
    {
        return $this->belongsTo(ClassRoom::class);
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class, 'student_id');
    }
}
