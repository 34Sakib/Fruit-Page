@extends('backend.layouts.master')

@section('title', 'Contact Information Details - ' . $contactInfo->header_title)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Contact Information Details</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.contact-info.edit', $contactInfo) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('admin.contact-info.index') }}" class="btn btn-default btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Header Information</h5>
                            <table class="table table-sm">
                                <tr>
                                    <td><strong>Title:</strong></td>
                                    <td>{{ $contactInfo->header_title }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Icon:</strong></td>
                                    <td><i class="{{ $contactInfo->header_icon }}"></i> {{ $contactInfo->header_icon }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Subtitle:</strong></td>
                                    <td>{{ $contactInfo->header_subtitle ?? '-' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5>Contact Details</h5>
                            <table class="table table-sm">
                                <tr>
                                    <td><strong>Email:</strong></td>
                                    <td>{{ $contactInfo->email ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Phone:</strong></td>
                                    <td>{{ $contactInfo->phone ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Address:</strong></td>
                                    <td>{{ $contactInfo->address ?? '-' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <h5>Service Hours</h5>
                            <table class="table table-sm">
                                <tr>
                                    <td><strong>Email Hours:</strong></td>
                                    <td>{{ $contactInfo->email_hours ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Phone Hours:</strong></td>
                                    <td>{{ $contactInfo->phone_hours ?? '-' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5>Map Information</h5>
                            <table class="table table-sm">
                                <tr>
                                    <td><strong>Map Address:</strong></td>
                                    <td>{{ $contactInfo->map_address ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Status:</strong></td>
                                    <td>
                                        @if($contactInfo->status)
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-danger">Inactive</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    @if($contactInfo->map_embed_url)
                        <div class="row mt-3">
                            <div class="col-12">
                                <h5>Map Preview</h5>
                                <div class="border p-2">
                                    {!! $contactInfo->map_embed_url !!}
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
                    <h3 class="card-title">Quick Actions</h3>
                </div>
                <div class="card-body">
                    <div class="btn-group w-100 mb-2">
                        <a href="{{ route('admin.contact-info.edit', $contactInfo) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                    </div>
                    
                    <form method="POST" action="{{ route('admin.contact-info.destroy', $contactInfo) }}?_method=DELETE" style="display: inline;">
                        @csrf
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Are you sure you want to delete this contact information?')">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Information</h3>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr>
                            <td><strong>ID:</strong></td>
                            <td>{{ $contactInfo->id }}</td>
                        </tr>
                        <tr>
                            <td><strong>Created:</strong></td>
                            <td>{{ $contactInfo->created_at->format('M d, Y h:i A') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Updated:</strong></td>
                            <td>{{ $contactInfo->updated_at->format('M d, Y h:i A') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
