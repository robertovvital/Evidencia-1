<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Halcon - @yield('title', 'Dashboard')</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; }
        nav { background: #222; color: #fff; padding: 10px 20px; }
        nav a { color: #fff; margin-right: 15px; text-decoration: none; }
        main { padding: 20px; max-width: 1000px; margin: 0 auto; }
        table { border-collapse: collapse; width: 100%; margin-top: 10px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        .status { display: inline-block; padding: 2px 8px; border-radius: 4px; background: #eee; }
        .alert { padding: 10px; background: #e6ffe6; border: 1px solid #4caf50; margin-bottom: 10px; }
        .errors { padding: 10px; background: #ffe6e6; border: 1px solid #f44336; margin-bottom: 10px; }
        form.inline { display: inline; }
        label { display: block; margin-top: 10px; }
        input, select, textarea { width: 100%; padding: 6px; box-sizing: border-box; }
        button { margin-top: 12px; padding: 8px 16px; }
    </style>
</head>
<body>
    <nav>
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <a href="{{ route('orders.index') }}">Orders</a>
        <a href="{{ route('orders.archived') }}">Archived orders</a>
        @if (auth()->user()->isAdmin())
            <a href="{{ route('users.index') }}">Users</a>
        @endif
        <span style="float:right">
            {{ auth()->user()->name }} ({{ auth()->user()->department->name ?? 'No department' }})
            <form class="inline" method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">Log out</button>
            </form>
        </span>
    </nav>
    <main>
        @if (session('status'))
            <div class="alert">{{ session('status') }}</div>
        @endif

        @if ($errors->any())
            <div class="errors">
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
