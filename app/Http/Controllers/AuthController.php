<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    //ログイン画面表示
    public function showLoginForm()
    {
        return view('auth.login');
    }
    
    //ログイン処理
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
    
        if (Auth::attempt($credentials)) {
            return redirect()->intended('/');
        }
    
        return back()->withErrors(['email' => '認証に失敗しました。']);
    }
    
    //ログアウト処理
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
