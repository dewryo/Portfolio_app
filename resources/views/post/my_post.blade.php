@extends('layouts.app')

@section('content')

<div class="container">
    <div style="height: 20px;"></div>
    <div class="row justify-content-center">
    <div class="col-md-6">
        @foreach($user->posts as $post) <!-- ここでループを開始 -->
            <div class="card-body">
                <div class="post-item">
                    <h5 class="card-title">{{ $post->title }}</h5>
                    @if($post->tags->isNotEmpty())
                        @foreach($post->tags as $tag)
                            <span class="badge badge-primary" style="background-color: rgb(92, 122, 255); color: white; margin-right: 8px;">
                                {{ $tag->name }}
                            </span>
                        @endforeach
                    @else
                        <p>No tag available</p>
                    @endif
                    <div style="height: 10px;"></div>
                    @if($post->images->isNotEmpty())
                        <img src="{{ asset($post->images->first()->file_path) }}" alt="{{ $post->images->first()->file_name }}" class="img-fluid" style="max-height: 500px; width: auto;">
                    @else
                        <p>No image available</p>
                    @endif
                    <p class="card-text">{{ $post->content }}</p>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('storage/profile_images/' . ($user->profile_image ?? 'default.png')) }}" alt="プロフィール画像" class="profile-image mx-3">
                        <span>{{ $user->name }}</span>
                    </div>
                </div>
                <hr>
            </div>
        @endforeach <!-- ここでループ終了 -->
    </div>
    </div>
</div>

@endsection
