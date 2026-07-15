@extends('layouts.app')

@section('title', 'Edit order')

@section('content')
    <h1>Edit order {{ $order->invoice_number }}</h1>

    <form method="POST" action="{{ route('orders.update', $order) }}">
        @csrf
        @method('PUT')

        <label for="invoice_number">Invoice number</label>
        <input type="text" name="invoice_number" id="invoice_number" value="{{ old('invoice_number', $order->invoice_number) }}" required>

        <label for="customer_name">Customer name / company</label>
        <input type="text" name="customer_name" id="customer_name" value="{{ old('customer_name', $order->customer_name) }}" required>

        <label for="customer_number">Customer number</label>
        <input type="text" name="customer_number" id="customer_number" value="{{ old('customer_number', $order->customer_number) }}" required>

        <label for="fiscal_data">Fiscal data</label>
        <textarea name="fiscal_data" id="fiscal_data" rows="3" required>{{ old('fiscal_data', $order->fiscal_data) }}</textarea>

        <label for="order_datetime">Order date and time</label>
        <input type="datetime-local" name="order_datetime" id="order_datetime" value="{{ old('order_datetime', $order->order_datetime->format('Y-m-d\TH:i')) }}" required>

        <label for="delivery_address">Delivery address</label>
        <input type="text" name="delivery_address" id="delivery_address" value="{{ old('delivery_address', $order->delivery_address) }}" required>

        <label for="notes">Notes</label>
        <textarea name="notes" id="notes" rows="3">{{ old('notes', $order->notes) }}</textarea>

        <button type="submit">Save changes</button>
    </form>
@endsection
