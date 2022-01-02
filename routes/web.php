<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JenisBarangController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\MutasiStokController;
use App\Http\Controllers\UserController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [AuthController::class, 'showFormLogin'])->name('login');
Route::post('auth/login', [AuthController::class, 'login']);
Route::get('auth/logout', [AuthController::class, 'logout'])->name('logout');

Route::group(['middleware' => 'auth'], function () {
  // dashboard
  Route::get('home', [HomeController::class, 'index'])->name('home');
  // Route Master Data
  Route::group(['prefix' => '/master'], function () {
    Route::get('jenis-barang', [JenisBarangController::class, 'index'])->name('jenis-barang');
    Route::get('supplier', [SupplierController::class, 'index'])->name('supplier');
    Route::get('satuan', [SatuanController::class, 'index'])->name('satuan');
    Route::get('barangs', [BarangController::class, 'index'])->name('barang');
    Route::get('barang-add', [BarangController::class, 'create'])->name('barang.create');
    Route::get('barang-edit/{id}', [BarangController::class, 'edit'])->name('barang.edit');
  });
  // Master Jenis Barang
  Route::group(['prefix' => '/jenis-barang'], function () {
    Route::post('/save', [JenisBarangController::class, 'save'])->name('jenis-barang.save');
    Route::post('/update', [JenisBarangController::class, 'update'])->name('jenis-barang.update');
    Route::get('/load-modal', [JenisBarangController::class, 'load_modal']);
    Route::get('/delete/{id}', [JenisBarangController::class, 'delete'])->name('jenis-barang.delete');
    Route::get('/fetch-data', [JenisBarangController::class, 'fetch_data']);
  });
  // Master Satuan
  Route::group(['prefix' => '/satuan'], function () {
    Route::post('/save', [SatuanController::class, 'save'])->name('satuan.save');
    Route::post('/update', [SatuanController::class, 'update'])->name('satuan.update');
    Route::get('/load-modal', [SatuanController::class, 'load_modal']);
    Route::get('/delete/{id}', [SatuanController::class, 'delete'])->name('satuan.delete');
    Route::get('/fetch-data', [SatuanController::class, 'fetch_data']);
  });
  //Master Barang
  Route::group(['prefix' => '/barang'], function () {
    Route::post('/add', [BarangController::class, 'add'])->name('barang.add');
    Route::post('/update', [BarangController::class, 'update'])->name('barang.update');
    Route::get('/delete/{id}', [BarangController::class, 'delete'])->name('barang.delete');
    Route::get('/fetch-data', [BarangController::class, 'fetch_data']);
    // Stok Barang
    Route::get('/stok', [BarangController::class, 'stok_barang']);
    Route::get('/fetch-data-stok', [BarangController::class, 'list_stok_barang']);
  });
  // Master Supplier
  Route::group(['prefix' => '/supplier'], function () {
    Route::post('/save', [SupplierController::class, 'save'])->name('supplier.save');
    Route::post('/update', [SupplierController::class, 'update'])->name('supplier.update');
    Route::get('/load-modal', [SupplierController::class, 'load_modal']);
    Route::get('/delete/{id}', [SupplierController::class, 'delete'])->name('supplier.delete');
    Route::get('/fetch-data', [SupplierController::class, 'fetch_data']);
  });
  // Barang Masuk
  Route::group(['prefix' => '/barang-masuk'], function() {
    Route::get('/', [BarangMasukController::class, 'index'])->name('barangMasuk');
    Route::get('/add', [BarangMasukController::class, 'create'])->name('barangMasuk.create');
    Route::get('/edit/{id}', [BarangMasukController::class, 'edit'])->name('barangMasuk.edit');
    Route::get('/fetch-data', [BarangMasukController::class, 'fetch_data']);
    Route::get('/delete/{id}', [BarangMasukController::class, 'delete'])->name('BarangMasuk.delete');
    Route::post('/save', [BarangMasukController::class, 'save'])->name('BarangMasuk.save');
    Route::post('/update', [BarangMasukController::class, 'update'])->name('BarangMasuk.update');
  });
  // Barang Keluar
  Route::group(['prefix' => '/barang-keluar'], function() {
    Route::get('/', [BarangKeluarController::class, 'index'])->name('barangKeluar');
    Route::get('/add', [BarangKeluarController::class, 'create'])->name('barangKeluar.create');
    Route::get('/edit/{id}', [BarangKeluarController::class, 'edit'])->name('barangKeluar.edit');
    Route::get('/fetch-data', [BarangKeluarController::class, 'fetch_data']);
    Route::get('/delete/{id}', [BarangKeluarController::class, 'delete'])->name('BarangKeluar.delete');
    Route::post('/save', [BarangKeluarController::class, 'save'])->name('BarangKeluar.save');
    Route::post('/update', [BarangKeluarController::class, 'update'])->name('BarangKeluar.update');
  });
  // Mutasi Stok
  Route::group(['prefix' => '/mutasi-stok'], function() {
    Route::get('/', [MutasiStokController::class, 'index'])->name('mutasiStok');
    Route::get('/add', [MutasiStokController::class, 'create'])->name('mutasiStok.create');
    Route::get('/edit/{id}', [MutasiStokController::class, 'edit'])->name('mutasiStok.edit');
    Route::get('/fetch-data', [MutasiStokController::class, 'fetch_data']);
    Route::get('/delete/{id}', [MutasiStokController::class, 'delete'])->name('mutasiStok.delete');
    Route::post('/save', [MutasiStokController::class, 'save'])->name('mutasiStok.save');
    Route::post('/update', [MutasiStokController::class, 'update'])->name('mutasiStok.update');
  });
  // Lookup Barang
  Route::get('/lookup-barang', [BarangController::class, 'lookup_barang']);
  Route::get('/lookup-barang/fetch-data', [BarangController::class, 'fetch_lookup_barang']);
  // Report
  Route::get('/laporan', [ReportController::class, 'index']);
  
  //Group Setting
  Route::group(['prefix' => '/setting'], function () {
    Route::get('user', [UserController::class, 'index'])->name('user');
    Route::get('user-add', [UserController::class, 'create'])->name('user.create');
    Route::get('user-edit/{id}', [UserController::class, 'edit'])->name('user.edit');
  });
   //Master User
   Route::group(['prefix' => '/user'], function () {
    Route::post('/add', [UserController::class, 'add'])->name('user.add');
    Route::post('/update', [UserController::class, 'update'])->name('user.update');
    Route::get('/delete/{id}', [UserController::class, 'delete'])->name('user.delete');
    Route::get('/fetch-data', [UserController::class, 'fetch_data']);
  });
});

Route::get('/report/pembelian', [ReportController::class, 'report_pembelian']);
Route::get('/report/penjualan', [ReportController::class, 'report_penjualan']);
Route::get('/report/barang-masuk', [ReportController::class, 'report_barang_masuk']);
Route::get('/report/barang-keluar', [ReportController::class, 'report_barang_keluar']);
Route::get('/report/kartu-stok', [ReportController::class, 'report_kartu_stok']);
Route::get('/report/mutasi-stok', [ReportController::class, 'report_mutasi_Stok']);
