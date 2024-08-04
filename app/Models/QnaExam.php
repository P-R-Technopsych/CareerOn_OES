<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QnaExam extends Model
{
    use HasFactory;
<<<<<<< HEAD
    public $table = "qna_exams";
    protected $fillable = ['exam_id', 'question_id'];
=======
    
    public $table = 'qna_exams';
    
    protected $fillable = [
        'exam_id',
        'question_id'
    ];

    public function question(){
        return $this->hasMany(Question::class , 'id','question_id' );
    }

>>>>>>> c0385c92df01cc527d895036d7cecd932a18902f
}
