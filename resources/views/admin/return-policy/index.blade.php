@extends('backend.layouts.master')

@section('title', 'Return Policy Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Return Policy Management</h3>

                        <div>
                            @if($returnPolicy)
                                <a href="{{ route('admin.return-policy.edit', $returnPolicy) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-edit"></i> Edit Policy
                                </a>
                                <form action="{{ route('admin.return-policy.toggle-status', $returnPolicy) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-{{ $returnPolicy->is_active ? 'warning' : 'success' }} btn-sm">
                                        <i class="fas fa-{{ $returnPolicy->is_active ? 'pause' : 'play' }}"></i>
                                        {{ $returnPolicy->is_active ? 'Deactivate' : 'Activate' }}
                                    </button>
                                </form>
                                <form action="{{ route('admin.return-policy.destroy', $returnPolicy) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this return policy?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('admin.return-policy.create') }}" class="btn btn-success btn-sm">
                                    <i class="fas fa-plus"></i> Create Policy
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @if($returnPolicy)
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Hero Section</h5>
                                <table class="table table-sm">
                                    <tr><td><strong>Title:</strong></td><td>{{ $returnPolicy->hero_title }}</td></tr>
                                    <tr><td><strong>Subtitle:</strong></td><td>{{ Str::limit($returnPolicy->hero_subtitle, 100) }}</td></tr>
                                    <tr><td><strong>Status:</strong></td><td>
                                        <span class="badge badge-{{ $returnPolicy->is_active ? 'success' : 'secondary' }}">
                                            {{ $returnPolicy->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td></tr>
                                </table>
                            </div>

                            <div class="col-md-6">
                                <h5>Return Support</h5>
                                <table class="table table-sm">
                                    <tr><td><strong>Hotline:</strong></td><td>{{ $returnPolicy->return_hotline ?: 'Not set' }}</td></tr>
                                    <tr><td><strong>Email:</strong></td><td>{{ $returnPolicy->return_email ?: 'Not set' }}</td></tr>
                                    <tr><td><strong>Hours:</strong></td><td>{{ $returnPolicy->support_hours ?: 'Not set' }}</td></tr>
                                    <tr><td><strong>WhatsApp:</strong></td><td>{{ $returnPolicy->whatsapp ?: 'Not set' }}</td></tr>
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
                                                <td>{{ $returnPolicy->introduction ? Str::limit(strip_tags($returnPolicy->introduction), 100) : '<span class="text-muted">Not set</span>' }}</td>
                                                <td>{!! $returnPolicy->introduction ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' !!}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Fresh Produce Eligibility</strong></td>
                                                <td>{{ $returnPolicy->fresh_produce_eligibility ? Str::limit(strip_tags($returnPolicy->fresh_produce_eligibility), 100) : '<span class="text-muted">Not set</span>' }}</td>
                                                <td>{!! $returnPolicy->fresh_produce_eligibility ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' !!}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Dairy & Perishables Eligibility</strong></td>
                                                <td>{{ $returnPolicy->dairy_perishables_eligibility ? Str::limit(strip_tags($returnPolicy->dairy_perishables_eligibility), 100) : '<span class="text-muted">Not set</span>' }}</td>
                                                <td>{!! $returnPolicy->dairy_perishables_eligibility ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' !!}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Packaged Foods Eligibility</strong></td>
                                                <td>{{ $returnPolicy->packaged_foods_eligibility ? Str::limit(strip_tags($returnPolicy->packaged_foods_eligibility), 100) : '<span class="text-muted">Not set</span>' }}</td>
                                                <td>{!! $returnPolicy->packaged_foods_eligibility ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' !!}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Non-Returnable Items</strong></td>
                                                <td>{{ $returnPolicy->non_returnable_items ? Str::limit(strip_tags($returnPolicy->non_returnable_items), 100) : '<span class="text-muted">Not set</span>' }}</td>
                                                <td>{!! $returnPolicy->non_returnable_items ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' !!}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Contact Customer Service</strong></td>
                                                <td>{{ $returnPolicy->contact_customer_service ? Str::limit(strip_tags($returnPolicy->contact_customer_service), 100) : '<span class="text-muted">Not set</span>' }}</td>
                                                <td>{!! $returnPolicy->contact_customer_service ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' !!}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Documentation Required</strong></td>
                                                <td>{{ $returnPolicy->documentation_required ? Str::limit(strip_tags($returnPolicy->documentation_required), 100) : '<span class="text-muted">Not set</span>' }}</td>
                                                <td>{!! $returnPolicy->documentation_required ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' !!}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Return Approval</strong></td>
                                                <td>{{ $returnPolicy->return_approval ? Str::limit(strip_tags($returnPolicy->return_approval), 100) : '<span class="text-muted">Not set</span>' }}</td>
                                                <td>{!! $returnPolicy->return_approval ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' !!}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Product Return Step</strong></td>
                                                <td>{{ $returnPolicy->product_return_step ? Str::limit(strip_tags($returnPolicy->product_return_step), 100) : '<span class="text-muted">Not set</span>' }}</td>
                                                <td>{!! $returnPolicy->product_return_step ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' !!}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Full Refund</strong></td>
                                                <td>{{ $returnPolicy->full_refund ? Str::limit(strip_tags($returnPolicy->full_refund), 100) : '<span class="text-muted">Not set</span>' }}</td>
                                                <td>{!! $returnPolicy->full_refund ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' !!}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Store Credit</strong></td>
                                                <td>{{ $returnPolicy->store_credit ? Str::limit(strip_tags($returnPolicy->store_credit), 100) : '<span class="text-muted">Not set</span>' }}</td>
                                                <td>{!! $returnPolicy->store_credit ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' !!}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Product Exchange</strong></td>
                                                <td>{{ $returnPolicy->product_exchange ? Str::limit(strip_tags($returnPolicy->product_exchange), 100) : '<span class="text-muted">Not set</span>' }}</td>
                                                <td>{!! $returnPolicy->product_exchange ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' !!}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Wrong Item Delivered</strong></td>
                                                <td>{{ $returnPolicy->wrong_item_delivered ? Str::limit(strip_tags($returnPolicy->wrong_item_delivered), 100) : '<span class="text-muted">Not set</span>' }}</td>
                                                <td>{!! $returnPolicy->wrong_item_delivered ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' !!}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Quality Issues</strong></td>
                                                <td>{{ $returnPolicy->quality_issues ? Str::limit(strip_tags($returnPolicy->quality_issues), 100) : '<span class="text-muted">Not set</span>' }}</td>
                                                <td>{!! $returnPolicy->quality_issues ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' !!}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Delivery Delays</strong></td>
                                                <td>{{ $returnPolicy->delivery_delays ? Str::limit(strip_tags($returnPolicy->delivery_delays), 100) : '<span class="text-muted">Not set</span>' }}</td>
                                                <td>{!! $returnPolicy->delivery_delays ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' !!}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Return Timeframes</strong></td>
                                                <td>{{ $returnPolicy->return_timeframes ? Str::limit(strip_tags($returnPolicy->return_timeframes), 100) : '<span class="text-muted">Not set</span>' }}</td>
                                                <td>{!! $returnPolicy->return_timeframes ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' !!}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Product Inspection</strong></td>
                                                <td>{{ $returnPolicy->product_inspection ? Str::limit(strip_tags($returnPolicy->product_inspection), 100) : '<span class="text-muted">Not set</span>' }}</td>
                                                <td>{!! $returnPolicy->product_inspection ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' !!}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Return Preparation</strong></td>
                                                <td>{{ $returnPolicy->return_preparation ? Str::limit(strip_tags($returnPolicy->return_preparation), 100) : '<span class="text-muted">Not set</span>' }}</td>
                                                <td>{!! $returnPolicy->return_preparation ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' !!}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Communication</strong></td>
                                                <td>{{ $returnPolicy->communication ? Str::limit(strip_tags($returnPolicy->communication), 100) : '<span class="text-muted">Not set</span>' }}</td>
                                                <td>{!! $returnPolicy->communication ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' !!}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <h5>Last Updated</h5>
                                <p><strong>{{ $returnPolicy->updated_at->format('F j, Y \a\t g:i A') }}</strong></p>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-undo fa-4x text-muted mb-3"></i>
                            <h4>No Return Policy Found</h4>
                            <p class="text-muted">Create your first return policy to get started.</p>
                            <a href="{{ route('admin.return-policy.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Create Return Policy
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
