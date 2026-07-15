@extends('layouts.guest')

@section('title', 'Track your order')

@section('content')
    <h1>Track your order</h1>
    <p>Enter your invoice number to check the status of your order.</p>

    <form method="GET" action="{{ route('home') }}">
        @if ($errors->any())
            <div class="errors">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <label for="invoice_number">Invoice number</label>
        <input type="text" name="invoice_number" id="invoice_number" value="{{ request('invoice_number') }}" required>

        <button type="submit">Search</button>
    </form>

    @if ($searched)
        <hr>
        @if (! $order)
            <p>No order was found for that invoice number.</p>
        @else
            <h2>Order {{ $order->invoice_number }}</h2>
            <p>Status: <span class="status">{{ $order->statusLabel() }}</span></p>

            @if ($order->status === \App\Models\Order::STATUS_DELIVERED)
                @php $delivered = $order->deliveredEvidence(); @endphp
                @if ($delivered)
                    <p>Delivery evidence:</p>
                    <img class="evidence" src="{{ asset('storage/' . $delivered->photo_path) }}" alt="Delivery evidence">
                @else
                    <p>Delivered, evidence photo pending upload.</p>
                @endif
            @elseif ($order->status === \App\Models\Order::STATUS_IN_PROCESS)
                <p>Process: {{ $order->statusLabel() }}</p>
                <p>Date: {{ $order->status_changed_at?->format('Y-m-d H:i') }}</p>
            @endif
        @endif
    @endif
@endsection
