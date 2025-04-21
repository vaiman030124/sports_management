@extends('admin.layout')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Admin Users</h4>
        <a href="{{ route('admin.admin-users.create') }}" class="btn btn-primary float-right">
            <i class="fas fa-plus"></i> Add Admin
        </a>
    </div>
    <div class="card-body">
        @if(isset($admins) && $admins->count())
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($admins as $admin)
                <tr>
                    <td>{{ $admin->id }}</td>
                    <td>{{ $admin->name }}</td>
                    <td>{{ $admin->email }}</td>
                    <td>{{ ucfirst($admin->role) }}</td>
                    <td>
                        <a href="{{ route('admin.admin-users.show', $admin) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.admin-users.edit', $admin) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.admin-users.destroy', $admin) }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="alert alert-info">No admin users found</div>
        @endif
    </div>
</div>
@endsection
