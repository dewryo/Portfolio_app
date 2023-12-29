@extends('layouts.app')

@section('content')
<div class="container">
    <div style="height: 20px;"></div>
    <h2>プロフィール編集</h2>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif


    @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
    @endif
    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">名前</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="form-group">
            <label for="email">Eメール</label>
            @if($user->email == 'guest@example.com')
                {{-- ゲストユーザーの場合は隠しフィールドを使用 --}}
                <input type="hidden" name="email" value="{{ $user->email }}">
                <input type="email" class="form-control" id="email" value="{{ $user->email }}" disabled>
            @else
                {{-- 通常のユーザーの場合は通常の入力フォーム --}}
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
            @endif
        </div>

        {{-- プロフィール画像アップロード用のフィールド --}}
        <div class="form-group">
            <label for="profile_image">プロフィール画像</label>
            <input type="file" class="form-control" id="profile_image" name="profile_image">
            @if ($user->profile_image)
                <img src="{{ Storage::disk('s3')->url('profile_images/'.$user->profile_image) }}" alt="Profile Image" width="100">
            @endif
        </div>

        {{-- 自己紹介文用のテキストエリア --}}
        <div class="form-group">
            <label for="bio">自己紹介文</label>
            <textarea class="form-control" id="bio" name="bio" rows="4">{{ old('bio', $user->bio) }}</textarea>
        </div>

        <div class="form-group">
            <label for="password">新しいパスワード (変更する場合のみ)</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>

        <div class="form-group">
            <label for="password-confirm">新しいパスワードの確認</label>
            <input type="password" class="form-control" id="password-confirm" name="password_confirmation">
        </div>

        <button type="submit" class="btn btn-primary">更新</button>
    </form>
</div>
@endsection
