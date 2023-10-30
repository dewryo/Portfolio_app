<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function showhome(Request $request)
    {
        $keyword = $request->input('keyword');
        $tags = $request->input('tag'); //クエリパラメータからタグを取得
        $query = Post::with(['images', 'postTags', 'tags']); //投稿一覧を取得

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
}
