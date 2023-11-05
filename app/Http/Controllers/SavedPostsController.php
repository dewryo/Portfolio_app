<?php

// app/Http/Controllers/SavedPostsController.php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SavedPostsController extends Controller
{
    // 投稿を保存するメソッド
    public function store(Request $request, $id)
    {
        $user = Auth::user();
        $post = Post::findOrFail($id);

        if (!$user) {
            // ユーザーがログインしていない場合はエラーレスポンスを返す
             return response()->json(['error' => 'Authentication required'], 401);
        }

        // 既に保存されているか確認
        if ($user->savedPosts()->where('post_id', $post->id)->exists()) {
            return response()->json(['message' => '既に保存されています。'], 409);
        }

        // 投稿を保存
        $user->savedPosts()->attach($post->id);

        return response()->json(['message' => '投稿を保存しました。'], 200);
    }

    // 保存した投稿を解除するメソッド
    public function destroy(Request $request, $id)
    {
        $user = Auth::user();
        $post = Post::findOrFail($id);

        if (!$user->savedPosts()->where('post_id', $post->id)->exists()) {
            return response()->json(['message' => 'まだ保存されていません。'], 409);
        }

        // 保存を解除
        $user->savedPosts()->detach($post->id);

        return response()->json(['message' => '保存を解除しました。'], 200);
    }
}
