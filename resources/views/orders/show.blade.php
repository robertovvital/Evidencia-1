@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/orders.css') }}">
@endpush

@section('title', 'Order ' . $order->invoice_number)

@section('content')
    <div class="card">
        <h1 class="mt-0">Order {{ $order->invoice_number }}</h1>
        <p><a href="{{ route('orders.index') }}">&laquo; Back to orders</a></p>

        <table class="plain">
            <tr><th>Customer</th><td>{{ $order->customer_name }} ({{ $order->customer_number }})</td></tr>
            <tr><th>Fiscal data</th><td>{{ $order->fiscal_data }}</td></tr>
            <tr><th>Order date</th><td>{{ $order->order_datetime->format('Y-m-d H:i') }}</td></tr>
            <tr><th>Delivery address</th><td>{{ $order->delivery_address }}</td></tr>
            <tr><th>Notes</th><td>{{ $order->notes ?: '-' }}</td></tr>
            <tr><th>Status</th><td><span class="status status--{{ $order->status }}">{{ $order->statusLabel() }}</span> (since {{ $order->status_changed_at?->format('Y-m-d H:i') }})</td></tr>
            <tr><th>Created by</th><td>{{ $order->creator->name ?? '-' }}</td></tr>
        </table>

        <h2>Evidence photos</h2>
        <div class="evidence-grid">
            <div class="evidence-box">
                <div class="evidence-box__title">In route</div>
                @if ($order->routeEvidence())
                    <img class="evidence" src="{{ asset('storage/' . $order->routeEvidence()->photo_path) }}" alt="Route evidence">
                @else
                    <div class="evidence-box__empty">Not uploaded yet.</div>
                @endif
            </div>
            <div class="evidence-box">
                <div class="evidence-box__title">Delivered</div>
                @if ($order->deliveredEvidence())
                    <img class="evidence" src="{{ asset('storage/' . $order->deliveredEvidence()->photo_path) }}" alt="Delivered evidence">
                @else
                    <div class="evidence-box__empty">Not uploaded yet.</div>
                @endif
            </div>
        </div>

        <h2>Change status</h2>
        <form class="stacked-form" method="POST" action="{{ route('orders.status', $order) }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="field">
                <label for="status">New status</label>
                <select name="status" id="status" required onchange="const photoField = document.getElementById('photo-field'); photoField.classList.toggle('is-visible', ['in_route', 'delivered'].includes(this.value));">
                    @foreach ($statuses ?? \App\Models\Order::STATUSES as $value => $label)
                        <option value="{{ $value }}" @selected($order->status === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            @if (auth()->user()->isRoute() || auth()->user()->isAdmin())
                <div id="photo-field" class="{{ in_array($order->status, ['in_route', 'delivered']) ? 'is-visible' : '' }}">
                    <label for="photo">Evidence photo (only Route department)</label>
                    <input type="file" name="photo" id="photo" accept="image/*" capture="environment">
                </div>
            @endif

            <button class="btn" type="submit">Update status</button>
        </form>
    </div>
@endsection
