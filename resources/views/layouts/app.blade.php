<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduForum</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@700&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg justify-content-between">
            
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="fa-solid fa-chalkboard"></i>
                <span>EduForum</span>
            </a>
            <div class="d-flex">
                <!-- Authentication Links -->
                @guest
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-bars fa-2x"></i>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('guest_login') }}">ゲストでログイン</a>
                        <a class="dropdown-item" href="{{ route('login') }}">ログイン</a>
                        @if (Route::has('register'))
                            <a class="dropdown-item" href="{{ route('register') }}">新規登録</a>
                        @endif
                    </div>
                </div>
                @else
                    <div class="nav-item dropdown mx-3">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            @php
                            $user = Auth::user();
                            @endphp
                            @if($user && $user->profile_image)
                                <img src="{{ Storage::disk('s3')->url($user->profile_image) }}" alt="プロフィール画像" class="profile-image">
                            @else
                                <i class="fas fa-user-circle fa-2x"></i> <!-- FontAwesomeアイコンを使用 -->
                            @endif
                            {{ $user->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">プロフィール編集</a>
                            <a class="dropdown-item" href="{{ route('post') }}">新規投稿</a>
                            <a class="dropdown-item" href="{{ route('my_post', ['id' =>  Auth::id()]) }}">投稿一覧</a>
                            <a class="dropdown-item" href="{{ route('saved_post', ['id' =>  Auth::id()]) }}">保存した投稿</a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                ログアウト
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>
                @endguest
            </div>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="text-center py-2">
        <p class="mb-0">&copy; 2023 EduForum</p>
    </footer>

    
</body>
</html>

<style>
/* ドロップダウンのアイコンを非表示にする */
.nav-item.dropdown .nav-link::after {
    display: none;
}
</style>