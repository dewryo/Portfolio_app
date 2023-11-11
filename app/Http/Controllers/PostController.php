<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\Image;
use App\Models\Like;
use App\Models\Tag;
use App\Models\PostTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class PostController extends Controller
{
    //トップページの投稿一覧表示
    public function showhome(Request $request)
    {
        $keyword = $request->input('keyword');
        $tags = $request->input('tag'); //クエリパラメータからタグを取得
        $query = Post::with(['images', 'postTags', 'tags' ,'likes' ,'user']); //投稿一覧を取得

        // キーワード検索がある場合
        if (!empty($keyword)) {
            $query->where(function ($query) use ($keyword) {
                $query->where('title', 'LIKE', "%{$keyword}%")
                    ->orWhere('content', 'LIKE', "%{$keyword}%")
                    // ユーザー名による検索を追加
                    ->orWhereHas('user', function ($query) use ($keyword) {
                        $query->where('name', 'LIKE', "%{$keyword}%");
                    });
            });
        }

        // タグによるフィルタリングがある場合
        if ($tags && is_array($tags)) {
            foreach ($tags as $tag) {
                $query->whereHas('tags', function($q) use ($tag) {
                    $q->where('name', $tag);
                });
            }
        }
        
        // ページネーションを適用する
        $posts = $query->paginate(10)->appends(['tag' => $tags]);

        // ログイン中のユーザーのIDを取得
        $userId = Auth::id();

        // 各投稿に対して、ログイン中のユーザーがいいねしているかどうかをチェック
        $posts->each(function ($post) use ($userId) {
            $post->is_liked_by_user = $post->likes->contains('user_id', $userId);
            $post->is_saved_by_user = $post->savedByUsers->contains($userId);
        });
                
        // AJAXリクエストの場合はJSONレスポンスを返す
        if ($request->ajax()) {
            return response()->json([
                'posts' => $posts->items(),
                'next_page_url' => $posts->nextPageUrl(),
            ]);
        }

        // 通常のリクエストの場合はビューを返す
        return view('index', ['posts' => $posts]);
    }

    //投稿詳細画面表示
    public function showPost($id)
    {
        $post = Post::findOrFail($id);
        return view('post.show', compact('post'));
    }

    //投稿フォーム画面表示
    public function showPostForm()
    {
        return view('post.post_form');
    }

}
