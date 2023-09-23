<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChalkTalk</title>
    @vite([ 'resources/js/app.js'])
</head>
<body>
    <header>
        <h1>ChalkTalk</h1>
        <div class="header-buttons">
        @if (Auth::check())
        <a href="{{ route('logout') }}" class="custom-link"><p>ログアウト</p></a>
        @else
        <a href="{{ route('register') }}" class="custom-link"><p>新規登録</p></a>
        <a href="{{ route('login') }}" class="custom-link"><p>ログイン</p></a>
        @endif
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        <p>&copy; 2023 ChalkTalk</p>
    </footer>
</body>
</html>