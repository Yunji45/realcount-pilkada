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
use App\Http\Controllers\RealcountController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Mail\PostMail;
use App\Models\Kelurahan;
use App\Models\PollingPlace;
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

Route::get('/', function () {
    return view('auth/login');
});
// Route::get('/send-email', function () {
//     $data = [
//         'name' => 'Syahrizal As',
//         'body' => 'Testing Kirim Email di Santri Koding'
//     ];

//     Mail::to('ihyanatikwibowo@gmail.com')->send(new VerifikasiEmail($data));

//     dd("Email Berhasil dikirim.");
// });


Route::get('/home', function () {
    return view('layouts/dashboard/dashboard');
});

// Route untuk mengambil kelurahan berdasarkan kecamatan
Route::get('/get-kabupatens/{provinsi_id}', [VoteController::class, 'getKabupatens']);
Route::get('/get-kecamatans/{kabupaten_id}', [VoteController::class, 'getKecamatans']);
Route::get('/get-kelurahans/{kecamatan_id}', [VoteController::class, 'getKelurahans']);
Route::get('/get-polling-places/{kelurahan_id}', [VoteController::class, 'getPollingPlaces']);

// Dashboard Home
Route::get('/superadmin/dashboard', [HomeSuperAdminController::class, 'index'])->name('superadmin.dashboard');
Route::get('/relawan/dashboard', [HomeRelawanController::class, 'index'])->name('relawan.dashboard');
Route::get('/saksi/dashboard', [HomeSaksiController::class, 'index'])->name('saksi.dashboard');
Route::get('/koordinator/dashboard', [HomeKoordinatorController::class, 'index'])->name('koordinator.dashboard');
Route::get('/pimpinan/dashboard', [HomePimpinanController::class, 'index'])->name('pimpinan.dashboard');
Route::get('/pemilih/dashboard', [HomePemilihController::class, 'index'])->name('pemilih.dashboard');
Route::get('/simpatisan/dashboard', [HomeSimpatisanController::class, 'index'])->name('simpatisan.dashboard');
Route::get('/lain-lain/dashboard', [HomeLainyaController::class, 'index'])->name('lain-lain.dashboard');


Route::get('/admin/dashboard/perorangan', action: [HomeAdminController::class, 'indexPerorangan'])->name('admin.dashboard.perorangan');
Route::get('/admin/dashboard/partai', action: [HomeAdminController::class, 'indexPartai'])->name('admin.dashboard.partai');
Route::get('/admin/dashboard/peta', action: [HomeAdminController::class, 'indexPeta'])->name('admin.dashboard.peta');


// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/map', [DaerahController::class, 'map'])->name('map');
Route::get('/', [ArticleController::class, 'showLandingPage'])->name(name: 'landingpage');
Route::get('/berita/all', [ArticleController::class, 'showLandingPageAll'])->name('berita.all');
Route::get('/berita/{id}', [ArticleController::class, 'showDetail'])->name('berita.detail');

Route::get('/category/{category}', [ArticleController::class, 'showByCategory'])->name('category.show');
Route::get('/article/{id}', [ArticleController::class, 'showArticle'])->name('article.show');

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
    Route::get('/admin/dashboard', [HomeAdminController::class, 'index'])->name('admin.dashboard');

    Route::post('/user-verifikasi/{user}', [UserController::class, 'verifikasi'])->name('user.verifikasi');
    Route::get('/get-kabupaten/{provinsiId}', [PollingPlaceController::class, 'getKabupaten'])->name('get.kabupaten');
    Route::get('/get-kecamatan/{kabupatenId}', [PollingPlaceController::class, 'getKecamatan'])->name('get.kecamatan');
    Route::get('/get-kelurahan/{kecamatanId}', [PollingPlaceController::class, 'getKelurahan'])->name('get.kelurahan');

    Route::post('/tps-import', [PollingPlaceController::class, 'import'])->name('tps.import');
    Route::post('/vote-import', [VoteController::class, 'import'])->name('vote.import');

    Route::get('/get-kabupaten-home/{provinsiId}', [HomeAdminController::class, 'getKabupaten'])->name('get.kabupaten');
    Route::get('/get-kecamatan-home/{kabupatenId}', [HomeAdminController::class, 'getKecamatan'])->name('get.kecamatan');
    Route::get('/get-kelurahan-home/{kecamatanId}', action: [HomeAdminController::class, 'getKelurahan'])->name('get.kelurahan');
    Route::get('/get-rw/{kelurahan_id}', action: [HomeAdminController::class, 'getRw'])->name('get-rw');

    // Route untuk mengembalikan data event dalam bentuk JSON
    Route::get('/getAgenda', [AgendaController::class, 'getAgendas'])->name('getAgenda');
    // Route::get('/map',[MapController::class,'index'])->name('map');
    Route::get('/user-pending', [UserController::class, 'pending'])->name('user.pending');


    //Profile
    Route::get('/dashboard/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    //Realcount
    Route::get('/realcount', [RealCountController::class, 'realcount'])->name('realcount');
});
