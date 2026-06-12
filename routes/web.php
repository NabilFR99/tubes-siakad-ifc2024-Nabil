<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\JadwalKuliahController;
use App\Http\Controllers\KrsController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MataKuliahController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => auth()->check() ? redirect()->route('dashboard') : view('auth.login'));

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
});

Route::middleware('auth')->group(function (): void {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function (): void {
        Route::resource('dosens', DosenController::class);
        Route::resource('mahasiswas', MahasiswaController::class);
        Route::resource('mata-kuliahs', MataKuliahController::class);
        Route::resource('jadwal-kuliahs', JadwalKuliahController::class);
        Route::get('krs', [KrsController::class, 'adminIndex'])->name('krs.index');
    });

    Route::middleware('role:mahasiswa')->group(function (): void {
        Route::get('/krs', [KrsController::class, 'index'])->name('krs.index');
        Route::post('/krs', [KrsController::class, 'store'])->name('krs.store');
        Route::delete('/krs/{krs}', [KrsController::class, 'destroy'])->name('krs.destroy');
        Route::get('/jadwal-saya', [KrsController::class, 'schedule'])->name('krs.schedule');
    });
});
