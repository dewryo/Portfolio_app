@extends('layouts.app')

@section('content')
<div id="app">
    <div class="container">
        <div style="height: 20px;"></div>
        <h1>{{ $post->title }}</h1>
        <hr>
        <image-gallery :images="{{ json_encode($post->images) }}"></image-gallery>
        <hr>

        <p class="lead">{{ $post->content }}</p>
    </div>
</div>
@endsection