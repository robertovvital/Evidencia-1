@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <h1>Dashboard</h1>
    <p>Welcome, {{ auth()->user()->name }}.</p>

    <ul>
        <li><a href="{{ route('orders.index') }}">Orders ({{ $ordersCount }})</a></li>
        <li><a href="{{ route('orders.create') }}">New order</a></li>
        <li><a href="{{ route('orders.archived') }}">Archived orders ({{ $archivedCount }})</a></li>
        @if (auth()->user()->isAdmin())
            <li><a href="{{ route('users.index') }}">Users ({{ $usersCount }})</a></li>
            <li><a href="{{ route('users.create') }}">New user</a></li>
        @endif
    </ul>
@endsection
