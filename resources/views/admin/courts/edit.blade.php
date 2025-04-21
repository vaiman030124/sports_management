@extends('admin.layout')

@section('title', 'Edit Court')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Edit Court</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.courts.index') }}">Courts</a></li>
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
                <h3 class="card-title">Edit Court Details</h3>
            </div>
            <form action="{{ route('admin.courts.update', $court->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Court Name</label>
                        <input type="text" class="form-control" id="name" name="name" 
                               value="{{ old('name', $court->name) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="venue_id">Venue</label>
                        <select class="form-control" id="venue_id" name="venue_id" required>
                            @foreach($venues as $venue)
                                <option value="{{ $venue->id }}" {{ $court->venue_id == $venue->id ? 'selected' : '' }}>
                                    {{ $venue->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="sport_id">Sport</label>
                        <select class="form-control" id="sport_id" name="sport_id" required>
                            @foreach($sports as $sport)
                                <option value="{{ $s sport->id }}" {{ $court->sport_id == $sport->id ? 'selected' : '' }}>
                                    {{ $sport->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="available" {{ $court->status == 'available' ? 'selected' : '' }}>Available</option>
                            <option value="unavailable" {{ $court->status == 'unavailable' ? 'selected' : '' }}>Unavailable</option>
                            <option value="maintenance" {{ $court->status == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                        </select>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('admin.courts.index') }}" class="btn btn-default">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
