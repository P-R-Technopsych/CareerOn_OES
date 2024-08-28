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
    return redirect('/register');
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

Route::get('/dashboard', [AuthController::class, 'loadDashboard'])->middleware(StudentMiddleware::class);
Route::get('/exam/{id}', [ExamController::class, 'loadExamDashboard'])->middleware(StudentMiddleware::class);
Route::post('/exam-submit', [ExamController::class, 'examSubmit'])->name('examSubmit')->middleware(StudentMiddleware::class);
Route::get('/results', [ExamController::class, 'resultDashboard'])->name('resultDashboard')->middleware(StudentMiddleware::class);
Route::get('/review-student-qna', [ExamController::class, 'reviewQna'])->name('resultStudentQna')->middleware(StudentMiddleware::class);

Route::get('/admin/dashboard', [AuthController::class, 'adminDashboard'])->middleware(AdminMiddleware::class);

//subjects route
Route::post('/add-subject', [AdminController::class, 'addSubject'])->name('addSubject')->middleware(AdminMiddleware::class);
Route::post('/edit-subject', [AdminController::class, 'editSubject'])->name('editSubject')->middleware(AdminMiddleware::class);
Route::post('/delete-subject', [AdminController::class, 'deleteSubject'])->name('deleteSubject')->middleware(AdminMiddleware::class);

//exam route
Route::get('/admin/exam', [AdminController::class, 'examDashboard'])->middleware(AdminMiddleware::class);
Route::post('/add-exam', [AdminController::class, 'addExam'])->name('addExam')->middleware(AdminMiddleware::class);
Route::get('/get-exam-detail/{id}', [AdminController::class, 'getExamDetail'])->name('getExamDetail')->middleware(AdminMiddleware::class);
Route::post('/update-exam', [AdminController::class, 'updateExam'])->name('updateExam')->middleware(AdminMiddleware::class);
Route::post('/delete-exam', [AdminController::class, 'deleteExam'])->name('deleteExam')->middleware(AdminMiddleware::class);

//Q&A route
Route::get('/admin/qna-ans', [AdminController::class, 'qnaDashboard'])->middleware(AdminMiddleware::class);
Route::post('/add-qna-ans', [AdminController::class, 'addQna'])->name('addQna')->middleware(AdminMiddleware::class);
Route::get('/get-qna-details', [AdminController::class, 'getQnaDetails'])->name('getQnaDetails')->middleware(AdminMiddleware::class);
Route::get('/delete-ans', [AdminController::class, 'deleteAns'])->name('deleteAns')->middleware(AdminMiddleware::class);
Route::post('/update-qna-ans', [AdminController::class, 'updateQna'])->name('updateQna')->middleware(AdminMiddleware::class);
Route::post('/delete-qna-ans', [AdminController::class, 'deleteQna'])->name('deleteQna')->middleware(AdminMiddleware::class);
Route::post('/import-qna-ans', [AdminController::class, 'importQna'])->name('importQna')->middleware(AdminMiddleware::class);

//Students showing in admin routing
Route::get('/admin/students', [AdminController::class, 'studentsDashboard'])->middleware(AdminMiddleware::class);
Route::post('/add-student', [AdminController::class, 'addStudent'])->name('addStudent')->middleware(AdminMiddleware::class);
Route::post('/edit-student', [AdminController::class, 'editStudent'])->name('editStudent')->middleware(AdminMiddleware::class);
Route::post('/delete-student', [AdminController::class, 'deleteStudent'])->name('deleteStudent')->middleware(AdminMiddleware::class);

//qna exams routing
Route::get('/get-questions', [AdminController::class, 'getQuestions'])->name('getQuestions')->middleware(AdminMiddleware::class);
Route::post('/add-questions', [AdminController::class, 'addQuestions'])->name('addQuestions')->middleware(AdminMiddleware::class);
Route::get('/get-exam-questions', [AdminController::class, 'getExamQuestions'])->name('getExamQuestions')->middleware(AdminMiddleware::class);
Route::get('/delete-exam-questions', [AdminController::class, 'deleteExamQuestions'])->name('deleteExamQuestions')->middleware(AdminMiddleware::class);
Route::get('/admin/marks', [AdminController::class, 'loadMarks'])->name('loadMarks')->middleware(AdminMiddleware::class);
Route::post('/update-marks', [AdminController::class, 'updateMarks'])->name('updateMarks')->middleware(AdminMiddleware::class);

//exam review routes
Route::get('/admin/review-exams', [AdminController::class, 'reviewExams'])->middleware(AdminMiddleware::class);
Route::get('/admin/get-reviewed-qna', [AdminController::class, 'reviewQna'])->name('reviewQna')->middleware(AdminMiddleware::class);
Route::post('/admin/approved-qna', [AdminController::class, 'approvedQna'])->name('approvedQna')->middleware(AdminMiddleware::class);
