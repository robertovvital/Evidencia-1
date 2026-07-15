<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Halcon - @yield('title', 'Track your order')</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; background: #f5f5f5; }
        header { background: #222; color: #fff; padding: 15px 20px; display: flex; justify-content: space-between; }
        header a { color: #fff; }
        main { max-width: 600px; margin: 40px auto; background: #fff; padding: 20px; border: 1px solid #ddd; }
        label { display: block; margin-top: 10px; }
        input { width: 100%; padding: 8px; box-sizing: border-box; }
        button { margin-top: 12px; padding: 8px 16px; }
        .status { display: inline-block; padding: 4px 10px; border-radius: 4px; background: #eee; font-weight: bold; }
        img.evidence { max-width: 100%; margin-top: 10px; border: 1px solid #ccc; }
        .errors { padding: 10px; background: #ffe6e6; border: 1px solid #f44336; margin-bottom: 10px; }
    </style>
</head>
<body>
    <header>
        <strong>Halcon</strong>
        <a href="{{ route('login') }}">Employee login</a>
    </header>
    <main>
        @yield('content')
    </main>
</body>
</html>
