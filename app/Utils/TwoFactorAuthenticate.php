<?php

namespace App\Utils;

use Illuminate\Support\Facades\Mail;
use App\Mail\TwoFactorAuthenticateMail;
use App\Models\User;
use Carbon\Carbon;

class TwoFactorAuthenticate {
    /**
     * 2段階認証コードを生成してメール送信
     */
    public static function sendMail(User $user): void
    {
        // 2段階認証コードを生成
        $twoFactorAuthCode = random_int(100000, 999999);

        // 2段階認証コードをDBに保存
        $user->two_factor_auth_code = $twoFactorAuthCode;
        $user->two_factor_auth_code_expires_at = Carbon::now()->addMinutes(10);
        $user->save();

        // メール送信
        Mail::to($user->email)->send(new TwoFactorAuthenticateMail($twoFactorAuthCode));
    }
}