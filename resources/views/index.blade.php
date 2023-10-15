@extends('layouts.app')

@section('content')
    <h2>板書一覧</h2>

    @foreach ($images as $image)
        <p>title:{{ $image->post->title }}</p>
        <img src="{{ asset($image->file_path) }}" alt="{{ $image->file_name }}">
        <p>content:{{ $image->post->content }}</p>
    @endforeach
@endsection