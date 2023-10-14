<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\Image;
use Illuminate\Http\Request;

class PostController extends Controller
{
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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // 画像をストレージに保存
        $imageName = time().'.'.$request->image->extension();  
        $request->image->move(public_path('images'), $imageName);

        // postsデータベースに保存
        $post = new Post;
        $post->user_id = Auth::id(); 
        $post->title = $request->title;
        $post->content = $request->content;
        $post->save();
        
        // imagesデータベースに保存
        $image = new Image;
        $image->user_id = Auth::id(); 
        $image->post_id = $post->id;
        $image->file_name = $imageName;
        $image->file_path = 'images/' . $imageName;
        $image->save();

        return redirect()->route('home'); // 保存後に遷移するルート名を指定
    }
}
