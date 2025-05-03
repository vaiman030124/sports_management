@extends('admin.layout')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">View Email Template</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.email-templates.index') }}">Email Templates</a></li>
                    <li class="breadcrumb-item active">View</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Email Template Details</h3>
                <a href="{{ route('admin.email-templates.edit', $emailTemplate) }}" class="btn btn-primary float-right">
                    <i class="fas fa-edit"></i> Edit
                </a>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-3">Type</dt>
                    <dd class="col-sm-9">{{ $emailTemplate->type }}</dd>

                    <dt class="col-sm-3">Subject</dt>
                    <dd class="col-sm-9">{{ $emailTemplate->subject }}</dd>
                    
                    <dt class="col-sm-3">Subject</dt>
                    <dd class="col-sm-9">{{ $emailTemplate->slug }}</dd>

                    <dt class="col-sm-3">Body</dt>
                    <dd class="col-sm-9"><pre>{{ $emailTemplate->body }}</pre></dd>

                    <dt class="col-sm-3">Variables</dt>
                    <dd class="col-sm-9"><pre>{{ json_encode($emailTemplate->variables, JSON_PRETTY_PRINT) }}</pre></dd>

                    <dt class="col-sm-3">Status</dt>
                    <dd class="col-sm-9">{{ ucfirst($emailTemplate->status) }}</dd>
                </dl>
            </div>
        </div>
    </div>
</section>
@endsection
