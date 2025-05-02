<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// API Version 1 - Public Routes
Route::prefix('v1')->group(function () {
    // Auth Routes
    Route::prefix('auth')->group(function () {
        Route::post('/register', [\App\Http\Controllers\Api\V1\AuthController::class, 'register'])->name('api.v1.auth.register');
        Route::post('/login', [\App\Http\Controllers\Api\V1\AuthController::class, 'login'])->name('api.v1.auth.login');
    });
});

// API Version 1 - Authenticated Routes
Route::prefix('v1')->middleware(['auth:sanctum', 'throttle:80,1'])->group(function () {
    // Auth Routes
    Route::prefix('auth')->group(function () {
        Route::post('/logout', [\App\Http\Controllers\Api\V1\AuthController::class, 'logout'])->name('api.v1.auth.logout');
        Route::get('/user', [\App\Http\Controllers\Api\V1\AuthController::class, 'user'])->name('api.v1.auth.user');
    });

    // Pengguna Routes
    Route::apiResource('pengguna', \App\Http\Controllers\Api\V1\PenggunaController::class)
        ->except(['store'])
        ->names([
            'index' => 'api.v1.pengguna.index',
            'show' => 'api.v1.pengguna.show',
            'update' => 'api.v1.pengguna.update',
            'destroy' => 'api.v1.pengguna.destroy'
        ]);
    
    // Riwayat Mutasi Pengguna
    Route::get('pengguna/{id}/riwayat-mutasi', [\App\Http\Controllers\Api\V1\PenggunaController::class, 'riwayatByPengguna'])
        ->name('api.v1.pengguna.riwayat-mutasi');

    // Kategori Barang Routes
    Route::apiResource('kategori-barang', \App\Http\Controllers\Api\V1\KategoriBarangController::class)
        ->names([
            'index' => 'api.v1.kategori-barang.index',
            'store' => 'api.v1.kategori-barang.store',
            'show' => 'api.v1.kategori-barang.show',
            'update' => 'api.v1.kategori-barang.update',
            'destroy' => 'api.v1.kategori-barang.destroy'
        ]);

    // Lokasi Routes
    Route::apiResource('lokasi', \App\Http\Controllers\Api\V1\LokasiController::class)
        ->names([
            'index' => 'api.v1.lokasi.index',
            'store' => 'api.v1.lokasi.store',
            'show' => 'api.v1.lokasi.show',
            'update' => 'api.v1.lokasi.update',
            'destroy' => 'api.v1.lokasi.destroy'
        ]);

    // Barang Routes
    Route::apiResource('barang', \App\Http\Controllers\Api\V1\BarangController::class)
        ->names([
            'index' => 'api.v1.barang.index',
            'store' => 'api.v1.barang.store',
            'show' => 'api.v1.barang.show',
            'update' => 'api.v1.barang.update',
            'destroy' => 'api.v1.barang.destroy'
        ]);
    
    // Riwayat Stok Barang
    Route::get('barang/{barang}/riwayat-stok', [\App\Http\Controllers\Api\V1\RiwayatStokController::class, 'riwayatByBarang'])
        ->name('api.v1.barang.riwayat-stok');

    // Mutasi Barang Routes
    Route::apiResource('mutasi-barang', \App\Http\Controllers\Api\V1\MutasiBarangController::class)
        ->names([
            'index' => 'api.v1.mutasi-barang.index',
            'store' => 'api.v1.mutasi-barang.store',
            'show' => 'api.v1.mutasi-barang.show',
            'update' => 'api.v1.mutasi-barang.update',
            'destroy' => 'api.v1.mutasi-barang.destroy'
        ]);
});