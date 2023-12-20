@extends('layouts.app')

@section('content')

<div id="app" class="container">
    
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div style="height: 20px;"></div>
            <h2>保存した投稿</h2>
            <hr>
            @foreach($posts as $post) <!-- ここでループを開始 -->
            <a href="{{ route('post.show',['post' => $post->id ]) }}" class="no-style-link">
                    <div class="card-body">
                        <div class="post-item">
                            <h5 class="card-title">{{ Str::limit($post->title, 50, '...') }}</h5>
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
                            <div style="display: flex; justify-content: center; align-items: center; height: 200px;">
                                <img src="{{ Storage::disk('s3')->url($post->images->first()->file_path) }}" alt="{{ $post->images->first()->file_name }}" class="img-fluid" style="max-height: 100%; max-width: 100%;">
                            </div>
                            @else
                            <p>No image available</p>
                            @endif
                            <p class="card-text">{{ Str::limit($post->content, 100, '...') }}</p>
                        </div>
                    </div>
                    </a>
                    <div>
                    <save-postbutton :post-id="{{ $post->id }}" :is-saved="{{ json_encode($post->savedByUsers->isNotEmpty()) }}" ></save-postbutton>
                    </div>
                    
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