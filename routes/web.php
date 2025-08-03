<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\Riwayat2Controller;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PengaduanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Route aplikasi berbasis Blade. Untuk API, gunakan routes/api.php.
*/

// ==========================
// RUTE PUBLIK (Tanpa Login)
// ==========================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/monitoring', [MonitoringController::class, 'index'])->name('monitoring.index');
Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat');
Route::get('/riwayat2', [Riwayat2Controller::class, 'index'])->name('riwayat2');
Route::get('/notifikasi', [NotifikasiController::class, 'index'])->name('notifikasi');
Route::get('/berita/{id}', [BeritaController::class, 'show'])->name('berita.show');
// =============================
// PENGADUAN
// =============================
Route::get('/pengaduan', [PengaduanController::class, 'index'])->name('pengaduan.index');
Route::post('/pengaduan', [PengaduanController::class, 'store'])->name('pengaduan.store');


// ==========================
// RUTE LOGIN (Hanya Admin)
// ==========================
// Tampilkan form login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
// Proses login
Route::post('/login', [LoginController::class, 'login']);
// Logout
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/'); // redirect ke halaman utama setelah logout
})->name('logout');

// ==========================
// RUTE ADMIN (Khusus Login Admin)
// ==========================
Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
});
