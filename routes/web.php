<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DirekturDashboardController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\HasilController;
use App\Http\Controllers\ValidasiHasilController;

/*
|--------------------------------------------------------------------------
| Route Login / Otentikasi
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.process');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Route Setelah Login (Authenticated Users Only)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Route Admin / HRD
    |--------------------------------------------------------------------------
    | Mengelola data master karyawan, input nilai kriteria, dan trigger hitung PM.
    */
    Route::middleware(['role:admin,hrd'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        Route::resource('karyawan', KaryawanController::class);
        Route::resource('penilaian', PenilaianController::class);
        
        // Aksi proses hitung Profile Matching
        Route::post('/hasil/calculate', [HasilController::class, 'calculate'])->name('hasil.calculate');
    });

    /*
    |--------------------------------------------------------------------------
    | Route Direktur Utama
    |--------------------------------------------------------------------------
    | Khusus untuk Direktur Utama menyetujui atau menolak laporan hasil.
    */
    Route::middleware(['role:direktur'])->group(function () {
        Route::get('/direktur/dashboard', [DirekturDashboardController::class, 'index'])->name('direktur.dashboard');
        Route::get('/direktur/validasi', [DirekturDashboardController::class, 'validasi'])->name('direktur.validasi');
        
        // Aksi simpan validasi/persetujuan laporan
        Route::post('/direktur/validasi-hasil', [ValidasiHasilController::class, 'store'])->name('direktur.validasi-hasil');
    });

    /*
    |--------------------------------------------------------------------------
    | Route Hasil & Laporan (Shared Access)
    |--------------------------------------------------------------------------
    | Dapat diakses oleh semua role, proteksi detail diatur dinamis di Controller.
    */
    Route::middleware(['role:admin,hrd,direktur'])->group(function () {
        Route::get('/hasil', [HasilController::class, 'index'])->name('hasil.index');
        Route::get('/hasil/export-pdf', [HasilController::class, 'exportPDF'])->name('hasil.export-pdf');
        Route::get('/hasil/{id}', [HasilController::class, 'show'])->name('hasil.show');
    });
});