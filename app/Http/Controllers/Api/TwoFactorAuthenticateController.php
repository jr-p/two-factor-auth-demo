<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Utils\TwoFactorAuthenticate;
use Illuminate\Http\Request;

class TwoFactorAuthenticateController extends Controller
{
    /**
     * 2段階認証コードを生成してメール送信
     */
    public function sendMail(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|integer',
        ]);

        $id = $validated['id'];
        $user = User::find($id);
        TwoFactorAuthenticate::sendSms($user);
        return response()->json(['message' => 'メールを送信しました。']);
    }
}