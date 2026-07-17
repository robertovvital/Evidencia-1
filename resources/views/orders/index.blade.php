@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/orders.css') }}">
@endpush

@section('title', 'Orders')

@section('content')
    <div class="card">
        <h1 class="mt-0">Orders</h1>
        <p><a class="btn btn--sm" href="{{ route('orders.create') }}">+ New order</a></p>

        <form class="filter-form" method="GET" action="{{ route('orders.index') }}">
            <div class="field">
                <label for="invoice_number">Invoice #</label>
                <input type="text" name="invoice_number" id="invoice_number" value="{{ request('invoice_number') }}">
            </div>
            <div class="field">
                <label for="customer_number">Customer #</label>
                <input type="text" name="customer_number" id="customer_number" value="{{ request('customer_number') }}">
            </div>
            <div class="field">
                <label for="date">Date</label>
                <input type="date" name="date" id="date" value="{{ request('date') }}">
            </div>
            <div class="field">
                <label for="status">Status</label>
                <select name="status" id="status">
                    <option value="">All</option>
                    @foreach ($statuses as $value => $label)
                        <option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="field">
                <button class="btn" type="submit">Filter</button>
            </div>
        </form>

        <table>
            <thead>
                <tr>
                    <th>Invoice</th>
                    <th>Customer</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                    <tr>
                        <td>{{ $order->invoice_number }}</td>
                        <td>{{ $order->customer_name }} ({{ $order->customer_number }})</td>
                        <td>{{ $order->order_datetime->format('Y-m-d H:i') }}</td>
                        <td><span class="status status--{{ $order->status }}">{{ $order->statusLabel() }}</span></td>
                        <td>
                            <a href="{{ route('orders.show', $order) }}">View</a> |
                            <a href="{{ route('orders.edit', $order) }}">Edit</a> |
                            <form class="inline" method="POST" action="{{ route('orders.destroy', $order) }}" onsubmit="return confirm('Archive this order?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn--danger btn--sm" type="submit">Archive</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5">No orders found.</td></tr>
                @endforelse
            </tbody>
        </table>

        {{ $orders->links() }}
    </div>
@endsection
