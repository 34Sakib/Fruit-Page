@extends('backend.layouts.master')

@section('title', 'Terms & Conditions Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Terms & Conditions Management</h3>

                        <div>
                            @if($termsConditions)
                                <a href="{{ route('admin.terms-conditions.edit', $termsConditions) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-edit"></i> Edit Content
                                </a>
                                <form action="{{ route('admin.terms-conditions.toggle-status', $termsConditions) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-{{ $termsConditions->is_active ? 'warning' : 'success' }} btn-sm">
                                        <i class="fas fa-{{ $termsConditions->is_active ? 'pause' : 'play' }}"></i> 
                                        {{ $termsConditions->is_active ? 'Deactivate' : 'Activate' }}
                                    </button>
                                </form>
                                <form action="{{ route('admin.terms-conditions.destroy', $termsConditions) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this terms and conditions?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('admin.terms-conditions.create') }}" class="btn btn-success btn-sm">
                                    <i class="fas fa-plus"></i> Create Terms & Conditions
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @if($termsConditions)
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Hero Section</h5>
                                <table class="table table-sm">
                                    <tr><td><strong>Title:</strong></td><td>{{ $termsConditions->hero_title }}</td></tr>
                                    <tr><td><strong>Subtitle:</strong></td><td>{{ Str::limit($termsConditions->hero_subtitle, 100) }}</td></tr>
                                    <tr><td><strong>Status:</strong></td><td>
                                        <span class="badge badge-{{ $termsConditions->is_active ? 'success' : 'secondary' }}">
                                            {{ $termsConditions->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td></tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h5>Contact Information</h5>
                                <table class="table table-sm">
                                    <tr><td><strong>Email:</strong></td><td>{{ $termsConditions->contact_email }}</td></tr>
                                    <tr><td><strong>Phone:</strong></td><td>{{ $termsConditions->contact_phone }}</td></tr>
                                    <tr><td><strong>Address:</strong></td><td>{{ Str::limit($termsConditions->contact_address, 50) }}</td></tr>
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
                                                <td>{{ $termsConditions->introduction ? Str::limit(strip_tags($termsConditions->introduction), 100) : '<span class="text-muted">Not set</span>' }}</td>
                                                <td>{{ $termsConditions->introduction ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Definitions</strong></td>
                                                <td>{{ $termsConditions->definitions ? Str::limit(strip_tags($termsConditions->definitions), 100) : '<span class="text-muted">Not set</span>' }}</td>
                                                <td>{{ $termsConditions->definitions ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Acceptance of Terms</strong></td>
                                                <td>{{ $termsConditions->acceptance_of_terms ? Str::limit(strip_tags($termsConditions->acceptance_of_terms), 100) : '<span class="text-muted">Not set</span>' }}</td>
                                                <td>{{ $termsConditions->acceptance_of_terms ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Registration</strong></td>
                                                <td>{{ $termsConditions->registration ? Str::limit(strip_tags($termsConditions->registration), 100) : '<span class="text-muted">Not set</span>' }}</td>
                                                <td>{{ $termsConditions->registration ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Account Termination</strong></td>
                                                <td>{{ $termsConditions->account_termination ? Str::limit(strip_tags($termsConditions->account_termination), 100) : '<span class="text-muted">Not set</span>' }}</td>
                                                <td>{{ $termsConditions->account_termination ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Product Information</strong></td>
                                                <td>{{ $termsConditions->product_information ? Str::limit(strip_tags($termsConditions->product_information), 100) : '<span class="text-muted">Not set</span>' }}</td>
                                                <td>{{ $termsConditions->product_information ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Order Processing</strong></td>
                                                <td>{{ $termsConditions->order_processing ? Str::limit(strip_tags($termsConditions->order_processing), 100) : '<span class="text-muted">Not set</span>' }}</td>
                                                <td>{{ $termsConditions->order_processing ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Pricing</strong></td>
                                                <td>{{ $termsConditions->pricing ? Str::limit(strip_tags($termsConditions->pricing), 100) : '<span class="text-muted">Not set</span>' }}</td>
                                                <td>{{ $termsConditions->pricing ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Payment Methods</strong></td>
                                                <td>{{ $termsConditions->payment_methods ? Str::limit(strip_tags($termsConditions->payment_methods), 100) : '<span class="text-muted">Not set</span>' }}</td>
                                                <td>{{ $termsConditions->payment_methods ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Delivery Areas</strong></td>
                                                <td>{{ $termsConditions->delivery_areas ? Str::limit(strip_tags($termsConditions->delivery_areas), 100) : '<span class="text-muted">Not set</span>' }}</td>
                                                <td>{{ $termsConditions->delivery_areas ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Delivery Time</strong></td>
                                                <td>{{ $termsConditions->delivery_time ? Str::limit(strip_tags($termsConditions->delivery_time), 100) : '<span class="text-muted">Not set</span>' }}</td>
                                                <td>{{ $termsConditions->delivery_time ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Delivery Charges</strong></td>
                                                <td>{{ $termsConditions->delivery_charges ? Str::limit(strip_tags($termsConditions->delivery_charges), 100) : '<span class="text-muted">Not set</span>' }}</td>
                                                <td>{{ $termsConditions->delivery_charges ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Return Policy</strong></td>
                                                <td>{{ $termsConditions->return_policy ? Str::limit(strip_tags($termsConditions->return_policy), 100) : '<span class="text-muted">Not set</span>' }}</td>
                                                <td>{{ $termsConditions->return_policy ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Refund Process</strong></td>
                                                <td>{{ $termsConditions->refund_process ? Str::limit(strip_tags($termsConditions->refund_process), 100) : '<span class="text-muted">Not set</span>' }}</td>
                                                <td>{{ $termsConditions->refund_process ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Intellectual Property</strong></td>
                                                <td>{{ $termsConditions->intellectual_property ? Str::limit(strip_tags($termsConditions->intellectual_property), 100) : '<span class="text-muted">Not set</span>' }}</td>
                                                <td>{{ $termsConditions->intellectual_property ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>User Conduct</strong></td>
                                                <td>{{ $termsConditions->user_conduct ? Str::limit(strip_tags($termsConditions->user_conduct), 100) : '<span class="text-muted">Not set</span>' }}</td>
                                                <td>{{ $termsConditions->user_conduct ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Limitation of Liability</strong></td>
                                                <td>{{ $termsConditions->limitation_of_liability ? Str::limit(strip_tags($termsConditions->limitation_of_liability), 100) : '<span class="text-muted">Not set</span>' }}</td>
                                                <td>{{ $termsConditions->limitation_of_liability ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Termination</strong></td>
                                                <td>{{ $termsConditions->termination ? Str::limit(strip_tags($termsConditions->termination), 100) : '<span class="text-muted">Not set</span>' }}</td>
                                                <td>{{ $termsConditions->termination ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Changes to Terms</strong></td>
                                                <td>{{ $termsConditions->changes_to_terms ? Str::limit(strip_tags($termsConditions->changes_to_terms), 100) : '<span class="text-muted">Not set</span>' }}</td>
                                                <td>{{ $termsConditions->changes_to_terms ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <h5>Last Updated</h5>
                                <p><strong>{{ $termsConditions->updated_at->format('F j, Y \a\t g:i A') }}</strong></p>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-file-contract fa-4x text-muted mb-3"></i>
                            <h4>No Terms & Conditions Found</h4>
                            <p class="text-muted">Create your first terms and conditions to get started.</p>
                            <a href="{{ route('admin.terms-conditions.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Create Terms & Conditions
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
