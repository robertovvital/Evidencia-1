<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Halcon - @yield('title', 'Dashboard')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('styles')
</head>
<body>
    <nav class="navbar">
        <div class="navbar__inner">
            <a class="navbar__brand" href="{{ route('dashboard') }}">Halcon</a>
            <div class="navbar__links">
                <a href="{{ route('dashboard') }}">Dashboard</a>
                <a href="{{ route('orders.index') }}">Orders</a>
                <a href="{{ route('orders.archived') }}">Archived orders</a>
                @if (auth()->user()->isAdmin())
                    <a href="{{ route('users.index') }}">Users</a>
                @endif
            </div>
            <div class="navbar__user">
                <span>{{ auth()->user()->name }} ({{ auth()->user()->department->name ?? 'No department' }})</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn--secondary btn--sm" type="submit">Log out</button>
                </form>
            </div>
        </div>
    </nav>
    <main class="page">
        @if (session('status'))
            <div class="alert alert--success">{{ session('status') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert--error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>
