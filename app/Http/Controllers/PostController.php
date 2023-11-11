<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\User;
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

    //自分の投稿一覧表示
    public function my_post($id)
    {
    // ユーザー情報を取得
    $user = User::findOrFail($id);

    // そのユーザーの投稿情報にページネーションを適用
    // imagesとtagsを事前にイーガーロード
    $posts = $user->posts()->with(['images', 'tags'])->paginate(10);

    return view('post.my_post', compact('user', 'posts'));
    }

        // 編集ページ
    public function edit(Post $post)
    {
        return view('post.edit', compact('post'));
    }

    // 更新処理
    public function update(Request $request, Post $post)
    {
        $data = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'tags' => 'array', // タグが配列であること
            'image' => 'image', // 画像ファイルであること
        ]);
    
        // 画像の処理
        if ($request->hasFile('image')) {
            // 既存の画像を削除
            if ($post->image) {
                Storage::delete($post->image);
            }
            // 新しい画像を保存
            $data['image'] = $request->file('image')->store('images');
        }
    
        // 投稿の更新
        $post->update($data);
    
        // タグの処理
        if ($request->has('tags')) {
            $post->tags()->sync($data['tags']);
        }
    
        return redirect()->route('my_post', ['id' =>  Auth::id()])->with('success', '投稿が更新されました。');
    }

    // 削除処理
    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('my_post', ['id' =>  Auth::id()])->with('success', '投稿が削除されました。');
    }
}
