<?php

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
use App\Http\Controllers\Realcount\TPSController;
use App\Http\Controllers\Realcount\VotingController;
use App\Http\Controllers\Realcount\D1Controller;
use App\Http\Controllers\Realcount\C1Controller;
use App\Http\Controllers\HomeController;
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

// START: KOORDINATOR
Route::middleware(['verified', 'auth', 'role:Koordinator'])->name('koordinator.')->group(function () {
    Route::get('/koordinator/dashboard', [HomeKoordinatorController::class, 'index'])->name('dashboard');

    Route::resources([]);
});
// END: KOORDINATOR

Route::middleware(['verified', 'auth', 'role:Admin|Super Admin|Pimpinan'])->group(function () {
    Route::get('/dashboard/perorangan', [HomeController::class, 'indexPerorangan'])->name('dashboard.perorangan');
    Route::get('/dashboard/partai', [HomeController::class, 'indexPartai'])->name('dashboard.partai');
    Route::get('/dashboard/peta', [HomeController::class, 'indexPeta'])->name('dashboard.peta');
    Route::resources([
        '/user' => UserController::class,
        '/role' => RoleController::class,
        '/permission' => PermissionController::class,

        '/tps' => PollingPlaceController::class,
        '/vote' => VoteController::class,
        '/kegiatan' => KegiatanController::class,
        '/articles' => ArticleController::class,
        '/category_articles' => CategoryArticleController::class,
        '/agenda' => AgendaController::class,
    ]);

    Route::get('/get-kabupaten/{provinsiId}', [PollingPlaceController::class, 'getKabupaten'])->name('get.kabupaten');
    Route::get('/get-kecamatan/{kabupatenId}', [PollingPlaceController::class, 'getKecamatan'])->name('get.kecamatan');
    Route::get('/get-kelurahan/{kecamatanId}', [PollingPlaceController::class, 'getKelurahan'])->name('get.kelurahan');
    Route::get('/get-rw/{kelurahan_id}', [HomeController::class, 'getRw'])->name('get-rw');

    Route::get('/category/{category}', [ArticleController::class, 'showByCategory'])->name('category.show');
    Route::get('/article/{id}', [ArticleController::class, 'showArticle'])->name('article.show');

    Route::post('/tps-import', [PollingPlaceController::class, 'import'])->name('tps.import');
    Route::post('/vote-import', [VoteController::class, 'import'])->name('vote.import');

    // Route untuk mengembalikan data event dalam bentuk JSON
    Route::get('/getAgenda', [AgendaController::class, 'getAgendas'])->name('getAgenda');
    // Route::get('/map',[MapController::class,'index'])->name('map');
    Route::get('/user-pending', [UserController::class, 'pending'])->name('user.pending');
});

Route::middleware(['verified', 'auth', 'role:Admin|Super Admin|Pimpinan|Koordinator'])->group(function () {
    Route::resources([
        '/partai' => PartaiController::class,
        '/election' => ElectionController::class,
        '/candidate' => CandidateController::class,
    ]);
});

Route::middleware(['verified', 'auth'])->group(function () {
    Route::resources([
        '/tps-realcount' => TPSController::class,
        '/vote-realcount' => VotingController::class,
        '/file-c1' => C1Controller::class,
        '/file-d1' => D1Controller::class,
    ]);

    //Landing Page
    Route::get('/', [ArticleController::class, 'showLandingPage'])->name(name: 'landingpage');
    //Profile
    Route::get('/dashboard/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    //Realcount
    Route::get('/realcount', [RealCountController::class, 'realcount'])->name('realcount');

    Route::get('/map', [DaerahController::class, 'map'])->name('map');
    Route::get('/berita/all', [ArticleController::class, 'showLandingPageAll'])->name('berita.all');
    Route::get('/berita/{id}', [ArticleController::class, 'showDetail'])->name('berita.detail');

    // Route untuk mengambil kelurahan berdasarkan kecamatan
    Route::get('/get-kabupatens/{provinsi_id}', [VoteController::class, 'getKabupatens']);
    Route::get('/get-kecamatans/{kabupaten_id}', [VoteController::class, 'getKecamatans']);
    Route::get('/get-kelurahans/{kecamatan_id}', [VoteController::class, 'getKelurahans']);
    Route::get('/get-polling-places/{kelurahan_id}', [VoteController::class, 'getPollingPlaces']);
    Route::get('/get-tps-realcount/{kelurahan_id}', [VotingController::class, 'getTpsRealCount']);
});
