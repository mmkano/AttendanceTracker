<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TimecardController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/auth/code', [AuthController::class, 'showCodeForm'])->name('auth.code');
Route::post('/auth/code', [AuthController::class, 'verifyCode']);
Route::post('/resend-code', [AuthController::class, 'resendCode'])->name('resend.code');

Route::get('/', [TimecardController::class, 'index'])->middleware('auth')->name('dashboard');
Route::post('/', [TimecardController::class, 'handleAction'])->name('timecard.action');
Route::get('/attendance_daily', [TimecardController::class, 'showDailyAttendance'])->name('attendance_daily');
Route::get('/users', [TimecardController::class, 'listUsers'])->name('users');
Route::get('/user/{userId}/records', [TimecardController::class, 'showUserRecords'])->name('user.records');