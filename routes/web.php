<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubKriteriaController;
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
//     return view('master');
// });
// Route::middleware('auth')->group(function () {
Route::get('/penilaian', function () {
    return view('penilaian.penilaian');
});

Route::get('/', [DashboardController::class, 'index']);

Route::resource('dashboard', DashboardController::class);
Route::resource('karyawan', KaryawanController::class);
Route::resource('kriteria', KriteriaController::class);
Route::resource('subkriteria', SubKriteriaController::class);
Route::resource('penilaian', PenilaianController::class);
// });
Route::get('/get-next-sub-kriteria/{kode_kriteria}', [SubKriteriaController::class, 'getNextSubKriteria']);

require __DIR__ . '/auth.php';
