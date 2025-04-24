@extends('admin.layout')

@section('title', 'Notification Details')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Notification #{{ $notification->id }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.notifications.index') }}">Notifications</a></li>
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
                <h3 class="card-title">Notification Information</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.notifications.edit', $notification->id) }}" class="btn btn-sm btn-info">
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
                                <td>{{ $notification->id }}</td>
                            </tr>
                            <tr>
                                <th>Title</th>
                                <td>{{ $notification->title }}</td>
                            </tr>
                            <tr>
                                <th>User</th>
                                <td>{{ $notification->user->name }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-bordered">
                            <tr>
                                <th>Status</th>
                                <td>
                                    <span class="badge badge-{{ $notification->status == 'read' ? 'success' : 'secondary' }}">
                                        {{ ucfirst($notification->status) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Created At</th>
                                <td>{{ $notification->created_at->format('M d, Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Updated At</th>
                                <td>{{ $notification->updated_at->format('M d, Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label>Content</label>
                    <div class="p-3 bg-light rounded">
                        {{ $notification->message }}
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('admin.notifications.edit', $notification) }}" class="btn btn-primary">
                    <i class="fas fa-edit"></i> Edit
                </a>

                <form action="{{ route('admin.notifications.destroy', $notification) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure you want to delete this notification?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </form>

                <a href="{{ route('admin.notifications.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to List
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
