<?php

use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CatalogController;
use Illuminate\Support\Facades\Route;

// ---------- Halaman publik ----------
Route::get('/', [CatalogController::class, 'index'])->name('catalog');

// ---------- Autentikasi admin ----------
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])
    ->middleware('throttle:5,1')
    ->name('login.attempt');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ---------- Panel admin (wajib login) ----------
Route::prefix('admin')
    ->name('admin.')
    ->middleware('auth')
    ->group(function () {
        Route::redirect('/', '/admin/products')->name('dashboard');
        Route::resource('products', ProductController::class)->except(['show']);
    });