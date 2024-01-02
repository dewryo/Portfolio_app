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
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    //トップページの投稿一覧表示
    public function showhome(Request $request)
    {
        $keyword = $request->input('keyword');
        $tags = $request->input('tag'); //クエリパラメータからタグを取得
        $query = Post::with(['images', 'postTag', 'tags' ,'likes' ,'user']); //投稿一覧を取得

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

        // 並べ替えによるフィルタリングがある場合
        if ($request->input('orderBy') === 'like') {
            // いいね順に並べ替え
            $query->withCount('likes')->orderBy('likes_count', 'desc');
        } elseif ($request->input('orderBy') === 'new' || !$request->has('orderBy')) {
            // 新着順に並べ替え、または並べ替えの指定がない場合
            $query->orderBy('created_at', 'desc');
        }
        if ($request->input('orderBy') === 'old') {
            // いいね順に並べ替え
            $query->orderBy('created_at', 'asc');
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


    //新規投稿保存
    public function store(Request $request)
    {

        // バリデーション
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'image' => 'required|array|min:1', // 配列として受け入れ、最低1つの要素を必要とします
            'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:20480',
            'grades' => 'required|array|min:1', // 配列として受け入れ、最低1つの要素を必要とします
            'subjects' => 'required|array|min:1', // 配列として受け入れ、最低1つの要素を必要とします
        ]);
        // postテーブルに格納
        $post = new Post;
        $post->user_id = Auth::id(); 
        $post->title = $request->title;
        $post->content = $request->content;
        $post->save();


        // imageテーブルに格納
        if ($request->hasFile('image')) {
        foreach ($request->file('image') as $uploadedFile) {
        // 画像に命名
        $imageName = time() . '_' . $uploadedFile->getClientOriginalName();
        // 画像をS3バケットにアップロード
        $imagePath = $uploadedFile->storeAs('images', $imageName, 's3');
        // Imageモデルを作成し、Postとのリレーションを設定
        $image = new Image;
        $image->user_id = Auth::id();
        $image->file_name = $imageName;
        $image->file_path = $imagePath;
        $image->post()->associate($post);
        $image->save();
    }
}

        //post_tagテーブルにtype=gradeで格納
        foreach($request->grades as $grade){
            $tag = Tag::where('name', $grade)->first();
            if($tag){
                $tag_id = $tag->id;
                $post_tag = new PostTag;
                $post_tag->post_id = $post->id;
                $post_tag->tag_id = $tag_id;
                $post_tag->type = 'grade';
                $post_tag->save();
            }
        }

        //post_tagテーブルにtype=subjectで格納
        foreach($request->subjects as $subject){
            $tag = Tag::where('name', $subject)->first();
            if($tag){
                $tag_id = $tag->id;
                $post_tag = new PostTag;
                $post_tag->post_id = $post->id;
                $post_tag->tag_id = $tag_id;
                $post_tag->type = 'subject';
                $post_tag->save();
            }
        }

        return redirect()->route('home'); // 保存後に遷移するルート名を指定
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
    $posts = $user->posts()->orderBy('created_at', 'desc')->with(['images', 'tags'])->paginate(12);

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
            'subjects' => 'required|array|min:1', 
            'grades' => 'required|array|min:1',// タグが配列であること
            'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:20480',
        ]);
    
        // 画像の処理
        if ($request->hasFile('image')) {
            // 既存のすべての画像を削除
            foreach ($post->images as $image) {
                // S3から画像を削除
                if (Storage::disk('s3')->exists($image->file_path)) {
                    Storage::disk('s3')->delete($image->file_path);
                }

                // ローカルデータベースのレコードを削除
                $image->delete();
            }

            // 新規画像の保存
            foreach ($request->file('image') as $uploadedFile) {
                // 画像に命名
                $imageName = time() . '_' . $uploadedFile->getClientOriginalName();
                // 画像をS3にアップロード
                $filePath = $uploadedFile->storeAs('images', $imageName, 's3');

                // Imageモデルを作成し、Postとのリレーションを設定
                $image = new Image;
                $image->user_id = Auth::id();
                $image->file_name = $imageName;
                $image->file_path = $filePath; // S3のパスを保存
                $image->post()->associate($post);
                $image->save();
            }
        }
    

        // タグの処理

        // 既存のタグを削除
        PostTag::where('post_id', $post->id)->delete();

        // post_tagテーブルにtype=gradeで格納
        foreach ($request->grades as $grade) {
            $tag = Tag::where('name', $grade)->first();
            if ($tag) {
                $postTag = new PostTag;
                $postTag->post_id = $post->id;
                $postTag->tag_id = $tag->id;
                $postTag->type = 'grade';
                $postTag->save();
            }
        }

        // post_tagテーブルにtype=subjectで格納
        foreach ($request->subjects as $subject) {
            $tag = Tag::where('name', $subject)->first();
            if ($tag) {
                $postTag = new PostTag;
                $postTag->post_id = $post->id;
                $postTag->tag_id = $tag->id;
                $postTag->type = 'subject';
                $postTag->save();
            }
        }
        
                // 投稿の更新
                $post->update($data);
    
    
        return redirect()->route('my_post', ['id' =>  Auth::id()])->with('success', '投稿が更新されました。');
    }

    // 削除処理
    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('my_post', ['id' =>  Auth::id()])->with('success', '投稿が削除されました。');
    }



    //保存した投稿一覧表示
    public function saved_post($id)
    {
    // ユーザー情報を取得
    $user = User::findOrFail($id);

    // そのユーザーの保存した投稿情報にページネーションを適用
    // imagesとtagsを事前にイーガーロード
    $posts = $user->savedPosts()->orderBy('created_at', 'desc')->with(['images', 'tags'])->paginate(10);

    return view('post.saved_post', compact('user', 'posts'));
    }


    //他人の投稿一覧表示
    public function user_post($id)
    {
    // ユーザー情報を取得
    $user = User::findOrFail($id);

    // そのユーザーの投稿情報にページネーションを適用
    // imagesとtagsを事前にイーガーロード
    $posts = $user->posts()->orderBy('created_at', 'desc')->with(['images', 'tags'])->paginate(10);

    return view('post.user_post', compact('user', 'posts'));
    }

}

