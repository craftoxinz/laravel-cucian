<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LaporanController;
use App\Http\Middleware\RoleMiddleware;

Route::view('/', 'home')->name('home');

// ============================================================
// AUTH
// ============================================================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// ============================================================
// PROTECTED ROUTES (Harus Login)
// ============================================================
Route::middleware(['auth'])->group(function () {

    // --------------------------------------------------------
    // 1. ROUTE KHUSUS KURIR
    // --------------------------------------------------------
    Route::middleware([RoleMiddleware::class . ':kurir'])
        ->prefix('kurir')
        ->name('kurir.')
        ->group(function () {

            Route::get('/dashboard', [App\Http\Controllers\Kurir\DashboardController::class, 'index'])->name('dashboard.index');

            Route::controller(App\Http\Controllers\Kurir\OrderController::class)
                ->prefix('orders')
                ->name('orders.')
                ->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::patch('/{order}/approve', 'approve')->name('approve');
                    Route::patch('/{order}/update-status-jemput', 'updateStatusJemput')->name('updateStatusJemput');
                });
        });

    // --------------------------------------------------------
    // 2. ROUTE BERSAMA (Bisa diakses ADMIN & KASIR)
    // --------------------------------------------------------
    Route::middleware([RoleMiddleware::class . ':admin,kasir'])->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Pelanggan
        Route::resource('pelanggan', PelangganController::class)->except(['show']);

        // Orders
        Route::resource('orders', OrderController::class)->only(['index', 'create', 'store', 'show']);
        Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
        Route::patch('orders/{order}/bayar', [OrderController::class, 'bayar'])->name('orders.bayar');
        Route::get('orders/{order}/nota', [OrderController::class, 'nota'])->name('orders.nota');

        // ----------------------------------------------------
        // Menu Khusus ADMIN Saja (Kasir tidak bisa tembak URL-nya)
        // ----------------------------------------------------
        Route::middleware([RoleMiddleware::class . ':admin'])->group(function () {
            // Layanan
            Route::resource('layanan', LayananController::class)->except(['show']);

            // Users
            Route::resource('users', UserController::class)->except(['show']);

            // Laporan
            Route::get('laporan', [LaporanController::class, 'index'])->name('laporan.index');
            Route::get('laporan/export', [LaporanController::class, 'export'])->name('laporan.export');
            Route::get('laporan/pdf', [LaporanController::class, 'export'])->name('laporan.pdf');
        });

    });

});

// ============================================================
// PELANGGAN (customer) auth + portal
// ============================================================
use App\Http\Controllers\PelangganAuthController;
use App\Http\Controllers\PelangganDashboardController;
use App\Http\Controllers\PelangganOrderController;

Route::get('/pelanggan/register', [PelangganAuthController::class, 'showRegister'])->name('pelanggan.register');
Route::post('/pelanggan/register', [PelangganAuthController::class, 'register'])->name('pelanggan.register.post');

Route::get('/pelanggan/login', [PelangganAuthController::class, 'showLogin'])->name('pelanggan.login');
Route::post('/pelanggan/login', [PelangganAuthController::class, 'login'])->name('pelanggan.login.post');
Route::post('/pelanggan/logout', [PelangganAuthController::class, 'logout'])->name('pelanggan.logout');

Route::middleware(['auth:pelanggan'])->prefix('pelanggan')->name('pelanggan.')->group(function () {
    Route::get('/dashboard', [PelangganDashboardController::class, 'index'])->name('dashboard');
    Route::get('/orders', [PelangganOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [PelangganOrderController::class, 'show'])->name('orders.show');
});
