<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\TwoFactorAuthenticateController;
use App\Http\Middleware\TwoFactorAuthenticateMiddleware;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
                ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
                ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

});

// 認証済みのユーザーのみアクセス可能
Route::middleware('auth')->group(function () {

    Route::get('two-factor', [TwoFactorAuthenticateController::class, 'create'])
                ->name('two-factor.create');

    Route::post('two-factor', [TwoFactorAuthenticateController::class, 'store'])
                ->name('two-factor.store');

    // 2段階認証済みのユーザーのみアクセス可能
    Route::middleware([TwoFactorAuthenticateMiddleware::class])->group(function () {
        Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                    ->name('logout');
    });
});

