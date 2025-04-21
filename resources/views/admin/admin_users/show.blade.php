@extends('admin.layout')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Admin User Details</h4>
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
@endsection
