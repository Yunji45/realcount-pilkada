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
// use App\Http\Controllers\Realcount\VotingUmumController;
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

// Route::get('/vote-umum',[VotingUmumController::class,'createform']);
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
        // '/voting-umum' => VotingUmumController::class
    ]);

    // Route untuk mengambil kelurahan berdasarkan kecamatan
    Route::get('/get-kabupaten/{provinsiId}', [PollingPlaceController::class, 'getKabupaten'])->name('get.kabupaten');
    Route::get('/get-kecamatan/{kabupatenId}', [PollingPlaceController::class, 'getKecamatan'])->name('get.kecamatan');
    Route::get('/get-kelurahan/{kecamatanId}', [PollingPlaceController::class, 'getKelurahan'])->name('get.kelurahan');
    Route::get('/get-rw/{kelurahanId}', [HomeController::class, 'getRw'])->name('get-rw');
    Route::get('/get-polling-places/{kelurahanId}', [VoteController::class, 'getPollingPlaces']);
    Route::get('/get-realcount-tps/{kelurahanId}', [VotingController::class, 'getTpsRealCount']);

    Route::get('/category/{category}', [ArticleController::class, 'showByCategory'])->name('category.show');
    Route::get('/article/{id}', [ArticleController::class, 'showArticle'])->name('article.show');

    Route::post('/tps-import', [PollingPlaceController::class, 'import'])->name('tps.import');
    Route::post('/vote-import', [VoteController::class, 'import'])->name('vote.import');

    // Route untuk mengembalikan data event dalam bentuk JSON
    Route::get('/getAgenda', [AgendaController::class, 'getAgendas'])->name('getAgenda');
    // Route::get('/map',[MapController::class,'index'])->name('map');
    Route::get('/user-pending', [UserController::class, 'pending'])->name('user.pending');
    Route::post('/user-verifikasi/{user}', [UserController::class, 'verifikasi'])->name('user.verifikasi');
    Route::post('/user-status/{id}', [UserController::class, 'status_user'])->name('user.status');
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
        '/realcount-tps' => TPSController::class,
        '/realcount-vote' => VotingController::class,
        '/file-c1' => C1Controller::class,
        '/file-d1' => D1Controller::class,
    ]);

    //Landing Page
    // Route::get('/', [ArticleController::class, 'showLandingPage'])->name(name: 'landingpage');
    //Profile
    Route::get('/dashboard/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    //Realcount
    Route::get('/realcount', [RealCountController::class, 'realcount'])->name('realcount');

    Route::get('/map', [DaerahController::class, 'map'])->name('map');
    Route::get('/berita/all', [ArticleController::class, 'showLandingPageAll'])->name('berita.all');
    Route::get('/berita/{id}', [ArticleController::class, 'showDetail'])->name('berita.detail');

    Route::get('map',[MapController::class,'index'])->name('map');
    Route::get('color-partai',[MapController::class,'getcolor'])->name('color');
    Route::get('filter-partai',[MapController::class,'filter'])->name('filter');

});
Route::get('/', [ArticleController::class, 'showLandingPage'])->name(name: 'landingpage');

//Funsi Delete Selection
Route::post('/users/massdelete', [UserController::class, 'massDelete'])->name('users.massDelete');
Route::post('/permissions/massdelete', [PermissionController::class, 'massDelete'])->name('permissions.massDelete');
Route::post('/partai/massdelete', [PartaiController::class, 'massDelete'])->name('partai.massDelete');
Route::post('/tps/massDelete', [PollingPlaceController::class, 'massDelete'])->name('tps.massDelete');
Route::post('/votes/massDelete', [VoteController::class, 'massDelete'])->name('vote.massDelete');

Route::delete('roles/massdelete', [RoleController::class, 'massDelete'])->name('role.massDelete');
Route::delete('/article/massDelete', [ArticleController::class, 'massDelete'])->name('article.massDelete');
Route::delete('/category_article/massDelete', [CategoryArticleController::class, 'massDelete'])->name('category_article.massDelete');
Route::delete('/elections/massdelete', [ElectionController::class, 'massDelete'])->name('election.massDelete');
Route::delete('/candidates/massDelete', [CandidateController::class, 'massDelete'])->name('candidates.massDelete');

