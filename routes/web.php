<?php

use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\LatihanController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MasterBahanController;
use App\Http\Controllers\MasterKategoriController;
use App\Http\Controllers\MasterProdukController;
use App\Http\Controllers\MasterSatuanController;
use App\Http\Controllers\MasterSupplierController;
use App\Http\Controllers\MasterTipeController;
use App\Http\Controllers\MasterUserController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ROPController;
use Illuminate\Support\Facades\Route;

//Route::get('/kelola', [MasterProdukController::class, 'MasterProduk']);
//Route::get('/satuan', [MasterProdukController::class, 'satuan']); //( buat testing data doang)

Route::middleware('auth')->group(function(){
Route::get('/Monitoring', [MonitoringController::class, 'index'])->name('Monitoring.index');



// Tambahkan route ini, sebaiknya di dalam grup middleware auth Anda
// Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/Laporan', [LaporanController::class, 'index'])->name('Laporan.index') ->middleware(['auth', 'role:owner']);
//Route::get('/Laporan/cari', [LaporanController::class, 'index'])->name('laporan.cari');
Route::get('/laporan/export', [LaporanController::class, 'exportPDF'])->name('laporan.export');


Route::get('/Produk', [MasterProdukController::class, 'index'])->name('produk.index')->middleware(['auth', 'role:admin']);
Route::post('/Produk', [MasterProdukController::class, 'store'])->name('produk.store');
Route::get('/produk/toggle-status/{id}', [MasterProdukController::class, 'toggleStatus'])->name('produk.toggleStatus');
Route::put('/produk/{id}', [MasterProdukController::class, 'update'])->name('produk.update');
Route::delete('/produk/{id}', [MasterProdukController::class, 'destroy'])->name('produk.destroy');

Route::get('/Kategori', [MasterKategoriController::class, 'index'])->name('kategori.index')->middleware(['auth', 'role:admin']);
Route::post('/Kategori', [MasterKategoriController::class, 'store'])->name('kategori.store');
Route::get('/kategori/toggle-status/{id}', [MasterKategoriController::class, 'toggleStatus'])->name('kategori.toggleStatus');
Route::put('/Kategori/{id}', [MasterKategoriController::class, 'update'])->name('kategori.update');
Route::delete('/Kategori/{id}', [MasterKategoriController::class, 'destroy'])->name('kategori.destroy');

Route::get('/Tipe', [MasterTipeController::class, 'index'])->name('tipe.index')->middleware(['auth', 'role:admin']);
Route::post('/Tipe', [MasterTipeController::class, 'store'])->name('tipe.store');
Route::get('/tipe/toggle-status/{id}', [MasterTipeController::class, 'toggleStatus'])->name('tipe.toggleStatus');
// Route::put('/Tipe/{id}', [MasterTipeController::class, 'update'])->name('tipe.update');
// Route::delete('/Tipe/{id}', [MasterTipeController::class, 'destroy'])->name('tipe.destroy');

Route::get('/Bahan', [MasterBahanController::class, 'index'])->name('bahan.index')->middleware(['auth', 'role:admin']);
Route::post('/Bahan', [MasterBahanController::class, 'store'])->name('bahan.store');
Route::put('/Bahan/{id}', [MasterBahanController::class, 'update'])->name('bahan.update');
Route::delete('/Bahan/{id}', [MasterBahanController::class, 'destroy'])->name('bahan.destroy');
Route::get('/bahan/toggle-status/{id}', [MasterBahanController::class, 'toggleStatus'])->name('bahan.toggleStatus');

Route::get('/Satuan', [MasterSatuanController::class, 'index'])->name('satuan.index') ->middleware(['auth', 'role:admin']);
Route::post('/Satuan', [MasterSatuanController::class, 'store'])->name('satuan.store');
Route::get('/satuan/toggle-status/{id}', [MasterSatuanController::class, 'toggleStatus'])->name('satuan.toggleStatus');
Route::put('/Satuan/{id}', [MasterSatuanController::class, 'update'])->name('satuan.update');
Route::delete('/Satuan/{id}', [MasterSatuanController::class, 'destroy'])->name('satuan.destroy');


Route::get('/Supplier', [MasterSupplierController::class, 'index'])->name('supplier.index') ->middleware(['auth', 'role:admin']);
Route::post('/Supplier', [MasterSupplierController::class, 'store'])->name('supplier.store');
Route::put('/Supplier/{id}', [MasterSupplierController::class, 'update'])->name('supplier.update');
Route::delete('/Supplier/{id}', [MasterSupplierController::class, 'destroy'])->name('supplier.destroy');
Route::get('/supplier/toggle-status/{id}', [MasterSupplierController::class, 'toggleStatus'])->name('supplier.toggleStatus');

Route::get('/User', [MasterUserController::class, 'index'])->name('user.index') ->middleware(['auth', 'role:owner']);
Route::post('/User', [MasterUserController::class, 'store'])->name('user.store');
Route::get('/user/toggle-status/{id}', [MasterUserController::class, 'toggleStatus'])->name('user.toggleStatus');
Route::post('/users/update-password/{id}', [MasterUserController::class, 'updatePassword'])->name('users.update-password');

// Route untuk menampilkan halaman Manajemen ROP (GET request)
Route::get('/rop', [ROPController::class, 'index'])->name('rop.index') ->middleware(['auth', 'role:admin']);
Route::post('/rop/store-or-update', [ROPController::class, 'storeOrUpdate'])->name('rop.storeOrUpdate');
Route::get('/rop/history/{id}', [ROPController::class, 'history'])->name('rop.history');



// Menampilkan form dan riwayat barang masuk
Route::get('/barang-masuk', [BarangMasukController::class, 'index'])->name('barang-masuk.index')->middleware(['auth', 'role:admin']);
// Menyimpan data transaksi barang masuk baru
Route::post('/barang-masuk', [BarangMasukController::class, 'store'])->name('barang-masuk.store');
Route::get('/barang-masuk/detail/{id}', [BarangMasukController::class, 'detail']);

Route::get('/barang-keluar', [BarangKeluarController::class, 'index'])->name('barang-keluar.index')->middleware(['auth', 'role:admin']);
Route::post('/barang-keluar', [BarangKeluarController::class, 'store'])->name('barang-keluar.store');
Route::get('/barang-keluar/detail/{id}', [BarangKeluarController::class, 'detail']);

//latiham
Route::get('/coba', [LatihanController::class, 'index'])->name('coba.index')->middleware(['auth', 'role:admin']);
Route::post('/coba', [LatihanController::class, 'store'])->name('coba.store');










//logut
Route::get('/Logout', [LoginController::class, 'logout'])->name('logout');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
});

Route::get('/Error', function () { return view('PageError');});


Route::middleware('guest')->group(function(){
//login
Route::get('/Login', [LoginController::class, 'index'])->name('login');
Route::post('/Login', [LoginController::class, 'store'])->name('actionlogin');
});
