@extends('frontend.layouts.app')

@section('title', 'Track Special Order')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm">
                <div class="card-header bg-gradient text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-truck me-2"></i>Track Special Order #{{ $specialOrder->order_number }}
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
                    <!-- Order Summary -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="gradient-text mb-3">Order Summary</h6>
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        @if($specialOrder->product && $specialOrder->product->image)
                                            <img src="{{ asset('storage/' . $specialOrder->product->image) }}" 
                                                 alt="{{ $specialOrder->product->name }}" 
                                                 class="rounded me-3 shadow-sm" 
                                                 style="width: 60px; height: 60px; object-fit: cover;">
                                        @else
                                            <div class="bg-light d-flex align-items-center justify-content-center rounded me-3 shadow-sm" 
                                                 style="width: 60px; height: 60px;">
                                                <i class="fas fa-box-open text-muted"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <h6 class="mb-1 fw-semibold">
                                                {{ $specialOrder->product ? $specialOrder->product->name : $specialOrder->product_name ?: 'Custom Product' }}
                                            </h6>
                                            <small class="text-muted">{{ Str::limit($specialOrder->notes, 80) }}</small>
                                            @if($specialOrder->quantity)
                                            <br><small class="text-muted">Qty: {{ number_format($specialOrder->quantity, 2) }} kg</small>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="text-muted">Total Amount</span>
                                        <span class="h5 gradient-text">৳{{ number_format($specialOrder->total_price, 2) }}</span>
                                    </div>
                                    @if($specialOrder->final_price && $specialOrder->final_price != $specialOrder->total_price)
                                    <div class="d-flex justify-content-between mt-2 pt-2 border-top">
                                        <span class="text-muted">Final Price</span>
                                        <span class="h5 text-success">৳{{ number_format($specialOrder->final_price, 2) }}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6 class="gradient-text mb-3">Order Information</h6>
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <small class="text-muted d-block fw-semibold">Order Number</small>
                                        <span class="fw-semibold">{{ $specialOrder->order_number }}</span>
                                    </div>
                                    <div class="mb-3">
                                        <small class="text-muted d-block fw-semibold">Order Date</small>
                                        <span>{{ $specialOrder->created_at->format('F j, Y \a\t g:i A') }}</span>
                                    </div>
                                    <div class="mb-3">
                                        <small class="text-muted d-block fw-semibold">Tracking Number</small>
                                        <span class="badge bg-dark">
                                            <i class="fas fa-truck"></i> {{ $specialOrder->tracking_number }}
                                        </span>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block fw-semibold">Current Status</small>
                                        <span class="badge bg-{{ 
                                            $specialOrder->status === 'completed' ? 'success' : 
                                            ($specialOrder->status === 'processing' ? 'primary' : 
                                            ($specialOrder->status === 'rejected' ? 'danger' : 'warning')) 
                                        }}">{{ ucfirst($specialOrder->status) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tracking Timeline -->
                    <div class="row">
                        <div class="col-12">
                            <h6 class="gradient-text mb-3">Order Status Timeline</h6>
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <div class="timeline">
                                        @php
                                            $statusOrder = ['pending', 'approved', 'processing', 'shipped', 'completed'];
                                            $isRejected = $specialOrder->status === 'rejected';
                                            $currentStatusIndex = $isRejected ? count($statusOrder) - 1 : array_search($specialOrder->status, $statusOrder);
                                            if ($currentStatusIndex === false) {
                                                $currentStatusIndex = -1; // Handle case when status is not in the order
                                            }
                                        @endphp
                                        
                                        <div class="d-flex justify-content-between text-center">
                                            @foreach($statusOrder as $index => $status)
                                                @php
                                                    $isCompleted = $index < $currentStatusIndex;
                                                    $isCurrent = !$isRejected && $index === $currentStatusIndex;
                                                    $icon = match($status) {
                                                        'pending' => 'fa-clock',
                                                        'approved' => 'fa-check-circle',
                                                        'processing' => 'fa-cog',
                                                        'shipped' => 'fa-shipping-fast',
                                                        'completed' => 'fa-check-double',
                                                        default => 'fa-circle'
                                                    };
                                                    $label = match($status) {
                                                        'pending' => 'Pending',
                                                        'approved' => 'Approved',
                                                        'processing' => 'Processing',
                                                        'shipped' => 'Shipped',
                                                        'completed' => 'Completed',
                                                        default => ucfirst($status)
                                                    };
                                                @endphp
                                                <div class="timeline-step {{ $isCurrent ? 'active' : ($isCompleted ? 'completed' : 'text-muted') }} {{ $isRejected ? 'rejected' : '' }} flex-fill">
                                                    <div class="timeline-icon">
                                                        <i class="fas {{ $icon }} fa-lg"></i>
                                                    </div>
                                                    <div class="timeline-label">
                                                        <small class="fw-semibold">{{ $label }}</small>
                                                        @if($isCurrent && $specialOrder->updated_at)
                                                            <div class="small text-muted mt-1">
                                                                {{ $specialOrder->updated_at->diffForHumans() }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        
                                        <!-- Progress Bar -->
                                        <div class="progress mt-4" style="height: 8px;">
                                            <div class="progress-bar {{ $isRejected ? 'bg-danger' : 'bg-gradient' }}" 
                                                 role="progressbar" 
                                                 style="width: {{ $isRejected ? '100' : (($currentStatusIndex + 1) / count($statusOrder) * 100) }}%;" 
                                                 aria-valuenow="{{ $isRejected ? 100 : (($currentStatusIndex + 1) / count($statusOrder) * 100) }}" 
                                                 aria-valuemin="0" 
                                                 aria-valuemax="100">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Shipping Information -->
                    @if($specialOrder->canBeTracked() && ($specialOrder->shipped_at || $specialOrder->estimated_delivery))
                    <div class="row mt-4">
                        <div class="col-12">
                            <h6 class="gradient-text mb-3">Shipping Information</h6>
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <div class="row g-4">
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
                                        @if($specialOrder->delivery_address)
                                        <div class="col-md-4">
                                            <small class="text-muted d-block fw-semibold">Delivery Address</small>
                                            <span class="d-flex align-items-center mt-1">
                                                <i class="fas fa-map-marker-alt me-2 gradient-text"></i>
                                                {{ $specialOrder->delivery_address }}
                                            </span>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Admin Notes -->
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
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('special-orders.details', $specialOrder->id) }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Order Details
                        </a>
                        <a href="{{ route('profile.show') }}#special-orders" class="btn btn-primary">
                            <i class="fas fa-list me-1"></i> My Orders
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.timeline-step {
    position: relative;
    padding: 0 10px;
}

.timeline-step .timeline-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 8px;
    border: 2px solid #e9ecef;
    background: white;
    transition: all 0.3s ease;
}

.timeline-step.completed .timeline-icon {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-color: #667eea;
    color: white;
}

.timeline-step.rejected .timeline-icon,
.timeline-step.active.rejected .timeline-icon {
    background: linear-gradient(135deg, #dc3545 0%, #a71d2a 100%);
    border-color: #dc3545;
    color: white;
}

.timeline-step.completed.rejected .timeline-icon {
    background: #dc3545;
    border-color: #dc3545;
    opacity: 0.8;
}

.timeline-step.active .timeline-icon {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-color: #667eea;
    color: white;
    box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
}

.timeline-step.text-muted .timeline-icon {
    background: #f8f9fa;
    border-color: #e9ecef;
    color: #6c757d;
}

.timeline-label {
    font-size: 12px;
}
</style>
@endsection
