@extends('layouts.app')

@section('content')

<div class="container">
    <div style="height: 20px;"></div>
    <div class="row justify-content-center">
        <div class="col-md-6">
            @foreach($posts as $post) <!-- ここでループを開始 -->
            <a href="{{ route('post.show',['post' => $post->id ]) }}" class="no-style-link">
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
                        <a href="{{ route('posts.edit', ['post' => $post->id]) }}">編集</a>
                    </div>
                    </a>
                <hr>
            @endforeach
            <!-- ページネーションリンクの表示 -->
            <div class="pagination-wrapper">
                {{ $posts->links('pagination::bootstrap-4') }} <!-- Bootstrap 4のスタイルを指定 -->
            </div>
        </div>

    </div>

</div>



@endsection

<style>
.no-style-link {
    text-decoration: none;
    color: inherit;
}
</style>