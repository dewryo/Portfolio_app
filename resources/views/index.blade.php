@extends('layouts.app')

@section('content')
    <h2>板書一覧</h2>
    <a class="btn btn-link" href="{{ route('post') }}">板書投稿</a>
    @foreach ($images as $image)
    <p>User ID: {{ $image->user_id }}</p>
    <img src="{{ asset($image -> file_path) }}" alt="{{ $image->file_name }}">
@endforeach
@endsection
