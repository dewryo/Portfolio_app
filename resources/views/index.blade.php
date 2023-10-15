@extends('layouts.app')

@section('content')

    @foreach ($posts as $post)
        <p>title:{{ $post->title }}</p>

        @if($post->post_tags->isNotEmpty())
            @foreach($post->post_tags as $post_tag)
                <p>{{ $post_tag->tag->name }}</p>
            @endforeach
        @else
            <p>No tag available</p>
        @endif
        
        @if($post->images->isNotEmpty())
            @foreach($post->images as $image)
                <img src="{{ asset($image->file_path) }}" alt="{{ $image->file_name }}">
            @endforeach
        @else
            <p>No image available</p>
        @endif

        <p>content:{{ $post->content }}</p>
    @endforeach
@endsection