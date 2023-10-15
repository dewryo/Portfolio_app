@extends('layouts.app')

@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div id="app" class="container mt-5">
    <form action="/posts" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label">タイトル</label>
            <input type="text" id="title" name="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <image-preview></image-preview>
        </div>

        <div class="mb-3">
            <label for="content" class="form-label">説明</label>
            <textarea id="content" name="content" rows="4" class="form-control" required></textarea>
        </div>

        <div class="mb-3">
            <tag-selector></tag-selector>
        </div>

        <div class="mb-3">
            <input type="submit" value="投稿" class="btn btn-primary">
        </div>

    </form>
</div>
@endsection