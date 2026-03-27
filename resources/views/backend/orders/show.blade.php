@extends('backend.layouts.master')

@section('title', 'Order Details - Admin Panel')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<style>
    .order-status {
        padding: 8px 15px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
        min-width: 100px;
        text-align: center;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .status-pending { 
        background-color: #fff3cd; 
        color: #856404; 
        border-left: 4px solid #ffc107;
    }
    .status-processing { 
        background-color: #cce5ff; 
        color: #004085;
        border-left: 4px solid #007bff;
    }
    .status-completed { 
        background-color: #d4edda; 
        color: #155724;
        border-left: 4px solid #28a745;
    }
    .status-cancelled { 
        background-color: #f8d7da; 
        color: #721c24;
        border-left: 4px solid #dc3545;
    }
    .status-refunded { 
        background-color: #e2e3e5; 
        color: #383d41;
        border-left: 4px solid #6c757d;
    }
    
    .card {
        box-shadow: 0 0 15px rgba(0,0,0,0.1);
        border: none;
        border-radius: 8px;
        margin-bottom: 20px;
    }
    
    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #e3e6f0;
        padding: 1rem 1.25rem;
    }
    
    .card-title {
        margin-bottom: 0;
        font-size: 1.1rem;
        font-weight: 600;
    }
    
    .btn i {
        margin-right: 5px;
    }
    
    .product-img {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 4px;
        border: 1px solid #eaeaea;
    }
    
    .status-select {
        max-width: 200px;
        display: inline-block;
        margin-right: 10px;
    }
    
    .order-info-card {
        border-left: 4px solid #4e73df;
        background-color: #f8f9fc;
    }
    
    .info-label {
        font-weight: 600;
        color: #5a5c69;
    }
    
    .info-value {
        color: #4e73df;
    }
    
    .table th {
        background-color: #f8f9fc;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
    }
    
    .total-amount {
        font-size: 1.25rem;
        font-weight: 700;
        color: #2e59d9;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title">
                            <i class="fas fa-shopping-cart mr-2"></i>
                            Order #{{ $order->order_number }}
                            <span class="order-status status-{{ $order->status }} ml-2">
                                {{ ucfirst($order->status) }}
                            </span>
                        </h3>
                        <div>
                            <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back to Orders
                            </a>
                            <button class="btn btn-primary ml-2" onclick="window.print()">
                                <i class="fas fa-print"></i> Print
                            </button>
                        </div>
                    </div>
                </div>
                
                @include('backend.layouts.partials.messages')
                
                <div class="card-body">

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    @include('backend.layouts.partials.messages')
                </div>
            </div>
            
                    <!-- Order Status Update -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card order-info-card">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="fas fa-sync-alt mr-2"></i>
                                        Update Order Status
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('admin.orders.status.update', $order->id) }}" method="POST" id="statusForm">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-row align-items-center">
                                            <div class="col-md-4 mb-3 mb-md-0">
                                                <select name="status" id="status" class="form-control form-control-lg status-select">
                                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                                    <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                                    <option value="refunded" {{ $order->status == 'refunded' ? 'selected' : '' }}>Refunded</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" name="tracking_number" class="form-control" 
                                                       placeholder="Tracking Number (Optional)" 
                                                       value="{{ old('tracking_number', $order->tracking_number) }}">
                                            </div>
                                            <div class="col-md-2">
                                                <button type="submit" class="btn btn-primary btn-block">
                                                    <i class="fas fa-save"></i> Update
                                                </button>
                                            </div>
                                        </div>
                                        <div class="form-group mt-3">
                                            <label for="notes" class="font-weight-bold">
                                                <i class="fas fa-sticky-note mr-1"></i>
                                                Order Notes
                                            </label>
                                            <textarea name="notes" id="notes" class="form-control" 
                                                      rows="2" 
                                                      placeholder="Add any notes about this order">{{ old('notes', $order->notes) }}</textarea>
                                        </div>
                                        @if($order->status_updated_at)
                                        <div class="text-muted small mt-2">
                                            <i class="far fa-clock mr-1"></i>
                                            Last updated: {{ $order->status_updated_at->format('M d, Y h:i A') }}
                                        </div>
                                        @endif
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
            
                    <!-- Order Items -->
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="fas fa-boxes mr-2"></i>
                                        Order Items
                                    </h3>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead class="bg-light">
                                                <tr>
                                                    <th style="width: 45%;">Product</th>
                                                    <th class="text-center">Price</th>
                                                    <th class="text-center">Qty</th>
                                                    <th class="text-right">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($order->items as $item)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="mr-3" style="width: 60px; height: 60px; flex-shrink: 0;">
                                                                @if($item->image_url)
                                                                    <img 
                                                            src="{{ $item->image_url }}" 
                                                            alt="{{ $item->name }}" 
                                                            style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;"
                                                            onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';"
                                                            loading="lazy"
                                                        >
                                                    @else
                                                        <div class="bg-light d-flex align-items-center justify-content-center w-100 h-100" 
                                                             style="border: 1px solid #dee2e6; border-radius: 8px;">
                                                            <span class="text-muted small">No Image</span>
                                                        </div>
                                                    @endif
                                                </div>
                                                
                                                <div class="ml-3">
                                                    <h6 class="mb-0 font-weight-bold">{{ $item->name }}</h6>
                                                    @if($item->sku)
                                                        <small class="text-muted">SKU: {{ $item->sku }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>${{ number_format($item->price, 2) }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-right"><strong>Subtotal:</strong></td>
                                        <td>${{ number_format($order->subtotal, 2) }}</td>
                                    </tr>
                                    @if($order->shipping_cost > 0)
                                    <tr>
                                        <td colspan="3" class="text-right"><strong>Shipping:</strong></td>
                                        <td>${{ number_format($order->shipping_cost, 2) }}</td>
                                    </tr>
                                    @endif
                                    @if($order->tax > 0)
                                    <tr>
                                        <td colspan="3" class="text-right"><strong>Tax:</strong></td>
                                        <td>${{ number_format($order->tax, 2) }}</td>
                                    </tr>
                                    @endif
                                    @if($order->discount > 0)
                                    <tr>
                                        <td colspan="3" class="text-right"><strong>Discount:</strong></td>
                                        <td>-${{ number_format($order->discount, 2) }}</td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td colspan="3" class="text-right"><strong>Total:</strong></td>
                                        <td><strong>${{ number_format($order->total, 2) }}</strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                
                        </div>
                    </div>
                </div>

                <!-- Order Summary & Customer Info -->
                <div class="col-lg-4">
                    <!-- Order Summary -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-receipt mr-2"></i>
                                Order Summary
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal:</span>
                                <span class="font-weight-bold">{{ number_format($order->subtotal, 2) }} {{ config('settings.currency_symbol') }}</span>
                            </div>
                            @if($order->discount > 0)
                            <div class="d-flex justify-content-between mb-2">
                                <span>Discount:</span>
                                <span class="text-danger">-{{ number_format($order->discount, 2) }} {{ config('settings.currency_symbol') }}</span>
                            </div>
                            @endif
                            <div class="d-flex justify-content-between mb-2">
                                <span>Shipping:</span>
                                <span>{{ number_format($order->shipping_amount, 2) }} {{ config('settings.currency_symbol') }}</span>
                            </div>
                            @if($order->tax_amount > 0)
                            <div class="d-flex justify-content-between mb-2">
                                <span>Tax ({{ $order->tax_rate }}%):</span>
                                <span>{{ number_format($order->tax_amount, 2) }} {{ config('settings.currency_symbol') }}</span>
                            </div>
                            @endif
                            <hr>
                            <div class="d-flex justify-content-between mb-0">
                                <h5 class="font-weight-bold">Total:</h5>
                                <h5 class="font-weight-bold text-primary">{{ number_format($order->total, 2) }} {{ config('settings.currency_symbol') }}</h5>
                            </div>
                            @if($order->payment_method)
                            <div class="mt-3">
                                <p class="mb-1"><strong>Payment Method:</strong></p>
                                <span class="badge bg-info">
                                    <i class="fas fa-money-bill-wave mr-1"></i>
                                    Cash on Delivery
                                </span>
                                @if($order->payment_status)
                                <span class="badge {{ $order->payment_status === 'paid' ? 'bg-success' : 'bg-warning' }} ml-2">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                                @endif
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Customer Information -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-user mr-2"></i>
                                Customer Information
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-light rounded-circle p-3 mr-3">
                                    <i class="fas fa-user fa-2x text-primary"></i>
                                </div>
                                <div>
                                    <h5 class="mb-0">{{ $order->first_name }} {{ $order->last_name }}</h5>
                                    <small class="text-muted">Customer #{{ $order->user_id ?? 'Guest' }}</small>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <h6 class="font-weight-bold mb-2">
                                    <i class="fas fa-envelope mr-2 text-primary"></i>
                                    Contact Information
                                </h6>
                                <div class="pl-4">
                                    <div class="mb-1">
                                        <i class="far fa-envelope mr-2 text-muted"></i>
                                        <a href="mailto:{{ $order->email }}">{{ $order->email }}</a>
                                    </div>
                                    @if($order->phone)
                                    <div>
                                        <i class="fas fa-phone-alt mr-2 text-muted"></i>
                                        <a href="tel:{{ $order->phone }}">{{ $order->phone }}</a>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <h6 class="font-weight-bold mb-2">
                                    <i class="fas fa-map-marker-alt mr-2 text-primary"></i>
                                    Billing Address
                                </h6>
                                <div class="pl-4">
                                    <p class="mb-1">{{ $order->billing_address['address1'] ?? '' }}</p>
                                    @if(isset($order->billing_address['address2']) && $order->billing_address['address2'])
                                        <p class="mb-1">{{ $order->billing_address['address2'] }}</p>
                                    @endif
                                    <p class="mb-1">
                                        {{ $order->billing_address['city'] ?? '' }}, 
                                        {{ $order->billing_address['state'] ?? '' }} 
                                        {{ $order->billing_address['postal_code'] ?? '' }}
                                    </p>
                                    <p class="mb-0">
                                        {{ $order->billing_address['country'] ?? '' }}
                                    </p>
                                </div>
                            </div>
                            
                            @if($order->shipping_address && $order->shipping_method !== 'pickup')
                            <div class="mb-3">
                                <h6 class="font-weight-bold mb-2">
                                    <i class="fas fa-truck mr-2 text-primary"></i>
                                    Shipping Address
                                </h6>
                                <div class="pl-4">
                                    <p class="mb-1">{{ $order->shipping_address['address1'] ?? '' }}</p>
                                    @if(isset($order->shipping_address['address2']) && $order->shipping_address['address2'])
                                        <p class="mb-1">{{ $order->shipping_address['address2'] }}</p>
                                    @endif
                                    <p class="mb-1">
                                        {{ $order->shipping_address['city'] ?? '' }}, 
                                        {{ $order->shipping_address['state'] ?? '' }} 
                                        {{ $order->shipping_address['postal_code'] ?? '' }}
                                    </p>
                                    <p class="mb-1">
                                        {{ $order->shipping_address['country'] ?? '' }}
                                    </p>
                                    @if($order->shipping_phone)
                                    <p class="mb-0">
                                        <i class="fas fa-phone-alt mr-2 text-muted"></i>
                                        {{ $order->shipping_phone }}
                                    </p>
                                    @endif
                                </div>
                            </div>
                            @endif
                            
                            @if($order->shipping_method)
                            <div class="mb-3">
                                <h6 class="font-weight-bold mb-2">
                                    <i class="fas fa-shipping-fast mr-2 text-primary"></i>
                                    Shipping Method
                                </h6>
                                <div class="pl-4">
                                    <span class="badge bg-light text-dark">
                                        <i class="fas fa-{{ $order->shipping_method === 'pickup' ? 'store' : 'truck' }} mr-1"></i>
                                        {{ ucfirst($order->shipping_method) }}
                                    </span>
                                    @if($order->tracking_number)
                                    <div class="mt-2">
                                        <span class="font-weight-bold">Tracking #:</span>
                                        <span>{{ $order->tracking_number }}</span>
                                        @if($order->tracking_url)
                                        <a href="{{ $order->tracking_url }}" target="_blank" class="ml-2" title="Track Order">
                                            <i class="fas fa-external-link-alt"></i>
                                        </a>
                                        @endif
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endif
                            
                            @if($order->user)
                            <div class="mt-4 pt-3 border-top">
                                <div class="d-flex flex-wrap justify-content-center gap-2">
                                    <a href="{{ route('admin.users.show', $order->user->id) }}" class="btn btn-outline-primary">
                                        <i class="fas fa-user-circle mr-1"></i> View Customer Profile
                                    </a>
                                    <a href="mailto:{{ $order->email }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-envelope mr-1"></i> Email Customer
                                    </a>
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Order Notes -->
                    @if($order->notes || $order->staff_notes)
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="far fa-sticky-note mr-2"></i>
                                Order Notes
                            </h3>
                        </div>
                        <div class="card-body">
                            @if($order->notes)
                            <div class="mb-3">
                                <h6 class="font-weight-bold">Customer Note:</h6>
                                <div class="bg-light p-3 rounded">
                                    {{ $order->notes }}
                                </div>
                            </div>
                            @endif
                            
                            @if($order->staff_notes)
                            <div>
                                <h6 class="font-weight-bold">Staff Notes:</h6>
                                <div class="bg-light p-3 rounded">
                                    {{ $order->staff_notes }}
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif
                    
                    <!-- Shipping Address -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title">Shipping Address</h3>
                        </div>
                        <div class="card-body">
                            <address>
                                {{ $order->first_name }} {{ $order->last_name }}<br>
                                {{ $order->address }}<br>
                                {{ $order->city }}, {{ $order->state }} {{ $order->post_code }}<br>
                                {{ $order->country }}<br>
                                <i class="fas fa-phone"></i> {{ $order->phone }}
                            </address>
                        </div>
                    </div>
                    
                    <!-- Order Notes -->
                    @if($order->notes)
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Order Notes</h3>
                        </div>
                        <div class="card-body">
                            <p>{{ $order->notes }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Handle status update form submission
        $('#statusForm').on('submit', function(e) {
            e.preventDefault();
            
            $.ajax({
                url: $(this).attr('action'),
                method: 'PUT',
                data: $(this).serialize(),
                success: function(response) {
                    if (response.success) {
                        // Update the status badge
                        const status = response.order.status;
                        const statusText = status.charAt(0).toUpperCase() + status.slice(1);
                        
                        // Remove all status classes and add the new one
                        $('.order-status')
                            .removeClass('status-pending status-processing status-completed status-cancelled status-refunded')
                            .addClass('status-' + status)
                            .text(statusText);
                            
                        // Show success message
                        toastr.success('Order status updated successfully');
                    }
                },
                error: function(xhr) {
                    toastr.error('An error occurred while updating the order status');
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>
@endsection
