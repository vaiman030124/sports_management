@extends('admin.layout')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Group: {{ $admin->name }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.admin-users.index') }}">Admin</a></li>
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
                <h3 class="card-title">Admin User Details</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.admin-users.edit', $admin->id) }}" class="btn btn-sm btn-info">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>ID:</strong> {{ $admin->id }}</p>
                        <p><strong>Name:</strong> {{ $admin->name }}</p>
                        <p><strong>Email:</strong> {{ $admin->email }}</p>
                        <p><strong>Role:</strong> {{ ucfirst(str_replace('_', ' ', $admin->role)) }}</p>
                        <p><strong>Created At:</strong> 
                            {{ $admin->created_at ? $admin->created_at->format('M d, Y H:i') : 'N/A' }}
                        </p>
                        <p><strong>Last Updated:</strong> 
                            {{ $admin->updated_at ? $admin->updated_at->format('M d, Y H:i') : 'N/A' }}
                        </p>
                    </div>
                </div>

                <div class="mt-4">
                    <a href="{{ route('admin.admin-users.edit', $admin) }}" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Edit
                    </a>

                    <form action="{{ route('admin.admin-users.destroy', $admin) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure you want to delete this admin user?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </form>

                    <a href="{{ route('admin.admin-users.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
