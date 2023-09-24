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
        <nav class="navbar navbar-expand-lg navbar-light bg-light justify-content-between">
            <a class="navbar-brand" href="{{ route('home') }}">ChalkTalk</a>
            <div class="d-flex">
                <form class="form-inline d-flex mr-2">
                    <input class="form-control mr-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </form>
                <div>
                    @if (Auth::check())
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-link">ログアウト</button>
                    </form>
                    @else
                    <a class="btn btn-link" href="{{ route('register') }}">新規登録</a>
                    <a class="btn btn-link" href="{{ route('login') }}">ログイン</a>
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

    <footer class="bg-light text-center py-4">
        <p class="mb-0">&copy; 2023 ChalkTalk</p>
    </footer>
</body>
</html>