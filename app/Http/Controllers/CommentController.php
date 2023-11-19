<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * 特定の投稿のコメントを取得
     */
    public function index(Post $post)
    {
        $comments = $post->comments()->with('user')->get();
        return response()->json($comments);
    }

    /**
     * 新しいコメントを保存
     */
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'body' => 'required|string',
        ]);

        $comment = $post->comments()->create([
            'user_id' => Auth::id(),
            'post_id' => $post->id,
            'body' => $request->body,
            // 'parent_id' を含める場合はここに追加
        ]);

        return response()->json($comment, 201);
    }

    /**
     * コメントを更新
     */
    public function update(Request $request, Comment $comment)
    {
        $this->authorize('update', $comment);

        $request->validate([
            'body' => 'required|string',
        ]);

        $comment->update($request->all());
        return response()->json($comment);
    }

    /**
     * コメントを削除
     */
    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);

        $comment->delete();
        return response()->json(null, 204);
    }

    /**
     * 返信コメントを保存
     */
    public function reply(Request $request, Comment $parent)
    {
        $request->validate([
            'body' => 'required|string',
        ]);

        $reply = $parent->replies()->create([
            'user_id' => Auth::id(),
            'post_id' => $parent->post_id, // 親コメントと同じ投稿ID
            'body' => $request->body,
            'parent_id' => $parent->id,
        ]);

        return response()->json($reply, 201);
    }
}
