@extends('backend.layouts.master')

@section('title', 'Privacy Policy Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Privacy Policy Management</h3>

                        <div>
                            @if($privacyPolicy)
                                <a href="{{ route('admin.privacy-policy.edit', $privacyPolicy) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-edit"></i> Edit Policy
                                </a>
                                <form action="{{ route('admin.privacy-policy.toggle-status', $privacyPolicy) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-{{ $privacyPolicy->is_active ? 'warning' : 'success' }} btn-sm">
                                        <i class="fas fa-{{ $privacyPolicy->is_active ? 'pause' : 'play' }}"></i> 
                                        {{ $privacyPolicy->is_active ? 'Deactivate' : 'Activate' }}
                                    </button>
                                </form>
                                <form action="{{ route('admin.privacy-policy.destroy', $privacyPolicy) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this privacy policy?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('admin.privacy-policy.create') }}" class="btn btn-success btn-sm">
                                    <i class="fas fa-plus"></i> Create Policy
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @if($privacyPolicy)
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Hero Section</h5>
                                <table class="table table-sm">
                                    <tr><td><strong>Title:</strong></td><td>{{ $privacyPolicy->hero_title }}</td></tr>
                                    <tr><td><strong>Subtitle:</strong></td><td>{{ Str::limit($privacyPolicy->hero_subtitle, 100) }}</td></tr>
                                    <tr><td><strong>Status:</strong></td><td>
                                        <span class="badge badge-{{ $privacyPolicy->is_active ? 'success' : 'secondary' }}">
                                            {{ $privacyPolicy->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td></tr>
                                </table>
                            </div>

                            <div class="col-md-6">
                                <h5>Contact Information</h5>
                                <table class="table table-sm">
                                    <tr><td><strong>Email:</strong></td><td>{{ $privacyPolicy->contact_email }}</td></tr>
                                    <tr><td><strong>Phone:</strong></td><td>{{ $privacyPolicy->contact_phone }}</td></tr>
                                    <tr><td><strong>Address:</strong></td><td>{{ Str::limit($privacyPolicy->contact_address, 50) }}</td></tr>
                                </table>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <h5>Content Sections</h5>
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Section</th>
                                                <th>Content Preview</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><strong>Introduction</strong></td>
                                                <td>{{ $privacyPolicy->introduction ? Str::limit(strip_tags($privacyPolicy->introduction), 100) : '<span class="text-muted">Not set</span>' }}</td>
                                                <td>{{ $privacyPolicy->introduction ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Personal Information</strong></td>
                                                <td>{{ $privacyPolicy->personal_info ? Str::limit(strip_tags($privacyPolicy->personal_info), 100) : '<span class="text-muted">Not set</span>' }}</td>
                                                <td>{{ $privacyPolicy->personal_info ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Auto Collected Info</strong></td>
                                                <td>{{ $privacyPolicy->auto_collected_info ? Str::limit(strip_tags($privacyPolicy->auto_collected_info), 100) : '<span class="text-muted">Not set</span>' }}</td>
                                                <td>{{ $privacyPolicy->auto_collected_info ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Information Usage</strong></td>
                                                <td>{{ $privacyPolicy->information_usage ? Str::limit(strip_tags($privacyPolicy->information_usage), 100) : '<span class="text-muted">Not set</span>' }}</td>
                                                <td>{{ $privacyPolicy->information_usage ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Data Sharing</strong></td>
                                                <td>{{ $privacyPolicy->data_sharing ? Str::limit(strip_tags($privacyPolicy->data_sharing), 100) : '<span class="text-muted">Not set</span>' }}</td>
                                                <td>{{ $privacyPolicy->data_sharing ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Data Security</strong></td>
                                                <td>{{ $privacyPolicy->data_security ? Str::limit(strip_tags($privacyPolicy->data_security), 100) : '<span class="text-muted">Not set</span>' }}</td>
                                                <td>{{ $privacyPolicy->data_security ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Cookies & Tracking</strong></td>
                                                <td>{{ $privacyPolicy->cookies_tracking ? Str::limit(strip_tags($privacyPolicy->cookies_tracking), 100) : '<span class="text-muted">Not set</span>' }}</td>
                                                <td>{{ $privacyPolicy->cookies_tracking ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Privacy Rights</strong></td>
                                                <td>{{ $privacyPolicy->privacy_rights ? Str::limit(strip_tags($privacyPolicy->privacy_rights), 100) : '<span class="text-muted">Not set</span>' }}</td>
                                                <td>{{ $privacyPolicy->privacy_rights ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Third Party Links</strong></td>
                                                <td>{{ $privacyPolicy->third_party_links ? Str::limit(strip_tags($privacyPolicy->third_party_links), 100) : '<span class="text-muted">Not set</span>' }}</td>
                                                <td>{{ $privacyPolicy->third_party_links ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Children Privacy</strong></td>
                                                <td>{{ $privacyPolicy->children_privacy ? Str::limit(strip_tags($privacyPolicy->children_privacy), 100) : '<span class="text-muted">Not set</span>' }}</td>
                                                <td>{{ $privacyPolicy->children_privacy ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Policy Changes</strong></td>
                                                <td>{{ $privacyPolicy->policy_changes ? Str::limit(strip_tags($privacyPolicy->policy_changes), 100) : '<span class="text-muted">Not set</span>' }}</td>
                                                <td>{{ $privacyPolicy->policy_changes ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <h5>Last Updated</h5>
                                <p><strong>{{ $privacyPolicy->updated_at->format('F j, Y \a\t g:i A') }}</strong></p>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-shield-alt fa-4x text-muted mb-3"></i>
                            <h4>No Privacy Policy Found</h4>
                            <p class="text-muted">Create your first privacy policy to get started.</p>
                            <a href="{{ route('admin.privacy-policy.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Create Privacy Policy
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
