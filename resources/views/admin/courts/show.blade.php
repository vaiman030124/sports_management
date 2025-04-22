@extends('admin.layout')

@section('title', 'Court Details')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Court Details</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.courts.index') }}">Courts</a></li>
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
                <h3 class="card-title">{{ $court->name }}</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.courts.edit', $court->id) }}" class="btn btn-sm btn-info">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h4>Basic Information</h4>
                        <table class="table table-bordered">
                            <tr>
                                <th>ID</th>
                                <td>{{ $court->id }}</td>
                            </tr>
                            <tr>
                                <th>Name</th>
                                <td>{{ $court->court_name }}</td>
                            </tr>
                            <tr>
                                <th>Sport</th>
                                <td>{{ $court->sport->sport_name }}</td>
                            </tr>
                            <tr>
                                <th>Court Type</th>
                                <td>{{ ucfirst($court->court_type) }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    <span class="badge badge-{{ $court->status == 'active' ? 'success' : ($court->status == 'maintenance' ? 'warning' : 'danger') }}">
                                        {{ ucfirst($court->status) }}
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h4>Additional Information</h4>
                        <p><strong>Created At:</strong> {{ $court->created_at->format('M d, Y H:i') }}</p>
                        <p><strong>Updated At:</strong> {{ $court->updated_at->format('M d, Y H:i') }}</p>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('admin.courts.index') }}" class="btn btn-default">Back to List</a>
            </div>
        </div>
    </div>
</section>
@endsection
