@extends('admin.layout')

@section('title', 'Slot Details')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Slot Details</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.slots.index') }}">Slots</a></li>
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
                <h3 class="card-title">Slot Information</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.slots.edit', $slot->id) }}" class="btn btn-sm btn-info">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>ID</th>
                        <td>{{ $slot->id }}</td>
                    </tr>
                    <tr>
                        <th>Court</th>
                        <td>{{ $slot->court->name }}</td>
                    </tr>
                    <tr>
                        <th>Day</th>
                        <td>{{ ucfirst($slot->day_of_week) }}</td>
                    </tr>
                    <tr>
                        <th>Time</th>
                        <td>{{ $slot->start_time }} - {{ $slot->end_time }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            <span class="badge badge-{{ $slot->status == 'available' ? 'success' : ($slot->status == 'booked' ? 'danger' : 'warning') }}">
                                {{ ucfirst($slot->status) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Created At</th>
                        <td>{{ $slot->created_at->format('M d, Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Updated At</th>
                        <td>{{ $slot->updated_at->format('M d, Y H:i') }}</td>
                    </tr>
                </table>
            </div>
            <div class="card-footer">
                <a href="{{ route('admin.slots.index') }}" class="btn btn-default">Back to List</a>
            </div>
        </div>
    </div>
</section>
@endsection
