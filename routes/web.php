<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\Controller;



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
//トップ画面表示

Route::get('/',[Controller::class, 'showhome'])->name('home');

// ログインページ
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
// ログイン処理
Route::post('/login', [AuthController::class, 'login']);
// ログアウト処理
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// 新規登録フォームの表示
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
// 新規登録処理
Route::post('/register', [RegisterController::class,'register']);