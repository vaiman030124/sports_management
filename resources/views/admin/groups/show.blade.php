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
                                <td>{{ $group->group_name }}</td>
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
                                <th>Created By</th>
                                <td>{{ $group->creator->name }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="mt-4">
                    <a href="{{ route('admin.groups.edit', $group) }}" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Edit
                    </a>

                    <form action="{{ route('admin.groups.destroy', $group) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure you want to delete this group?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </form>

                    <a href="{{ route('admin.groups.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
