<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class TwoFactorAuthenticateController extends Controller
{
    /**
     * ２段階認証コードの入力画面を表示
     */
    public function create()
    {
        if (!Auth::user()->two_factor_auth_code) {
            return redirect(route('dashboard', absolute: false));
        }
        return Inertia::render('Auth/TwoFactorAuthenticate');
    }

    /**
     * ２段階認証コードの検証
     */
    public function store(Request $request)
    {
        $request->validate([
            'two_factor_auth_code' => 'required|string',
        ]);

        $now = Carbon::now();

        $user = User::find(Auth::id());
        $two_factor_auth_code = $user->two_factor_auth_code;
        $tow_factor_expires_at = new Carbon($user->two_factor_auth_code_expires_at);

        // ２段階認証コードが一致し、有効期限内であれば、２段階認証を有効にする
        if ($request->two_factor_auth_code === $two_factor_auth_code && $now->lt($tow_factor_expires_at)) {
            $user->two_factor_auth_code = null;
            $user->two_factor_auth_code_expires_at = null;
            $user->save();
            return redirect(route('dashboard', absolute: false));
        } else {
            return redirect(route('two-factor-authenticate.create', absolute: false));
        }
    }
}
