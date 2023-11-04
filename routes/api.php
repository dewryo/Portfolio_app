<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LikeController;

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

// トップページの投稿一覧を取得するルート
Route::middleware('web')->group(function () {
Route::get('/posts', [PostController::class, 'showHome']); 
});

// いいねが押されたときに実行するルート（認証済みユーザーのみ）
Route::middleware('web')->group(function () {
    Route::post('/posts/{post}/likes', [LikeController::class, 'toggleLike']);
});