<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\PenilaianKaryawanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RekapController;
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
Route::middleware('auth')->group(function () {
    Route::get('/penilaian', function () {
        return view('penilaian.penilaian');
    });

    Route::get('/', [DashboardController::class, 'index']);

    Route::resource('dashboard', DashboardController::class);
    Route::resource('karyawan', KaryawanController::class);
    Route::resource('kriteria', KriteriaController::class);
    Route::resource('subkriteria', SubKriteriaController::class);
    Route::resource('penilaian', PenilaianController::class);
    Route::get('penilaian/{divisi}/{tgl_penilaian}', [PenilaianController::class, 'show'])->name('penilaian.show');
    Route::delete('penilaian/{divisi}/{tgl_penilaian}', [PenilaianController::class, 'destroy'])->name('penilaian.destroy');
    Route::get('rekap', [RekapController::class, 'index'])->name('rekap.index');
    Route::post('rekap-pdf', [RekapController::class, 'rekap'])->name('rekap.rekap');
    Route::get('/divisi-by-date', [RekapController::class, 'getDivisiByDate'])->name('divisi.by.date');
    Route::put('validasi/{divisi}/{tgl_penilaian}', [PenilaianController::class, 'validasi'])->name('penilaian.validasi');

    Route::get('penilaian-karyawan/create/{id}', [PenilaianKaryawanController::class, 'create'])->name('penilaiankaryawan.create');
    Route::post('penilaian-karyawan/{id}', [PenilaianKaryawanController::class, 'store'])->name('penilaiankaryawan.store');
    Route::get('penilaian-karyawan/{id}', [PenilaianKaryawanController::class, 'edit'])->name('penilaiankaryawan.edit');
    Route::put('penilaian-karyawan/{id}', [PenilaianKaryawanController::class, 'update'])->name('penilaiankaryawan.update');

    Route::post('rekap-penilaian', [RekapController::class, 'getRekap'])->name('rekap.penilaian');
});
Route::get('/get-next-sub-kriteria/{kode_kriteria}', [SubKriteriaController::class, 'getNextSubKriteria']);

require __DIR__ . '/auth.php';
