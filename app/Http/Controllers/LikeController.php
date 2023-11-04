<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LikeController extends Controller
{
    //いいねが押されたとき
    public function toggleLike(Post $post)
    {
        $user = Auth::user();
        //ユーザーが既にいいねしているかチェック
        $like = $user->likes()->where('post_id',$post->id)->first();
     
        if($like){
            //いいねが既にある場合はいいねを取り消す
            $like->delete();
            $isLiked = false;
        }else{
            //いいねがなかった場合は、いいねを追加
            $user->likes()->create(['post_id'=>$post->id]);
            $isLiked = true;
        }
        //最新のいいね数を取得
        $LikeCount = $post->likes()->count();

        return response()->json{[
            'isLiked' => $isLiked,
            'LikeCount' => $LikeCount,
        ]};
    }
}
