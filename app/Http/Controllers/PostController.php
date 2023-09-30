<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    //新規投稿表示
    public function showPostForm()
    {
        return view('post.post_form');
    }
}
