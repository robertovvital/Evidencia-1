@extends('layouts.app')

@section('title', 'Archived orders')

@section('content')
    <h1>Archived orders</h1>
    <p><a href="{{ route('orders.index') }}">&laquo; Back to orders</a></p>

    <table>
        <thead>
            <tr>
                <th>Invoice</th>
                <th>Customer</th>
                <th>Status when archived</th>
                <th>Archived on</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($orders as $order)
                <tr>
                    <td>{{ $order->invoice_number }}</td>
                    <td>{{ $order->customer_name }} ({{ $order->customer_number }})</td>
                    <td><span class="status">{{ $order->statusLabel() }}</span></td>
                    <td>{{ $order->deleted_at->format('Y-m-d H:i') }}</td>
                    <td>
                        <form class="inline" method="POST" action="{{ route('orders.restore', $order->id) }}">
                            @csrf
                            <button type="submit">Restore</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5">No archived orders.</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $orders->links() }}
@endsection
