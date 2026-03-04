<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $fillable = [
        'subject_id',
        'name',
        'description',
        'start',
        'end',
        'duration',
        'status',
    ];

    public function classes()
    {
        return $this->belongsToMany(Kelas::class, 'class_exam', 'exam_id', 'class_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
    public function attempts()
    {
        return $this->hasMany(ExamAttempt::class);
    }
}
