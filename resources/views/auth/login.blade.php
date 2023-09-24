@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="text-center mb-4">ログイン</h1>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label for="email">メールアドレス</label>
                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror">
                    @error('email')
                    <div class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">パスワード</label>
                    <input type="password" name="password" id="password" class="form-control">
                </div>

                <div class="form-group form-check">
                    <input type="checkbox" name="remember" id="remember" class="form-check-input">
                    <label for="remember" class="form-check-label">ログイン状態を保存する</label>
                </div>

                <button type="submit" class="btn btn-primary">ログイン</button>
            </form>
        </div>
    </div>
</div>

@endsection