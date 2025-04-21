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
                        <select class="form-control" id="court_id" name="court_id" required>
                            @foreach($courts as $court)
                                <option value="{{ $court->id }}" {{ $slot->court_id == $court->id ? 'selected' : '' }}>
                                    {{ $court->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="start_time">Start Time</label>
                        <input type="time" class="form-control" id="start_time" name="start_time" 
                               value="{{ old('start_time', $slot->start_time) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="end_time">End Time</label>
                        <input type="time" class="form-control" id="end_time" name="end_time" 
                               value="{{ old('end_time', $slot->end_time) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="day_of_week">Day of Week</label>
                        <select class="form-control" id="day_of_week" name="day_of_week" required>
                            <option value="monday" {{ $slot->day_of_week == 'monday' ? 'selected' : '' }}>Monday</option>
                            <option value="tuesday" {{ $slot->day_of_week == 'tuesday' ? 'selected' : '' }}>Tuesday</option>
                            <option value="wednesday" {{ $slot->day_of_week == 'wednesday' ? 'selected' : '' }}>Wednesday</option>
                            <option value="thursday" {{ $slot->day_of_week == 'thursday' ? 'selected' : '' }}>Thursday</option>
                            <option value="friday" {{ $slot->day_of_week == 'friday' ? 'selected' : '' }}>Friday</option>
                            <option value="saturday" {{ $slot->day_of_week == 'saturday' ? 'selected' : '' }}>Saturday</option>
                            <option value="sunday" {{ $slot->day_of_week == 'sunday' ? 'selected' : '' }}>Sunday</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="available" {{ $slot->status == 'available' ? 'selected' : '' }}>Available</option>
                            <option value="booked" {{ $slot->status == 'booked' ? 'selected' : '' }}>Booked</option>
                            <option value="maintenance" {{ $slot->status == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                        </select>
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
