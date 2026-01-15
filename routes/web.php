<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppointmentController;

Route::get('/', [AuthController::class, 'showLoginForm']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware('auth')->get('/dashboard', function () {
    return view('module.dashboard.dashboard');
})->name('dashboard');

Route::middleware('auth')->resource('appointments', AppointmentController::class);
