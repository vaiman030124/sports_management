@extends('admin.layout')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Create New Sport</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.sports.index') }}">Sports</a></li>
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
                <h3 class="card-title">Sport Details</h3>
            </div>
<form action="{{ route('admin.sports.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row">
                        {{-- Sport Name --}}
                        <div class="form-group col-md-6">
                            <label for="sport_name">Sport Name</label>
                            <input type="text" class="form-control @error('sport_name') is-invalid @enderror" id="sport_name" name="sport_name" value="{{ old('sport_name') }}">
                            @error('sport_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Venue --}}
                        <div class="form-group col-md-6">
                            <label for="venue_id">Venue</label>
                            <select class="form-control @error('venue_id') is-invalid @enderror" id="venue_id" name="venue_id">
                                <option value="">Select Venue</option>
                                @foreach($venues as $venue)
                                    <option value="{{ $venue->id }}" {{ old('venue_id') == $venue->id ? 'selected' : '' }}>{{ $venue->venue_name }}</option>
                                @endforeach
                            </select>
                            @error('venue_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        {{-- Pricing Peak --}}
                        <div class="form-group col-md-6">
                            <label for="pricing_peak">Pricing Peak</label>
                            <input type="text" class="form-control @error('pricing_peak') is-invalid @enderror" id="pricing_peak" name="pricing_peak" value="{{ old('pricing_peak') }}">
                            @error('pricing_peak')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Pricing Non Peak --}}
                        <div class="form-group col-md-6">
                            <label for="pricing_non_peak">Pricing Non Peak</label>
                            <input type="text" class="form-control @error('pricing_non_peak') is-invalid @enderror" id="pricing_non_peak" name="pricing_non_peak" value="{{ old('pricing_non_peak') }}">
                            @error('pricing_non_peak')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        {{-- Court Count --}}
                        <div class="form-group col-md-6">
                            <label for="court_count">Court Count</label>
                            <input type="number" class="form-control @error('court_count') is-invalid @enderror" id="court_count" name="court_count" value="{{ old('court_count') }}">
                            @error('court_count')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Shared With --}}
                        <div class="form-group col-md-6">
                            <label>Shared With</label>
                            <div class="form-check">
                                <input class="form-check-input @error('shared_with') is-invalid @enderror" type="checkbox" name="shared_with[]" id="shared_with_public" value="public" {{ (is_array(old('shared_with')) && in_array('public', old('shared_with'))) ? 'checked' : '' }}>
                                <label class="form-check-label" for="shared_with_public">Public</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input @error('shared_with') is-invalid @enderror" type="checkbox" name="shared_with[]" id="shared_with_members" value="members" {{ (is_array(old('shared_with')) && in_array('members', old('shared_with'))) ? 'checked' : '' }}>
                                <label class="form-check-label" for="shared_with_members">Members</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input @error('shared_with') is-invalid @enderror" type="checkbox" name="shared_with[]" id="shared_with_guests" value="guests" {{ (is_array(old('shared_with')) && in_array('guests', old('shared_with'))) ? 'checked' : '' }}>
                                <label class="form-check-label" for="shared_with_guests">Guests</label>
                            </div>
                            @error('shared_with')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        {{-- Status --}}
                        <div class="form-group col-md-6">
                            <label for="status">Status</label>
                            <select class="form-control @error('status') is-invalid @enderror" id="status" name="status">
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        {{-- Image --}}
                        <div class="form-group col-md-6">
                            <label for="image">Image</label>
                            <input type="file" class="form-control-file @error('image') is-invalid @enderror" id="image" name="image">
                            @error('image')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Category Image --}}
                        <div class="form-group col-md-6">
                            <label for="image_category">Category Image</label>
                            <input type="file" class="form-control-file @error('image_category') is-invalid @enderror" id="image_category" name="image_category">
                            @error('image_category')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Descriptions --}}
                        <div class="form-group col-md-6">
                            <label for="descriptions">Descriptions</label>
                            <textarea class="form-control @error('descriptions') is-invalid @enderror" id="descriptions" name="descriptions" rows="3">{{ old('descriptions') }}</textarea>
                            @error('descriptions')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        {{-- Facilities --}}
                        <div class="form-group col-md-12">
                            <label for="facilities">Facilities</label>
                            <textarea class="form-control @error('facilities') is-invalid @enderror" id="facilities" name="facilities" rows="3">{{ old('facilities') }}</textarea>
                            @error('facilities')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Create Sport</button>
                    <a href="{{ route('admin.sports.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
