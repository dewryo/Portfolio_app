@extends('layouts.app')

@section('content')
<div id="app">
    <div class="container">
        <div style="height: 20px;"></div>
        <h1>{{ $post->title }}</h1>
        <hr>
        <image-gallery :images="{{ json_encode($post->images->map(function ($image) {
            return ['url' => asset($image->file_path), 'name' => $image->file_name];
        })) }}"></image-gallery>
        <hr>
        <p class="lead">{{ $post->content }}</p>

        <comments-list :post-id="{{ $post->id }}" ></comments-list>
    </div>
</div>
@endsection