<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\HasilController;
use App\Http\Controllers\Auth\LoginController;

// Redirect ke login
Route::get('/', function () {
    return redirect()->route('login');
});

// Login Routes
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login.process');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('karyawan', KaryawanController::class);
    Route::resource('penilaian', PenilaianController::class);
    
    Route::get('hasil', [HasilController::class, 'index'])->name('hasil.index');
    Route::post('hasil/calculate', [HasilController::class, 'calculate'])->name('hasil.calculate');
    Route::get('hasil/export-pdf', [HasilController::class, 'exportPDF'])->name('hasil.export-pdf');
    Route::get('hasil/{id}', [HasilController::class, 'show'])->name('hasil.show');
});