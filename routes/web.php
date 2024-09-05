<?php

use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\KegiatanController;
use App\Http\Controllers\Api\WilayahController as DaerahController;
use App\Models\Kegiatan;
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
    return view('welcome');
});
// Route::get('/map', [DaerahController::class, 'map'])->name('map');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::middleware(['verified', 'auth', 'role:Super Admin|Admin'])->group(function () {
Route::middleware(['verified', 'auth'])->group(function () {
    Route::resources([
        '/role' => RoleController::class,
        '/permission' => PermissionController::class,
        '/user' => UserController::class,
        '/kegiatan' => KegiatanController::class,
    ]);
});
