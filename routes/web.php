<?php

use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\KegiatanController;
use App\Http\Controllers\Api\WilayahController as DaerahController;
use App\Http\Controllers\PollingPlaceController;
use App\Http\Controllers\Admin\ArticleController;
use App\Models\Article;
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

// Route::get('/', function () {
//     return view('welcome');
// });
// Route::get('/map', [DaerahController::class, 'map'])->name('map');
Route::get('/login', function () {
    return view('auth/login');
})->name('login');


Route::get('/', function () {
    return view('landingpage.app');
});

Route::get('/berita', [ArticleController::class, 'showLandingPage'])->name('landingpage');
Route::get('/category/{category}', [ArticleController::class, 'showByCategory'])->name('category.show');
Route::get('/article/{id}', [ArticleController::class, 'showArticle'])->name('article.show');
Route::get('/',[ArticleController::class,'showLandingPage'])->name('landingpage');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::middleware(['verified', 'auth', 'role:Super Admin|Admin'])->group(function () {
Route::middleware(['verified', 'auth'])->group(function () {
    Route::resources([
        '/role' => RoleController::class,
        '/permission' => PermissionController::class,
        '/user' => UserController::class,
        '/tps' => PollingPlaceController::class,
        '/kegiatan' => KegiatanController::class,
        '/articles' => ArticleController::class,
    ]);
    Route::get('/get-kabupaten/{provinsiId}', [PollingPlaceController::class, 'getKabupaten'])->name('get.kabupaten');
    Route::get('/get-kecamatan/{kabupatenId}', [PollingPlaceController::class, 'getKecamatan'])->name('get.kecamatan');
    Route::get('/get-kelurahan/{kecamatanId}', [PollingPlaceController::class, 'getKelurahan'])->name('get.kelurahan');

});
