@extends('admin.layout')

@section('title', 'Edit Refund')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Edit Refund #{{ $refund->id }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.refunds.index') }}">Refunds</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Refund Details</h3>
            </div>
            <form action="{{ route('admin.refunds.update', $refund->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Transaction ID</label>
                                <input type="text" class="form-control" value="#{{ $refund->transaction_id }}" readonly>
                            </div>
                            <div class="form-group">
                                <label>User</label>
                                <input type="text" class="form-control" value="{{ $refund->user->name }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="amount">Amount *</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <input type="number" step="0.01" class="form-control" id="amount" name="amount" 
                                           value="{{ old('amount', $refund->amount) }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status">Status *</label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="pending" {{ $refund->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="processing" {{ $refund->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                    <option value="completed" {{ $refund->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="rejected" {{ $refund->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="refund_date">Refund Date *</label>
                                <input type="date" class="form-control" id="refund_date" name="refund_date" 
                                       value="{{ old('refund_date', $refund->refund_date) }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="reason">Reason *</label>
                        <textarea class="form-control" id="reason" name="reason" rows="3" required>{{ old('reason', $refund->reason) }}</textarea>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Update Refund</button>
                    <a href="{{ route('admin.refunds.index') }}" class="btn btn-default">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
