@extends('layouts.app')

@section('title', 'Order ' . $order->invoice_number)

@section('content')
    <h1>Order {{ $order->invoice_number }}</h1>
    <p><a href="{{ route('orders.index') }}">&laquo; Back to orders</a></p>

    <table>
        <tr><th>Customer</th><td>{{ $order->customer_name }} ({{ $order->customer_number }})</td></tr>
        <tr><th>Fiscal data</th><td>{{ $order->fiscal_data }}</td></tr>
        <tr><th>Order date</th><td>{{ $order->order_datetime->format('Y-m-d H:i') }}</td></tr>
        <tr><th>Delivery address</th><td>{{ $order->delivery_address }}</td></tr>
        <tr><th>Notes</th><td>{{ $order->notes ?: '-' }}</td></tr>
        <tr><th>Status</th><td><span class="status">{{ $order->statusLabel() }}</span> (since {{ $order->status_changed_at?->format('Y-m-d H:i') }})</td></tr>
        <tr><th>Created by</th><td>{{ $order->creator->name ?? '-' }}</td></tr>
    </table>

    <h2>Evidence photos</h2>
    <table>
        <tr>
            <th>In route</th>
            <td>
                @if ($order->routeEvidence())
                    <img class="evidence" style="max-width:200px" src="{{ asset('storage/' . $order->routeEvidence()->photo_path) }}" alt="Route evidence">
                @else
                    Not uploaded yet.
                @endif
            </td>
        </tr>
        <tr>
            <th>Delivered</th>
            <td>
                @if ($order->deliveredEvidence())
                    <img class="evidence" style="max-width:200px" src="{{ asset('storage/' . $order->deliveredEvidence()->photo_path) }}" alt="Delivered evidence">
                @else
                    Not uploaded yet.
                @endif
            </td>
        </tr>
    </table>

    <h2>Change status</h2>
    <form method="POST" action="{{ route('orders.status', $order) }}" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <label for="status">New status</label>
        <select name="status" id="status" required onchange="document.getElementById('photo-field').style.display = (this.value === 'in_route' || this.value === 'delivered') ? 'block' : 'none';">
            @foreach ($statuses ?? \App\Models\Order::STATUSES as $value => $label)
                <option value="{{ $value }}" @selected($order->status === $value)>{{ $label }}</option>
            @endforeach
        </select>

        @if (auth()->user()->isRoute() || auth()->user()->isAdmin())
            <div id="photo-field" style="display: {{ in_array($order->status, ['in_route', 'delivered']) ? 'block' : 'none' }}">
                <label for="photo">Evidence photo (only Route department)</label>
                <input type="file" name="photo" id="photo" accept="image/*" capture="environment">
            </div>
        @endif

        <button type="submit">Update status</button>
    </form>
@endsection
