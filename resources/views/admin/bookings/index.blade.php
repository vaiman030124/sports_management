@extends('admin.layout')

@section('title', 'Bookings Management')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Bookings Management</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Bookings</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Bookings List</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.bookings.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add New
                    </a>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Group</th>
                            <th>Trainer</th>
                            <th>Venue</th>
                            <th>Court</th>
                            <th>Sport</th>
                            <th>Date</th>
                            <th>Time Slot</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $booking)
                        <tr>
                            <td>{{ $booking->id }}</td>
                            <td>{{ $booking->user->name ?? 'N/A' }}</td>
                            <td>{{ $booking->group->group_name ?? 'N/A' }}</td>
                            <td>{{ $booking->trainer->name ?? 'N/A' }}</td>
                            <td>{{ $booking->venue->venue_name ?? 'N/A' }}</td>
                            <td>{{ $booking->court->court_name ?? 'N/A' }}</td>
                            <td>{{ $booking->sport->sport_name ?? 'N/A' }}</td>
                            <td>{{ $booking->booking_date->format('Y-m-d') }}</td>
                            <td>{{ $booking->slot->slot_time ?? '' }} - {{ $booking->slot->slot_end_time ?? '' }}</td>
                            <td>
                                <span class="badge badge-{{ $booking->status == 'confirmed' ? 'success' : 'warning' }}">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.bookings.edit', $booking->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection
