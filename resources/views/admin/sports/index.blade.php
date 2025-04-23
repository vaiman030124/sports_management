@extends('admin.layout')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Sports Management</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Sports</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Sports</h3>
                <a href="{{ route('admin.sports.create') }}" class="btn btn-primary float-right">
                    <i class="fas fa-plus"></i> Add Sport
                </a>
            </div>
            <div class="card-body">
                @if(isset($sports) && $sports->count())
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Sport Name</th>
                            <th>Venue</th>
                            <th>Court Count</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sports as $sport)
                        <tr>
                            <td>{{ $sport->id }}</td>
                            <td>{{ $sport->sport_name }}</td>
                            <td>{{ $sport->venue ? $sport->venue->venue_name : '' }}</td>
                            <td>{{ $sport->court_count }}</td>
                            <td>
                                @if(strtolower($sport->status) === 'active')
                                    <span class="badge badge-success">Active</span>
                                @elseif(strtolower($sport->status) === 'inactive')
                                    <span class="badge badge-danger">Inactive</span>
                                @else
                                    <span class="badge badge-secondary">{{ ucfirst($sport->status) }}</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.sports.show', $sport) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.sports.edit', $sport) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.sports.destroy', $sport) }}" method="POST" style="display:inline">
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
                {{ $sports->links() }}
                @else
                <div class="alert alert-info">No sports found</div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
