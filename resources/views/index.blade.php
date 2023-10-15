@extends('layouts.app')

@section('content')
<div class="container">
    <p></p>
    @foreach ($posts as $post)
    <div class="card mb-4 mx-auto" style="max-width: 50%;">
        <div class="card-body">
            <h5 class="card-title">{{ $post->title }}</h5>

            @if($post->post_tags->isNotEmpty())
            <div class="tags">
                @foreach($post->post_tags as $post_tag)
                <span class="badge badge-primary" style="background-color: rgb(92, 122, 255); color: white;">{{ $post_tag->tag->name }}</span>
                @endforeach
            </div>
            @else
            <p>No tag available</p>
            @endif

            @if($post->images->isNotEmpty())
            <div class="images">
                @php
                    $firstImage = $post->images->first();
                @endphp
                <img src="{{ asset($firstImage->file_path) }}" alt="{{ $firstImage->file_name }}" class="img-fluid" style="max-height: 500px; width: auto;">
            </div>
            @else
            <p>No image available</p>
            @endif

            <p class="card-text">{{ $post->content }}</p>
        </div>
    </div>
    @endforeach
</div>
@endsection