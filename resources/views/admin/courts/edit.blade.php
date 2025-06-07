@extends('admin.layout')

@section('title', 'Edit Court')

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
            <form action="{{ route('admin.courts.update', $court->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="name">Court Name</label>
                            <input type="text" class="form-control @error('court_name') is-invalid @enderror" id="court_name" name="court_name" placeholder="Enter Court name" required  value="{{ old('court_name', $court->court_name) }}">
                            @error('court_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-6">
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
                    </div>
                    <div class="col-sm-6">
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
                    </div>
                    <div class="col-sm-6">
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
                </div>                                                        
                <div class="row mt-3">
                    {{-- Existing Images --}}
                    <div class="form-group col-md-12">
                        <label>Existing Images</label>
                        <div class="d-flex flex-wrap gap-2 mb-3" data-court-id="{{ $court->id }}">
                            @if($court->images && count($court->images) > 0)
                                @foreach($court->images as $image)
                                    <div class="position-relative d-inline-block">
                                        <img src="{{ asset('storage/' . $image) }}" alt="Court Image" class="img-thumbnail" style="width: 120px; height: 120px; object-fit: cover;">
                                        <button type="button" class="btn btn-danger btn-sm remove-image-btn" data-image="{{ $image }}" aria-label="Remove image">
                                            &times;
                                        </button>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    {{-- Add New Images --}}
                    <div class="form-group col-md-12">
                        <label for="images">Add New Images</label>
                        <input type="file" class="form-control-file @error('images') is-invalid @enderror" id="images" name="images[]" multiple>
                        @error('images')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        @error('images.*')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div class="form-group col-md-6 mt-3">
                        <label for="description">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $court->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
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
<script>
document.addEventListener('DOMContentLoaded', function () {
    const removeButtons = document.querySelectorAll('.remove-image-btn');

    removeButtons.forEach(button => {
        button.addEventListener('click', function () {
            const image = this.getAttribute('data-image');
            if (!image) return;

            if (confirm('Are you sure you want to delete this image?')) {
                const container = this.closest('[data-court-id]');
                if (!container) {
                    alert('Court ID container not found');
                    return;
                }
                const courtId = container.getAttribute('data-court-id');
                if (!courtId) {
                    alert('Court ID not found');
                    return;
                }
                fetch(`/admin/courts/${courtId}/images`, {
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
