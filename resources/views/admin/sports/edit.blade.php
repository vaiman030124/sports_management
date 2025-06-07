@extends('admin.layout')

@section('content')
<style>
.position-relative.d-inline-block {
    position: relative;
    display: inline-block;
}
.remove-image-btn {
    position: absolute;
    top: 5px;
    right: 5px;
    display: none;
    z-index: 10;
    cursor: pointer;
    background-color: rgba(255, 0, 0, 0.7);
    border: none;
    color: white;
    font-weight: bold;
    border-radius: 50%;
    width: 24px;
    height: 24px;
    line-height: 20px;
    text-align: center;
    padding: 0;
}
.position-relative.d-inline-block:hover .remove-image-btn {
    display: block;
}
</style>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Edit Sport: {{ $sport->sport_name }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.sports.index') }}">Sports</a></li>
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
                <h3 class="card-title">Sport Details</h3>
            </div>
            <form action="{{ route('admin.sports.update', $sport->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="row">
                        {{-- Sport Name --}}
                        <div class="form-group col-md-6">
                            <label for="sport_name">Sport Name</label>
                            <input type="text" class="form-control @error('sport_name') is-invalid @enderror" id="sport_name" name="sport_name" value="{{ old('sport_name', $sport->sport_name) }}">
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
                                    <option value="{{ $venue->id }}" {{ old('venue_id', $sport->venue_id) == $venue->id ? 'selected' : '' }}>{{ $venue->venue_name }}</option>
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
                            <input type="text" class="form-control @error('pricing_peak') is-invalid @enderror" id="pricing_peak" name="pricing_peak" value="{{ old('pricing_peak', $sport->pricing_peak) }}">
                            @error('pricing_peak')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Pricing Non Peak --}}
                        <div class="form-group col-md-6">
                            <label for="pricing_non_peak">Pricing Non Peak</label>
                            <input type="text" class="form-control @error('pricing_non_peak') is-invalid @enderror" id="pricing_non_peak" name="pricing_non_peak" value="{{ old('pricing_non_peak', $sport->pricing_non_peak) }}">
                            @error('pricing_non_peak')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        {{-- Court Count --}}
                        <div class="form-group col-md-6">
                            <label for="court_count">Court Count</label>
                            <input type="number" class="form-control @error('court_count') is-invalid @enderror" id="court_count" name="court_count" value="{{ old('court_count', $sport->court_count) }}">
                            @error('court_count')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Shared With --}}
                        <div class="form-group col-md-6">
                            <label>Shared With</label>
                            <div class="form-check">
                                <input class="form-check-input @error('shared_with') is-invalid @enderror" type="checkbox" name="shared_with[]" id="shared_with_public" value="public" {{ (is_array(old('shared_with', $sport->shared_with)) && in_array('public', old('shared_with', $sport->shared_with))) ? 'checked' : '' }}>
                                <label class="form-check-label" for="shared_with_public">Public</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input @error('shared_with') is-invalid @enderror" type="checkbox" name="shared_with[]" id="shared_with_members" value="members" {{ (is_array(old('shared_with', $sport->shared_with)) && in_array('members', old('shared_with', $sport->shared_with))) ? 'checked' : '' }}>
                                <label class="form-check-label" for="shared_with_members">Members</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input @error('shared_with') is-invalid @enderror" type="checkbox" name="shared_with[]" id="shared_with_guests" value="guests" {{ (is_array(old('shared_with', $sport->shared_with)) && in_array('guests', old('shared_with', $sport->shared_with))) ? 'checked' : '' }}>
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
                                <option value="active" {{ old('status', $sport->status) == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $sport->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        {{-- Existing Images --}}
                        <div class="form-group col-md-12">
                            <label>Existing Images</label>
                            <div class="d-flex flex-wrap gap-2 mb-3" data-sport-id="{{ $sport->id }}">
                                @if($sport->images && count($sport->images) > 0)
                                    @foreach($sport->images as $image)
                                        <div class="position-relative d-inline-block">
                                            <img src="{{ asset('storage/' . $image) }}" alt="Sport Image" class="img-thumbnail" style="width: 120px; height: 120px; object-fit: cover;">
                                            <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1 remove-image-btn" data-image="{{ $image }}" aria-label="Remove image">
                                                &times;
                                            </button>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        {{-- Add New Images --}}
                        <div class="form-group col-md-12">
                            <label for="images">Add New Images</label>
                            <input type="file" class="form-control-file @error('images') is-invalid @enderror" id="images" name="images[]">
                            @error('images')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            @error('images.*')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Descriptions --}}
                        <div class="form-group col-md-6">
                            <label for="descriptions">Descriptions</label>
                            <textarea class="form-control @error('descriptions') is-invalid @enderror" id="descriptions" name="descriptions" rows="3">{{ old('descriptions', $sport->descriptions) }}</textarea>
                            @error('descriptions')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        {{-- Facilities --}}
                        <div class="form-group col-md-12">
                            <label for="facilities">Facilities</label>
                            <textarea class="form-control @error('facilities') is-invalid @enderror" id="facilities" name="facilities" rows="3">{{ old('facilities', $sport->facilities) }}</textarea>
                            @error('facilities')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Update Sport</button>
                    <a href="{{ route('admin.sports.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                </div>
            </form>
        </div>
    </div>
</section>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const removeButtons = document.querySelectorAll('.remove-image-btn');

    removeButtons.forEach(button => {
        button.addEventListener('click', function () {
            const image = this.getAttribute('data-image');
            if (!image) return;

            if (confirm('Are you sure you want to delete this image?')) {
                const container = this.closest('[data-sport-id]');
                if (!container) {
                    alert('Sport ID container not found');
                    return;
                }
                const sportId = container.getAttribute('data-sport-id');
                if (!sportId) {
                    alert('Sport ID not found');
                    return;
                }
                fetch(`/admin/sports/${sportId}/images`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ image: image })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to delete image');
                    }
                    return response.json();
                })
                .then(data => {
                    // Remove image container from DOM
                    this.parentElement.remove();
                    alert(data.message);
                })
                .catch(error => {
                    alert(error.message);
                });
            }
        });
    });
});
</script>
@endsection
