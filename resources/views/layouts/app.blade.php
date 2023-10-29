<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>loilotalk</title>
    @vite([ 'resources/js/app.js'])
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light justify-content-between">
            <a class="navbar-brand" href="{{ route('home') }}">loilotalk</a>
            <div class="d-flex">
                <div>
                    @if (Auth::check())
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-link">ログアウト</button>
                        <a class="btn btn-link" href="{{ route('post') }}">新規投稿</a>
                    </form>
                    @else
                    <a class="btn btn-link" href="{{ route('register') }}">新規登録</a>
                    <a class="btn btn-link" href="{{ route('login') }}">ログイン</a>
                    <a class="btn btn-link" href="{{ route('post') }}">新規投稿</a>
                    @endif
                </div>
            </div>
        </nav>
    </header>
    
    </body>
    </html>

    <main>
        @yield('content')
    </main>

    <footer class="text-center py-2">
        <p class="mb-0">&copy; 2023 loilotalk</p>
    </footer>
</body>
</html>