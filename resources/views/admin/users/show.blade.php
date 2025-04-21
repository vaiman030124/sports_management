@extends('admin.layout')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>User Details</h4>
    </div>
    <div class="card-body">
        <p><strong>Name:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Phone:</strong> {{ $user->phone }}</p>
        <p><strong>Status:</strong> {{ ucfirst($user->status) }}</p>
        
        <div class="mt-3">
            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-info">Edit User</a>
            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this user?');">Delete User</button>
            </form>

            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
        </div>
    </div>
</div>
@endsection
