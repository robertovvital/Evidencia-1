@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endpush

@section('title', 'Dashboard')

@section('content')
    <div class="card">
        <h1 class="mt-0">Dashboard</h1>
        <p class="text-muted">Welcome, {{ auth()->user()->name }}.</p>

        <div class="dashboard-grid">
            <a class="dashboard-card" href="{{ route('orders.index') }}">
                <div class="dashboard-card__count">{{ $ordersCount }}</div>
                <div class="dashboard-card__label">Orders</div>
            </a>
            <a class="dashboard-card dashboard-card--new" href="{{ route('orders.create') }}">
                <div class="dashboard-card__count">+</div>
                <div class="dashboard-card__label">New order</div>
            </a>
            <a class="dashboard-card" href="{{ route('orders.archived') }}">
                <div class="dashboard-card__count">{{ $archivedCount }}</div>
                <div class="dashboard-card__label">Archived orders</div>
            </a>
            @if (auth()->user()->isAdmin())
                <a class="dashboard-card" href="{{ route('users.index') }}">
                    <div class="dashboard-card__count">{{ $usersCount }}</div>
                    <div class="dashboard-card__label">Users</div>
                </a>
                <a class="dashboard-card dashboard-card--new" href="{{ route('users.create') }}">
                    <div class="dashboard-card__count">+</div>
                    <div class="dashboard-card__label">New user</div>
                </a>
            @endif
        </div>
    </div>
@endsection
