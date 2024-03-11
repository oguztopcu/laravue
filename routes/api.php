<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Keys\KeyController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('/login', [LoginController::class, 'login'])->name('api.auth.login');

    Route::post('/register', [LoginController::class, 'register'])->name('api.auth.register');

    Route::post('/check', [LoginController::class, 'getUser'])->name('api.auth.getUser');
    Route::post('/logout', [LoginController::class, 'logout'])->name('api.auth.logout');
});

Route::middleware(['verifyToken'])->group(function () {
    Route::prefix('api-keys')->group(function () {
        Route::get('/', [ApiController::class, 'index'])->name('api.api-keys.index');
        Route::post('/', [ApiController::class, 'store'])->name('api.api-keys.store');
        Route::delete('/{apiKeyId}', [ApiController::class, 'destroy'])->name('api.api-keys.destroy');
    });

    Route::prefix('keys')->group(function () {
        Route::get('/', [KeyController::class, 'index'])->name('api.keys.index');
        Route::get('/search', [KeyController::class, 'search'])->name('api.keys.search');
        Route::get('/{keyId}', [KeyController::class, 'show'])->name('api.keys.show');

        Route::post('/', [KeyController::class, 'store'])->name('api.keys.store');
        Route::delete('/{keyId}', [KeyController::class, 'destroy'])->name('api.keys.destroy');
    });
});
