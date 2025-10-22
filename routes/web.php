<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Permohonan routes for warga
use App\Http\Controllers\Permohonan\WargaPermohonanController;
use App\Http\Controllers\Permohonan\AdminPermohonanController;

Route::middleware(['auth'])->group(function () {
    Route::get('/permohonan', [WargaPermohonanController::class, 'index'])->name('permohonan.warga.index');
    Route::get('/permohonan/create', [WargaPermohonanController::class, 'create'])->name('permohonan.warga.create');
    Route::post('/permohonan', [WargaPermohonanController::class, 'store'])->name('permohonan.warga.store');
});

// Admin dashboard (protected by auth and role check)
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'role:admin'])->name('admin.dashboard');

// Admin permohonan management
Route::middleware(['auth','role:admin'])->prefix('admin')->name('admin.')->group(function(){
    Route::get('permohonan', [AdminPermohonanController::class, 'index'])->name('permohonan.index');
    Route::get('permohonan/{permohonan}', [AdminPermohonanController::class, 'show'])->name('permohonan.show');
    Route::put('permohonan/{permohonan}', [AdminPermohonanController::class, 'update'])->name('permohonan.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
