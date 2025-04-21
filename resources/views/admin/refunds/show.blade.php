@extends('admin.layout')

@section('title', 'Refund Details')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Refund #{{ $refund->id }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.refunds.index') }}">Refunds</a></li>
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
                <h3 class="card-title">Refund Information</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.refunds.edit', $refund->id) }}" class="btn btn-sm btn-info">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-bordered">
                            <tr>
                                <th>ID</th>
                                <td>{{ $refund->id }}</td>
                            </tr>
                            <tr>
                                <th>Transaction ID</th>
                                <td>#{{ $refund->transaction_id }}</td>
                            </tr>
                            <tr>
                                <th>User</th>
                                <td>{{ $refund->user->name }}</td>
                            </tr>
                            <tr>
                                <th>Amount</th>
                                <td>${{ number_format($refund->amount, 2) }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-bordered">
                            <tr>
                                <th>Status</th>
                                <td>
                                    <span class="badge badge-{{ $refund->status == 'completed' ? 'success' : ($refund->status == 'pending' ? 'warning' : 'danger') }}">
                                        {{ ucfirst($refund->status) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Refund Date</th>
                                <td>{{ $refund->refund_date }}</td>
                            </tr>
                            <tr>
                                <th>Created At</th>
                                <td>{{ $refund->created_at->format('M d, Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label>Reason</label>
                    <div class="p-2 border rounded">
                        {{ $refund->reason ?? 'No reason provided' }}
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('admin.refunds.index') }}" class="btn btn-default">Back to List</a>
            </div>
        </div>
    </div>
</section>
@endsection
