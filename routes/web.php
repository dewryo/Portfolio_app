<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\LoginController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//ロードバランサーのヘルスチェック用ルート
Route::get('/health-check', function () {
    return response()->json(['status' => 'ok'], 200);
});


//トップ画面表示
Route::redirect('/', '/posts');
Route::get('/posts',[PostController::class, 'showhome'])->name('home');

// ログインページ
Route::get('/login', [AuthController::class, 'showLoginForm'])->middleware('guest') ->name('login');




// 新規登録フォームの表示
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->middleware('guest') ->name('register');


//新規投稿フォームの表示
Route::get('/posts/form', [PostController::class, 'showPostForm'])->middleware('auth')->name('post');


//投稿詳細画面の表示
Route::get('/posts/{post}', [PostController::class, 'showPost'])->name('post.show');


// プロフィール編集画面
Route::get('/profile/edit', [ProfileController::class,'edit'])->name('profile.edit');



// 自分の投稿一覧ページ表示
Route::get('/my_post/{id}',[PostController::class, 'my_post'])->middleware('auth')->name('my_post');

// 他人の投稿一覧ページ表示
Route::get('/posts/users/{id}',[PostController::class, 'user_post'])->name('user_post');

// 投稿編集ページへのルート
Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');



// 保存した投稿一覧ページ表示
Route::get('/saved_post/{id}',[PostController::class, 'saved_post'])->middleware('auth')->name('saved_post');

// ゲストログイン用のルート
Route::get('/guest-login', [LoginController::class, 'guestLogin'])->name('guest_login');

Route::middleware(['forceHttps'])->group(function () {
    // ログイン処理
Route::post('/login', [AuthController::class, 'login']);
// ログアウト処理
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
// 新規登録処理
Route::post('/register', [RegisterController::class,'register']);
//新規投稿処理
Route::post('/posts', [PostController::class, 'store']);
// プロフィール更新
Route::put('/profile', [ProfileController::class,'update'])->name('profile.update');
// 投稿更新のためのルート
Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
// 投稿削除のためのルート
Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
});