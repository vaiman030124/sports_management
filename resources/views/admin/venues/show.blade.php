@extends('admin.layout')

@section('title', 'Venue Details')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Venue Details</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.venues.index') }}">Venues</a></li>
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
                <h3 class="card-title">{{ $venue->venue_name }}</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.venues.edit', $venue->id) }}" class="btn btn-sm btn-info">
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
                                <td>{{ $venue->id }}</td>
                            </tr>
                            <tr>
                                <th>Name</th>
                                <td>{{ $venue->venue_name }}</td>
                            </tr>
                            <tr>
                                <th>Location</th>
                                <td>{{ $venue->location }}</td>
                            </tr>
                            <tr>
                                <th>Capacity</th>
                                <td>{{ $venue->capacity }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    <span class="badge badge-{{ $venue->status == 'available' ? 'success' : ($venue->status == 'maintenance' ? 'warning' : 'danger') }}">
                                        {{ ucfirst($venue->status) }}
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h4>Description</h4>
                        <p>{{ $venue->description ?? 'No description available' }}</p>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('admin.venues.index') }}" class="btn btn-default">Back to List</a>
            </div>
        </div>
    </div>
</section>
@endsection
