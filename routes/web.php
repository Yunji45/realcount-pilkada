<?php

use App\Http\Controllers\Admin\HomeAdminController;
use App\Http\Controllers\Admin\HomeRelawanController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\KegiatanController;
use App\Http\Controllers\Api\WilayahController as DaerahController;
use App\Http\Controllers\PollingPlaceController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\HomeKoordinatorController;
use App\Http\Controllers\Admin\HomeLainyaController;
use App\Http\Controllers\Admin\HomePemilihController;
use App\Http\Controllers\Admin\HomePimpinanController;
use App\Http\Controllers\Admin\HomeSaksiController;
use App\Http\Controllers\Admin\HomeSimpatisanController;
use App\Http\Controllers\Admin\HomeSuperAdminController;
use App\Http\Controllers\AgendaController;
use App\Models\Agenda;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('auth/login');
});

Route::get('/home', function () {
    return view('layouts/dashboard/dashboard');
});


// Dashboard Home
Route::get('/superadmin/dashboard', [HomeSuperAdminController::class, 'index'])->name('superadmin.dashboard');
Route::get('/admin/dashboard', [HomeAdminController::class, 'index'])->name('admin.dashboard');
Route::get('/relawan/dashboard', [HomeRelawanController::class, 'index'])->name('relawan.dashboard');
Route::get('/saksi/dashboard', [HomeSaksiController::class, 'index'])->name('saksi.dashboard');
Route::get('/koordinator/dashboard', [HomeKoordinatorController::class, 'index'])->name('koordinator.dashboard');
Route::get('/pimpinan/dashboard', [HomePimpinanController::class, 'index'])->name('pimpinan.dashboard');
Route::get('/pemilih/dashboard', [HomePemilihController::class, 'index'])->name('pemilih.dashboard');
Route::get('/simpatisan/dashboard', [HomeSimpatisanController::class, 'index'])->name('simpatisan.dashboard');
Route::get('/lain-lain/dashboard', [HomeLainyaController::class, 'index'])->name('lain-lain.dashboard');


// Route::get('/', function () {
//     return view('welcome');
// });
// Route::get('/map', [DaerahController::class, 'map'])->name('map');
// Route::get('/', [ArticleController::class, 'showLandingPage'])->name('landingpage');

// Route::get('/home', [App\Http\Controllers\Admin\HomeController::class, 'index'])->name('home');

// Route::middleware(['verified', 'auth', 'role:Super Admin|Admin'])->group(function () {
Route::middleware(['verified', 'auth'])->group(function () {
    Route::resources([
        '/role' => RoleController::class,
        '/permission' => PermissionController::class,
        '/user' => UserController::class,
        '/tps' => PollingPlaceController::class,
        '/kegiatan' => KegiatanController::class,
        '/articles' => ArticleController::class,
        '/agenda' => AgendaController::class,
    ]);
    Route::get('/get-kabupaten/{provinsiId}', [PollingPlaceController::class, 'getKabupaten'])->name('get.kabupaten');
    Route::get('/get-kecamatan/{kabupatenId}', [PollingPlaceController::class, 'getKecamatan'])->name('get.kecamatan');
    Route::get('/get-kelurahan/{kecamatanId}', [PollingPlaceController::class, 'getKelurahan'])->name('get.kelurahan');

    // Route untuk mengembalikan data event dalam bentuk JSON
    Route::get('/getAgenda', [AgendaController::class, 'getAgendas'])->name('getAgenda');
});
