<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>loilotalk</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/@popperjs/core@2"></script>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg justify-content-between">
            <a class="navbar-brand" href="{{ route('home') }}">loilotalk</a>
            <div class="d-flex">
                <!-- Authentication Links -->
                @guest
                    <a class="nav-link mx-3" href="{{ route('login') }}">ログイン</a>
                    @if (Route::has('register'))
                        <a class="nav-link mx-3" href="{{ route('register') }}">新規登録</a>
                    @endif
                @else
                    <div class="nav-item dropdown mx-3">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <img src="/storage/profile_images/{{ Auth::user()->profile_image }}" alt="プロフィール画像" class="profile-image">
                            {{ Auth::user()->name }}
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
        <p class="mb-0">&copy; 2023 loilotalk</p>
    </footer>

    
</body>
</html>

