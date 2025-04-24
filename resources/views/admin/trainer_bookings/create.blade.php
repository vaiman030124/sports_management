@extends('admin.layout')

@section('title', 'Create Trainer Booking')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Create New Trainer Booking</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.trainer_bookings.index') }}">Trainer Bookings</a></li>
                    <li class="breadcrumb-item active">Create</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Booking Details</h3>
            </div>
            <form action="{{ route('admin.trainer_bookings.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user_id">User *</label>
                                <select class="form-control @error('user_id') is-invalid @enderror" id="user_id" name="user_id" required>
                                    <option value="">Select</option>
                                    @foreach($users as $k =>$user)
                                        <option value="{{ $k }}" {{ old('user_id') == $k ? "selected" : '' }}>{{ $user }}</option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="trainer_id">Trainer *</label>
                                <select class="form-control @error('trainer_id') is-invalid @enderror" id="trainer_id" name="trainer_id" required>
                                    <option value="">Select</option>
                                    @foreach($trainers as $k => $trainer)
                                        <option value="{{ $k }}" {{ old('trainer_id') == $k ? "selected" : '' }}>{{ $trainer }}</option>
                                    @endforeach
                                </select>
                                @error('trainer_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="booking_date">Booking Date *</label>
                                <input type="date" class="form-control @error('booking_date') is-invalid @enderror" id="booking_date" name="booking_date" required value="{{ old('booking_date') }}">
                                @error('booking_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="booking_time">Booking Start Time *</label>
                                <input type="time" class="form-control @error('booking_time') is-invalid @enderror" id="booking_time" name="booking_time" required value="{{ old('booking_time') }}">
                                @error('booking_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="booking_end_time">Booking End Time *</label>
                                <input type="time" class="form-control @error('booking_end_time') is-invalid @enderror" id="booking_end_time" name="booking_end_time" required value="{{ old('booking_end_time') }}">
                                @error('booking_end_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status">Status *</label>
                                <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required value="{{ old('status') }}">
                                    <option value="pending" {{ old('status') == "pending" ? "selected" : '' }}>Pending</option>
                                    <option value="confirmed" {{ old('status') == "confirmed" ? "selected" : '' }}>Confirmed</option>
                                    <option value="cancelled" {{ old('status') == "cancelled" ? "selected" : '' }}>Cancelled</option>
                                    <option value="completed" {{ old('status') == "completed" ? "selected" : '' }}>Completed</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Create Booking</button>
                    <a href="{{ route('admin.trainer_bookings.index') }}" class="btn btn-default">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
