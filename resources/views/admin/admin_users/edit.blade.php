@extends('admin.layout')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Edit Admin User</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.admin-users.update', $admin) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Name --}}
            <div class="form-group">
                <label for="name">Name</label>
                <input 
                    type="text" 
                    name="name" 
                    id="name" 
                    class="form-control @error('name') is-invalid @enderror" 
                    value="{{ old('name', $admin->name) }}" 
                    >
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Email --}}
            <div class="form-group">
                <label for="email">Email</label>
                <input 
                    type="email" 
                    name="email" 
                    id="email" 
                    class="form-control @error('email') is-invalid @enderror" 
                    value="{{ old('email', $admin->email) }}" 
                    >
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Password --}}
            <div class="form-group">
                <label for="password">Password (leave blank to keep current)</label>
                <input 
                    type="password" 
                    name="password" 
                    id="password" 
                    class="form-control @error('password') is-invalid @enderror">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Confirm Password --}}
            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input 
                    type="password" 
                    name="password_confirmation" 
                    id="password_confirmation" 
                    class="form-control">
            </div>

            {{-- Role --}}
            <div class="form-group">
                <label for="role">Role</label>
                <select 
                    name="role" 
                    id="role" 
                    class="form-control @error('role') is-invalid @enderror" 
                    >
                    <option value="admin" {{ old('role', $admin->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="super_admin" {{ old('role', $admin->role) == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                </select>
                @error('role')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Submit Button --}}
            <button type="submit" class="btn btn-primary">Update Admin</button>

            <a href="{{ route('admin.admin-users.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
        </form>
    </div>
</div>
@endsection

