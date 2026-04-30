<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\TindakanController;
use App\Http\Controllers\TransaksiController;

// DASHBOARD
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// AUTH GROUP
Route::middleware('auth')->group(function () {

    // PROFILE
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 🔥 ADMIN ONLY
  Route::middleware(['auth', 'role:admin'])->group(function () {

    // 🔥 MASTER DATA (ADMIN ONLY)
    Route::resource('obat', ObatController::class);
    Route::resource('tindakan', TindakanController::class);

    // 🔥 MANAJEMEN USER
    Route::get('/user', [App\Http\Controllers\UserController::class, 'index']);
    Route::get('/user/{id}/edit-role', [App\Http\Controllers\UserController::class, 'editRole']);
    Route::post('/user/{id}/update-role', [App\Http\Controllers\UserController::class, 'updateRole']);

});
    // 🔥 ADMIN + DOKTER
    Route::middleware('role:admin,dokter')->group(function () {
        Route::resource('pasien', PasienController::class);
    });

    // 🔥 ADMIN + KASIR
    Route::middleware('role:admin,kasir')->group(function () {
        Route::get('/transaksi', [TransaksiController::class, 'index']);
        Route::get('/transaksi/create', [TransaksiController::class, 'create']);
        Route::post('/transaksi/store', [TransaksiController::class, 'store']);
        Route::get('/transaksi/{id}', [TransaksiController::class, 'show']);
        Route::get('/transaksi/print/{id}', [TransaksiController::class, 'print']);
        Route::get('/transaksi/thermal/{id}', [TransaksiController::class, 'thermal']);
    });

    // 🔥 DASHBOARD DATA (SEMUA ROLE LOGIN BOLEH)
    Route::get('/dashboard/data', [TransaksiController::class, 'dashboardData']);
    Route::get('/dashboard/chart', [TransaksiController::class, 'chartData']);
    Route::get('/dashboard/pie-obat', [TransaksiController::class, 'pieObat']);
    Route::get('/dashboard/advanced', [TransaksiController::class, 'dashboardAdvanced']);

});

require __DIR__.'/auth.php';