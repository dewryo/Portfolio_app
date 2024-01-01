<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduForum</title>
   
    <link rel="preload" as="style" href="{{ asset('build/assets/app-e0a2cbf2.css') }}" />
    <link rel="preload" as="style" href="{{ asset('build/assets/app-b364c60a.css') }}" />
    <link rel="modulepreload" href="{{ asset('build/assets/app-f49c8aa8.js') }}" />
    <link rel="stylesheet" href="{{ asset('build/assets/app-e0a2cbf2.css') }}" />
    <link rel="stylesheet" href="{{ asset('build/assets/app-b364c60a.css') }}" />
    <script type="module" src="{{ asset('build/assets/app-f49c8aa8.js') }}"></script>

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
                    <a class="nav-link mx-3" href="{{ route('guest_login') }}">ゲストでログイン</a>
                    <a class="nav-link mx-3" href="{{ route('login') }}">ログイン</a>
                    @if (Route::has('register'))
                        <a class="nav-link mx-3" href="{{ route('register') }}">新規登録</a>
                    @endif
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

