<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Auth\AdminController;
use App\Http\Controllers\Auth\ManajemenPasienController;
use App\Http\Controllers\Auth\PemeriksaanController;
use App\Http\Controllers\Auth\CallcenterController;
use App\Http\Controllers\Auth\ReagensiaController;
use App\Http\Controllers\Auth\InstrumenController;
use App\Http\Controllers\Auth\PilihLoginController;
use App\Http\Controllers\Auth\KunjunganLabolaturiumController;


Route::get('/', [PilihLoginController::class, 'showLoginOptions'])->name('pilihLogin');
// Rute untuk User
Route::prefix('user')->name('user.')->namespace('Auth')->group(function () {
    Route::get('/register', [UserController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [UserController::class, 'register']);

    Route::get('/login', [UserController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [UserController::class, 'login']);

    Route::middleware(['auth:web'])->group(function () {
        Route::post('/logout', [UserController::class, 'logout'])->name('logoutUser');
        Route::get('/dashboard', [UserController::class, 'showDashboardForm'])->name('dashboard');
        Route::put('/update-profile', [UserController::class, 'updateProfile'])->name('updateProfile');
        Route::get('/patient/details/{id}', [UserController::class, 'showPatientDetailsAndPemeriksaan'])->name('patient.details.pemeriksaan');
    });
});
// callcenter
Route::prefix('callcenter')->name('callcenter.')->namespace('Auth')->group(function () {
    Route::get('/register', [CallcenterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [CallcenterController::class, 'register']);

    Route::get('/login', [CallcenterController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [CallcenterController::class, 'login']);
    Route::get('/dashboard', [CallcenterController::class, 'showDataPatients'])->name('dashboard');
    Route::delete('/callcenter/destroy/{id}', [CallcenterController::class, 'destroy'])->name('antrian.destroy');
    Route::post('/logout', [CallcenterController::class, 'logoutCallcenter'])->name('logoutCallcenter');

});

// Rute untuk Admin
Route::prefix('admin')->name('admin.')->namespace('Auth')->group(function () {
    Route::get('/register', [AdminController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AdminController::class, 'register']);

    Route::get('/login', [AdminController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminController::class, 'login']);

    Route::middleware(['auth:admin'])->group(function () {
        Route::post('/logout', [AdminController::class, 'logout'])->name('logoutAdmin');
        Route::get('/home', [AdminController::class, 'showHomeForm'])->name('home');

        // Rute lainnya untuk admin
        Route::get('/manajementpasien', [ManajemenPasienController::class, 'showManajementForm'])->name('mpasient');
        Route::post('/manajementpasien/store', [ManajemenPasienController::class, 'store'])->name('mpasient.store');
        Route::get('/manajementpasien/{id}/edit', [ManajemenPasienController::class, 'edit'])->name('mpasient.edit');
        Route::put('/manajementpasien/{id}', [ManajemenPasienController::class, 'update'])->name('mpasient.update');
        Route::delete('/manajementpasien/{id}/destroy', [ManajemenPasienController::class, 'destroy'])->name('mpasient.destroy');
        Route::get('/patient/details/{id}', [ManajemenPasienController::class, 'showPatientDetailsAndPemeriksaan'])->name('patient.details.pemeriksaan');


        // Pemeriksaan
        Route::get('/patient/pemeriksaan', [PemeriksaanController::class, 'showPemeriksaanForm'])->name('pemeriksaan');
        Route::post('/patient/pemeriksaan/store', [PemeriksaanController::class, 'store'])->name('pemeriksaan.store');
        Route::get('/pemeriksaan/{id_periksa}/edit', [PemeriksaanController::class, 'edit'])->name('pemeriksaan.edit');
        Route::put('/pemeriksaan/{id_periksa}', [PemeriksaanController::class, 'update'])->name('pemeriksaan.update');
        Route::delete('/pemeriksaan/{id}/destroy', [PemeriksaanController::class, 'destroy'])->name('pemeriksaan.destroy');
        Route::get('/pemeriksaan/{id}/details', [PemeriksaanController::class, 'showPemeriksaanDetails'])->name('pemeriksaan.details');
        Route::get('/pemeriksaan/hasil', [PemeriksaanController::class, 'showHasilForm'])->name('pemeriksaanHasil');

        // Reagensia
        Route::get('/reagensia', [ReagensiaController::class, 'showReagensiaForm'])->name('reagensia');
        Route::post('/reagensia/store', [ReagensiaController::class, 'store'])->name('reagensia.store');
        Route::get('/reagensia/{id}/edit', [ReagensiaController::class, 'edit'])->name('reagensia.edit');
        Route::put('/reagensia/{id}/update', [ReagensiaController::class, 'update'])->name('reagensia.update');
        Route::delete('/reagensia/{id}/destroy', [ReagensiaController::class, 'destroy'])->name('reagensia.destroy');
        Route::get('/reagensia/{id}/details', [ReagensiaController::class, 'showReagenDetail'])->name('reagensia.details');

        // Instrumen
        Route::get('/instrumen', [InstrumenController::class, 'showInstrumenForm'])->name('instrumen');
        Route::get('/instrumen/create', [InstrumenController::class, 'create'])->name('instrumen.create');
        Route::post('/instrumen/store', [InstrumenController::class, 'store'])->name('instrumen.store');
        Route::put('/instrumen/{id_instrumen}/update', [InstrumenController::class, 'update'])->name('instrumen.update');
        Route::delete('/instrumen/{id_instrumen}/destroy', [InstrumenController::class, 'destroy'])->name('instrumen.destroy');
        Route::get('/instrumen/{id_instrumen}/details', [InstrumenController::class, 'showInstrumenDetail'])->name('instrumen.details');

        // Kunjungan Laboratorium
        Route::get('/kunjungan-laboratorium', [KunjunganLabolaturiumController::class, 'showKunjunganForm'])->name('kunjunganLabolaturium');
        Route::post('/kunjungan-laboratorium/store', [KunjunganLabolaturiumController::class, 'store'])->name('kunjunganLabolaturium.store');
        Route::put('/kunjungan-laboratorium/{id}/update', [KunjunganLabolaturiumController::class, 'update'])->name('kunjunganLabolaturium.update');
        Route::delete('/kunjungan-laboratorium/{id}/destroy', [KunjunganLabolaturiumController::class, 'destroy'])->name('kunjunganLabolaturium.destroy');
        Route::get('/kunjungan-laboratorium/{id}/details', [KunjunganLabolaturiumController::class, 'showKunjunganDetail'])->name('kunjunganLabolaturium.details');
    });
});

