@extends('admin.layouts.app')

@section('title', 'Razorpay Payment Details')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Razorpay Payment Details</h1>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Transaction ID: {{ $transaction->id }}</h5>
            <p><strong>User:</strong> {{ $transaction->user->name ?? 'N/A' }}</p>
            <p><strong>Booking ID:</strong> {{ $transaction->booking_id }}</p>
            <p><strong>Amount:</strong> {{ number_format($transaction->amount, 2) }}</p>
            <p><strong>Status:</strong> {{ ucfirst($transaction->status) }}</p>
            <p><strong>Payment Mode:</strong> {{ ucfirst($transaction->payment_mode) }}</p>
            <p><strong>Payment Reference:</strong> {{ $transaction->payment_reference }}</p>
            <p><strong>Transaction Date:</strong> {{ $transaction->transaction_date ? $transaction->transaction_date->format('Y-m-d H:i') : 'N/A' }}</p>
        </div>
    </div>

    <a href="{{ route('admin.razorpay-payments.index') }}" class="btn btn-secondary mt-3">Back to Payments</a>
</div>
@endsection
