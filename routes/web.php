<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\StudentMiddleware;
use App\Mail\HelloMail;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ExamController;

Route::get('/', function () {
    return redirect('/Login');
    //Mail::to('example@email.com')->send(new TestMail());
});

Route::get('/register', [AuthController::class, 'loadRegister']);
Route::post('/register', [AuthController::class, 'studentRegister'])->name('studentRegister');

Route::get('/login', [AuthController::class, 'loadLogin']);
Route::post('/login', [AuthController::class, 'userLogin'])->name('userLogin');

Route::get('/logout', [AuthController::class, 'logout']);

Route::get('/forget-password', [AuthController::class, 'forgetPasswordLoad']);
Route::post('/forget-password', [AuthController::class, 'forgetPassword'])->name('forgetPassword');

Route::get('/reset-password', [AuthController::class, 'resetPasswordLoad']);
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('resetPassword');

Route::middleware([StudentMiddleware::class])->group(function () {
    Route::get('/dashboard', [AuthController::class, 'loadDashboard'])->middleware(StudentMiddleware::class);
    Route::get('/exam/{id}', [ExamController::class, 'loadExamDashboard'])->middleware(StudentMiddleware::class);
    Route::post('/exam-submit', [ExamController::class, 'examSubmit'])->name('examSubmit')->middleware(StudentMiddleware::class);
    Route::get('/results', [ExamController::class, 'resultDashboard'])->name('resultDashboard')->middleware(StudentMiddleware::class);
    Route::get('/review-student-qna', [ExamController::class, 'reviewQna'])->name('resultStudentQna')->middleware(StudentMiddleware::class);
});

Route::middleware([AdminMiddleware::class])->group(function () {

    Route::get('/admin/dashboard', [AuthController::class, 'adminDashboard']);

    //subjects route
    Route::post('/add-subject', [AdminController::class, 'addSubject'])->name('addSubject');
    Route::post('/edit-subject', [AdminController::class, 'editSubject'])->name('editSubject');
    Route::post('/delete-subject', [AdminController::class, 'deleteSubject'])->name('deleteSubject');

    //exam route
    Route::get('/admin/exam', [AdminController::class, 'examDashboard']);
    Route::post('/add-exam', [AdminController::class, 'addExam'])->name('addExam');
    Route::get('/get-exam-detail/{id}', [AdminController::class, 'getExamDetail'])->name('getExamDetail');
    Route::post('/update-exam', [AdminController::class, 'updateExam'])->name('updateExam');
    Route::post('/delete-exam', [AdminController::class, 'deleteExam'])->name('deleteExam');

    //Q&A route
    Route::get('/admin/qna-ans', [AdminController::class, 'qnaDashboard']);
    Route::post('/add-qna-ans', [AdminController::class, 'addQna'])->name('addQna');
    Route::get('/get-qna-details', [AdminController::class, 'getQnaDetails'])->name('getQnaDetails');
    Route::get('/delete-ans', [AdminController::class, 'deleteAns'])->name('deleteAns');
    Route::post('/update-qna-ans', [AdminController::class, 'updateQna'])->name('updateQna');
    Route::post('/delete-qna-ans', [AdminController::class, 'deleteQna'])->name('deleteQna');
    Route::post('/import-qna-ans', [AdminController::class, 'importQna'])->name('importQna');

    //Students showing in admin routing
    Route::get('/admin/students', [AdminController::class, 'studentsDashboard']);
    Route::post('/add-student', [AdminController::class, 'addStudent'])->name('addStudent');
    Route::post('/edit-student', [AdminController::class, 'editStudent'])->name('editStudent');
    Route::post('/delete-student', [AdminController::class, 'deleteStudent'])->name('deleteStudent');
    Route::get('/export-students', [AdminController::class, 'exportStudents'])->name('exportStudents');

    //qna exams routing
    Route::get('/get-questions', [AdminController::class, 'getQuestions'])->name('getQuestions');
    Route::post('/add-questions', [AdminController::class, 'addQuestions'])->name('addQuestions');
    Route::get('/get-exam-questions', [AdminController::class, 'getExamQuestions'])->name('getExamQuestions');
    Route::get('/delete-exam-questions', [AdminController::class, 'deleteExamQuestions'])->name('deleteExamQuestions');
    Route::get('/admin/marks', [AdminController::class, 'loadMarks'])->name('loadMarks');
    Route::post('/update-marks', [AdminController::class, 'updateMarks'])->name('updateMarks');

    //exam review routes
    Route::get('/admin/review-exams', [AdminController::class, 'reviewExams']);
    Route::get('/admin/get-reviewed-qna', [AdminController::class, 'reviewQna'])->name('reviewQna');
    Route::post('/admin/approved-qna', [AdminController::class, 'approvedQna'])->name('approvedQna');
});
