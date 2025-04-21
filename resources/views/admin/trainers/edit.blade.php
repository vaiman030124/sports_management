@extends('admin.layout')

@section('title', 'Edit Trainer')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Edit Trainer: {{ $trainer->name }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.trainers.index') }}">Trainers</a></li>
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
                <h3 class="card-title">Trainer Details</h3>
            </div>
            <form action="{{ route('admin.trainers.update', $trainer->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Full Name *</label>
                                <input type="text" class="form-control" id="name" name="name" 
                                       value="{{ old('name', $trainer->name) }}" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email *</label>
                                <input type="email" class="form-control" id="email" name="email" 
                                       value="{{ old('email', $trainer->email) }}" required>
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="text" class="form-control" id="phone" name="phone" 
                                       value="{{ old('phone', $trainer->phone) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="specialization">Specialization *</label>
                                <input type="text" class="form-control" id="specialization" name="specialization" 
                                       value="{{ old('specialization', $trainer->specialization) }}" required>
                            </div>
                            <div class="form-group">
                                <label for="experience">Experience (years) *</label>
                                <input type="number" class="form-control" id="experience" name="experience" 
                                       value="{{ old('experience', $trainer->experience) }}" min="0" required>
                            </div>
                            <div class="form-group">
                                <label for="status">Status *</label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="active" {{ $trainer->status == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ $trainer->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="bio">Bio/Description</label>
                        <textarea class="form-control" id="bio" name="bio" rows="3">{{ old('bio', $trainer->bio) }}</textarea>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Update Trainer</button>
                    <a href="{{ route('admin.trainers.index') }}" class="btn btn-default">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
