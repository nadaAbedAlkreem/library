<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
 

 
Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'show'])->name('register');
Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register'])->name('register.add');
    
Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'Login'])->name('login.action');
Route::get('/resetPassword', [App\Http\Controllers\Auth\ResetPasswordController::class, 'show'])->name('resetPassword');
Route::post('/resetPassword', [App\Http\Controllers\Auth\ResetPasswordController::class ,  'resetPassowrdAction'])->name('resetPassword.action');

Route::get('/newPassword/{token}', [App\Http\Controllers\Auth\NewPasswordController::class, 'show'])->name('newPassword');
Route::post('/newPassword', [App\Http\Controllers\Auth\NewPasswordController::class, 'newPassowrdAction'])->name('newPassword.action');

Route::get('/send', [App\Http\Controllers\Auth\MailController::class, 'index']);
Route::get('/logout' , [App\Http\Controllers\Auth\LoginController::class , 'logout'])->name('logout');