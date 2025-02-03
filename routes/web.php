<?php

use App\Http\Controllers\BarangInventarisController;
use App\Http\Controllers\daftarBarangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JenisBarangController;
use App\Http\Controllers\LaporanDaftarBarangController;
use App\Http\Controllers\LaporanPengembalianBarangController;
use App\Http\Controllers\LaporanStatusBarangController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\user;



Route::view('/login', 'auth.login')->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware([user::class])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    // Route untuk JenisBarang
Route::get('jenis_barang', [JenisBarangController::class, 'index'])->name('jenis_barang.index');
Route::get('jenis_barang/create', [JenisBarangController::class, 'create'])->name('jenis_barang.create');
Route::post('jenis_barang', [JenisBarangController::class, 'store'])->name('jenis_barang.store');
Route::get('jenis_barang/{id}/edit', [JenisBarangController::class, 'edit'])->name('jenis_barang.edit');
Route::put('jenis_barang/{id}', [JenisBarangController::class, 'update'])->name('jenis_barang.update');
Route::delete('jenis_barang/{id}', [JenisBarangController::class, 'destroy'])->name('jenis_barang.destroy');


// Rute untuk daftar-barang
Route::get('daftar-barang', [BarangInventarisController::class, 'index'])->name('daftar-barang.index');
Route::get('daftar-barang/create', [BarangInventarisController::class, 'create'])->name('daftar-barang.create');
Route::post('daftar-barang', [BarangInventarisController::class, 'store'])->name('daftar-barang.store');
Route::get('daftar-barangs', [BarangInventarisController::class, 'index'])->name('daftar-barang.index');
Route::get('daftar-barang/create', [BarangInventarisController::class, 'create'])->name('daftar-barang.create');
Route::post('daftar-barang', [BarangInventarisController::class, 'store'])->name('daftar-barang.store');
Route::get('daftar-barang/{id}', [BarangInventarisController::class, 'edit'])->name('daftar-barang.edit');
Route::put('daftar-barang/{id}/edit', [BarangInventarisController::class, 'update'])->name('daftar-barang.update');
Route::delete('daftar-barang/{id}', [BarangInventarisController::class, 'destroy'])->name('daftar-barang.destroy');
// Route::get('daftar-barang/{id}', [BarangInventarisController::class, 'show'])->name('daftar-barang.show');
// Route::get('daftar-barang/{id}/edit', [BarangInventarisController::class, 'edit'])->name('daftar-barang.edit');
// Route::put('daftar-barang/{id}', [BarangInventarisController::class, 'update'])->name('daftar-barang.update');
// Route::delete('daftar-barang/{id}', [BarangInventarisController::class, 'destroy'])->name('daftar-barang.destroy');

Route::get('peminjamans', [PeminjamanController::class, 'index'])->name('peminjaman.index');
Route::get('peminjaman/create', [PeminjamanController::class, 'create'])->name('peminjaman.create');
Route::post('peminjaman', [PeminjamanController::class, 'store'])->name('peminjaman.store');
Route::get('peminjaman/{pb_id}', [PeminjamanController::class, 'show'])->name('peminjaman.show'); // Untuk detail barang
Route::get('peminjaman/{pb_id}/edit', [PeminjamanController::class, 'edit'])->name('peminjaman.edit'); // Untuk edit
Route::put('/peminjaman/{pb_id}', [PeminjamanController::class, 'update'])->name('peminjaman.update');
Route::delete('peminjaman/{pb_id}', [PeminjamanController::class, 'destroy'])->name('peminjaman.destroy');


Route::get('pengembalians', [PengembalianController::class, 'index'])->name('pengembalian.index');
Route::get('/pengembalian/{pb_id}/detail', [PengembalianController::class, 'detailPeminjaman'])
    ->name('pengembalian.detail');
Route::get('pengembalian/Barang', [PengembalianController::class, 'indexKembali'])->name('pengembalian.barang');
Route::post('pengembalian/create', [PengembalianController::class, 'store'])->name('pengembalian.kembali');

Route::get('/laporan-daftar-barang', [LaporanDaftarBarangController::class, 'index'])->name('laporan.daftar-barang');
Route::get('/laporan-status-barang', [LaporanStatusBarangController::class, 'index'])->name('laporan.status-barang');
Route::get('/laporan-pengembalian-barang', [LaporanPengembalianBarangController::class, 'index'])->name('laporan.pengembalian-barang');

Route::get('/daftar-pengguna', [UserController::class, 'index'])->name('users.index');
});
