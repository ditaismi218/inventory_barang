<?php

use App\Http\Controllers\BarangInventarisController;
use App\Http\Controllers\daftarBarangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\JenisBarangController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\LaporanDaftarBarangController;
use App\Http\Controllers\LaporanPengembalianBarangController;
use App\Http\Controllers\LaporanStatusBarangController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\SiswaController;
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

Route::get('/export/pdf', [ExportController::class, 'exportPDF'])->name('export.pdf');
Route::get('/export/excel', [ExportController::class, 'exportExcel'])->name('export.excel');
Route::get('/export/csv', [ExportController::class, 'exportCSV'])->name('export.csv');

Route::get('/users', [UserController::class, 'index'])->name('users.index'); // Tampilkan daftar user
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create'); // Form tambah user
    Route::post('/users', [UserController::class, 'store'])->name('users.store'); // Simpan user baru
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit'); // Form edit user
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update'); // Update user
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy'); // Hapus user
    Route::patch('/users/{user}/status', [UserController::class, 'toggleStatus'])->name('users.toggleStatus'); // Aktif/Nonaktifkan user

Route::get('/peminjaman/search', [PeminjamanController::class, 'search'])->name('peminjaman.search');

Route::get('/jurusan', [JurusanController::class, 'index'])->name('jurusan.index'); // Menampilkan daftar jurusan
Route::get('/jurusan/create', [JurusanController::class, 'create'])->name('jurusan.create'); // Form tambah jurusan
Route::post('/jurusan', [JurusanController::class, 'store'])->name('jurusan.store'); // Simpan jurusan ke database
Route::get('/jurusan/{jurusan}/edit', [JurusanController::class, 'edit'])->name('jurusan.edit'); // Form edit jurusan
Route::put('/jurusan/{jurusan}', [JurusanController ::class, 'update'])->name('jurusan.update'); // Update jurusan
Route::delete('/jurusan/{jurusan}', [JurusanController::class, 'destroy'])->name('jurusan.destroy'); // Hapus jurusan

Route::get('/kelas', [KelasController::class, 'index'])->name('kelas.index');
Route::get('/kelas/create', [KelasController::class, 'create'])->name('kelas.create');
Route::post('/kelas', [KelasController::class, 'store'])->name('kelas.store');
Route::get('/kelas/{kelas}/edit', [KelasController::class, 'edit'])->name('kelas.edit');
Route::put('/kelas/{kelas}', [KelasController::class, 'update'])->name('kelas.update');
Route::delete('/kelas/{kelas}', [KelasController::class, 'destroy'])->name('kelas.destroy');

Route::get('/siswa', [SiswaController::class, 'index'])->name('siswa.index');
Route::get('/siswa/create', [SiswaController::class, 'create'])->name('siswa.create');
Route::post('/siswa', [SiswaController::class, 'store'])->name('siswa.store');
Route::get('/siswa/{siswa}/edit', [SiswaController::class, 'edit'])->name('siswa.edit');
Route::put('/siswa/{siswa}', [SiswaController::class, 'update'])->name('siswa.update');
Route::delete('/siswa/{siswa}', [SiswaController::class, 'destroy'])->name('siswa.destroy');
});
