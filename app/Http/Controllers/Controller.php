<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Image;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function showhome(Request $request)
    {
        $tag = $request->input('tag'); //クエリパラメータからタグを取得
        $query = Post::with(['images', 'postTags', 'tags']); //投稿一覧を取得

        if($tag){
            $query->whereHas('tags',function($query) use ($tag){
                $query->where('name',$tag);
            });
        }

        $posts = $query -> paginate(10); //tagが空の場合は全投稿取得、tagが取得されている際はタグ名に一致する投稿のみ取得
        
        if($request->ajax()){
            return response()->json([
                'posts' => $posts->items(),
                'next_page_url' => $posts->nextPageUrl(),
            ]);
        }
        
        return view('index',['posts' => $posts]);
    }
}
