<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PoliController as PasiensPoliController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\Admin\PasienController;
use App\Http\Controllers\ObatController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'showLogin'])->name('showLogin');
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function()
{   Route::get('/dashboard', function(){
        return view('admin.dashboard');
    })->name('admin.dashboard');
    Route::resource('polis', PoliController::class);
    Route::resource('dokter', DokterController::class);
    Route::resource('pasien', PasienController::class);
    Route::resource('obat', ObatController::class);
    Route::resource('jadwal-periksa', JadwalPeriksaController::class);

});
Route::middleware(['auth', 'role:dokter'])->prefix('dokter')->group(function()
{   Route::get('/dashboard', function(){
        return view('dokter.dashboard');
    })->name('dokter.dashboard');

});

Route::middleware(['auth', 'role:pasien'])->prefix('pasien')->group(function()
{   Route::get('/dashboard', function(){
        return view('pasien.dashboard');
    })->name('admin.dashboard');
    Route::get('/daftar', [PasiensPoliController::class, 'get'])->name('pasien.daftar');
    Route::post('/daftar', [PasiensPoliController::class, 'submit'])->name('pasien.daftar.submit');
});
