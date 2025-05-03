@extends('admin.layout')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Email Templates Management</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Email Templates</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Email Templates</h3>
                <a href="{{ route('admin.email-templates.create') }}" class="btn btn-primary float-right">
                    <i class="fas fa-plus"></i> Add Email Template
                </a>
            </div>
            <div class="card-body">
                @if(isset($emailTemplates) && $emailTemplates->count())
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Type</th>
                            <th>Subject</th>
                            <th>Slug</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($emailTemplates as $template)
                        <tr>
                            <td>{{ $template->id }}</td>
                            <td>{{ $template->type }}</td>
                            <td>{{ $template->subject }}</td>
                            <td>{{ $template->slug }}</td>
                            <td>{{ ucfirst($template->status) }}</td>
                            <td>
                                <a href="{{ route('admin.email-templates.show', $template) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.email-templates.edit', $template) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.email-templates.destroy', $template) }}" method="POST" style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="alert alert-info">No email templates found</div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
