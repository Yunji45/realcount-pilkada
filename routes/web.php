<?php

use App\Http\Controllers\Admin\HomeAdminController;
use App\Http\Controllers\Relawan\HomeRelawanController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\KegiatanController;
use App\Http\Controllers\Api\WilayahController as DaerahController;
use App\Http\Controllers\PollingPlaceController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\CandidateController;
use App\Http\Controllers\Admin\CategoryArticleController;
use App\Http\Controllers\Koordinator\HomeKoordinatorController;
use App\Http\Controllers\Lainya\HomeLainyaController;
use App\Http\Controllers\Pemilih\HomePemilihController;
use App\Http\Controllers\Pimpinan\HomePimpinanController;
use App\Http\Controllers\Saksi\HomeSaksiController;
use App\Http\Controllers\Simpatisan\HomeSimpatisanController;
use App\Http\Controllers\SuperAdmin\HomeSuperAdminController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\ElectionController;
use App\Http\Controllers\PartaiController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\MapController;
use Illuminate\Support\Facades\Route;
use App\Mail\PostMail;
use Illuminate\Support\Facades\Mail;

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

// Route::get('/', function () {
//     return view('auth/login');
// });
Route::get('/send-email', function () {
    $data = [
        'name' => 'Syahrizal As',
        'body' => 'Testing Kirim Email di Santri Koding'
    ];

    Mail::to('ihyanatikwibowo@gmail.com')->send(new PostMail($data));

    dd("Email Berhasil dikirim.");
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
Route::get('/map', [DaerahController::class, 'map'])->name('map');
Route::get('/', [ArticleController::class, 'showLandingPage'])->name('landingpage');

// Route::get('/home', [App\Http\Controllers\Admin\HomeController::class, 'index'])->name('home');

// Route::middleware(['verified', 'auth', 'role:Super Admin|Admin'])->group(function () {
Route::middleware(['verified', 'auth'])->group(function () {
    Route::resources([
        '/role' => RoleController::class,
        '/permission' => PermissionController::class,
        '/user' => UserController::class,
        '/partai' => PartaiController::class,
        '/election' => ElectionController::class,
        '/candidate' => CandidateController::class,
        '/tps' => PollingPlaceController::class,
        '/vote' => VoteController::class,
        '/kegiatan' => KegiatanController::class,
        '/articles' => ArticleController::class,
        '/category_articles' => CategoryArticleController::class,
        '/agenda' => AgendaController::class,
    ]);
    Route::post('/user-verifikasi/{user}', [UserController::class, 'verifikasi'])->name('user.veifikasi');
    Route::get('/get-kabupaten/{provinsiId}', [PollingPlaceController::class, 'getKabupaten'])->name('get.kabupaten');
    Route::get('/get-kecamatan/{kabupatenId}', [PollingPlaceController::class, 'getKecamatan'])->name('get.kecamatan');
    Route::get('/get-kelurahan/{kecamatanId}', [PollingPlaceController::class, 'getKelurahan'])->name('get.kelurahan');

    // Route untuk mengembalikan data event dalam bentuk JSON
    Route::get('/getAgenda', [AgendaController::class, 'getAgendas'])->name('getAgenda');
    // Route::get('/map',[MapController::class,'index'])->name('map');
    Route::get('/user-pending',[UserController::class,'pending'])->name('user.pending');
});
