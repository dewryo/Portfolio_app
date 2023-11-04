<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\Image;
use App\Models\Tag;
use App\Models\PostTag;
use Illuminate\Http\Request;

class PostController extends Controller
{
    //トップページの投稿一覧表示
    public function showhome(Request $request)
    {
        $keyword = $request->input('keyword');
        $tags = $request->input('tag'); //クエリパラメータからタグを取得
        $query = Post::with(['images', 'postTags', 'tags','likes']); //投稿一覧を取得

        if(!empty($keyword)){
            $query->where('title', 'LIKE', "%{$keyword}%")
            ->orWhere('content', 'LIKE', "%{$keyword}%");
        }

        if($tags && is_array($tags)){
            foreach ($tags as $tag) {
                $query->whereHas('tags', function($query) use ($tag) {
                    $query->where('name', $tag); // すべての選択されたタグを持つ投稿を検索
                });
            }
        }

        $posts = $query -> paginate(10)->appends(['tag' => $tags]);
        
        if($request->ajax()){
            return response()->json([
                'posts' => $posts->items(),
                'next_page_url' => $posts->nextPageUrl(),
            ]);
        }

        return view('index');
    }
    //新規投稿表示
    public function showPostForm()
    {
        return view('post.post_form');
    }

    public function store(Request $request)
    {

        // バリデーション
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'image' => 'required|array|min:1', // 配列として受け入れ、最低1つの要素を必要とします
            'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048', // 各画像のバリデーション
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
        if($request->hasFile('image')){
            foreach($request->file('image') as $uploadedFile){
                  // 画像に命名
                $imageName = time() . '_' . $uploadedFile->getClientOriginalName();
                  // 画像をストレージに保存
                $uploadedFile->move(public_path('images'), $imageName);
                // Imageモデルを作成し、Postとのリレーションを設定
                $image = new Image;
                $image->user_id = Auth::id();
                $image->file_name = $imageName;
                $image->file_path = 'images/' . $imageName;
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
}