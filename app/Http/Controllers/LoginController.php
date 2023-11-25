<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    // ゲストログイン処理
    public function guestLogin()
    {
        $guestUser = User::where('email', 'guest@example.com')->first();

        if ($guestUser) {
            Auth::login($guestUser);
            return redirect('/posts'); // リダイレクト先を適宜設定
        }

        return redirect('/login')->with('error', 'ゲストアカウントが存在しません。');
    }
}
