<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BagoongController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\FeedbackController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', [AuthController::class, 'loginForm'])->name('loginForm');
Route::post('/', [AuthController::class, 'login'])->name('login');
Route::post('/dashboard', [AuthController::class, 'login'])->name('dashboard');

Route::get('/register', [AuthController::class, 'registerForm'])->name('registerForm');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/aboutUs', [AuthController::class, 'aboutUs'])->name('aboutUs');

Route::get('/bagoongs', [BagoongController::class, 'index'])->name('bagoongs.index');
Route::get('/bagoongs/create', [BagoongController::class, 'create'])->name('bagoongs.create');
Route::post('/bagoongs', [BagoongController::class, 'store'])->name('bagoongs.store');
Route::delete('/bagoongs/{bagoong}', [BagoongController::class, 'destroy'])->name('bagoongs.destroy');
Route::patch('/bagoongs/{bagoong}', [BagoongController::class, 'update'])->name('bagoongs.update');



Route::get('/logs', [LogController::class, 'index'])->name('logs.index');
Route::delete('/log/{id}', [LogController::class, 'destroy'])->name('log.delete');
Route::post('/clear-all-logs', [LogController::class, 'clearAllLogs'])->name('logs.clearAll');


Route::post('/bagoongs/{bagoong}', [BagoongController::class, 'download'])->name('bagoong.download');


Route::get('/index', [DashboardController::class, 'index']);


// Route::get('/sendmail', [EmailController::class, 'sendMail']);

Route::get('/verification/{user}/{token}', [AuthController::class, 'verification']);
Route::post('/submit-feedback', [FeedbackController::class, 'submitFeedback'])->name('submitFeedback');
