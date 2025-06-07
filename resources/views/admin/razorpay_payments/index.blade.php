@extends('admin.layout')

@section('title', 'Razorpay Payments')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Razorpay Payments</h1>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Booking ID</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Transaction Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($payments as $payment)
            <tr>
                <td>{{ $payment->id }}</td>
                <td>{{ $payment->user->name ?? 'N/A' }}</td>
                <td>{{ $payment->booking_id }}</td>
                <td>{{ number_format($payment->amount, 2) }}</td>
                <td>{{ ucfirst($payment->status) }}</td>
                <td>{{ $payment->transaction_date ? $payment->transaction_date->format('Y-m-d H:i') : 'N/A' }}</td>
                <td>
                    <a href="{{ route('admin.razorpay-payments.show', $payment->id) }}" class="btn btn-sm btn-primary">View</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $payments->links() }}
</div>
@endsection
