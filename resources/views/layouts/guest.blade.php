<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Halcon - @yield('title', 'Track your order')</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>
    <header class="guest-header">
        <div class="guest-header__inner">
            <a class="guest-header__brand" href="{{ route('home') }}">Halcon</a>
            <a class="guest-header__link" href="{{ route('login') }}">Employee login</a>
        </div>
    </header>
    <main class="guest-main">
        @yield('content')
    </main>
</body>
</html>
