@extends('layouts.app')

@section('content')

<div class="container">
    <div style="height: 20px;"></div>
    <div class="row justify-content-center">
        
        <div class="col-md-12">
            <h2>自分の投稿</h2>
            <div class="bg-light">
                <p>{{ Auth::user()->bio }}</p>
            </div>
            <hr>
            <div class="posts-grid" >
                @foreach($posts as $post) <!-- ここでループを開始 -->
                    <div class="post-item">
                        <a href="{{ route('post.show',['post' => $post->id ]) }}" class="no-style-link">
                            <div class="card-body">
                                <h5 class="card-title">{{ Str::limit($post->title, 10, '...') }}</h5>
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
                                <img src="{{ asset($post->images->first()->file_path) }}" alt="{{ $post->images->first()->file_name }}" class="img-fluid" style="max-height: 100%; max-width: 100%;">
                            </div>
                        @else
                            <p>No image available</p>
                        @endif
                        <p class="card-text">{{ Str::limit($post->content, 10, '...') }}</p>
                    </div>
                </a>
                    <a href="{{ route('posts.edit', ['post' => $post->id]) }}" class="btn btn-primary">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('posts.destroy', ['post' => $post->id]) }}" method="POST" class="d-inline" onsubmit="return confirmDelete()">
                        @csrf {{-- CSRF トークンを含める --}}
                        @method('DELETE') {{-- DELETE メソッドを指定する --}}
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </form>
                    
                    <hr>
                </div>
            @endforeach
        </div>

            <!-- ページネーションリンクの表示 -->
            <div class="pagination-wrapper">
                {{ $posts->links('pagination::bootstrap-4') }} <!-- Bootstrap 4のスタイルを指定 -->
            </div>
        </div>

    </div>

</div>



@endsection

<script>
    function confirmDelete() {
        return confirm('この投稿を削除してもよろしいですか？');
    }
</script>

<style>
.no-style-link {
    text-decoration: none;
    color: inherit;
}

.no-style-link {
    text-decoration: none;
    color: inherit;
}

.posts-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
}

@media (max-width: 1200px) {
    .posts-grid {
        grid-template-columns: repeat(3, 1fr);
    }
}

@media (max-width: 992px) {
    .posts-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .posts-grid {
        grid-template-columns: 1fr;
    }
}
</style>