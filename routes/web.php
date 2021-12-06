<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JenisBarangController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\SupplierController;

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
    Route::get('barang', [BarangController::class, 'index'])->name('barang');
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
    Route::delete('/delete/{id}', [BarangMasukController::class, 'delete'])->name('BarangMasuk.delete');
    Route::post('/save', [BarangMasukController::class, 'save'])->name('BarangMasuk.save');
    Route::post('/update', [BarangMasukController::class, 'update'])->name('BarangMasuk.update');
  });
  // Lookup Barang
  Route::get('/lookup-barang', [BarangController::class, 'lookup_barang']);
  Route::get('/lookup-barang/fetch-data', [BarangController::class, 'fetch_lookup_barang']);
});
