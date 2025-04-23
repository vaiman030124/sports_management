@extends('admin.layout')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Venue: {{ $venue->venue_name }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.venues.index') }}">Venues</a></li>
                    <li class="breadcrumb-item active">Details</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Venue Details</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.venues.edit', $venue->id) }}" class="btn btn-sm btn-info">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                </div>
            </div>
            <div class="card-body">
                <p><strong>Venue Name:</strong> {{ $venue->venue_name }}</p>
                <p><strong>Location:</strong> {{ $venue->location }}</p>
                <p><strong>Description:</strong> {{ $venue->description }}</p>
                <p><strong>Capacity:</strong> {{ $venue->capacity }}</p>
                <p><strong>Status:</strong> {{ ucfirst($venue->status) }}</p>
                @if($venue->images && count($venue->images) > 0)
                    <div class="mb-3">
                        <strong>Images:</strong>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($venue->images as $image)
                                <img src="{{ asset('storage/' . $image) }}" alt="Venue Image" class="img-thumbnail" style="width: 120px; height: 120px; object-fit: cover;">
                            @endforeach
                        </div>
                    </div>
                @endif
                <div class="mt-3">
                    <a href="{{ route('admin.venues.edit', $venue->id) }}" class="btn btn-info">Edit Venue</a>
                    <form action="{{ route('admin.venues.destroy', $venue->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this venue?');">Delete Venue</button>
                    </form>

                    <a href="{{ route('admin.venues.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
