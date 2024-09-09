<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TwoFactorAuthenticateController;

Route::get('/two-factor-create', [TwoFactorAuthenticateController::class, 'sendMail'])->name('two-factor-create');