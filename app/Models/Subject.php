<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = ['name', 'status'];

    public function kelas()
    {
        return $this->belongsToMany(Kelas::class, 'class_subject');
    }

    public function exams()
    {
        return $this->hasMany(Exam::class);
    }
}
