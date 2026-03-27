@extends('backend.layouts.master')

@section('title', 'View Contact - ' . $contact->name)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Contact Details</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.contacts.index') }}" class="btn btn-default btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to Contacts
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Name:</strong><br>
                            {{ $contact->name }}
                        </div>
                        <div class="col-md-6">
                            <strong>Email:</strong><br>
                            <a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Phone:</strong><br>
                            {{ $contact->phone ?: 'Not provided' }}
                        </div>
                        <div class="col-md-6">
                            <strong>Status:</strong><br>
                            {!! $contact->status_badge !!}
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            <strong>Subject:</strong><br>
                            {{ $contact->subject }}
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            <strong>Message:</strong><br>
                            <div style="background: #f8f9fa; padding: 15px; border-radius: 5px; white-space: pre-wrap;">
                                {{ $contact->message }}
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Received:</strong><br>
                            {{ $contact->created_at->format('M d, Y h:i A') }}
                        </div>
                        @if($contact->replied_at)
                        <div class="col-md-6">
                            <strong>Replied:</strong><br>
                            {{ $contact->replied_at->format('M d, Y h:i A') }}
                        </div>
                        @endif
                    </div>

                    @if($contact->admin_reply)
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            <strong>Admin Reply:</strong><br>
                            <div style="background: #d4edda; padding: 15px; border-radius: 5px; white-space: pre-wrap;">
                                {{ $contact->admin_reply }}
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Actions</h3>
                </div>
                <div class="card-body">
                    @if($contact->status !== 'replied')
                    <form method="POST" action="{{ route('admin.contacts.update', $contact) }}?_method=PUT" class="mb-3">
                        @csrf
                        <input type="hidden" name="_method" value="PUT">
                        <div class="form-group">
                            <label for="admin_reply">Reply Message:</label>
                            <textarea name="admin_reply" id="admin_reply" class="form-control" rows="5" placeholder="Type your reply here...">{{ $contact->admin_reply }}</textarea>
                        </div>
                        <div class="btn-group w-100">
                            @if($contact->status === 'pending')
                            <button type="submit" name="mark_as_read" value="1" class="btn btn-info">Mark as Read</button>
                            @endif
                            <button type="submit" name="send_reply" value="1" class="btn btn-success">Send Reply</button>
                        </div>
                    </form>
                    @endif

                    <div class="btn-group w-100">
                        <a href="{{ route('admin.contacts.edit', $contact) }}" class="btn btn-warning">Edit</a>
                        <form method="POST" action="{{ route('admin.contacts.destroy', $contact) }}?_method=DELETE" style="display: inline;">
                            @csrf
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this contact?')">Delete</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Quick Actions</h3>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        <a href="mailto:{{ $contact->email }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-envelope"></i> Send Email
                        </a>
                        @if($contact->phone)
                        <a href="tel:{{ $contact->phone }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-phone"></i> Call Customer
                        </a>
                        @endif
                        <button type="button" class="list-group-item list-group-item-action" onclick="copyToClipboard('{{ $contact->email }}')">
                            <i class="fas fa-copy"></i> Copy Email
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        alert('Email copied to clipboard!');
    });
}
</script>
@endpush
