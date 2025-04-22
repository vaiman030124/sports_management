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
                        <input type="text" class="form-control @error('court_name') is-invalid @enderror" id="court_name" name="court_name" placeholder="Enter Court name" required  value="{{ old('court_name', $court->court_name) }}">
                        @error('court_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="sport_id">Sport</label>
                        <select class="form-control @error('sport_id') is-invalid @enderror" id="sport_id" name="sport_id" required>
                            <option value="">Select</option>
                            @foreach($sports as $k => $sport)
                                <option value="{{ $k }}" {{ old('sport_id', $court->sport_id) == $k ? 'selected' : '' }}>{{ $sport }}</option>
                            @endforeach
                        </select>
                        @error('sport_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="court_type">Court Type</label>
                        <select class="form-control @error('court_type') is-invalid @enderror" id="court_type" name="court_type" required>
                            <option value="shared" {{ old('court_type', $court->court_type) == "shared" ? 'selected' : '' }}>Shared</option>
                            <option value="dedicated" {{ old('court_type', $court->court_type) == "dedicated" ? 'selected' : '' }}>Dedicated</option>
                        </select>
                        @error('court_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                            <option value="active" {{ old('status', $court->status) == "active" ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $court->status) == "inactive" ? 'selected' : '' }}>Inactive</option>
                            <option value="maintenance" {{ old('status', $court->status) == "maintenance" ? 'selected' : '' }}>Maintenance</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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
