<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ReservasiController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\MejaController;
use App\Http\Controllers\DetailPesananController;

// Halaman Dashboard Utama
Route::get('/', [DashboardController::class, 'index']);

// Modul Reservasi
Route::get('/reservasi', [ReservasiController::class, 'index']);
Route::get('/reservasi/create', [ReservasiController::class, 'create']);
Route::post('/reservasi/store', [ReservasiController::class, 'store']);
Route::get('/reservasi/{id}/edit', [ReservasiController::class, 'edit']);
Route::put('/reservasi/{id}', [ReservasiController::class, 'update']);
Route::delete('/reservasi/{id}', [ReservasiController::class, 'destroy']);

// Modul Detail Pesanan
Route::get('/reservasi/{id}/detail', [DetailPesananController::class, 'show']);
Route::post('/reservasi/{id}/detail/store', [DetailPesananController::class, 'store']);
Route::delete('/reservasi/{id_reservasi}/detail/{id_menu}', [DetailPesananController::class, 'destroy']);

// Modul Menu
Route::get('/menu', [MenuController::class, 'index']);
Route::get('/menu/create', [MenuController::class, 'create']);
Route::post('/menu/store', [MenuController::class, 'store']);
Route::get('/menu/{id}/edit', [MenuController::class, 'edit']);
Route::put('/menu/{id}', [MenuController::class, 'update']);
Route::delete('/menu/{id}', [MenuController::class, 'destroy']);

// Modul Pelanggan
Route::get('/pelanggan', [PelangganController::class, 'index']);
Route::get('/pelanggan/create', [PelangganController::class, 'create']);
Route::post('/pelanggan/store', [PelangganController::class, 'store']);
Route::get('/pelanggan/{id}/edit', [PelangganController::class, 'edit']);
Route::put('/pelanggan/{id}', [PelangganController::class, 'update']);
Route::delete('/pelanggan/{id}', [PelangganController::class, 'destroy']);

// Modul Meja
Route::get('/meja', [MejaController::class, 'index']);
Route::get('/meja/create', [MejaController::class, 'create']);
Route::post('/meja/store', [MejaController::class, 'store']);
Route::get('/meja/{id}/edit', [MejaController::class, 'edit']);
Route::put('/meja/{id}', [MejaController::class, 'update']);
Route::delete('/meja/{id}', [MejaController::class, 'destroy']);