@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>板書投稿</title>
</head>
<body>
<div id="app">
    <form action="/posts" method="POST" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="title">タイトル:</label>
            <input type="text" id="title" name="title" required>
        </div>

        <div>
            <image-preview></image-preview>
        </div>

        <div>
            <label for="content">コンテンツ:</label>
            <textarea id="content" name="content" rows="4" cols="50" required></textarea>
        </div>

        <div>
            <input type="submit" value="投稿">
        </div>
    </form>
</div>

</body>
</html>
@endsection