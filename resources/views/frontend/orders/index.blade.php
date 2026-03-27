@extends('frontend.layouts.master')

@section('title', 'My Orders - FruitsPage')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4">
                <i class="fas fa-shopping-bag"></i> My Orders
            </h2>
        </div>
    </div>

    <!-- Regular Orders Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-shopping-cart"></i> Regular Orders
                    </h4>
                </div>
                <div class="card-body">
                    @if(auth()->check() && isset($orders) && $orders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Order #</th>
                                        <th>Date</th>
                                        <th>Items</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                        <tr>
                                            <td>{{ $order->order_number ?? 'N/A' }}</td>
                                            <td>{{ $order->created_at->format('M j, Y') }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @php
                                                        $firstItem = $order->items->first();
                                                        $remainingItems = $order->items->count() - 1;
                                                    @endphp
                                                    @if($firstItem && isset($firstItem->product) && $firstItem->product->image)
                                                        <img src="{{ asset('storage/' . $firstItem->product->image) }}" 
                                                             alt="{{ $firstItem->name }}" 
                                                             class="rounded me-2" 
                                                             style="width: 40px; height: 40px; object-fit: cover;">
                                                    @else
                                                        <div class="bg-light d-flex align-items-center justify-content-center rounded me-2" 
                                                             style="width: 40px; height: 40px;">
                                                            <i class="fas fa-box-open text-muted"></i>
                                                        </div>
                                                    @endif
                                                    <div>
                                                        {{ $order->items->sum('quantity') }} {{ Str::plural('item', $order->items->sum('quantity')) }}
                                                        @if($remainingItems > 0)
                                                            <div class="text-muted small">+{{ $remainingItems }} more {{ Str::plural('item', $remainingItems) }}</div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td>${{ number_format($order->total, 2) }}</td>
                                            <td>
                                                @php
                                                    $statusConfig = [
                                                        'completed' => ['color' => 'success', 'icon' => 'check-circle'],
                                                        'processing' => ['color' => 'primary', 'icon' => 'sync-alt'],
                                                        'shipped' => ['color' => 'info', 'icon' => 'truck'],
                                                        'cancelled' => ['color' => 'danger', 'icon' => 'times-circle'],
                                                        'default' => ['color' => 'secondary', 'icon' => 'clock']
                                                    ];
                                                    $status = $order->status;
                                                    $config = $statusConfig[$status] ?? $statusConfig['default'];
                                                @endphp
                                                <span class="badge bg-{{ $config['color'] }}-subtle text-{{ $config['color'] }} d-inline-flex align-items-center">
                                                    <i class="fas fa-{{ $config['icon'] }} me-1"></i>
                                                    {{ ucfirst($status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary d-flex align-items-center"
                                                        onclick="window.location.href='{{ route('orders.show', $order->id) }}'"
                                                        data-bs-toggle="tooltip" 
                                                        title="View Order Details">
                                                    <i class="fas fa-eye me-1"></i>
                                                    <span class="d-none d-md-inline">View</span>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @elseif(auth()->check())
                        <div class="text-center py-4">
                            <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No Regular Orders Yet</h5>
                            <p class="text-muted">Start shopping to see your regular orders here.</p>
                            <a href="{{ route('home') }}" class="btn btn-primary">
                                <i class="fas fa-shopping-bag"></i> Start Shopping
                            </a>
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            <strong>Login Required:</strong> Please <a href="{{ route('login') }}">login</a> or 
                            <a href="{{ route('register') }}">register</a> to view your regular orders.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Special Orders Section -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-star"></i> Special Orders
                    </h4>
                </div>
                <div class="card-body">
                    @if(auth()->check() && auth()->user()->specialOrders && auth()->user()->specialOrders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Order #</th>
                                        <th>Date</th>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(auth()->user()->specialOrders as $specialOrder)
                                        <tr>
                                            <td>{{ $specialOrder->order_number }}</td>
                                            <td>{{ $specialOrder->created_at->format('M j, Y') }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if($specialOrder->product && $specialOrder->product->image)
                                                        <img src="{{ asset('storage/' . $specialOrder->product->image) }}" 
                                                             alt="{{ $specialOrder->product->name }}" 
                                                             class="rounded me-2" 
                                                             style="width: 40px; height: 40px; object-fit: cover;">
                                                    @else
                                                        <div class="bg-light d-flex align-items-center justify-content-center rounded me-2" 
                                                             style="width: 40px; height: 40px;">
                                                            <i class="fas fa-star text-muted"></i>
                                                        </div>
                                                    @endif
                                                    <div>
                                                        @if($specialOrder->product)
                                                            {{ $specialOrder->product->name }}
                                                        @else
                                                            {{ $specialOrder->product_name ?: 'Custom Product' }}
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $specialOrder->quantity }} kg</td>
                                            <td>৳{{ number_format($specialOrder->total_price, 2) }}</td>
                                            <td>
                                                @php
                                                    $statusConfig = [
                                                        'completed' => ['color' => 'success', 'icon' => 'check-circle'],
                                                        'processing' => ['color' => 'primary', 'icon' => 'sync-alt'],
                                                        'approved' => ['color' => 'info', 'icon' => 'check'],
                                                        'pending' => ['color' => 'warning', 'icon' => 'clock'],
                                                        'rejected' => ['color' => 'danger', 'icon' => 'times-circle'],
                                                        'default' => ['color' => 'secondary', 'icon' => 'clock']
                                                    ];
                                                    $status = $specialOrder->status;
                                                    $config = $statusConfig[$status] ?? $statusConfig['default'];
                                                @endphp
                                                <span class="badge bg-{{ $config['color'] }}-subtle text-{{ $config['color'] }} d-inline-flex align-items-center">
                                                    <i class="fas fa-{{ $config['icon'] }} me-1"></i>
                                                    {{ ucfirst($status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-success d-flex align-items-center"
                                                        onclick="showSpecialOrderDetails({{ $specialOrder->id }})"
                                                        data-bs-toggle="tooltip" 
                                                        title="View Order Details">
                                                    <i class="fas fa-eye me-1"></i>
                                                    <span class="d-none d-md-inline">View</span>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @elseif(auth()->check())
                        <div class="text-center py-4">
                            <i class="fas fa-star fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No Special Orders Yet</h5>
                            <p class="text-muted">Request special products and they will appear here.</p>
                            <a href="{{ route('special-order.create') }}" class="btn btn-success">
                                <i class="fas fa-plus"></i> Request Special Order
                            </a>
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            <strong>Login Required:</strong> Please <a href="{{ route('login') }}">login</a> or 
                            <a href="{{ route('register') }}">register</a> to view your special orders and track them.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Special Order Details Modal -->
<div class="modal fade" id="specialOrderModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Special Order Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="specialOrderDetails">
                <!-- Details will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function showSpecialOrderDetails(orderId) {
    const modal = document.getElementById('specialOrderModal');
    const details = document.getElementById('specialOrderDetails');
    
    details.innerHTML = `
        <div class="text-center">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-2">Loading order details...</p>
        </div>
    `;
    
    // Load details via AJAX
    fetch(`/special-order/details/${orderId}`)
        .then(response => response.json())
        .then(data => {
            details.innerHTML = `
                <div class="row">
                    <div class="col-md-6">
                        <h6>Order Information</h6>
                        <p><strong>Order #:</strong> ${data.order_number}</p>
                        <p><strong>Date:</strong> ${data.date}</p>
                        <p><strong>Status:</strong> ${data.status}</p>
                        ${data.tracking_number ? `<p><strong>Tracking:</strong> ${data.tracking_number}</p>` : ''}
                    </div>
                    <div class="col-md-6">
                        <h6>Product Details</h6>
                        <p><strong>Product:</strong> ${data.product}</p>
                        <p><strong>Quantity:</strong> ${data.quantity} kg</p>
                        <p><strong>Total:</strong> ৳${data.total}</p>
                    </div>
                </div>
                ${data.admin_notes ? `<div class="mt-3"><h6>Notes:</h6><p>${data.admin_notes}</p></div>` : ''}
            `;
        })
        .catch(error => {
            details.innerHTML = `
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle"></i>
                    Error loading order details. Please try again.
                </div>
            `;
        });
    
    new bootstrap.Modal(modal).show();
}
</script>
@endpush
