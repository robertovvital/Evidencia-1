@extends('layouts.app')

@section('title', 'Orders')

@section('content')
    <h1>Orders</h1>
    <p><a href="{{ route('orders.create') }}">+ New order</a></p>

    <form method="GET" action="{{ route('orders.index') }}">
        <table style="border:none">
            <tr style="border:none">
                <td style="border:none">
                    <label for="invoice_number">Invoice #</label>
                    <input type="text" name="invoice_number" id="invoice_number" value="{{ request('invoice_number') }}">
                </td>
                <td style="border:none">
                    <label for="customer_number">Customer #</label>
                    <input type="text" name="customer_number" id="customer_number" value="{{ request('customer_number') }}">
                </td>
                <td style="border:none">
                    <label for="date">Date</label>
                    <input type="date" name="date" id="date" value="{{ request('date') }}">
                </td>
                <td style="border:none">
                    <label for="status">Status</label>
                    <select name="status" id="status">
                        <option value="">All</option>
                        @foreach ($statuses as $value => $label)
                            <option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </td>
                <td style="border:none; vertical-align:bottom">
                    <button type="submit">Filter</button>
                </td>
            </tr>
        </table>
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
                    <td><span class="status">{{ $order->statusLabel() }}</span></td>
                    <td>
                        <a href="{{ route('orders.show', $order) }}">View</a> |
                        <a href="{{ route('orders.edit', $order) }}">Edit</a> |
                        <form class="inline" method="POST" action="{{ route('orders.destroy', $order) }}" onsubmit="return confirm('Archive this order?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Archive</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5">No orders found.</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $orders->links() }}
@endsection
