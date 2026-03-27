@extends('backend.layouts.master')

@section('title', 'Contact Information Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Contact Information Management</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.contact-info.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Add New Contact Info
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Header Title</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($contactInfos as $contactInfo)
                                <tr>
                                    <td>{{ $contactInfo->id }}</td>
                                    <td>{{ Str::limit($contactInfo->header_title, 50) }}</td>
                                    <td>{{ $contactInfo->email ?? '-' }}</td>
                                    <td>{{ $contactInfo->phone ?? '-' }}</td>
                                    <td>
                                        @if($contactInfo->status)
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>{{ $contactInfo->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <a href="{{ route('admin.contact-info.edit', $contactInfo) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('admin.contact-info.show', $contactInfo) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin.contact-info.destroy', $contactInfo) }}?_method=DELETE" style="display: inline;">
                                            @csrf
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No contact information found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{ $contactInfos->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
