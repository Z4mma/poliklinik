<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\Admin\PasienController;
use App\Http\Controllers\Admin\PoliController;
use App\Http\Controllers\Admin\JadwalPeriksaController;
use App\Http\Controllers\Pasien\PoliController as PasiensPoliController;
use App\Http\Controllers\dokter\PeriksaPasienController;
use App\Http\Controllers\dokter\RiwayatPasienController;

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('showLogin');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');

        Route::resource('polis', PoliController::class);
        Route::resource('dokter', DokterController::class);
        Route::resource('pasien', PasienController::class);
        Route::resource('obat', ObatController::class);
        Route::resource('jadwal-periksa', JadwalPeriksaController::class);
        Route::resource('periksa-pasien', PeriksaPasienController::class);
    });

/*
|--------------------------------------------------------------------------
| DOKTER
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:dokter'])
    ->prefix('dokter')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('dokter.dashboard');
        })->name('dokter.dashboard');

        Route::get('periksa-pasien', [PeriksaPasienController::class, 'index'])
            ->name('periksa-pasien.index');

        Route::get('periksa-pasien/{id}', [PeriksaPasienController::class, 'create'])
            ->name('periksa-pasien.show');

        Route::post('periksa-pasien/{id}', [PeriksaPasienController::class, 'store'])
            ->name('periksa-pasien.store');

        Route::get('riwayat-pasien', [RiwayatPasienController::class, 'index'])
            ->name('dokter.riwayat-pasien.index');

        Route::get('riwayat-pasien/{id}', [RiwayatPasienController::class, 'show'])
            ->name('dokter.riwayat-pasien.show');
    });

/*
|--------------------------------------------------------------------------
| PASIEN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:pasien'])
    ->prefix('pasien')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('pasien.dashboard');
        })->name('pasien.dashboard');

        Route::get('/daftar', [PasiensPoliController::class, 'get'])
            ->name('pasien.daftar');

        Route::post('/daftar', [PasiensPoliController::class, 'submit'])
            ->name('pasien.daftar.submit');
    });
