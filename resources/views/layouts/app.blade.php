<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChalkTalk</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <header>
        <h1>ChalkTalk</h1>
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        <p>&copy; 2023 ChalkTalk</p>
    </footer>
</body>
</html>