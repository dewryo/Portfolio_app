<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\SavedPostsController;
use App\Http\Controllers\CommentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


// ユーザー情報を取得するルート（認証済みユーザーのみ）
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// 新規投稿が押されたときに実行するルート（認証済みユーザーのみ）
Route::middleware('web')->group(function () {
    Route::get('/posts/new', [PostController::class, 'showPostForm']);
});

// トップページの投稿一覧を取得するルート
Route::middleware('web')->group(function () {
Route::get('/posts', [PostController::class, 'showHome']); 
});

// いいねが押されたときに実行するルート（認証済みユーザーのみ）
Route::middleware('web')->group(function () {
    Route::post('/posts/{post}/likes', [LikeController::class, 'toggleLike']);
});

// 投稿を保存するためのルート
Route::middleware('web')->group(function () {
    Route::post('/posts/{id}/save', [SavedPostsController::class, 'store']);
});
// 保存した投稿を解除するためのルート
Route::middleware('web')->group(function () {
    Route::delete('/posts/{id}/save', [SavedPostsController::class, 'destroy']);
});

// コメントに関するルート
Route::middleware('web')->group(function () {
    Route::get('/posts/{post}/comments', [CommentController::class, 'index']);
});



// 新しいコメントを投稿
Route::middleware('web')->group(function () {
    Route::post('/posts/{post}/comments', [CommentController::class, 'store']);
});


// コメントを更新
Route::middleware('web')->group(function () {
    Route::patch('/posts/comments/{comment}', [CommentController::class, 'update']);
});



// コメントを削除
Route::middleware('web')->group(function () {
    Route::delete('posts/comments/{comment}', [CommentController::class, 'destroy']);
});



// 返信コメントを投稿
Route::middleware('web')->group(function () {
    Route::post('/posts/comments/{parent}/replies', [CommentController::class, 'reply']);
});

