@extends('layouts.app')

@section('content')

<div class="container">
<div class="row justify-content-center">
<div class="col-md-6">
    <h1 class="text-center mb-4">新規登録</h1>

    <form action="{{ route('register') }}" method="post">
        @csrf

        <div class="form-group">
            @error('name')
            <div class="invalid-feedback d-block" role="alert">
                <strong>{{ $message }}</strong>
            </div>
            @enderror
            <label for="name">名前</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
        </div>

        <div class="form-group">
            @error('email')
            <div class="invalid-feedback d-block" role="alert">
                <strong>{{ $message }}</strong>
            </div>
            @enderror
            <label for="email">メールアドレス</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
        </div>

        <div class="form-group">
            @error('password')
            <div class="invalid-feedback d-block" role="alert">
                <strong>{{ $message }}</strong>
            </div>
            @enderror
            <label for="password">パスワード</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>

        <div class="form-group">
            @error('password_confirmation')
            <div class="invalid-feedback d-block" role="alert">
                <strong>{{ $message }}</strong>
            </div>
            @enderror
            <label for="password_confirmation">パスワード（確認）</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
        </div>

        <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="remember" name="remember">
            <label class="form-check-label" for="remember">ログイン状態を保存する</label>
        </div>

        <button type="submit" class="btn btn-primary">登録</button>
    </form>
</div>
</div>
</div>


@endsection
