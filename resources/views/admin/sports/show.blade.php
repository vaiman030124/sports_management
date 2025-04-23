@extends('admin.layout')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Sport: {{ $sport->sport_name }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.sports.index') }}">Sports</a></li>
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
                <h3 class="card-title">Sport Details</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.sports.edit', $sport->id) }}" class="btn btn-sm btn-info">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                </div>
            </div>
            <div class="card-body">
                <p><strong>Sport Name:</strong> {{ $sport->sport_name }}</p>
                <p><strong>Venue:</strong> {{ $sport->venue ? $sport->venue->venue_name : '' }}</p>
                <p><strong>Court Count:</strong> {{ $sport->court_count }}</p>
                <p><strong>Shared With:</strong> 
                    @if(is_array($sport->shared_with))
                        {{ implode(', ', $sport->shared_with) }}
                    @else
                        {{ $sport->shared_with }}
                    @endif
                </p>
                <p><strong>Pricing Peak:</strong> {{ $sport->pricing_peak }}</p>
                <p><strong>Pricing Non Peak:</strong> {{ $sport->pricing_non_peak }}</p>
                <p><strong>Status:</strong> {{ ucfirst($sport->status) }}</p>
            </div>
            <div class="card-footer">
                <a href="{{ route('admin.sports.edit', $sport->id) }}" class="btn btn-info">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <form action="{{ route('admin.sports.destroy', $sport->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this sport?');">Delete Sport</button>
                </form>
                <a href="{{ route('admin.sports.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to List
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
