<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit', ['user' => Auth::user()]);
    }
    
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
            'password' => 'sometimes|nullable|string|min:8|confirmed',
            'profile_image' => 'sometimes|nullable|image|max:2048', // 画像ファイルバリデーション
            'bio' => 'nullable|string',
        ]);
    
        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->bio = $request->bio;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
    
        // 画像がアップロードされた場合の処理
        if ($request->hasFile('profile_image')) {
            // S3のディスクを指定してファイルをアップロード
            $filePath = $request->file('profile_image')->store('profile_images', 's3');
            // フルパスを保存
            $user->profile_image = $filePath;
        }
    
        $user->save();
        return back()->with('status', 'プロフィールが更新されました。');
    }
}
