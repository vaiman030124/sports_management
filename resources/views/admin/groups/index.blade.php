@extends('admin.layout')

@section('title', 'Groups Management')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Groups Management</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Groups</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Groups List</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.groups.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Create Group
                    </a>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Sport</th>
                            <th>Members Count</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($groups as $group)
                        <tr>
                            <td>{{ $group->id }}</td>
                            <td>{{ $group->name }}</td>
                            <td>{{ $group->sport->name ?? 'N/A' }}</td>
                            <td>{{ $group->members_count }}</td>
                            <td>
                                <span class="badge badge-{{ $group->status == 'active' ? 'success' : 'secondary' }}">
                                    {{ ucfirst($group->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.groups.edit', $group->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('admin.groups.show', $group->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer clearfix">
                {{ $groups->links() }}
            </div>
        </div>
    </div>
</section>
@endsection
