<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\StudentMiddleware;

Route::get('/',function(){
    return redirect('/register');
});

Route::get('/register',[AuthController::class, 'loadRegister']);
Route::post('/register',[AuthController::class,'studentRegister'])->name('studentRegister');

Route::get('/login',[AuthController::class, 'loadLogin']);
Route::post('/login',[AuthController::class,'userLogin'])->name('userLogin');

Route::get('/logout',[AuthController::class, 'logout']);

Route::get('/dashboard',[AuthController::class, 'loadDashboard'])->middleware(StudentMiddleware::class);

Route::get('/admin/dashboard',[AuthController::class, 'adminDashboard'])->middleware(AdminMiddleware::class);
