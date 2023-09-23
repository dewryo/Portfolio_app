@extends('layouts.app')

@section('content')
<h1>新規登録</h1>
<form action="{{ route('register') }}" method="post">
    @csrf
    <div>
        <label for="name">名前</label>
        <input type="text" id="name" name="name" required>
    </div>
    <div>
        <label for="email">メールアドレス</label>
        <input type="email" id="email" name="email" required>
    </div>
    <div>
        <label for="password">パスワード</label>
        <input type="password" id="password" name="password" required>
    </div>
    <div>
        <label for="password_confirmation">パスワード（確認）</label>
        <input type="password" id="password_confirmation" name="password_confirmation" required>
    </div>
    <div class="form-group">
        <input type="checkbox" name="remember" id="remember">
        <label for="remember">ログイン状態を保存する</label>
    </div>
    <button type="submit">登録</button>
</form>
@endsection
