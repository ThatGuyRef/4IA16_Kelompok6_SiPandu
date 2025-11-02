<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    if (Auth::check() && Auth::user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Permohonan routes for warga
use App\Http\Controllers\Permohonan\WargaPermohonanController;
use App\Http\Controllers\Permohonan\AdminPermohonanController;
use App\Http\Controllers\AdminDashboardController;

Route::middleware(['auth'])->group(function () {
    Route::get('/permohonan', [WargaPermohonanController::class, 'index'])->name('permohonan.warga.index');
    Route::get('/permohonan/create', [WargaPermohonanController::class, 'create'])->name('permohonan.warga.create');
    Route::post('/permohonan', [WargaPermohonanController::class, 'store'])->name('permohonan.warga.store');
    // Confirmation page after submit
    Route::get('/permohonan/confirm/{permohonan?}', [WargaPermohonanController::class, 'confirm'])->name('permohonan.warga.confirm');
    // Detail permohonan for warga
    Route::get('/permohonan/{permohonan}', [WargaPermohonanController::class, 'show'])->name('permohonan.warga.show');
});

// Admin dashboard (protected by auth and role check)
Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
    ->middleware(['auth', 'role:admin'])
    ->name('admin.dashboard');

// Admin permohonan management
Route::middleware(['auth','role:admin'])->prefix('admin')->name('admin.')->group(function(){
    Route::get('permohonan', [AdminPermohonanController::class, 'index'])->name('permohonan.index');
    Route::get('permohonan/{permohonan}', [AdminPermohonanController::class, 'show'])->name('permohonan.show');
    Route::patch('permohonan/{permohonan}', [AdminPermohonanController::class, 'update'])->name('permohonan.update');

    // Live metrics endpoint for dashboard polling
    Route::get('metrics', [AdminDashboardController::class, 'metrics'])->name('metrics');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
