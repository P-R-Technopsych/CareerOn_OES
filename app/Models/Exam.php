<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_name',
        'subject_id',
        'date',
        'time',
        'attempt'
    ];

    public function subjects()
    {
        return $this->hasMany(Subject::class, 'id', 'subject_id');
        //return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }

    public function getQnaExam()
    {
        return $this->hasMany(QnaExam::class, 'exam_id', 'id');
        //return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }
}
