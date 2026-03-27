@extends('backend.layouts.master')

@section('title', 'Shipping Policy Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Shipping Policy Management</h3>

                        <div>
                            @if($shippingPolicy)
                                <a href="{{ route('admin.shipping-policy.edit', $shippingPolicy) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-edit"></i> Edit Policy
                                </a>
                                <form action="{{ route('admin.shipping-policy.toggle-status', $shippingPolicy) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-{{ $shippingPolicy->is_active ? 'warning' : 'success' }} btn-sm">
                                        <i class="fas fa-{{ $shippingPolicy->is_active ? 'pause' : 'play' }}"></i> 
                                        {{ $shippingPolicy->is_active ? 'Deactivate' : 'Activate' }}
                                    </button>
                                </form>
                                <form action="{{ route('admin.shipping-policy.destroy', $shippingPolicy) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this shipping policy?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('admin.shipping-policy.create') }}" class="btn btn-success btn-sm">
                                    <i class="fas fa-plus"></i> Create Policy
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if($shippingPolicy)
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Hero Section</h5>
                                <table class="table table-sm">
                                    <tr><td><strong>Title:</strong></td><td>{{ $shippingPolicy->hero_title }}</td></tr>
                                    <tr><td><strong>Subtitle:</strong></td><td>{{ Str::limit($shippingPolicy->hero_subtitle, 100) }}</td></tr>
                                    <tr><td><strong>Status:</strong></td><td>
                                        <span class="badge badge-{{ $shippingPolicy->is_active ? 'success' : 'secondary' }}">
                                            {{ $shippingPolicy->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td></tr>
                                </table>
                            </div>

                            <div class="col-md-6">
                                <h5>Shipping Support</h5>
                                <table class="table table-sm">
                                    <tr><td><strong>Hotline:</strong></td><td>{{ $shippingPolicy->shipping_hotline ?: 'Not set' }}</td></tr>
                                    <tr><td><strong>Email:</strong></td><td>{{ $shippingPolicy->shipping_email ?: 'Not set' }}</td></tr>
                                    <tr><td><strong>Hours:</strong></td><td>{{ $shippingPolicy->support_hours ?: 'Not set' }}</td></tr>
                                </table>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <h5 class="text-muted mb-3">Content Sections</h5>
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
                                                <td>{{ $shippingPolicy->introduction ? Str::limit(strip_tags($shippingPolicy->introduction), 100) : '<span class="text-muted">Not set</span>' }}</td>
                                                <td>{!! $shippingPolicy->introduction ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' !!}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Current Coverage</strong></td>
                                                <td>{{ $shippingPolicy->current_coverage ? Str::limit(strip_tags($shippingPolicy->current_coverage), 100) : '<span class="text-muted">Not set</span>' }}</td>
                                                <td>{!! $shippingPolicy->current_coverage ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' !!}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Expansion Plans</strong></td>
                                                <td>{{ $shippingPolicy->expansion_plans ? Str::limit(strip_tags($shippingPolicy->expansion_plans), 100) : '<span class="text-muted">Not set</span>' }}</td>
                                                <td>{!! $shippingPolicy->expansion_plans ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' !!}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Standard Delivery Time</strong></td>
                                                <td>{{ $shippingPolicy->standard_delivery_time ? Str::limit(strip_tags($shippingPolicy->standard_delivery_time), 100) : '<span class="text-muted">Not set</span>' }}</td>
                                                <td>{!! $shippingPolicy->standard_delivery_time ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' !!}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Express Delivery Time</strong></td>
                                                <td>{{ $shippingPolicy->express_delivery_time ? Str::limit(strip_tags($shippingPolicy->express_delivery_time), 100) : '<span class="text-muted">Not set</span>' }}</td>
                                                <td>{!! $shippingPolicy->express_delivery_time ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' !!}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Scheduled Delivery</strong></td>
                                                <td>{{ $shippingPolicy->scheduled_delivery ? Str::limit(strip_tags($shippingPolicy->scheduled_delivery), 100) : '<span class="text-muted">Not set</span>' }}</td>
                                                <td>{!! $shippingPolicy->scheduled_delivery ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' !!}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Standard Delivery Rates</strong></td>
                                                <td>{{ $shippingPolicy->standard_delivery_rates ? Str::limit(strip_tags($shippingPolicy->standard_delivery_rates), 100) : '<span class="text-muted">Not set</span>' }}</td>
                                                <td>{!! $shippingPolicy->standard_delivery_rates ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' !!}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Additional Services</strong></td>
                                                <td>{{ $shippingPolicy->additional_services ? Str::limit(strip_tags($shippingPolicy->additional_services), 100) : '<span class="text-muted">Not set</span>' }}</td>
                                                <td>{!! $shippingPolicy->additional_services ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' !!}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Order Confirmation</strong></td>
                                                <td>{{ $shippingPolicy->order_confirmation ? Str::limit(strip_tags($shippingPolicy->order_confirmation), 100) : '<span class="text-muted">Not set</span>' }}</td>
                                                <td>{!! $shippingPolicy->order_confirmation ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' !!}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Quality Assurance</strong></td>
                                                <td>{{ $shippingPolicy->quality_assurance ? Str::limit(strip_tags($shippingPolicy->quality_assurance), 100) : '<span class="text-muted">Not set</span>' }}</td>
                                                <td>{!! $shippingPolicy->quality_assurance ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' !!}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Dispatch Process</strong></td>
                                                <td>{{ $shippingPolicy->dispatch_process ? Str::limit(strip_tags($shippingPolicy->dispatch_process), 100) : '<span class="text-muted">Not set</span>' }}</td>
                                                <td>{!! $shippingPolicy->dispatch_process ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' !!}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Fresh Produce Packaging</strong></td>
                                                <td>{{ $shippingPolicy->fresh_produce_packaging ? Str::limit(strip_tags($shippingPolicy->fresh_produce_packaging), 100) : '<span class="text-muted">Not set</span>' }}</td>
                                                <td>{!! $shippingPolicy->fresh_produce_packaging ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' !!}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Dairy & Perishables Packaging</strong></td>
                                                <td>{{ $shippingPolicy->dairy_perishables_packaging ? Str::limit(strip_tags($shippingPolicy->dairy_perishables_packaging), 100) : '<span class="text-muted">Not set</span>' }}</td>
                                                <td>{!! $shippingPolicy->dairy_perishables_packaging ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' !!}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Packaged Goods Packaging</strong></td>
                                                <td>{{ $shippingPolicy->packaged_goods_packaging ? Str::limit(strip_tags($shippingPolicy->packaged_goods_packaging), 100) : '<span class="text-muted">Not set</span>' }}</td>
                                                <td>{!! $shippingPolicy->packaged_goods_packaging ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' !!}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Before Delivery</strong></td>
                                                <td>{{ $shippingPolicy->before_delivery ? Str::limit(strip_tags($shippingPolicy->before_delivery), 100) : '<span class="text-muted">Not set</span>' }}</td>
                                                <td>{!! $shippingPolicy->before_delivery ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' !!}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>During Delivery</strong></td>
                                                <td>{{ $shippingPolicy->during_delivery ? Str::limit(strip_tags($shippingPolicy->during_delivery), 100) : '<span class="text-muted">Not set</span>' }}</td>
                                                <td>{!! $shippingPolicy->during_delivery ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' !!}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>After Delivery</strong></td>
                                                <td>{{ $shippingPolicy->after_delivery ? Str::limit(strip_tags($shippingPolicy->after_delivery), 100) : '<span class="text-muted">Not set</span>' }}</td>
                                                <td>{!! $shippingPolicy->after_delivery ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' !!}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Weather Conditions</strong></td>
                                                <td>{{ $shippingPolicy->weather_conditions ? Str::limit(strip_tags($shippingPolicy->weather_conditions), 100) : '<span class="text-muted">Not set</span>' }}</td>
                                                <td>{!! $shippingPolicy->weather_conditions ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' !!}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Product Unavailability</strong></td>
                                                <td>{{ $shippingPolicy->product_unavailability ? Str::limit(strip_tags($shippingPolicy->product_unavailability), 100) : '<span class="text-muted">Not set</span>' }}</td>
                                                <td>{!! $shippingPolicy->product_unavailability ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' !!}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Failed Delivery Attempts</strong></td>
                                                <td>{{ $shippingPolicy->failed_delivery_attempts ? Str::limit(strip_tags($shippingPolicy->failed_delivery_attempts), 100) : '<span class="text-muted">Not set</span>' }}</td>
                                                <td>{!! $shippingPolicy->failed_delivery_attempts ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' !!}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>International Shipping</strong></td>
                                                <td>{{ $shippingPolicy->international_shipping ? Str::limit(strip_tags($shippingPolicy->international_shipping), 100) : '<span class="text-muted">Not set</span>' }}</td>
                                                <td>{!! $shippingPolicy->international_shipping ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' !!}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Shipping Hotline</strong></td>
                                                <td>{{ $shippingPolicy->shipping_hotline ?: '<span class="text-muted">Not set</span>' }}</td>
                                                <td>{!! $shippingPolicy->shipping_hotline ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' !!}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Shipping Email</strong></td>
                                                <td>{{ $shippingPolicy->shipping_email ?: '<span class="text-muted">Not set</span>' }}</td>
                                                <td>{!! $shippingPolicy->shipping_email ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' !!}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Support Hours</strong></td>
                                                <td>{{ $shippingPolicy->support_hours ?: '<span class="text-muted">Not set</span>' }}</td>
                                                <td>{!! $shippingPolicy->support_hours ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' !!}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Live Chat</strong></td>
                                                <td>{{ $shippingPolicy->live_chat ?: '<span class="text-muted">Not set</span>' }}</td>
                                                <td>{!! $shippingPolicy->live_chat ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' !!}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <h5>Last Updated</h5>
                                <p><strong>{{ $shippingPolicy->updated_at->format('F j, Y \a\t g:i A') }}</strong></p>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-truck fa-4x text-muted mb-3"></i>
                            <h4>No Shipping Policy Found</h4>
                            <p class="text-muted">Create your first shipping policy to get started.</p>
                            <a href="{{ route('admin.shipping-policy.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Create Shipping Policy
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
