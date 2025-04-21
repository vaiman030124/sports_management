@extends('admin.layout')

@section('title', 'Trainer Booking Details')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Trainer Booking #{{ $booking->id }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.trainer_bookings.index') }}">Trainer Bookings</a></li>
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
                <h3 class="card-title">Booking Information</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.trainer_bookings.edit', $booking->id) }}" class="btn btn-sm btn-info">
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
                                <td>{{ $booking->id }}</td>
                            </tr>
                            <tr>
                                <th>User</th>
                                <td>{{ $booking->user->name }}</td>
                            </tr>
                            <tr>
                                <th>Trainer</th>
                                <td>{{ $booking->trainer->name }}</td>
                            </tr>
                            <tr>
                                <th>Booking Date</th>
                                <td>{{ $booking->booking_date->format('M d, Y') }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-bordered">
                            <tr>
                                <th>Status</th>
                                <td>
                                    <span class="badge badge-{{ $booking->status == 'confirmed' ? 'success' : ($booking->status == 'pending' ? 'warning' : 'danger') }}">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Created At</th>
                                <td>{{ $booking->created_at->format('M d, Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Updated At</th>
                                <td>{{ $booking->updated_at->format('M d, Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label>Notes</label>
                    <div class="p-2 border rounded">
                        {{ $booking->notes ?? 'No notes available' }}
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('admin.trainer_bookings.index') }}" class="btn btn-default">Back to List</a>
            </div>
        </div>
    </div>
</section>
@endsection
