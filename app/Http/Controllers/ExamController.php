<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exam;
use App\Models\QnaExam;

class ExamController extends Controller
{
    //
    public function loadExamDashboard($id)
    {
        $qnaExam = Exam::where('entrance_id',$id)->with('getQnaExam')->get();
        if(count($qnaExam)>0){

            if($qnaExam['0']['date'] == date('Y-m-d')){
                if (count($qnaExam[0]['getQnaExam'])>0) {
                    $qna = QnaExam::Where('exam_id',$qnaExam[0]['id'])->with('question','answers')->get();
                } else {
                    return view('student.exam-dashboard',['success'=>true,'exam'=>$qnaExam,'qna'=>$qna]);
                }
                
            }
            elseif($qnaExam['0']['date'] > date('Y-m-d')){
                return view('student.exam-dashboard',['success'=>false,'msg'=>'This exam will be start on'.$qnaExam[0]['date'],'exam'=>$qnaExam]);
            }
            else{
                return view('student.exam-dashboard',['success'=>false,'msg'=>'This exam has been expired on'.$qnaExam[0]['date'],'exam'=>$qnaExam]);
            }

        }
        else{
            return view('404');
        }
    }
}
