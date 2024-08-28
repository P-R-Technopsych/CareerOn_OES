<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Psy\TabCompletion\Matcher\FunctionsMatcher;

class ExamAnswer extends Model
{
    use HasFactory;
    public $table = "exams_answers";

    protected $fillable = [
        'attempt_id',
        'question_id',
        'answer_id'
    ];

    public function question()
    {
        return $this->hasOne(Question::class, 'id', 'question_id');
    }

    public function answer()
    {
        return $this->hasOne(Answer::class, 'id', 'answer_id');
    }
}
