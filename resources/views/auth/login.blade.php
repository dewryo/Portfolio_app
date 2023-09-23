@extends('layouts.app')

@section('content')
    <h1>ログイン</h1>
    <form method="POST" action="{{ route('login') }}">
    @csrf
    <div class="form-group">
        @error('email')
        <div class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </div>
        @enderror
        <label for="email">メールアドレス</label>
        <input type="email" name="email" id="email">
    </div>

    <div class="form-group">
        <label for="password">パスワード</label>
        <input type="password" name="password" id="password">
    </div>

    <div class="form-group">
        <input type="checkbox" name="remember" id="remember">
        <label for="remember">ログイン状態を保存する</label>
    </div>

    <button type="submit">ログイン</button>

    </form>
@endsection