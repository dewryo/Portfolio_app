@extends('layouts.app')

@section('content')

<div class="container">
    <div style="height: 20px;"></div>
    <div class="row justify-content-center">
        
        <div class="col-md-6">
            <h2>自分の投稿</h2>
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
                                <img src="{{ asset($post->images->first()->file_path) }}" alt="{{ $post->images->first()->file_name }}" class="img-fluid" style="max-height: 500px; width: auto;">
                            @else
                                <p>No image available</p>
                            @endif
                            <p class="card-text">{{ Str::limit($post->content, 100, '...') }}</p>
                        </div>

                    </div>
                    </a>
                    <a href="{{ route('posts.edit', ['post' => $post->id]) }}" class="btn btn-primary">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('posts.destroy', ['post' => $post->id]) }}" method="POST" class="d-inline">
                        @csrf {{-- CSRF トークンを含める --}}
                        @method('DELETE') {{-- DELETE メソッドを指定する --}}
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </form>
                    
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