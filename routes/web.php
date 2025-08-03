<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\Riwayat2Controller;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\PengaduanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Ini adalah route untuk aplikasi berbasis web (Blade)
| Tidak disarankan menaruh route API di sini — pindahkan ke routes/api.php
*/

// =============================
// AUTH & LANDING PAGE
// =============================
Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

// =============================
// BERANDA
// =============================
Route::get('/home', [HomeController::class, 'index'])->name('home');

// =============================
// RIWAYAT
// =============================
Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat');
Route::get('/riwayat2', [Riwayat2Controller::class, 'index'])->name('riwayat2');

// =============================
// MONITORING
// =============================
Route::get('/monitoring', [MonitoringController::class, 'index'])->name('monitoring.index');

// =============================
// NOTIFIKASI
// =============================
Route::get('/notifikasi', [NotifikasiController::class, 'index'])->name('notifikasi');

// =============================
// BERITA
// =============================
Route::get('/berita/{id}', [BeritaController::class, 'show'])->name('berita.show');

// =============================
// PENGADUAN
// =============================
Route::get('/pengaduan', [PengaduanController::class, 'index'])->name('pengaduan.index');
Route::post('/pengaduan', [PengaduanController::class, 'store'])->name('pengaduan.store');


// =============================
// CATATAN:
// Route API seperti /api/sensor-terbaru sebaiknya diletakkan di routes/api.php
// Jika masih butuh diakses dari Blade, buat route-nya di api.php, lalu akses dengan fetch/AJAX
// =============================

