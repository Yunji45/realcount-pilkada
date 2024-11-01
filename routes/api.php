<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\WilayahController;
use App\Http\Controllers\Api\ChartController;
use App\Http\Controllers\MapController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('provinsi', [WilayahController::class, 'index_provinsi'])->name('provinsi.index');
Route::get('provinsi/{id}', [WilayahController::class, 'show_provinsi'])->name('provinsi.show');

Route::get('kabupaten', [WilayahController::class, 'index_kabupaten'])->name('kabupaten.index');
Route::get('kabupaten/{id}', [WilayahController::class, 'show_kabupaten'])->name('kabupaten.show');

Route::get('kecamatan', [WilayahController::class, 'index_kecamatan'])->name('kecamatan.index');
Route::get('kecamatan/{id}', [WilayahController::class, 'show_kecamatan'])->name('kecamatan.show');

Route::get('kelurahan', [WilayahController::class, 'index_kelurahan'])->name('kelurahan.index');
Route::get('kelurahan/{id}', [WilayahController::class, 'show_kelurahan'])->name('kelurahan.show');
// Route::get('map',[MapController::class,'index'])->name('map');
// Route::get('color-partai',[MapController::class,'getcolor'])->name('color');
// Route::get('filter-partai',[MapController::class,'filter'])->name('filter');

//chart
route::get('chart-vote',[ChartController::class, 'getVotesPerPartaiElection'])->name('chart');
Route::get('/votes-per-election', [ChartController::class, 'getVotesByElection']);
Route::get('/elections', [ChartController::class, 'getElections']);

// Route::middleware(['verified', 'auth'])->group(function () {
//     Route::get('map',[MapController::class,'index'])->name('map');
//     Route::get('color-partai',[MapController::class,'getcolor'])->name('color');
//     Route::get('filter-partai',[MapController::class,'filter'])->name('filter');

// });



