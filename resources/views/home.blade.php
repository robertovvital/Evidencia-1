@extends('layouts.guest')

@section('title', 'Track your order')

@section('content')
    <div class="guest-card">
        <h1>Track your order</h1>
        <p class="text-muted">Enter your invoice number to check the status of your order.</p>

        <form class="guest-form" method="GET" action="{{ route('home') }}">
            @if ($errors->any())
                <div class="alert alert--error">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="field">
                <label for="invoice_number">Invoice number</label>
                <input type="text" name="invoice_number" id="invoice_number" value="{{ request('invoice_number') }}" required>
            </div>

            <button class="btn" type="submit">Search</button>
        </form>

        @if ($searched)
            <div class="guest-result">
                @if (! $order)
                    <p class="mb-0">No order was found for that invoice number.</p>
                @else
                    <h2>Order {{ $order->invoice_number }}</h2>
                    <p class="mb-0">Status: <span class="status status--{{ $order->status }}">{{ $order->statusLabel() }}</span></p>

                    @if ($order->status === \App\Models\Order::STATUS_DELIVERED)
                        @php $delivered = $order->deliveredEvidence(); @endphp
                        @if ($delivered)
                            <p>Delivery evidence:</p>
                            <img class="evidence" src="{{ asset('storage/' . $delivered->photo_path) }}" alt="Delivery evidence">
                        @else
                            <p class="mb-0">Delivered, evidence photo pending upload.</p>
                        @endif
                    @elseif ($order->status === \App\Models\Order::STATUS_IN_PROCESS)
                        <p>Process: {{ $order->statusLabel() }}</p>
                        <p class="mb-0">Date: {{ $order->status_changed_at?->format('Y-m-d H:i') }}</p>
                    @endif
                @endif
            </div>
        @endif
    </div>
@endsection
