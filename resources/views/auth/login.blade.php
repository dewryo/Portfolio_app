@extends('layouts.app')

@section('content')
    <h1>ログイン</h1>
    <form action="POST" action="{{ route('login') }}">
    @csrf
    <div class="form-group">
        <label for="email">メールアドレス</label>
        <input type="email" name="email" id="email" required>
    </div>

    <div class="form-group">
        <label for="password">パスワード</label>
        <input type="password" name="password" id="password" required>
    </div>

    <div class="form-group">
        <input type="checkbox" name="remember" id="remember">
        <label for="remember">ログイン状態を保存する</label>
    </div>

    <button type="submit">ログイン</button>

    </form>
@endsection