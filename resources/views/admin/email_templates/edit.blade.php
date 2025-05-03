@extends('admin.layout')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Edit Email Template</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.email-templates.index') }}">Email Templates</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <form action="{{ route('admin.email-templates.update', $emailTemplate) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="type">Type</label>
                        <input type="text" name="type" id="type" class="form-control" value="{{ old('type', $emailTemplate->type) }}" required>
                        @error('type')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="subject">Subject</label>
                        <input type="text" name="subject" id="subject" class="form-control" value="{{ old('subject', $emailTemplate->subject) }}" required>
                        @error('subject')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="slug">Slug</label>
                        <input type="text" name="slug" id="slug" readonly class="form-control" value="{{ old('slug', $emailTemplate->slug )}}" required>
                        @error('slug')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <small class="form-text text-muted">Unique identifier for the template, used in URLs.</small>
                    </div>
                    <div class="form-group">
                        <label for="body">Body</label>
                        <textarea name="body" id="body" class="form-control" rows="10" required>{{ old('body', $emailTemplate->body) }}</textarea>
                        @error('body')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <small class="form-text text-muted">You can use Blade syntax for variables, e.g. {{ '{' }}{ $variable }}.</small>
                    </div>
                    <div class="form-group">
                        <label for="variables">Variables (JSON format)</label>
                        <textarea name="variables" id="variables" class="form-control" rows="3">{{ old('variables', json_encode($emailTemplate->variables)) }}</textarea>
                        @error('variables')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <small class="form-text text-muted">Example: {"name": "User Name", "resetUrl": "Reset Link"}</small>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="active" {{ old('status', $emailTemplate->status) == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $emailTemplate->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('admin.email-templates.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary float-right">Update</button>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection
