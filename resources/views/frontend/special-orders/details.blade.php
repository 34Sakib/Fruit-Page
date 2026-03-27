@extends('frontend.layouts.app')

@section('title', 'Special Order Details')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm">
                <div class="card-header bg-gradient text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-star me-2"></i>Special Order #{{ $specialOrder->order_number }}
                        </h5>
                        <div>
                            <span class="badge bg-{{ 
                                $specialOrder->status === 'completed' ? 'success' : 
                                ($specialOrder->status === 'processing' ? 'primary' : 
                                ($specialOrder->status === 'rejected' ? 'danger' : 'warning')) 
                            }} text-uppercase fs-6">{{ $specialOrder->status }}</span>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="gradient-text mb-3">Order Information</h6>
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <tbody>
                                        <tr>
                                            <td class="fw-semibold">Order Number:</td>
                                            <td>{{ $specialOrder->order_number }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold">Order Date:</td>
                                            <td>{{ $specialOrder->created_at->format('F j, Y \a\t g:i A') }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold">Status:</td>
                                            <td>
                                                <span class="badge bg-{{ 
                                                    $specialOrder->status === 'completed' ? 'success' : 
                                                    ($specialOrder->status === 'processing' ? 'primary' : 
                                                    ($specialOrder->status === 'rejected' ? 'danger' : 'warning')) 
                                                }}">{{ ucfirst($specialOrder->status) }}</span>
                                            </td>
                                        </tr>
                                        @if($specialOrder->tracking_number)
                                        <tr>
                                            <td class="fw-semibold">Tracking Number:</td>
                                            <td>
                                                <span class="badge bg-dark">
                                                    <i class="fas fa-truck"></i> {{ $specialOrder->tracking_number }}
                                                </span>
                                            </td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6 class="gradient-text mb-3">Product Details</h6>
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        @if($specialOrder->product && $specialOrder->product->image)
                                            <img src="{{ asset('storage/' . $specialOrder->product->image) }}" 
                                                 alt="{{ $specialOrder->product->name }}" 
                                                 class="rounded me-3 shadow-sm" 
                                                 style="width: 80px; height: 80px; object-fit: cover;">
                                        @else
                                            <div class="bg-light d-flex align-items-center justify-content-center rounded me-3 shadow-sm" 
                                                 style="width: 80px; height: 80px;">
                                                <i class="fas fa-box-open text-muted fa-2x"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <h6 class="mb-1 fw-semibold">
                                                {{ $specialOrder->product ? $specialOrder->product->name : $specialOrder->product_name ?: 'Custom Product' }}
                                            </h6>
                                            @if($specialOrder->category)
                                                <small class="text-muted">Category: {{ $specialOrder->category->name }}</small>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <span class="text-muted">Order Details:</span>
                                        <div class="mt-1 p-2 bg-light rounded">
                                            {{ $specialOrder->notes }}
                                        </div>
                                    </div>
                                    @if($specialOrder->quantity)
                                    <div class="mb-2">
                                        <span class="text-muted">Final Quantity:</span>
                                        <span class="fw-semibold">{{ number_format($specialOrder->quantity, 2) }} kg</span>
                                    </div>
                                    @endif
                                    <div class="mb-2">
                                        <span class="text-muted">Total Price:</span>
                                        <span class="h5 gradient-text">৳{{ number_format($specialOrder->total_price, 2) }}</span>
                                    </div>
                                    @if($specialOrder->final_price && $specialOrder->final_price != $specialOrder->total_price)
                                    <div class="mt-3 pt-3 border-top">
                                        <span class="text-muted">Final Price (After Negotiation):</span>
                                        <span class="h5 text-success">৳{{ number_format($specialOrder->final_price, 2) }}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    @if($specialOrder->admin_notes)
                    <div class="row mt-4">
                        <div class="col-12">
                            <h6 class="gradient-text mb-3">Admin Notes</h6>
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <p class="mb-0">{{ $specialOrder->admin_notes }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    <div class="row mt-4">
                        <div class="col-12">
                            <h6 class="gradient-text mb-3">Customer Information</h6>
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p class="mb-2">
                                                <span class="text-muted">Name:</span>
                                                <span class="fw-semibold">{{ $specialOrder->name }}</span>
                                            </p>
                                            <p class="mb-2">
                                                <span class="text-muted">Email:</span>
                                                <span class="fw-semibold">{{ $specialOrder->email }}</span>
                                            </p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="mb-2">
                                                <span class="text-muted">Phone:</span>
                                                <span class="fw-semibold">{{ $specialOrder->phone }}</span>
                                            </p>
                                            <p class="mb-2">
                                                <span class="text-muted">Address:</span>
                                                <span class="fw-semibold">{{ $specialOrder->address }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    @if($specialOrder->canBeTracked())
                    <div class="row mt-4">
                        <div class="col-12">
                            <h6 class="gradient-text mb-3">Tracking Information</h6>
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <small class="text-muted d-block fw-semibold">Tracking Number</small>
                                            <span class="d-flex align-items-center mt-1">
                                                <i class="fas fa-truck me-2 gradient-text"></i>
                                                {{ $specialOrder->tracking_number }}
                                            </span>
                                        </div>
                                        @if($specialOrder->shipped_at)
                                        <div class="col-md-4">
                                            <small class="text-muted d-block fw-semibold">Shipped On</small>
                                            <span class="d-flex align-items-center mt-1">
                                                <i class="fas fa-calendar-alt me-2 gradient-text"></i>
                                                {{ $specialOrder->shipped_at->format('M d, Y') }}
                                            </span>
                                        </div>
                                        @endif
                                        @if($specialOrder->estimated_delivery)
                                        <div class="col-md-4">
                                            <small class="text-muted d-block fw-semibold">Estimated Delivery</small>
                                            <span class="d-flex align-items-center mt-1">
                                                <i class="fas fa-shipping-fast me-2 gradient-text"></i>
                                                {{ $specialOrder->estimated_delivery->format('M d, Y') }}
                                            </span>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('profile.show') }}#special-orders" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Back to Orders
                        </a>
                        @if($specialOrder->canBeTracked())
                            <a href="{{ route('special-orders.track', $specialOrder->id) }}" class="btn btn-primary">
                                <i class="fas fa-truck me-1"></i> Track Order
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
