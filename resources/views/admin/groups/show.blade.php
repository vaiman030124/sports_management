@extends('admin.layout')

@section('title', 'Group Details')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Group: {{ $group->name }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.groups.index') }}">Groups</a></li>
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
                <h3 class="card-title">Group Information</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.groups.edit', $group->id) }}" class="btn btn-sm btn-info">
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
                                <td>{{ $group->id }}</td>
                            </tr>
                            <tr>
                                <th>Name</th>
                                <td>{{ $group->name }}</td>
                            </tr>
                            <tr>
                                <th>Sport</th>
                                <td>{{ $group->sport->name ?? 'N/A' }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-bordered">
                            <tr>
                                <th>Status</th>
                                <td>
                                    <span class="badge badge-{{ $group->status == 'active' ? 'success' : 'secondary' }}">
                                        {{ ucfirst($group->status) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Max Members</th>
                                <td>{{ $group->max_members ?? 'Unlimited' }}</td>
                            </tr>
                            <tr>
                                <th>Created At</th>
                                <td>{{ $group->created_at->format('M d, Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label>Description</label>
                    <div class="p-3 bg-light rounded">
                        {{ $group->description ?? 'No description available' }}
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('admin.groups.index') }}" class="btn btn-default">
                    <i class="fas fa-arrow-left"></i> Back to List
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
