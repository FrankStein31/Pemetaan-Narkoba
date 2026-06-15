<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminSettingsController;
use App\Http\Controllers\AdminDataPasienController;
use App\Http\Controllers\AdminAntrianPasienController;
use App\Http\Controllers\AdminWargaController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\SosialisasiController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\VillageController;
use App\Models\Desa;
use Illuminate\Http\Request;

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
Route::get('/', [LandingController::class, 'index']);
// Route::get('/', function () {
//     return redirect('/admin/dashboard');
// });

Route::get('/landing', function () {
    return view('landing'); // Tampilkan view contact.blade.php
});

// login
Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);
Route::get('/logout', function () {
    return redirect('/');
});

//cari desaa
Route::get('/get-desa/{kecamatan_id}', function ($kecamatan_id) {
    $desas = Desa::where('kecamatan_id', $kecamatan_id)->get();
    return response()->json($desas);
});

// registrasi
Route::get('/registrasi', [RegisterController::class, 'index']);
Route::post('/registrasi', [RegisterController::class, 'store'])->name('registrasi.store');

// dashboard admin
Route::get('/admin/dashboard',  [AdminDashboardController::class, 'index'])->middleware('admin');
// Route::get('/bar-chart-apex', [AdminDashboardController::class, 'barChartApex']);
Route::get('/dashboard/chart', [AdminDashboardController::class, 'barChartApex'])->middleware('admin');

Route::get('/masyarakat/dashboard',  [AdminDashboardController::class, 'indexmas'])->middleware('user');


// data pasien
Route::get('/admin/pasien', [AdminDataPasienController::class, 'index'])->middleware('admin');
Route::get('/admin/pasien/filter', [AdminDataPasienController::class, 'filter'])->middleware('admin');
Route::post('/admin/pasien/delete', [AdminDataPasienController::class, 'deletePatient'])->middleware('admin');
Route::get('/admin/pasien/delete', function () {
    return redirect('/admin/pasien');
})->middleware('admin');
Route::post('/admin/pasien/edit', [AdminDataPasienController::class, 'editPatient'])->middleware('admin');
Route::get('/admin/pasien/edit', function () {
    return redirect('/admin/pasien');
})->middleware('admin');
Route::get('/admin/pasien/search', [AdminDataPasienController::class, 'search'])->middleware('admin');

//data warga
Route::get('/admin/warga', [AdminWargaController::class, 'index'])->middleware('admin');
Route::get('/warga-positif', [AdminWargaController::class, 'indexpositif'])->middleware('admin');
Route::post('/admin/warga', [AdminWargaController::class, 'store'])->middleware('admin');
Route::get('/get-desa/{kecamatan_id}', [AdminWargaController::class, 'getDesaByKecamatan']);
Route::post('/admin/warga/edit', [AdminWargaController::class, 'editWarga'])->middleware('admin');
Route::get('/admin/warga/search', [AdminWargaController::class, 'search'])->middleware('admin');
Route::get('/warga-positif/search', [AdminWargaController::class, 'searchpos'])->middleware('admin');
Route::get('/api/grafik-positif', [AdminWargaController::class, 'getDataPasienPositif']);

// Route::get('/get-desa/{kecamatan_id}', [AdminWargaController::class, 'getDesaByKecamatan']);


Route::post('/warga/delete', [AdminWargaController::class, 'deleteWarga'])->name('warga.delete');

// daftar antrian
Route::get('/admin/antrian', [AdminAntrianPasienController::class, 'index'])->middleware('admin');
Route::post('/admin/antrian', [AdminAntrianPasienController::class, 'generateQueueNumber'])->middleware('admin');
Route::post('/admin/antrian/confirm', [AdminAntrianPasienController::class, 'confirmPatient'])->middleware('admin');
Route::get('/admin/antrian/confirm', function () {
    return redirect('/admin/antrian');
})->middleware('admin');
Route::post('/admin/antrian/skip', [AdminAntrianPasienController::class, 'skipPatient'])->middleware('admin');
Route::get('/admin/antrian/skip', function () {
    return redirect('/admin/antrian');
})->middleware('admin');
Route::get('/admin/antrian/search', [AdminAntrianPasienController::class, 'search'])->middleware('admin');

// pasien terlambat
Route::get('/admin/daftar-antrian-terlambat', [AdminAntrianPasienController::class, 'daftarAntrianTerlambat'])->middleware('admin');
Route::get('/admin/daftar-antrian-terlambat/search', [AdminAntrianPasienController::class, 'searchAntrianTerlambat'])->middleware('admin');
Route::post('/admin/daftar-antrian-terlambat/confirm', [AdminAntrianPasienController::class, 'confirmPasienTerlambat'])->middleware('admin');
Route::get('/admin/daftar-antrian-terlambat/confirm', function () {
    return redirect('/admin/daftar-antrian-terlambat');
})->middleware('admin');

// Setting admin
Route::middleware('auth')->group(function () {
    Route::get('/admin/pengaturan', [AdminSettingsController::class, 'index']);
    Route::post('/admin/pengaturan', [AdminSettingsController::class, 'store']);
    Route::post('/admin/pengaturan/verify', [AdminSettingsController::class, 'verify']);
    Route::post('/admin/pengaturan/setemail', [AdminSettingsController::class, 'setemail']);
    Route::get('/admin/pengaturan/setemail', fn() => back());
    Route::get('/admin/pengaturan/verify', fn() => back());
    Route::post('/admin/pengaturan/changepassword', [AdminSettingsController::class, 'changepassword']);
    Route::get('/admin/pengaturan/changepassword', fn() => back());
    Route::post('/admin/pengaturan/app', [AdminSettingsController::class, 'updateapp']);
    Route::get('/admin/pengaturan/app', fn() => back());
});

// Pengaduan
Route::get('/admin/pengaduan', [PengaduanController::class, 'index'])->name('pengaduan.index');
Route::get('/masyarakat/pengaduan', [PengaduanController::class, 'create'])->name('pengaduan.create');
Route::post('/masyarakat/pengaduan/tambah', [PengaduanController::class, 'store'])->name('pengaduan.store');
Route::post('/masyarakat/pengaduan', [PengaduanController::class, 'deletePengaduan'])->name('pengaduan.delete');
Route::get('/masyarakat/tambah-pengaduan', [PengaduanController::class,'indextambah'])->name('pengaduan.tambah');
// Route::delete('/pengaduan/{id}', [PengaduanController::class, 'destroy'])->name('pengaduan.destroy');

// Sosialisai
Route::get('/sosialisasi', [SosialisasiController::class, 'index'])->name('sosialisasi.index');
Route::post('/sosialisasi', [SosialisasiController::class, 'store'])->name('sosialisasi.store');
Route::post('/admin/sosialisasi/edit', [SosialisasiController::class, 'editSosialisasi'])->name('sosialisasi.edit');
Route::put('/sosialisasi/toggle/{id}', [SosialisasiController::class, 'toggleStatus'])->name('sosialisasi.toggle');
Route::post('/admin/sosialisasi/delete', [SosialisasiController::class, 'deleteSosialisasi'])->name('sosialisasi.delete');

// Route::get('/maps', [VillageController::class, 'index']);
Route::get('/maps-desa', [VillageController::class, 'coba'])->name('maps.index');
Route::get('/maps-desa-sosialisasi', [VillageController::class, 'sosialisasi'])->name('maps-sosialisasi.index');
Route::get('/maps-desa-jenis-narkoba', [VillageController::class, 'jenis'])->name('maps-jenis.index');

Route::get('/admin/messages', [MessageController::class, 'index'])->name('messages.index');
Route::get('/tambah', [MessageController::class, 'indextambah'])->name('messages.indextambah');
Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');
// Route::get('/admin/messages/{id}/edit', [MessageController::class, 'edit'])->name('messages.edit');
// Route::put('/admin/messages/{id}', [MessageController::class, 'update'])->name('messages.update');
// Route::delete('/admin/messages/{id}', [MessageController::class, 'destroy'])->name('messages.destroy');

// Route::middleware('user')->group(function () {
//     Route::get('/admin/pengaturan', [AdminSettingsController::class, 'index']);
//     Route::post('/admin/pengaturan', [AdminSettingsController::class, 'store']);
//     Route::post('/admin/pengaturan/verify', [AdminSettingsController::class, 'verify']);
//     Route::post('/admin/pengaturan/setemail', [AdminSettingsController::class, 'setemail']);
//     Route::get('/admin/pengaturan/setemail', fn() => back());
//     Route::get('/admin/pengaturan/verify', fn() => back());
//     Route::post('/admin/pengaturan/changepassword', [AdminSettingsController::class, 'changepassword']);
//     Route::get('/admin/pengaturan/changepassword', fn() => back());
//     Route::post('/admin/pengaturan/app', [AdminSettingsController::class, 'updateapp']);
//     Route::get('/admin/pengaturan/app', fn() => back());
// });


