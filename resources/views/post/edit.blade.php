@extends('layouts.app')

@section('content')
<div id="app" class="container mt-5">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">タイトル</label>
            <input type="text" id="title" name="title" class="form-control" value="{{ $post->title }}" required>
        </div>

        <div class="mb-3">
            <image-preview
            :initial-image="{{ json_encode($post->images->map(function ($image) {
                return ['url' => asset($image->file_path), 'name' => $image->file_name];
            })) }}"></image-preview>
        </div>

        <div class="mb-3">
            <label for="content" class="form-label">説明</label>
            <textarea id="content" name="content" rows="4" class="form-control" required>{{ $post->content }}</textarea>
        </div>

        <div class="mb-3">

            <tag-selector
            :initial-grades="{{ json_encode($post->gradeTags->pluck('name')->all()) }}"
            :initial-subjects="{{ json_encode($post->subjectTags->pluck('name')->all()) }}"
        ></tag-selector>
        </div>

        <div class="mb-3">
            <input type="submit" value="更新" class="btn btn-primary">
        </div>


    </form>


</div>
@endsection
