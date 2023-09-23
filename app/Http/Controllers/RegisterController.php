<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    //新規登録画面表示
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    //新規登録機能
    public function register(Request $request)
    {
        // バリデーション
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);

        // ユーザーの作成
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->input('remember');

        // ログインしてホームページにリダイレクト
        auth()->attempt($credentials,$remember);

        return redirect()->route('home');
    }
}