@extends('admin.layout')

@section('title', 'Transaction Details')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Transaction #{{ $transaction->id }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.transactions.index') }}">Transactions</a></li>
                    <li class="breadcrumb-item active">Details</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Transaction Information</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.transactions.edit', $transaction->id) }}" class="btn btn-sm btn-info">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>ID</th>
                        <td>{{ $transaction->id }}</td>
                    </tr>
                    <tr>
                        <th>User</th>
                        <td>{{ $transaction->user->name }}</td>
                    </tr>
                    <tr>
                        <th>Booking</th>
                        <td>{{ $transaction->booking->id }}</td>
                    </tr>
                    <tr>
                        <th>Amount</th>
                        <td>${{ number_format($transaction->amount, 2) }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            <span class="badge badge-{{ $transaction->status == 'completed' ? 'success' : 'danger' }}">
                                {{ ucfirst($transaction->status) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Payment Method</th>
                        <td>{{ $transaction->payment_method }}</td>
                    </tr>
                    <tr>
                        <th>Transaction Date</th>
                        <td>{{ $transaction->transaction_date->format('M d, Y H:i') }}</td>
                    </tr>
                </table>
            </div>
            <div class="card-footer">
                <a href="{{ route('admin.transactions.index') }}" class="btn btn-default">Back to List</a>
            </div>
        </div>
    </div>
</section>
@endsection
