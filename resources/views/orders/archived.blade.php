@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/orders.css') }}">
@endpush

@section('title', 'Archived orders')

@section('content')
    <div class="card">
        <h1 class="mt-0">Archived orders</h1>
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
                        <td><span class="status status--{{ $order->status }}">{{ $order->statusLabel() }}</span></td>
                        <td>{{ $order->deleted_at->format('Y-m-d H:i') }}</td>
                        <td>
                            <form class="inline" method="POST" action="{{ route('orders.restore', $order->id) }}">
                                @csrf
                                <button class="btn btn--secondary btn--sm" type="submit">Restore</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5">No archived orders.</td></tr>
                @endforelse
            </tbody>
        </table>

        {{ $orders->links() }}
    </div>
@endsection
