@extends('frontend.layouts.master')

@section('title', 'Order #' . $order->order_number . ' - ' . config('app.name'))

@section('content')
<div class="py-5 bg-light">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Order #{{ $order->order_number }}</h2>
            <span class="badge bg-{{ 
                $order->status === 'completed' ? 'success' : 
                ($order->status === 'processing' ? 'primary' : 
                ($order->status === 'shipped' ? 'info' : 
                ($order->status === 'cancelled' ? 'danger' : 'secondary'))) 
            }} fs-6 py-2 px-3">
                {{ ucfirst($order->status) }}
            </span>
        </div>
        
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">

                <!-- Order Information -->
                <div class="row g-4 mb-4">
                    <div class="col-md-4">
                        <div class="bg-light p-3 rounded-3 h-100">
                            <h6 class="fw-bold mb-3"><i class="fas fa-receipt me-2"></i>Order Details</h6>
                            <div class="d-flex mb-2">
                                <span class="text-muted w-40">Order Date:</span>
                                <span class="ms-auto">{{ $order->created_at->format('M d, Y h:i A') }}</span>
                            </div>
                            @if($order->cancelled_at)
                                <div class="d-flex mb-2">
                                    <span class="text-muted w-40">Cancelled On:</span>
                                    <span class="ms-auto text-danger">{{ $order->cancelled_at->format('M d, Y') }}</span>
                                </div>
                                @if($order->cancellation_reason)
                                    <div class="d-flex mb-2">
                                        <span class="text-muted w-40">Reason:</span>
                                        <span class="ms-auto">{{ $order->cancellation_reason }}</span>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="bg-light p-3 rounded-3 h-100">
                            <h6 class="fw-bold mb-3"><i class="fas fa-truck me-2"></i>Shipping Address</h6>
                            @if($order->shippingAddress)
                                <address class="mb-0">
                                    <strong>{{ $order->shippingAddress->full_name }}</strong><br>
                                    {{ $order->shippingAddress->address_line1 }}<br>
                                    @if($order->shippingAddress->address_line2)
                                        {{ $order->shippingAddress->address_line2 }}<br>
                                    @endif
                                    {{ $order->shippingAddress->city }}, {{ $order->shippingAddress->state }}<br>
                                    {{ $order->shippingAddress->postal_code }}, {{ $order->shippingAddress->country }}<br>
                                    <i class="fas fa-phone me-1"></i> {{ $order->shippingAddress->phone }}
                                </address>
                            @else
                                <p class="text-muted mb-0">No shipping address provided</p>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="bg-light p-3 rounded-3 h-100">
                            <h6 class="fw-bold mb-3"><i class="fas fa-file-invoice-dollar me-2"></i>Billing Address</h6>
                            @if($order->billingAddress)
                                <address class="mb-0">
                                    <strong>{{ $order->billingAddress->full_name }}</strong><br>
                                    {{ $order->billingAddress->address_line1 }}<br>
                                    @if($order->billingAddress->address_line2)
                                        {{ $order->billingAddress->address_line2 }}<br>
                                    @endif
                                    {{ $order->billingAddress->city }}, {{ $order->billingAddress->state }}<br>
                                    {{ $order->billingAddress->postal_code }}, {{ $order->billingAddress->country }}<br>
                                    <i class="fas fa-phone me-1"></i> {{ $order->billingAddress->phone }}
                                </address>
                            @else
                                <p class="text-muted mb-0">No billing address provided</p>
                            @endif
                        </div>
                    </div>
                    </div>

                <!-- Order Items -->
                <div class="mt-5">
                    <h5 class="mb-4"><i class="fas fa-box-open me-2"></i>Order Items</h5>
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0" style="width: 50%">Product</th>
                                    <th class="text-end border-0">Price</th>
                                    <th class="text-center border-0">Qty</th>
                                    <th class="text-end border-0">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                    <tr class="border-top">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @php
                                                    // Try to get image from order item first, then fall back to product
                                                    $imageUrl = null;
                                                    if (!empty($item->image_url) && $item->image_url !== asset('images/default-product.png')) {
                                                        $imageUrl = $item->image_url;
                                                    } elseif (isset($item->product) && $item->product->image) {
                                                        $imageUrl = asset('storage/' . $item->product->image);
                                                    } elseif (!empty($item->options['image'] ?? null)) {
                                                        $imageUrl = $item->options['image'];
                                                    }
                                                @endphp
                                                
                                                @if($imageUrl)
                                                    <img 
                                                        src="{{ $imageUrl }}" 
                                                        alt="{{ $item->name }}" 
                                                        class="rounded me-3" 
                                                        style="width: 60px; height: 60px; object-fit: cover;"
                                                        onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';"
                                                        loading="lazy"
                                                    >
                                                @else
                                                    <div class="bg-light d-flex align-items-center justify-content-center rounded me-3" 
                                                         style="width: 60px; height: 60px;">
                                                        <i class="fas fa-box-open text-muted"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <h6 class="mb-1">{{ $item->product->name ?? 'Product #' . $item->product_id }}</h6>
                                                    @if($item->options && count($item->options) > 0)
                                                        <div class="mt-1">
                                                            @foreach($item->options as $key => $value)
                                                                <span class="badge bg-light text-dark me-1 mb-1">
                                                                    {{ ucfirst($key) }}: {{ $value }}
                                                                </span>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-end">
                                            <span class="text-nowrap">${{ number_format($item->price, 2) }}</span>
                                        </td>
                                        <td class="text-center">{{ $item->quantity }}</td>
                                        <td class="text-end">
                                            <span class="fw-bold text-nowrap">${{ number_format($item->price * $item->quantity, 2) }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-light">
                                <tr>
                                    <td colspan="4" class="p-4">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Subtotal:</span>
                                            <span>${{ number_format($order->subtotal, 2) }}</span>
                                        </div>
                                        @if($order->discount > 0)
                                            <div class="d-flex justify-content-between mb-2 text-success">
                                                <span>Discount:</span>
                                                <span>-${{ number_format($order->discount, 2) }}</span>
                                            </div>
                                        @endif
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Shipping:</span>
                                            <span>${{ number_format($order->shipping_cost, 2) }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Tax:</span>
                                            <span>${{ number_format($order->tax, 2) }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between border-top pt-2 mt-2 fw-bold fs-5">
                                            <span>Total:</span>
                                            <span>${{ number_format($order->total, 2) }}</span>
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                </div>

                <!-- Order Actions -->
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center border-top pt-4 mt-4">
                    <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary mb-3 mb-sm-0">
                        <i class="fas fa-arrow-left me-2"></i> Back to Orders
                    </a>
                    <div class="d-flex flex-column flex-sm-row gap-2">
                        @if(in_array($order->status, ['processing', 'shipped']))
                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#cancelOrder{{ $order->id }}">
                                <i class="fas fa-times me-2"></i> Cancel Order
                            </button>
                            @include('frontend.profile.partials.modals.cancel-order', ['order' => $order])
                        @endif
                        <a href="{{ route('orders.invoice', $order) }}" class="btn btn-primary">
                            <i class="fas fa-file-pdf me-2"></i> Download Invoice
                        </a>
                    </div>
                </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .badge {
        text-transform: capitalize;
        font-weight: 500;
    }
    
    .card {
        border: none;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }
    
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
    }
    
    .table th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        color: #6c757d;
    }
    
    .btn {
        border-radius: 8px;
        padding: 0.5rem 1.25rem;
        font-weight: 500;
        transition: all 0.2s ease-in-out;
    }
    
    .btn-primary {
        background-color: #4e73df;
        border-color: #4e73df;
    }
    
    .btn-primary:hover {
        background-color: #2e59d9;
        border-color: #2653d4;
    }
    
    .btn-outline-secondary {
        color: #6c757d;
        border-color: #d1d3e2;
    }
    
    .btn-outline-secondary:hover {
        background-color: #f8f9fc;
        border-color: #b7b9cc;
        color: #5a5c69;
    }
    
    .w-40 {
        width: 40%;
    }
    
    @media (max-width: 767.98px) {
        .w-40 {
            width: 100%;
            margin-bottom: 0.25rem;
        }
        
        .d-flex {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .ms-auto {
            margin-left: 0 !important;
            margin-top: 0.25rem;
        }
    }
</style>
@endpush
