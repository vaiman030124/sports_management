@extends('admin.layout')

@section('title', 'Edit Notification')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Edit Notification #{{ $notification->id }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.notifications.index') }}">Notifications</a></li>
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
                <h3 class="card-title">Notification Details</h3>
            </div>
            <form action="{{ route('admin.notifications.update', $notification->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label for="title">Title *</label>
                        <input type="text" class="form-control" id="title" name="title" 
                               value="{{ old('title', $notification->title) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="type">Type *</label>
                        <select class="form-control" id="type" name="type" required>
                            <option value="email" {{ $notification->type == 'email' ? 'selected' : '' }}>Email</option>
                            <option value="sms" {{ $notification->type == 'sms' ? 'selected' : '' }}>SMS</option>
                            <option value="push" {{ $notification->type == 'push' ? 'selected' : '' }}>Push Notification</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status">Status *</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="draft" {{ $notification->status == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="scheduled" {{ $notification->status == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                            <option value="sent" {{ $notification->status == 'sent' ? 'selected' : '' }}>Sent</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="send_at">Schedule Date/Time</label>
                        <input type="datetime-local" class="form-control" id="send_at" name="send_at" 
                               value="{{ old('send_at', $notification->send_at ? $notification->send_at->format('Y-m-d\TH:i') : '') }}">
                    </div>
                    <div class="form-group">
                        <label for="content">Content *</label>
                        <textarea class="form-control" id="content" name="content" rows="8" required>{{ old('content', $notification->content) }}</textarea>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Update Notification</button>
                    <a href="{{ route('admin.notifications.index') }}" class="btn btn-default">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
