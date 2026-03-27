@extends('frontend.layouts.master')

@section('content')
<div class="container py-5">

    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">

            <div class="card shadow-lg border-0 overflow-hidden">
                
                <!-- Header -->
                <div class="card-header bg-gradient-primary text-white py-4 position-relative">
                    <div class="position-absolute top-0 end-0 w-50 h-100 bg-gradient-secondary opacity-50"></div>
                    <h4 class="mb-0 fw-bold"><i class="fas fa-shipping-fast me-2"></i>Order Tracking</h4>
                    <p class="mb-0 mt-1 opacity-75">Track your order in real-time</p>
                </div>

                <div class="card-body p-4">

                    @if(isset($order))

                        <!-- Order Info Box -->
                        <div class="card border-0 shadow-sm mb-4 bg-gradient-light">
                            <div class="card-body p-4">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <h5 class="fw-bold text-dark mb-2">Order #{{ $order->order_number }}</h5>
                                        <div class="d-flex flex-wrap gap-3">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-calendar-alt text-primary me-2"></i>
                                                <span class="text-muted">{{ $order->created_at->format('F d, Y') }}</span>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-receipt text-primary me-2"></i>
                                                <span class="text-muted">{{ number_format($order->grand_total, 2) }} Tk</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                                        @php
                                            $statusToShow = strtolower($order->status) === 'completed' ? 'delivered' : $order->status;
                                        @endphp
                                        <span class="badge fs-6 px-3 py-2 
                                            @if($statusToShow == 'delivered') bg-gradient-success
                                            @elseif($statusToShow == 'shipped') bg-gradient-info
                                            @elseif($statusToShow == 'processing') bg-gradient-warning
                                            @else bg-gradient-secondary @endif
                                        ">
                                            <i class="fas 
                                                @if($statusToShow == 'delivered') fa-check-circle
                                                @elseif($statusToShow == 'shipped') fa-shipping-fast
                                                @elseif($statusToShow == 'processing') fa-cog
                                                @else fa-clock @endif
                                            me-1"></i>
                                            {{ ucfirst($statusToShow) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Progress Bar -->
                        @php
                            $statuses = ['pending', 'processing', 'shipped', 'delivered'];
                            $displayStatus = strtolower($order->status) === 'completed' ? 'delivered' : strtolower($order->status);
                            $currentStatus = array_search($displayStatus, array_map('strtolower', $statuses));
                            $progress = $currentStatus !== false ? (($currentStatus + 1) / count($statuses)) * 100 : 25;
                        @endphp

                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body p-4">
                                <h6 class="fw-semibold text-dark mb-3">Delivery Progress</h6>
                                <div class="progress mb-3" style="height: 12px; border-radius: 10px; background: #f1f3f4;">
                                    <div 
                                        class="progress-bar progress-bar-striped progress-bar-animated bg-gradient-primary"
                                        role="progressbar"
                                        style="width: {{ $progress }}%; border-radius: 10px;"
                                        aria-valuenow="{{ $progress }}"
                                        aria-valuemin="0"
                                        aria-valuemax="100"
                                    >
                                    </div>
                                </div>
                                <div class="text-center">
                                    <small class="text-muted">{{ number_format($progress, 0) }}% Complete</small>
                                </div>
                            </div>
                        </div>

                        <!-- Status Steps -->
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4">
                                <h6 class="fw-semibold text-dark mb-4">Delivery Timeline</h6>
                                <div class="row text-center position-relative">
                                    <!-- Connection Line -->
                                    <div class="position-absolute top-50 start-0 end-0" style="height: 3px; background: linear-gradient(90deg, #28a745 0%, #28a745 {{ $progress }}%, #e9ecef {{ $progress }}%, #e9ecef 100%); z-index: 1;"></div>
                                    
                                    @foreach($statuses as $status)
                                        <div class="col position-relative" style="z-index: 2;">
                                            <div class="status-step 
                                                {{ $loop->index <= $currentStatus ? 'text-success' : 'text-muted' }}"
                                            >
                                                <div class="step-icon mb-3 mx-auto 
                                                    {{ $loop->index <= $currentStatus ? 'bg-gradient-success text-white shadow-success' : 'bg-light text-muted shadow-sm' }}
                                                ">
                                                    <i class="fas 
                                                        @if($loop->index <= $currentStatus) fa-check
                                                        @elseif($loop->index == $currentStatus + 1) fa-spinner fa-pulse
                                                        @else fa-circle @endif
                                                    "></i>
                                                </div>

                                                <p class="fw-semibold mb-1">{{ ucfirst($status) }}</p>
                                                @if($loop->index <= $currentStatus)
                                                    <small class="text-success">
                                                        <i class="fas fa-check me-1"></i>Completed
                                                    </small>
                                                @elseif($loop->index == $currentStatus + 1)
                                                    <small class="text-primary">
                                                        <i class="fas fa-clock me-1"></i>In Progress
                                                    </small>
                                                @else
                                                    <small class="text-muted">
                                                        <i class="fas fa-clock me-1"></i>Pending
                                                    </small>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                    @else
                        <!-- No Order Found -->
                        <div class="card border-0 shadow-sm bg-gradient-warning text-dark">
                            <div class="card-body text-center p-5">
                                <div class="mb-3">
                                    <i class="fas fa-exclamation-triangle fa-3x opacity-50"></i>
                                </div>
                                <h5 class="fw-bold mb-2">Order Not Found</h5>
                                <p class="mb-0 opacity-75">No order found with the provided tracking information.</p>
                            </div>
                        </div>
                    @endif

                    <!-- Back Button -->
                    <div class="text-center mt-4">
                        <a href="{{ route('orders.index') }}" class="btn btn-primary px-4 py-2 shadow-sm">
                            <i class="fas fa-arrow-left me-2"></i> Back to Orders
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>

</div>
@endsection

@push('styles')
<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    }
    
    .bg-gradient-secondary {
        background: linear-gradient(135deg, #868e96 0%, #495057 100%) !important;
    }
    
    .bg-gradient-success {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%) !important;
    }
    
    .bg-gradient-info {
        background: linear-gradient(135deg, #17a2b8 0%, #6f42c1 100%) !important;
    }
    
    .bg-gradient-warning {
        background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%) !important;
    }
    
    .bg-gradient-light {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%) !important;
    }

    .status-step .step-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        margin: auto;
        transition: all 0.3s ease;
        border: 3px solid white;
        position: relative;
    }

    .status-step .step-icon.shadow-success {
        box-shadow: 0 0.5rem 1rem rgba(40, 167, 69, 0.3) !important;
    }

    .status-step .step-icon:not(.shadow-success) {
        box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.1) !important;
    }

    .status-step p {
        font-size: 14px;
        margin-top: 8px;
        font-weight: 600;
    }

    .status-step:hover .step-icon {
        transform: scale(1.1);
        transition: all 0.3s ease;
    }

    .progress-bar {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    }

    .card {
        border-radius: 1rem !important;
    }

    .card-header {
        border-radius: 1rem 1rem 0 0 !important;
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 0.75rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1rem rgba(102, 126, 234, 0.3);
    }

    .badge {
        border-radius: 0.75rem;
        font-weight: 600;
    }

    .bg-gradient-warning {
        background: linear-gradient(135deg, rgba(255, 193, 7, 0.1) 0%, rgba(253, 126, 20, 0.1) 100%) !important;
        border: 1px solid rgba(255, 193, 7, 0.2);
    }
</style>
@endpush