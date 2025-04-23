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
            <form action="{{ route('admin.trainers.update', $trainer->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Name *</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" 
                                       placeholder="Enter name" value="{{ old('name', $trainer->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="is_kid_trainer">Is kid trainer *</label>
                                <select name="is_kid_trainer" id="is_kid_trainer" class="form-control @error('is_kid_trainer') is-invalid @enderror" required>
                                        <option value="0" {{ $trainer->is_kid_trainer == 0 ? 'selected' : '' }}>No</option>
                                        <option value="1" {{ $trainer->is_kid_trainer == 1 ? 'selected' : '' }}>Yes</option>
                                </select>
                                @error('is_kid_trainer')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="status">Status *</label>
                                <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                                        <option value="active" {{ $trainer->status == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ $trainer->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="admin_user_id">Admin User *</label>
                                <select name="admin_user_id" id="admin_user_id" class="form-control @error('admin_user_id') is-invalid @enderror" required>
                                    @foreach($admin_users as $admin_user)
                                        <option value="{{ $admin_user->id }}" {{ $trainer->admin_user_id == $admin_user->id ? 'selected' : '' }}>{{ $admin_user->name }}</option>
                                    @endforeach
                                </select>
                                @error('admin_user_id')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="is_adult_trainer">Is adult trainer *</label>
                                <select name="is_adult_trainer" id="is_adult_trainer" class="form-control @error('is_adult_trainer') is-invalid @enderror" required>
                                        <option value="0" {{ $trainer->is_adult_trainer == 0 ? 'selected' : '' }}>No</option>
                                        <option value="1" {{ $trainer->is_adult_trainer == 1 ? 'selected' : '' }}>Yes</option>
                                </select>
                                @error('is_adult_trainer')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="sports">Sport *</label>
                                <select name="sports" id="sports" class="form-control @error('sports') is-invalid @enderror" required>
                                    @foreach($sports as $sport)
                                        <option value="{{ $sport->id }}" {{ $trainer->sports == $sport->id ? 'selected' : '' }}>{{ $sport->sport_name }}</option>
                                    @endforeach
                                </select>
                                @error('sports')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    @if ($trainer->photo)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $trainer->photo) }}" alt="Trainer Image" width="100">
                        </div>
                    @endif
                    <div class="form-group">
                        <label for="photo">Image</label>
                        <input 
                            type="file" 
                            name="photo" 
                            id="photo" 
                            class="form-control-file @error('photo') is-invalid @enderror">
                        @error('photo')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" 
                                  placeholder="Enter trainer description" value="{{ old('description', $trainer->description) }}"></textarea>
                        @error('description')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Update Trainer</button>
                    <a href="{{ route('admin.trainers.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
