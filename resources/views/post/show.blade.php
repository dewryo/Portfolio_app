@extends('layouts.app')

@section('content')
<div id="app">
    <div class="container">
        <div style="height: 20px;"></div>
        <h1>{{ $post->title }}</h1>

        <div class="d-flex justify-content-between align-items-center">
            <div>
                <!-- 左側の空白コンテナ-->
            </div>
        <div class="post-item">
            <a href="/posts/users/{{ $post->user->id }}">
                @php
                $user_image = "/storage/profile_images/" . $post->user->profile_image;
                @endphp
                @if($post->user->profile_image)
                <img src="{{ Storage::disk('s3')->url($post->user->profile_image) }}" alt="プロフィール画像" class="profile-image mx-3">
                @else
                <i class="fas fa-user-circle fa-2x"></i> <!-- FontAwesomeアイコンを使用 -->
                @endif
                <span>{{ $post->user->name }}</span>
            </a>
        </div>
        </div>
        <hr>
        <image-gallery :images="{{ json_encode($post->images->map(function ($image) {
            return ['url' => Storage::disk('s3')->url($image->file_path), 'name' => $image->file_name];
        })) }}"></image-gallery>
        <hr>
        <p class="lead">{{ $post->content }}</p>

        <comments-list :post-id="{{ $post->id }}" ></comments-list>
    </div>
</div>
@endsection

<style scoped>

    
    .post-item {
      /* 通常時のスタイル */
      transition: background-color 0.3s ease;
      text-align: right; /* divタグ内のコンテンツを右寄せにする */
      
    }
    
    .post-item a {
    color: inherit; /* リンクの色を親要素の色に合わせる */
    text-decoration: none; /* 下線を消す */
}

    .post-item:hover {
      /* ホバー時のスタイル */
      background-color: #f5f5f5; /* 例: 薄い灰色に変更 */
      cursor: pointer; /* マウスカーソルを指の形に変更 */
    }
    </style>
