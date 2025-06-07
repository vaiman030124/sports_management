@extends('admin.layout')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Edit User: {{ $user->name }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
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
                <h3 class="card-title">Edit User</h3>
            </div>
            <div class="card-body">

                <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Name --}}
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input 
                            type="text" 
                            name="name" 
                            id="name" 
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $user->name) }}" 
                            required
                        >
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input 
                            type="email" 
                            name="email" 
                            id="email" 
                            class="form-control @error('email') is-invalid @enderror" 
                            value="{{ old('email', $user->email) }}" 
                            required
                        >
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="form-group">
                        <label for="password">Password (leave blank to keep current password)</label>
                        <input 
                            type="password" 
                            name="password" 
                            id="password" 
                            class="form-control @error('password') is-invalid @enderror"
                        >
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Confirm Password --}}
                    <div class="form-group">
                        <label for="password_confirmation">Confirm Password</label>
                        <input 
                            type="password" 
                            name="password_confirmation" 
                            id="password_confirmation" 
                            class="form-control"
                        >
                    </div>

                    {{-- Phone --}}
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input 
                            type="text" 
                            name="phone" 
                            id="phone" 
                            class="form-control @error('phone') is-invalid @enderror" 
                            value="{{ old('phone', $user->phone) }}"
                            required
                        >
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Profile Image --}}
                    @if ($user->profile_image)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $user->profile_image) }}" alt="Profile Image" width="100">
                        </div>
                    @endif
                    <div class="form-group">
                        <label for="profile_image">Profile Image</label>
                        <input 
                            type="file" 
                            name="profile_image" 
                            id="profile_image" 
                            class="form-control-file @error('profile_image') is-invalid @enderror"
                        >
                        @error('profile_image')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Sport Played --}}
                    <div class="form-group">
                        <label for="sport_played">What sport do you play?</label>
                        <select 
                            name="sport_played[]" 
                            id="sport_played" 
                            class="form-control @error('sport_played') is-invalid @enderror"
                            multiple
                        >
                            @foreach($sports as $sport)
                                <option value="{{ $sport->sport_name }}" {{ (is_array(old('sport_played', $user->sport_played)) && in_array($sport->sport_name, old('sport_played', $user->sport_played))) ? 'selected' : '' }}>
                                    {{ $sport->sport_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('sport_played')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Level --}}
                    <div class="form-group">
                        <label for="level">Level</label>
                        <select 
                            name="level" 
                            id="level" 
                            class="form-control @error('level') is-invalid @enderror"
                        >
                            <option value="">Select level</option>
                            <option value="Beginner" {{ old('level', $user->level) == 'Beginner' ? 'selected' : '' }}>Beginner</option>
                            <option value="Beginner+" {{ old('level', $user->level) == 'Beginner+' ? 'selected' : '' }}>Beginner+</option>
                            <option value="Intermediate" {{ old('level', $user->level) == 'Intermediate' ? 'selected' : '' }}>Intermediate</option>
                            <option value="Intermediate+" {{ old('level', $user->level) == 'Intermediate+' ? 'selected' : '' }}>Intermediate+</option>
                            <option value="Advance" {{ old('level', $user->level) == 'Advance' ? 'selected' : '' }}>Advance</option>
                            <option value="Advance+" {{ old('level', $user->level) == 'Advance+' ? 'selected' : '' }}>Advance+</option>
                        </select>
                        @error('level')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Location --}}
                    <div class="form-group">
                        <label for="location">Location</label>
                        <input 
                            type="text" 
                            name="location" 
                            id="location" 
                            class="form-control @error('location') is-invalid @enderror" 
                            value="{{ old('location', $user->location) }}"
                            placeholder="Enter location"
                        >
                        @error('location')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Update User</button>

                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

