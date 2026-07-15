<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LaporanController;

Route::view('/', 'home')->name('home');

// ============================================================
// AUTH
// ============================================================
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ============================================================
// PROTECTED ROUTES (Dashboard, Pelanggan, Layanan, Orders, Users, Laporan)
// ============================================================
    Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Pelanggan (index, create, store, edit, update, destroy)
    Route::resource('pelanggan', PelangganController::class)->except(['show']);

    // Layanan (index, create, store, edit, update, destroy)
    Route::resource('layanan', LayananController::class)->except(['show']);

    // Orders
    Route::resource('orders', OrderController::class)->only(['index', 'create', 'store', 'show']);
    Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::patch('orders/{order}/bayar',  [OrderController::class, 'bayar'])->name('orders.bayar');
    Route::get('orders/{order}/nota',     [OrderController::class, 'nota'])->name('orders.nota');

    // Users (index, create, store, edit, update, destroy)
    Route::resource('users', UserController::class)->except(['show']);

    // Laporan
    Route::get('laporan',        [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('laporan/export', [LaporanController::class, 'export'])->name('laporan.export');
    Route::get('laporan/pdf', [LaporanController::class, 'export'])->name('laporan.pdf');

});
