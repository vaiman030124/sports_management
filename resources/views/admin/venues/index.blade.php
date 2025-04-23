@extends('admin.layout')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Venues Management</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Venues</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Venues</h3>
                <a href="{{ route('admin.venues.create') }}" class="btn btn-primary float-right">
                    <i class="fas fa-plus"></i> Add Venue
                </a>
            </div>
            <div class="card-body">
                @if(isset($venues) && $venues->count())
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Venue Name</th>
                            <th>Location</th>
                            <th>Capacity</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($venues as $venue)
                        <tr>
                            <td>{{ $venue->id }}</td>
                            <td>{{ $venue->venue_name }}</td>
                            <td>{{ $venue->location }}</td>
                            <td>{{ $venue->capacity }}</td>
                            <td>
                            @if(strtolower($venue->status) === 'active')
                                <span class="badge badge-success">Active</span>
                            @elseif(strtolower($venue->status) === 'inactive')
                                <span class="badge badge-danger">Inactive</span>
                            @elseif(strtolower($venue->status) === 'maintenance')
                                <span class="badge badge-warning">Maintenance</span>
                            @else
                                <span class="badge badge-secondary">{{ ucfirst($venue->status) }}</span>
                            @endif
                        </td>
                            <td>
                                <a href="{{ route('admin.venues.show', $venue) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.venues.edit', $venue) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.venues.destroy', $venue) }}" method="POST" style="display:inline">
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
                {{ $venues->links() }}
                @else
                <div class="alert alert-info">No venues found</div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
