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
use App\Http\Controllers\AdminManagementController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BendunganController;
use App\Http\Controllers\KecamatanController;
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

    // Manajemen Pengaduan
    Route::get('/admin/pengaduan', [PengaduanController::class, 'indexAdmin'])->name('admin.pengaduan.index');
    Route::post('/admin/pengaduan/{id}/respon', [PengaduanController::class, 'beriRespon'])->name('admin.pengaduan.respon');
    Route::delete('/admin/pengaduan/{id}', [PengaduanController::class, 'destroy'])->name('pengaduan.destroy');

    // Monitoring Multi
    Route::get('/admin/monitoring-multilokasi', [MonitoringController::class, 'multiLokasi'])->name('monitoring.multi');
    Route::get('/admin/monitoring-multi', [MonitoringController::class, 'multiLokasi'])->name('admin.monitoring.multi');
    Route::get('/admin/fetch-bendungan/{id}', [MonitoringController::class, 'fetchBendungan']);
    Route::get('/admin/bendungan-detail-chart/{id}', [MonitoringController::class, 'getChartDetail'])->name('admin.monitoring.detailChart');


    // Manajemen Admin
    Route::get('/admin/managemen', [AdminManagementController::class, 'index'])->name('admin.managemen.index');
    Route::post('/admin/managemen', [AdminManagementController::class, 'store'])->name('admin.managemen.store');
    Route::put('/admin/managemen/{id}', [AdminManagementController::class, 'update'])->name('admin.managemen.update');
    Route::delete('/admin/managemen/{id}', [AdminManagementController::class, 'destroy'])->name('admin.managemen.destroy');
    Route::post('/admin/pengaduan/{id}/respon', [PengaduanController::class, 'respon'])->name('admin.pengaduan.respon');
    Route::get('/admin/pengaduan/{id}/hapus-respon', [PengaduanController::class, 'hapusRespon'])->name('admin.pengaduan.hapus-respon');

    // Admin - Kecamatan
    Route::get('/admin/kecamatan', [KecamatanController::class, 'index'])->name('admin.kecamatan.index');
    Route::post('/admin/kecamatan', [KecamatanController::class, 'store'])->name('admin.kecamatan.store');
    Route::put('/admin/kecamatan/{id}', [KecamatanController::class, 'update'])->name('admin.kecamatan.update');
    Route::delete('/admin/kecamatan/{id}', [KecamatanController::class, 'destroy'])->name('admin.kecamatan.destroy');
    Route::post('/admin/kecamatan/{id}/edit-mode', [KecamatanController::class, 'editMode'])->name('admin.kecamatan.editMode');

    // Admin - Bendungan
    Route::get('/admin/bendungan', [BendunganController::class, 'index'])->name('admin.bendungan.index');
    Route::post('/admin/bendungan', [BendunganController::class, 'store'])->name('admin.bendungan.store');
    Route::put('/admin/bendungan/{id}', [BendunganController::class, 'update'])->name('admin.bendungan.update');
    Route::delete('/admin/bendungan/{id}', [BendunganController::class, 'destroy'])->name('admin.bendungan.destroy');
    Route::post('/admin/bendungan/{id}/edit-mode', [BendunganController::class, 'editMode'])->name('admin.bendungan.editMode');
});
