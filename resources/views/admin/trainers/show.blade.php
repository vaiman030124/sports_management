@extends('admin.layout')

@section('title', 'Trainer Details')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Trainer Details: {{ $trainer->name }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.trainers.index') }}">Trainers</a></li>
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
                <h3 class="card-title">Trainer Information</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.trainers.edit', $trainer->id) }}" class="btn btn-sm btn-info">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>ID</th>
                        <td>{{ $trainer->id }}</td>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <td>{{ $trainer->name }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $trainer->adminUser->email }}</td>
                    </tr>
                    <tr>
                        <th>Sport</th>
                        <td>{{ $trainer->trainerSport->sport_name }}</td>
                    </tr>
                    <tr>
                        <th>Is kid trainer</th>
                        <td>{{ $trainer->is_kid_trainer == 1 ? 'Yes' : 'No'}}</td>
                    </tr>
                    <tr>
                        <th>Is adult trainer</th>
                        <td>{{ $trainer->is_adult_trainer == 1 ? 'Yes' : 'No'}}</td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <td>{{ $trainer->description }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            <span class="badge badge-{{ $trainer->status == 'active' ? 'success' : 'danger' }}">
                                {{ ucfirst($trainer->status) }}
                            </span>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="card-footer">
                <a href="{{ route('admin.trainers.edit', $trainer) }}" class="btn btn-primary">
                    <i class="fas fa-edit"></i> Edit
                </a>

                <form action="{{ route('admin.trainers.destroy', $trainer) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure you want to delete this trainer?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </form>

                <a href="{{ route('admin.trainers.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to List
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
