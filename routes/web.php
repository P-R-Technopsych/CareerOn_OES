<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\StudentMiddleware;
use App\Mail\HelloMail;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\AdminController;

Route::get('/',function(){
    return redirect('/register');
    //Mail::to('example@email.com')->send(new TestMail());
});

Route::get('/register',[AuthController::class, 'loadRegister']);
Route::post('/register',[AuthController::class,'studentRegister'])->name('studentRegister');

Route::get('/login',[AuthController::class, 'loadLogin']);
Route::post('/login',[AuthController::class,'userLogin'])->name('userLogin');

Route::get('/logout',[AuthController::class, 'logout']);

Route::get('/forget-password',[AuthController::class, 'forgetPasswordLoad']);
Route::post('/forget-password',[AuthController::class, 'forgetPassword'])->name('forgetPassword');

Route::get('/reset-password',[AuthController::class, 'resetPasswordLoad']);
Route::post('/reset-password',[AuthController::class, 'resetPassword'])->name('resetPassword');

Route::get('/dashboard',[AuthController::class, 'loadDashboard'])->middleware(StudentMiddleware::class);

Route::get('/admin/dashboard',[AuthController::class, 'adminDashboard'])->middleware(AdminMiddleware::class);

//subjects route
Route::post('/add-subject',[AdminController::class, 'addSubject'])->name('addSubject')->middleware(AdminMiddleware::class);
Route::post('/edit-subject',[AdminController::class, 'editSubject'])->name('editSubject')->middleware(AdminMiddleware::class);
Route::post('/delete-subject',[AdminController::class, 'deleteSubject'])->name('deleteSubject')->middleware(AdminMiddleware::class);
