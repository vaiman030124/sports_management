@extends('admin.layout')

@section('title', 'Membership Plan Details')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Plan: {{ $plan->name }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.membership_plans.index') }}">Plans</a></li>
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
                <h3 class="card-title">Plan Information</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.membership_plans.edit', $plan->id) }}" class="btn btn-sm btn-info">
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
                                <td>{{ $plan->id }}</td>
                            </tr>
                            <tr>
                                <th>Name</th>
                                <td>{{ $plan->name }}</td>
                            </tr>
                            <tr>
                                <th>Duration</th>
                                <td>{{ $plan->duration_months }} months</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-bordered">
                            <tr>
                                <th>Price</th>
                                <td>${{ number_format($plan->price, 2) }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    <span class="badge badge-{{ $plan->status == 'active' ? 'success' : 'danger' }}">
                                        {{ ucfirst($plan->status) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Created At</th>
                                <td>{{ $plan->created_at->format('M d, Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label>Description</label>
                    <div class="p-2 border rounded">
                        {{ $plan->description ?? 'No description available' }}
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('admin.membership_plans.index') }}" class="btn btn-default">Back to List</a>
            </div>
        </div>
    </div>
</section>
@endsection
