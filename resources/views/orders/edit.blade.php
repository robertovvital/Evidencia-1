@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/orders.css') }}">
@endpush

@section('title', 'Edit order')

@section('content')
    <div class="card">
        <h1 class="mt-0">Edit order {{ $order->invoice_number }}</h1>

        <form class="stacked-form" method="POST" action="{{ route('orders.update', $order) }}">
            @csrf
            @method('PUT')

            <div class="field">
                <label for="invoice_number">Invoice number</label>
                <input type="text" name="invoice_number" id="invoice_number" value="{{ old('invoice_number', $order->invoice_number) }}" required>
            </div>

            <div class="field">
                <label for="customer_name">Customer name / company</label>
                <input type="text" name="customer_name" id="customer_name" value="{{ old('customer_name', $order->customer_name) }}" required>
            </div>

            <div class="field">
                <label for="customer_number">Customer number</label>
                <input type="text" name="customer_number" id="customer_number" value="{{ old('customer_number', $order->customer_number) }}" required>
            </div>

            <div class="field">
                <label for="fiscal_data">Fiscal data</label>
                <textarea name="fiscal_data" id="fiscal_data" rows="3" required>{{ old('fiscal_data', $order->fiscal_data) }}</textarea>
            </div>

            <div class="field">
                <label for="order_datetime">Order date and time</label>
                <input type="datetime-local" name="order_datetime" id="order_datetime" value="{{ old('order_datetime', $order->order_datetime->format('Y-m-d\TH:i')) }}" required>
            </div>

            <div class="field">
                <label for="delivery_address">Delivery address</label>
                <input type="text" name="delivery_address" id="delivery_address" value="{{ old('delivery_address', $order->delivery_address) }}" required>
            </div>

            <div class="field">
                <label for="notes">Notes</label>
                <textarea name="notes" id="notes" rows="3">{{ old('notes', $order->notes) }}</textarea>
            </div>

            <button class="btn" type="submit">Save changes</button>
        </form>
    </div>
@endsection
