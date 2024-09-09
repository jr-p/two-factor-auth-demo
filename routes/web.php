<?php

use App\Http\Middleware\TwoFactorAuthenticateMiddleware;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified', TwoFactorAuthenticateMiddleware::class])->name('dashboard');

require __DIR__.'/auth.php';
