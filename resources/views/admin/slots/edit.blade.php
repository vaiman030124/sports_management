@extends('admin.layout')

@section('title', 'Edit Slot')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Edit Slot</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.slots.index') }}">Slots</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Edit Slot Details</h3>
            </div>
            <form action="{{ route('admin.slots.update', $slot->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label for="court_id">Court</label>
                        <select class="form-control @error('court_id') is-invalid @enderror" id="court_id" name="court_id" required>
                            <option value="">Select court</option>
                            @foreach($courts as $court)
                                <option value="{{ $court->id }}" {{ old('court_id', $slot->court_id) == $court->id ? 'selected' : '' }}>{{ $court->court_name }}</option>
                            @endforeach
                        </select>
                        @error('court_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="date">Date</label>
                        <input type="date" class="form-control @error('date') is-invalid @enderror" id="date" name="date" required value="{{ old('date', $slot->date) }}">
                        @error('date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="start_time">Start Time</label>
                        <input type="time" class="form-control @error('start_time') is-invalid @enderror" id="start_time" name="start_time" required value="{{ old('start_time', substr($slot->start_time, 0, -3)) }}">
                        @error('start_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="end_time">End Time</label>
                        <input type="time" class="form-control @error('end_time') is-invalid @enderror" id="end_time" name="end_time" required value="{{ old('end_time', substr($slot->end_time, 0, -3)) }}">
                        @error('end_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- <div class="form-group">
                        <label for="day_of_week">Day of Week</label>
                        <select class="form-control @error('day_of_week') is-invalid @enderror" id="day_of_week" name="day_of_week" required>
                            <option value="monday">Monday</option>
                            <option value="tuesday">Tuesday</option>
                            <option value="wednesday">Wednesday</option>
                            <option value="thursday">Thursday</option>
                            <option value="friday">Friday</option>
                            <option value="saturday">Saturday</option>
                            <option value="sunday">Sunday</option>
                        </select>
                    </div> -->
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                            <option value="available" {{ old('status', $slot->status) == "available" ? 'selected' : '' }}>Available</option>
                            <option value="booked" {{ old('status', $slot->status) == "booked" ? 'selected' : '' }}>Booked</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="slot_type">Slot Type</label>
                        <select class="form-control @error('slot_type') is-invalid @enderror" id="slot_type" name="slot_type" required>
                            <option value="peak" {{ old('slot_type', $slot->slot_type) == "peak" ? 'selected' : '' }}>Peak</option>
                            <option value="non_peak" {{ old('slot_type', $slot->slot_type) == "non_peak" ? 'selected' : '' }}>Non Peak</option>
                        </select>
                        @error('slot_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="price">Price</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control @error('price') is-invalid @enderror" id="price" name="price" required value="{{ old('price', $slot->price) }}">
                            <div class="input-group-append">
                                <span class="input-group-text">.00</span>
                            </div>
                        </div>
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('admin.slots.index') }}" class="btn btn-default">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
