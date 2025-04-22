@extends('admin.layout')

@section('title', 'Create New Court')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Create New Court</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.courts.index') }}">Courts</a></li>
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
                <h3 class="card-title">Court Details</h3>
            </div>
            <form action="{{ route('admin.courts.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Court Name</label>
                        <input type="text" class="form-control @error('court_name') is-invalid @enderror" id="court_name" name="court_name" placeholder="Enter Court name" required>
                        @error('court_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="sport_id">Sport</label>
                        <select class="form-control @error('sport_id') is-invalid @enderror" id="sport_id" name="sport_id" required>
                            <option value="">Select</option>
                            @foreach($sports as $k => $sport)
                                <option value="{{ $k }}">{{ $sport }}</option>
                            @endforeach
                        </select>
                        @error('sport_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="court_type">Court Type</label>
                        <select class="form-control @error('court_type') is-invalid @enderror" id="court_type" name="court_type" required>
                            <option value="shared">Shared</option>
                            <option value="dedicated" selected>Dedicated</option>
                        </select>
                        @error('court_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                            <option value="maintenance">Maintenance</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="{{ route('admin.courts.index') }}" class="btn btn-default">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
