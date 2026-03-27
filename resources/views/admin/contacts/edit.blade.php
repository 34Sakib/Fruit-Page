@extends('backend.layouts.master')

@section('title', 'Edit Contact - ' . $contact->name)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Contact</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.contacts.show', $contact) }}" class="btn btn-default btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to Contact
                        </a>
                    </div>
                </div>
                <form method="POST" action="{{ route('admin.contacts.update', $contact) }}?_method=PUT">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ $contact->name }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ $contact->email }}" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">Phone</label>
                                    <input type="text" class="form-control" id="phone" name="phone" value="{{ $contact->phone }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select class="form-control" id="status" name="status">
                                        <option value="pending" {{ $contact->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="read" {{ $contact->status === 'read' ? 'selected' : '' }}>Read</option>
                                        <option value="replied" {{ $contact->status === 'replied' ? 'selected' : '' }}>Replied</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="subject">Subject</label>
                            <input type="text" class="form-control" id="subject" name="subject" value="{{ $contact->subject }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="message">Original Message</label>
                            <textarea class="form-control" id="message" name="message" rows="6" readonly>{{ $contact->message }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="admin_reply">Admin Reply</label>
                            <textarea class="form-control" id="admin_reply" name="admin_reply" rows="6" placeholder="Type your reply here...">{{ $contact->admin_reply }}</textarea>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Contact
                        </button>
                        <a href="{{ route('admin.contacts.show', $contact) }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
