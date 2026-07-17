@extends('layouts.guest')

@section('title', 'Employee login')

@section('content')
    <div class="guest-card">
        <h1>Employee login</h1>

        @if ($errors->any())
            <div class="alert alert--error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form class="guest-form" method="POST" action="{{ route('login') }}">
            @csrf
            <div class="field">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus>
            </div>

            <div class="field">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>
            </div>

            <label class="checkbox-inline">
                <input type="checkbox" name="remember">
                <span>Remember me</span>
            </label>

            <button class="btn" type="submit">Log in</button>
        </form>
    </div>
@endsection
