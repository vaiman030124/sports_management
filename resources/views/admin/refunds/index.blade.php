@extends('admin.layout')

@section('title', 'Refunds Management')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Refunds Management</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Refunds</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Refunds List</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.refunds.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Create Refund
                    </a>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Transaction</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Requested At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($refunds as $refund)
                        <tr>
                            <td>{{ $refund->id }}</td>
                            <td>#{{ $refund->transaction_id }}</td>
                            <td>{{ number_format($refund->amount, 2) }}</td>
                            <td>
                                <span class="badge badge-{{ $refund->status == 'approved' ? 'success' : ($refund->status == 'pending' ? 'warning' : 'danger') }}">
                                    {{ ucfirst($refund->status) }}
                                </span>
                            </td>
                            <td>{{ $refund->created_at->format('M d, Y H:i') }}</td>
                            <td>
                                <a href="{{ route('admin.refunds.edit', $refund->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('admin.refunds.show', $refund->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer clearfix">
                {{ $refunds->links() }}
            </div>
        </div>
    </div>
</section>
@endsection
