@extends('frontend.layouts.master')

@section('title', 'My Profile - ' . config('app.name'))

@section('content')

@push('styles')
<style>
    body {
        background: linear-gradient(135deg, #f8f9fc 0%, #eef2f7 100%);
        min-height: 100vh;
    }

    .profile-container {
        background: transparent;
    }

    .card {
        border: none;
        border-radius: 1rem;
        box-shadow: 0 0.5rem 2rem 0 rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        background: linear-gradient(135deg, #ffffff 0%, #fafbfe 100%);
        overflow: hidden;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 1rem 3rem 0 rgba(0, 0, 0, 0.12);
    }

    .card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #667eea, #764ba2, #f093fb, #f5576c);
    }

    .card-header {
        background: linear-gradient(135deg, #ffffff 0%, #f8f9ff 100%) !important;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        padding: 1.5rem 2rem;
        border-radius: 1rem 1rem 0 0 !important;
    }

    .nav-pills .nav-link {
        color: #6c757d;
        border-radius: 0.75rem;
        padding: 1rem 1.25rem;
        margin-bottom: 0.75rem;
        transition: all 0.3s ease;
        border: 1px solid transparent;
        background: linear-gradient(135deg, #ffffff 0%, #f8f9ff 100%);
        position: relative;
        overflow: hidden;
    }

    .nav-pills .nav-link::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
        transition: left 0.5s;
    }

    .nav-pills .nav-link:hover::before {
        left: 100%;
    }

    .nav-pills .nav-link:hover {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-color: #667eea;
        transform: translateX(5px);
        box-shadow: 0 0.5rem 1.5rem rgba(102, 126, 234, 0.3);
    }

    .nav-pills .nav-link.active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-color: #667eea;
        box-shadow: 0 0.5rem 1.5rem rgba(102, 126, 234, 0.4);
        transform: translateX(5px);
    }

    .avatar-xxl {
        width: 140px;
        height: 140px;
        border: 4px solid #fff;
        box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.1);
    }

    .order-card {
        border: 1px solid rgba(0, 0, 0, 0.08);
        border-radius: 1rem;
        transition: all 0.3s ease;
        background: linear-gradient(135deg, #ffffff 0%, #fafbfe 100%);
        overflow: hidden;
        position: relative;
    }

    .order-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, #667eea, #764ba2);
    }

    .order-card:hover {
        border-color: #667eea;
        transform: translateY(-3px);
        box-shadow: 0 1rem 2.5rem rgba(102, 126, 234, 0.15);
    }

    .badge {
        font-weight: 600;
        padding: 0.5em 1em;
        border-radius: 0.5rem;
        font-size: 0.75rem;
    }

    .btn {
        border-radius: 0.75rem;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        box-shadow: 0 0.25rem 0.75rem rgba(102, 126, 234, 0.4);
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1.5rem rgba(102, 126, 234, 0.5);
    }

    .btn-outline-primary {
        border: 2px solid #667eea;
        color: #667eea;
        background: transparent;
    }

    .btn-outline-primary:hover {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1.5rem rgba(102, 126, 234, 0.3);
    }

    /* Status indicators */
    .status-badge {
        font-size: 0.8rem;
        padding: 0.5em 1em;
        border-radius: 0.5rem;
        font-weight: 600;
    }

    .status-processing {
        background: linear-gradient(135deg, rgba(54, 185, 204, 0.15) 0%, rgba(54, 185, 204, 0.05) 100%);
        color: #36b9cc;
        border: 1px solid rgba(54, 185, 204, 0.2);
    }

    .status-shipped {
        background: linear-gradient(135deg, rgba(28, 200, 138, 0.15) 0%, rgba(28, 200, 138, 0.05) 100%);
        color: #1cc88a;
        border: 1px solid rgba(28, 200, 138, 0.2);
    }

    .status-completed {
        background: linear-gradient(135deg, rgba(28, 200, 138, 0.15) 0%, rgba(28, 200, 138, 0.05) 100%);
        color: #1cc88a;
        border: 1px solid rgba(28, 200, 138, 0.2);
    }

    .status-cancelled {
        background: linear-gradient(135deg, rgba(231, 74, 59, 0.15) 0%, rgba(231, 74, 59, 0.05) 100%);
        color: #e74a3b;
        border: 1px solid rgba(231, 74, 59, 0.2);
    }

    /* Progress bar */
    .progress {
        height: 0.75rem;
        border-radius: 1rem;
        background: rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .progress-bar {
        background: linear-gradient(90deg, #667eea, #764ba2);
        border-radius: 1rem;
        transition: width 0.6s ease;
    }

    /* Form controls */
    .form-control {
        border-radius: 0.75rem;
        border: 1px solid #e3e6f0;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
        background: linear-gradient(135deg, #ffffff 0%, #fafbfe 100%);
    }

    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.25);
        background: linear-gradient(135deg, #ffffff 0%, #f8f9ff 100%);
        transform: translateY(-1px);
    }

    .input-group-text {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
        border-radius: 0.75rem 0 0 0.75rem;
    }

    /* Modal enhancements */
    .modal-content {
        border-radius: 1rem;
        border: none;
        box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.15);
        background: linear-gradient(135deg, #ffffff 0%, #fafbfe 100%);
    }

    .modal-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 1rem 1rem 0 0;
        border: none;
        padding: 1.5rem 2rem;
    }

    .modal-footer {
        border-top: 1px solid rgba(0, 0, 0, 0.05);
        border-radius: 0 0 1rem 1rem;
        padding: 1.5rem 2rem;
    }

    /* Alert enhancements */
    .alert {
        border-radius: 1rem;
        border: none;
        padding: 1rem 1.5rem;
    }

    .alert-info {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.05) 100%);
        color: #667eea;
        border-left: 4px solid #667eea;
    }

    /* Floating animation */
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }

    .floating {
        animation: float 3s ease-in-out infinite;
    }

    /* Gradient text */
    .gradient-text {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .card-body {
            padding: 1.25rem;
        }
        
        .nav-pills {
            flex-direction: row !important;
            flex-wrap: nowrap;
            overflow-x: auto;
            padding-bottom: 1rem;
            scrollbar-width: none;
        }
        
        .nav-pills::-webkit-scrollbar {
            display: none;
        }
        
        .nav-pills .nav-link {
            white-space: nowrap;
            margin-right: 0.5rem;
            margin-bottom: 0;
            min-width: 120px;
        }

        .avatar-xxl {
            width: 100px;
            height: 100px;
        }
    }

    /* Status steps */
    .status-step {
        transition: all 0.3s ease;
    }

    .status-step.active {
        color: #667eea;
        transform: scale(1.1);
    }

    .status-step.completed {
        color: #1cc88a;
    }

    /* Address card enhancements */
    .address-card {
        transition: all 0.3s ease;
        border: 2px solid transparent;
        background: linear-gradient(135deg, #ffffff 0%, #fafbfe 100%);
    }

    .address-card:hover {
        border-color: #667eea;
        transform: translateY(-3px);
        box-shadow: 0 1rem 2rem rgba(102, 126, 234, 0.1);
    }

    .address-card.default {
        border-color: #667eea;
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.02) 100%);
    }

    /* Search and filter enhancements */
    .input-group {
        border-radius: 0.75rem;
        overflow: hidden;
        box-shadow: 0 0.25rem 0.75rem rgba(0, 0, 0, 0.1);
    }

    .input-group .form-control {
        border: none;
        box-shadow: none;
    }

    .input-group .btn {
        border-radius: 0 0.75rem 0.75rem 0;
    }

    /* Timeline styles for modals */
    .timeline-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 8px;
        border: 2px solid #e9ecef;
        background: white;
    }

    .timeline-icon.completed {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-color: #667eea;
        color: white;
    }

    .timeline-icon.text-muted {
        background: #f8f9fa;
        border-color: #e9ecef;
        color: #6c757d;
    }

    /* Fix header badges to look identical - override Bootstrap positioning */
    .header-icons .position-absolute.top-0.start-100.translate-middle {
        position: absolute !important;
        top: -8px !important;
        right: -8px !important;
        transform: none !important;
        left: auto !important;
    }

    #mobile-cart-count,
    .wishlist-count-badge {
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
        font-size: 10px !important;
        min-width: 18px !important;
        height: 18px !important;
        line-height: 18px !important;
        text-align: center !important;
        padding: 0 4px !important;
        border-radius: 50% !important;
        background-color: #dc3545 !important;
        color: white !important;
        font-weight: bold !important;
        border: 1px solid #fff !important;
        box-shadow: 0 1px 3px rgba(0,0,0,0.3) !important;
        z-index: 1000 !important;
    }
</style>
@endpush

<div class="container py-5 profile-container">
    <div class="row g-4">
        <!-- Sidebar -->
        <div class="col-lg-3">
            <div class="card h-100 floating">
                <div class="card-body text-center p-4">
                    <div class="position-relative d-inline-block mb-4">
                        <div class="avatar-xxl rounded-circle overflow-hidden">
                            <img src="{{ $user->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=667eea&color=fff&size=200' }}" 
                                 alt="{{ $user->name }}" 
                                 class="w-100 h-100 object-fit-cover"
                                 style="object-fit: cover;">
                        </div>
                        <span class="position-absolute bottom-0 end-0 bg-success rounded-circle p-2 border border-3 border-white shadow">
                            <i class="fas fa-check text-white"></i>
                        </span>
                    </div>
                    <h4 class="mb-1 fw-bold gradient-text">{{ $user->name }}</h4>
                    <p class="text-muted mb-2">{{ $user->email }}</p>
                    <span class="badge bg-primary bg-opacity-10 text-primary mb-3 px-3 py-2">
                        <i class="fas fa-star me-1"></i> Premium Member
                    </span>
                    <p class="text-muted small mb-4">
                        <i class="far fa-calendar-alt me-1"></i> Member since {{ $user->created_at->format('F Y') }}
                    </p>
                    
                    <div class="d-grid gap-2">
                        <ul class="nav nav-pills flex-column" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active w-100 text-start" id="profile-tab" data-bs-toggle="pill" data-bs-target="#profile" type="button" role="tab">
                                    <i class="fas fa-user-circle me-2"></i> My Profile
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link w-100 text-start" id="orders-tab" data-bs-toggle="pill" data-bs-target="#orders" type="button" role="tab">
                                    <i class="fas fa-shopping-bag me-2"></i> My Orders
                                    <span class="badge bg-primary rounded-pill ms-auto">{{ $orders->count() ?? 0 }}</span>
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link w-100 text-start" id="special-orders-tab" data-bs-toggle="pill" data-bs-target="#special-orders" type="button" role="tab">
                                    <i class="fas fa-star me-2"></i> Special Orders
                                    <span class="badge bg-success rounded-pill ms-auto">{{ auth()->user()->specialOrders->count() ?? 0 }}</span>
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link w-100 text-start" id="addresses-tab" data-bs-toggle="pill" data-bs-target="#addresses" type="button" role="tab">
                                    <i class="fas fa-map-marker-alt me-2"></i> My Addresses
                                    <span class="badge bg-primary rounded-pill ms-auto">{{ $addresses->count() ?? 0 }}</span>
                                </button>
                            </li>
                            <li class="nav-item mt-4 pt-2 border-top">
                                <a class="nav-link text-danger w-100 text-start" href="{{ route('logout') }}" 
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt me-2"></i> Sign Out
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-lg-9">
            <div class="tab-content">
                <!-- Profile Tab -->
                <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 gradient-text">
                                <i class="fas fa-user-circle me-2"></i>Profile Information
                            </h5>
                            <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                                <i class="fas fa-edit me-1"></i> Edit Profile
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-8 mx-auto">
                                    <div class="alert alert-info mb-4">
                                        <i class="fas fa-info-circle me-2"></i>
                                        Keep your profile information up to date to ensure smooth shopping experience.
                                    </div>
                                    
                                    <form action="{{ route('profile.update') }}" method="POST" class="needs-validation" novalidate>
                                        @csrf
                                        @method('PATCH')
                                        
                                        <div class="mb-4">
                                            <label class="form-label fw-semibold text-dark mb-2">Full Name</label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="fas fa-user"></i>
                                                </span>
                                                <input type="text" class="form-control" value="{{ $user->name }}" disabled>
                                            </div>
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label class="form-label fw-semibold text-dark mb-2">Email Address</label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="fas fa-envelope"></i>
                                                </span>
                                                <input type="email" class="form-control" value="{{ $user->email }}" disabled>
                                            </div>
                                        </div>
                                        
                                        <div class="d-flex justify-content-between align-items-center mt-5 pt-4 border-top">
                                            <div>
                                                <h6 class="mb-1 gradient-text">Account Security</h6>
                                                <p class="small text-muted mb-0">Last updated {{ $user->updated_at->diffForHumans() }}</p>
                                            </div>
                                            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                                                <i class="fas fa-shield-alt me-1"></i> Change Password
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Orders Tab -->
                <div class="tab-pane fade" id="orders" role="tabpanel" aria-labelledby="orders-tab">
                    <div class="card">
                        <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                            <div class="mb-3 mb-md-0">
                                <h5 class="mb-0 gradient-text">
                                    <i class="fas fa-shopping-bag me-2"></i>My Orders
                                </h5>
                                <p class="text-muted small mb-0 mt-1">View and manage your order history</p>
                            </div>
                            <div class="d-flex">
                                <div class="input-group input-group-sm" style="width: 280px;">
                                    <span class="input-group-text bg-transparent border-end-0">
                                        <i class="fas fa-search text-muted"></i>
                                    </span>
                                    <input type="text" class="form-control border-start-0" placeholder="Search orders...">
                                    <button class="btn btn-outline-secondary" type="button">
                                        <i class="fas fa-filter"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            @if(isset($orders) && $orders->count() > 0)
                                @foreach($orders as $order)
                                <div class="order-card mb-4 p-0 overflow-hidden">
                                    <div class="card-header bg-light d-flex flex-column flex-md-row justify-content-between align-items-md-center p-4">
                                        <div class="mb-2 mb-md-0">
                                            <div class="d-flex align-items-center flex-wrap gap-2">
                                                <h6 class="mb-0 fw-bold me-3">Order #{{ $order->order_number ?? 'N/A' }}</h6>
                                                @php
                                                    $statusClass = [
                                                        'processing' => 'status-processing',
                                                        'shipped' => 'status-shipped',
                                                        'completed' => 'status-completed',
                                                        'cancelled' => 'status-cancelled'
                                                    ][$order->status] ?? 'bg-secondary';
                                                @endphp
                                                <span class="badge status-badge {{ $statusClass }}">
                                                    <i class="fas {{ 
                                                        $order->status === 'processing' ? 'fa-sync-alt' : 
                                                        ($order->status === 'shipped' ? 'fa-truck' : 
                                                        ($order->status === 'completed' ? 'fa-check-circle' : 'fa-times-circle')) 
                                                    }} me-1"></i>
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </div>
                                            <div class="mt-2">
                                                <small class="text-muted">
                                                    <i class="far fa-calendar-alt me-1"></i> 
                                                    Placed on {{ $order->created_at ? $order->created_at->format('M d, Y') : 'N/A' }}
                                                </small>
                                                @if($order->tracking_number)
                                                    <small class="text-muted ms-3">
                                                        <i class="fas fa-truck me-1"></i> 
                                                        {{ $order->tracking_number }}
                                                    </small>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center mt-2 mt-md-0">
                                            <span class="fw-bold me-2">Total:</span>
                                            <span class="h5 mb-0 gradient-text">${{ number_format($order->total, 2) }}</span>
                                        </div>
                                    </div>
                                    <div class="card-body p-4">
                                        @if(isset($order->items) && $order->items->count() > 0)
                                            @foreach($order->items as $item)
                                                <div class="d-flex align-items-center mb-3 p-3 rounded-3" style="background: rgba(0,0,0,0.02);">
                                                    @php
                                                        $imageUrl = null;
                                                        if (!empty($item->image_url) && $item->image_url !== asset('images/default-product.png')) {
                                                            $imageUrl = $item->image_url;
                                                        } elseif (isset($item->product) && $item->product->image) {
                                                            $imageUrl = asset('storage/' . $item->product->image);
                                                        } elseif (!empty($item->options['image'] ?? null)) {
                                                            $imageUrl = $item->options['image'];
                                                        }
                                                        $productName = $item->product->name ?? 'Product #' . $item->product_id;
                                                    @endphp
                                                    
                                                    @if($imageUrl)
                                                        <img 
                                                            src="{{ $imageUrl }}" 
                                                            alt="{{ $productName }}" 
                                                            class="rounded me-3 shadow-sm" 
                                                            style="width: 70px; height: 70px; object-fit: cover;"
                                                            onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';"
                                                            loading="lazy"
                                                        >
                                                    @else
                                                        <div class="bg-light d-flex align-items-center justify-content-center rounded me-3 shadow-sm" 
                                                             style="width: 70px; height: 70px;">
                                                            <i class="fas fa-box-open text-muted fa-lg"></i>
                                                        </div>
                                                    @endif
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-1 fw-semibold">{{ $productName }}</h6>
                                                        <small class="text-muted">Qty: {{ $item->quantity ?? 0 }} × ${{ isset($item->price) ? number_format($item->price, 2) : '0.00' }}</small>
                                                    </div>
                                                    <div class="text-end">
                                                        <div class="fw-bold h6 gradient-text">${{ number_format($item->price * $item->quantity, 2) }}</div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                        
                                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mt-4 pt-4 border-top">
                                            <div class="d-flex gap-2 mb-3 mb-md-0">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#orderDetails{{ $order->id }}">
                                                        <i class="fas fa-eye me-1"></i> View Details
                                                    </button>
                                                    <button type="button" class="btn btn-outline-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <span class="visually-hidden">Toggle Dropdown</span>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a class="dropdown-item" href="{{ route('orders.track', $order->id) }}">
                                                                <i class="fas fa-truck me-2"></i> Track Order
                                                            </a>
                                                        </li>
                                                        @if($order->status === 'shipped' && $order->tracking_url)
                                                        <li>
                                                            <a class="dropdown-item" href="{{ $order->tracking_url }}" target="_blank">
                                                                <i class="fas fa-external-link-alt me-2"></i> Track on Carrier
                                                            </a>
                                                        </li>
                                                        @endif
                                                        @if(in_array($order->status, ['processing', 'shipped']))
                                                        <li><hr class="dropdown-divider"></li>
                                                        <li>
                                                            <a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#cancelOrder{{ $order->id }}">
                                                                <i class="fas fa-times-circle me-2"></i> Cancel Order
                                                            </a>
                                                        </li>
                                                        @endif
                                                        @if($order->status === 'completed' && $order->can_return)
                                                        <li>
                                                            <a class="dropdown-item text-warning" href="#" data-bs-toggle="modal" data-bs-target="#returnOrder{{ $order->id }}">
                                                                <i class="fas fa-undo me-2"></i> Request Return
                                                            </a>
                                                        </li>
                                                        @endif
                                                        <li><hr class="dropdown-divider"></li>
                                                        <li>
                                                            <a class="dropdown-item" href="{{ route('orders.support') }}?order={{ $order->order_number ?? '' }}">
                                                                <i class="fas fa-headset me-2"></i> Contact Support
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                @if($order->status === 'shipped' && $order->tracking_url)
                                                <a href="{{ $order->tracking_url }}" target="_blank" class="btn btn-outline-secondary" title="Track on Carrier">
                                                    <i class="fas fa-truck"></i>
                                                </a>
                                                @endif
                                            </div>
                                            <div class="text-end">
                                                @if(isset($order->shipping_cost) && $order->shipping_cost > 0)
                                                    <div class="text-muted small">Delivery: ${{ number_format($order->shipping_cost, 2) }}</div>
                                                @endif
                                                <div class="text-muted small">Total Amount</div>
                                                <div class="fw-bold h5 gradient-text">${{ number_format($order->total, 2) }}</div>
                                            </div>
                                        </div>
                                        
                                        <div class="mt-4">
                                            @php
                                                $progress = [
                                                    'processing' => 25,
                                                    'shipped' => 50,
                                                    'out_for_delivery' => 75,
                                                    'completed' => 100,
                                                    'cancelled' => 0
                                                ][$order->status] ?? 0;
                                                
                                                $statusOrder = ['pending', 'processing', 'shipped', 'delivered', 'completed', 'cancelled', 'refunded'];
                                            @endphp
                                            
                                            <div class="progress mb-3">
                                                <div class="progress-bar {{ $order->status === 'cancelled' ? 'bg-danger' : '' }}" 
                                                     role="progressbar" 
                                                     style="width: {{ $progress }}%;" 
                                                     aria-valuenow="{{ $progress }}" 
                                                     aria-valuemin="0" 
                                                     aria-valuemax="100">
                                                </div>
                                            </div>
                                            
                                            <div class="d-flex justify-content-between text-center">
                                                @foreach($statusOrder as $status)
                                                    @php
                                                        $isCompleted = array_search($status, $statusOrder) < array_search($order->status, $statusOrder);
                                                        $isCurrent = $status === $order->status;
                                                        $icon = match($status) {
                                                            'pending' => 'fa-clock',
                                                            'processing' => 'fa-cog',
                                                            'shipped' => 'fa-shipping-fast',
                                                            'delivered' => 'fa-truck',
                                                            'completed' => 'fa-check-circle',
                                                            'cancelled' => 'fa-times-circle',
                                                            'refunded' => 'fa-undo',
                                                            default => 'fa-circle'
                                                        };
                                                    @endphp
                                                    <div class="status-step {{ $isCurrent ? 'active' : ($isCompleted ? 'completed' : 'text-muted') }} flex-fill">
                                                        <i class="fas {{ $icon }} d-block mb-2 fa-lg"></i>
                                                        <small class="fw-semibold">{{ ucfirst($status) }}</small>
                                                        @if($isCurrent && $order->status_updated_at)
                                                            <div class="small text-muted mt-1">
                                                                {{ $order->status_updated_at->diffForHumans() }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                            
                                            @if($order->status === 'shipped' && $order->shipped_at)
                                                <div class="mt-4 p-4 rounded-3" style="background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.02) 100%);">
                                                    <div class="row g-4">
                                                        <div class="col-md-4">
                                                            <small class="text-muted d-block fw-semibold">Shipped On</small>
                                                            <span class="d-flex align-items-center mt-1">
                                                                <i class="fas fa-calendar-alt me-2 gradient-text"></i>
                                                                {{ $order->shipped_at->format('M d, Y') }}
                                                            </span>
                                                        </div>
                                                        @if($order->estimated_delivery)
                                                        <div class="col-md-4">
                                                            <small class="text-muted d-block fw-semibold">Estimated Delivery</small>
                                                            <span class="d-flex align-items-center mt-1">
                                                                <i class="fas fa-shipping-fast me-2 gradient-text"></i>
                                                                {{ $order->estimated_delivery->format('M d, Y') }}
                                                            </span>
                                                        </div>
                                                        @endif
                                                        @if(isset($order->delivery_agent) && is_array($order->delivery_agent) && !empty($order->delivery_agent['name']))
                                                        <div class="col-md-4">
                                                            <small class="text-muted d-block fw-semibold">Delivery Agent</small>
                                                            <div class="d-flex align-items-center mt-1">
                                                                <i class="fas fa-user-tie me-2 gradient-text"></i>
                                                                <div>
                                                                    <div class="fw-semibold">{{ $order->delivery_agent['name'] }}</div>
                                                                    @if(isset($order->delivery_agent['contact']))
                                                                    <small class="text-muted">{{ $order->delivery_agent['contact'] }}</small>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <div class="text-center py-5">
                                    <div class="mb-4">
                                        <i class="fas fa-shopping-bag fa-4x gradient-text"></i>
                                    </div>
                                    <h4 class="gradient-text mb-3">No orders yet</h4>
                                    <p class="text-muted mb-4">You haven't placed any orders yet.</p>
                                    <a href="{{ route('special.page', 'fruits') }}" class="btn btn-primary btn-lg">
                                        <i class="fas fa-shopping-cart me-2"></i> Start Shopping
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Special Orders Tab -->
                <div class="tab-pane fade" id="special-orders" role="tabpanel" aria-labelledby="special-orders-tab">
                    <div class="card">
                        <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                            <div class="mb-3 mb-md-0">
                                <h5 class="mb-0 gradient-text">
                                    <i class="fas fa-star me-2"></i>My Special Orders
                                </h5>
                                <p class="text-muted small mb-0 mt-1">View and track your special order requests</p>
                            </div>
                            <div class="d-flex">
                                <div class="input-group input-group-sm" style="width: 280px;">
                                    <span class="input-group-text bg-transparent border-end-0">
                                        <i class="fas fa-search text-muted"></i>
                                    </span>
                                    <input type="text" class="form-control border-start-0" placeholder="Search special orders...">
                                    <button class="btn btn-outline-secondary" type="button">
                                        <i class="fas fa-filter"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            @if(auth()->user()->specialOrders && auth()->user()->specialOrders->count() > 0)
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
                                                <th>Tracking</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach(auth()->user()->specialOrders as $specialOrder)
                                                <tr>
                                                    <td>{{ $specialOrder->order_number }}</td>
                                                    <td>{{ $specialOrder->created_at->format('M j, Y') }}</td>
                                                    <td>
                                                        @if($specialOrder->product)
                                                            {{ $specialOrder->product->name }}
                                                        @else
                                                            {{ $specialOrder->product_name ?: 'Custom Product' }}
                                                        @endif
                                                    </td>
                                                    <td>{{ $specialOrder->quantity }} kg</td>
                                                    <td>৳{{ number_format($specialOrder->total_price, 2) }}</td>
                                                    <td>
                                                        @switch($specialOrder->status)
                                                            @case('pending')
                                                                <span class="badge bg-warning">Pending</span>
                                                                @break
                                                            @case('approved')
                                                                <span class="badge bg-success">Approved</span>
                                                                @break
                                                            @case('rejected')
                                                                <span class="badge bg-danger">Rejected</span>
                                                                @break
                                                            @case('processing')
                                                                <span class="badge bg-info">Processing</span>
                                                                @break
                                                            @case('completed')
                                                                <span class="badge bg-primary">Completed</span>
                                                                @break
                                                            @default
                                                                <span class="badge bg-secondary">{{ $specialOrder->status }}</span>
                                                        @endswitch
                                                    </td>
                                                    <td>
                                                        @if($specialOrder->canBeTracked())
                                                            <span class="badge bg-dark">
                                                                <i class="fas fa-truck"></i> {{ $specialOrder->tracking_number }}
                                                            </span>
                                                        @else
                                                            <span class="text-muted">Not Available</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-sm btn-outline-success" onclick="showSpecialOrderDetailsModal({{ $specialOrder->id }})">
                                                            <i class="fas fa-eye"></i> View
                                                        </button>
                                                        @if($specialOrder->canBeTracked())
                                                            <button class="btn btn-sm btn-outline-primary ms-2" onclick="showSpecialOrderTrackModal({{ $specialOrder->id }})">
                                                                <i class="fas fa-truck me-1"></i> Track
                                                            </button>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <div class="mb-4">
                                        <i class="fas fa-star fa-4x gradient-text"></i>
                                    </div>
                                    <h4 class="gradient-text mb-3">No Special Orders Yet</h4>
                                    <p class="text-muted mb-4">You haven't requested any special products yet.</p>
                                    <a href="{{ route('special-order.create') }}" class="btn btn-success btn-lg">
                                        <i class="fas fa-plus me-2"></i> Request Special Order
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Addresses Tab -->
                <div class="tab-pane fade" id="addresses" role="tabpanel" aria-labelledby="addresses-tab">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 gradient-text">My Addresses</h5>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAddressModal">
                                <i class="fas fa-plus me-1"></i> Add New Address
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @if(isset($addresses) && $addresses->count() > 0)
                                    @foreach($addresses as $address)
                                        <div class="col-md-6 mb-4">
                                            <div class="card h-100 address-card {{ $address->is_default ? 'default' : '' }}">
                                                <div class="card-body p-4">
                                                    @if($address->is_default)
                                                        <span class="badge bg-primary mb-3">Default Address</span>
                                                    @endif
                                                    <h6 class="card-title fw-bold mb-3 gradient-text">{{ $address->first_name }} {{ $address->last_name }}</h6>
                                                    <p class="card-text mb-2">
                                                        <i class="fas fa-map-marker-alt me-2 text-muted"></i>
                                                        {{ $address->address_line1 }}
                                                    </p>
                                                    @if($address->address_line2)
                                                        <p class="card-text mb-2 text-muted">{{ $address->address_line2 }}</p>
                                                    @endif
                                                    <p class="card-text mb-2">
                                                        <i class="fas fa-city me-2 text-muted"></i>
                                                        {{ $address->city }}, {{ $address->state }} {{ $address->postal_code }}
                                                    </p>
                                                    <p class="card-text mb-3">
                                                        <i class="fas fa-phone-alt me-2 text-muted"></i> 
                                                        <span class="fw-semibold">{{ $address->phone }}</span>
                                                    </p>
                                                    <div class="mt-4 pt-3 border-top">
                                                        <button class="btn btn-outline-primary btn-sm me-2" 
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#editAddressModal{{ $address->id }}">
                                                            <i class="fas fa-edit me-1"></i> Edit
                                                        </button>
                                                        <form action="{{ route('addresses.destroy', $address->id) }}" 
                                                              method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-outline-danger btn-sm" 
                                                                    onclick="return confirm('Are you sure you want to delete this address?')">
                                                                <i class="fas fa-trash me-1"></i> Delete
                                                            </button>
                                                        </form>
                                                        @if(!$address->is_default)
                                                            <form action="{{ route('addresses.set-default', $address->id) }}" 
                                                                  method="POST" class="d-inline ms-2">
                                                                @csrf
                                                                <button type="submit" class="btn btn-outline-secondary btn-sm">
                                                                    Set as Default
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="col-12 text-center py-5">
                                        <div class="mb-4">
                                            <i class="fas fa-map-marker-alt fa-4x gradient-text"></i>
                                        </div>
                                        <h4 class="gradient-text mb-3">No saved addresses</h4>
                                        <p class="text-muted mb-4">You haven't added any addresses yet.</p>
                                        <button class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#addAddressModal">
                                            <i class="fas fa-plus me-2"></i> Add Address
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Special Order Tracking Modal -->
<div class="modal fade" id="specialOrderTrackModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Track Special Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="specialOrderTrack">
                <!-- Tracking info will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Special Order Details Modal -->
<div class="modal fade" id="specialOrderDetailsModal" tabindex="-1">
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

<!-- Edit Profile Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editProfileForm" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf
                @method('PATCH')
                <div class="modal-header">
                    <h5 class="modal-title text-white">Edit Profile</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-4">
                        <label for="name" class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', $user->name) }}" 
                               required minlength="3" maxlength="255"
                               @if($errors->has('name')) autofocus @endif>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="email" class="form-label fw-semibold">Email Address</label>
                        <input type="email" id="email" name="email" class="form-control" value="{{ $user->email }}" disabled>
                        <input type="hidden" name="email" value="{{ $user->email }}">
                        <small class="text-muted">Contact support to change your email address.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="saveProfileBtn">
                        <span class="d-flex align-items-center">
                            <span class="spinner-border spinner-border-sm me-2 d-none" role="status" aria-hidden="true"></span>
                            <span>Save Changes</span>
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="changePasswordForm" action="{{ route('password.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title text-white">Change Password</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Current Password</label>
                        <input type="password" class="form-control" name="current_password" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold">New Password</label>
                        <input type="password" class="form-control" name="password" required>
                        <small class="text-muted">Minimum 8 characters</small>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Confirm New Password</label>
                        <input type="password" class="form-control" name="password_confirmation" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Password</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Address Modal -->
<div class="modal fade" id="addAddressModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-white">Add New Address</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('addresses.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">First Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="first_name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Last Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="last_name" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Phone Number <span class="text-danger">*</span></label>
                        <input type="tel" class="form-control" name="phone" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Company (Optional)</label>
                        <input type="text" class="form-control" name="company">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Address Line 1 <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="address_line1" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Address Line 2 (Optional)</label>
                        <input type="text" class="form-control" name="address_line2">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">City <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="city" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">State/Province <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="state" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Postal Code <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="postal_code" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Country <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="country" value="Bangladesh" required>
                        </div>
                    </div>
                    <div class="form-check mt-4">
                        <input type="hidden" name="is_default" value="0">
                        <input class="form-check-input" type="checkbox" name="is_default" id="defaultAddress" value="1">
                        <label class="form-check-label fw-semibold" for="defaultAddress">
                            Set as default address
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Address</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Address Modals -->
@foreach($user->addresses as $address)
<div class="modal fade" id="editAddressModal{{ $address->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-white">Edit Address</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('addresses.update', $address->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">First Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="first_name" value="{{ $address->first_name }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Last Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="last_name" value="{{ $address->last_name }}" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Phone Number <span class="text-danger">*</span></label>
                        <input type="tel" class="form-control" name="phone" value="{{ $address->phone }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Company (Optional)</label>
                        <input type="text" class="form-control" name="company" value="{{ $address->company ?? '' }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Address Line 1 <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="address_line1" value="{{ $address->address_line1 }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Address Line 2 (Optional)</label>
                        <input type="text" class="form-control" name="address_line2" value="{{ $address->address_line2 }}">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">City <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="city" value="{{ $address->city }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">State/Province <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="state" value="{{ $address->state }}" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Postal Code <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="postal_code" value="{{ $address->postal_code }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Country <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="country" value="{{ $address->country }}" required>
                        </div>
                    </div>
                    <div class="form-check mt-4">
                        <input type="hidden" name="is_default" value="0">
                        <input class="form-check-input" type="checkbox" name="is_default" id="defaultAddress{{ $address->id }}" 
                               value="1" {{ $address->is_default ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold" for="defaultAddress{{ $address->id }}">
                            Set as default address
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Address</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

@foreach($orders ?? [] as $order)
<!-- Order Details Modal -->
<div class="modal fade" id="orderDetails{{ $order->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-white">Order #{{ $order->order_number ?? 'N/A' }}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="gradient-text mb-3">Order Summary</h6>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <tbody>
                                    @foreach($order->items ?? [] as $item)
                                    <tr>
                                        <td class="p-2">
                                            <div class="d-flex align-items-center">
                                                @php
                                                    $imageUrl = null;
                                                    if (!empty($item->image_url) && $item->image_url !== asset('images/default-product.png')) {
                                                        $imageUrl = $item->image_url;
                                                    } elseif (isset($item->product) && $item->product->image) {
                                                        $imageUrl = asset('storage/' . $item->product->image);
                                                    } elseif (!empty($item->options['image'] ?? null)) {
                                                        $imageUrl = $item->options['image'];
                                                    }
                                                    $productName = $item->product->name ?? 'Product #' . $item->product_id;
                                                @endphp
                                                
                                                @if($imageUrl)
                                                    <img 
                                                        src="{{ $imageUrl }}" 
                                                        alt="{{ $productName }}" 
                                                        class="rounded me-3 shadow-sm" 
                                                        style="width: 60px; height: 60px; object-fit: cover;"
                                                        onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';"
                                                        loading="lazy"
                                                    >
                                                @else
                                                    <div class="bg-light d-flex align-items-center justify-content-center rounded me-3 shadow-sm" 
                                                         style="width: 60px; height: 60px;">
                                                        <i class="fas fa-box-open text-muted"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <div class="fw-semibold">{{ $productName }}</div>
                                                    <small class="text-muted">Qty: {{ $item->quantity ?? 0 }} × ${{ isset($item->price) ? number_format($item->price, 2) : '0.00' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-end p-2 fw-semibold gradient-text">${{ isset($item->price) && isset($item->quantity) ? number_format($item->price * $item->quantity, 2) : '0.00' }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6 class="gradient-text mb-3">Order Information</h6>
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <div class="mb-3">
                                    <h6 class="mb-2 fw-semibold">Order Status</h6>
                                    <span class="badge bg-{{ 
                                        $order->status === 'completed' ? 'success' : 
                                        ($order->status === 'processing' ? 'primary' : 
                                        ($order->status === 'cancelled' ? 'danger' : 'warning')) 
                                    }} text-uppercase">{{ $order->status ?? 'N/A' }}</span>
                                </div>
                                <div class="mb-3">
                                    <h6 class="mb-2 fw-semibold">Order Date</h6>
                                    <p class="mb-0">{{ $order->created_at ? $order->created_at->format('F j, Y \a\t g:i A') : 'N/A' }}</p>
                                </div>
                                @if(isset($order->shipping_cost) && $order->shipping_cost > 0)
                                <div class="mb-2">
                                    <div class="d-flex justify-content-between">
                                        <span class="text-muted">Subtotal:</span>
                                        <span>${{ number_format($order->subtotal ?? ($order->total - $order->shipping_cost), 2) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="text-muted">Delivery:</span>
                                        <span>${{ number_format($order->shipping_cost, 2) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mt-2 pt-2 border-top">
                                        <h6 class="mb-0 fw-semibold">Total Amount</h6>
                                        <h5 class="mb-0 gradient-text">${{ number_format($order->total, 2) }}</h5>
                                    </div>
                                </div>
                                @else
                                <div class="mb-3">
                                    <h6 class="mb-2 fw-semibold">Total Amount</h6>
                                    <p class="h5 mb-0 gradient-text">${{ number_format($order->total, 2) }}</p>
                                </div>
                                @endif
                                @if(!empty($order->tracking_number))
                                <div class="mt-4 pt-3 border-top">
                                    <h6 class="mb-2 fw-semibold">Tracking Information</h6>
                                    <p class="mb-1">Tracking #: {{ $order->tracking_number }}</p>
                                    @if(!empty($order->tracking_url))
                                    <a href="{{ $order->tracking_url }}" target="_blank" class="btn btn-outline-primary btn-sm mt-2">
                                        <i class="fas fa-truck me-1"></i> Track Package
                                    </a>
                                    @endif
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                @if(isset($order->id))
                <a href="{{ route('orders.invoice', $order->id) }}" class="btn btn-primary">
                    <i class="fas fa-print me-1"></i> Print Invoice
                </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endforeach

@push('scripts')
<script>
    // Alert function to show success/error messages
    function showAlert(type, message) {
        const alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
        
        // Find or create alerts container
        let alertContainer = document.getElementById('alerts-container');
        if (!alertContainer) {
            alertContainer = document.createElement('div');
            alertContainer.id = 'alerts-container';
            alertContainer.className = 'container py-3';
            const mainContent = document.querySelector('.container.py-5');
            if (mainContent) {
                mainContent.parentNode.insertBefore(alertContainer, mainContent);
            } else {
                document.body.insertAdjacentElement('afterbegin', alertContainer);
            }
        }
        
        // Add the new alert
        alertContainer.insertAdjacentHTML('beforeend', alertHtml);
        
        // Auto-remove alert after 5 seconds
        setTimeout(() => {
            const alert = alertContainer.lastElementChild;
            if (alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }
        }, 5000);
    }

    // Initialize all modals and components
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Initialize popovers
        var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
        var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl);
        });

        // Tab functionality
        if (window.location.hash) {
            const tabTrigger = document.querySelector(`[data-bs-target="${window.location.hash}"]`);
            if (tabTrigger) {
                const tab = new bootstrap.Tab(tabTrigger);
                tab.show();
            }
        }

        // Update URL when tabs are shown
        const tabElms = document.querySelectorAll('button[data-bs-toggle="tab"]');
        tabElms.forEach(tabElm => {
            tabElm.addEventListener('shown.bs.tab', function (e) {
                const target = e.target.getAttribute('data-bs-target');
                if (target !== '#profile') {
                    window.history.pushState(null, '', target);
                } else {
                    window.history.pushState(null, '', window.location.pathname);
                }
            });
        });

        // Handle form submissions
        setupFormHandlers();
    });

    function setupFormHandlers() {
        // Edit Profile Form
        const editProfileForm = document.getElementById('editProfileForm');
        if (editProfileForm) {
            editProfileForm.addEventListener('submit', handleProfileUpdate);
            
            // Clear validation errors when modal is hidden
            editProfileForm.closest('.modal').addEventListener('hidden.bs.modal', function() {
                clearFormErrors(editProfileForm);
            });
        }

        // Change Password Form
        const changePasswordForm = document.getElementById('changePasswordForm');
        if (changePasswordForm) {
            changePasswordForm.addEventListener('submit', handlePasswordChange);
            
            // Clear form and errors when modal is hidden
            changePasswordForm.closest('.modal').addEventListener('hidden.bs.modal', function() {
                changePasswordForm.reset();
                clearFormErrors(changePasswordForm);
            });
        }
    }

    function clearFormErrors(form) {
        // Remove is-invalid class from all form elements
        form.querySelectorAll('.is-invalid').forEach(el => {
            el.classList.remove('is-invalid');
        });
        
        // Remove all error messages
        form.querySelectorAll('.invalid-feedback').forEach(el => {
            el.remove();
        });
        
        // Also clear any server-side validation errors
        const alertsContainer = document.getElementById('alerts-container');
        if (alertsContainer) {
            alertsContainer.innerHTML = '';
        }
    }

    async function handleProfileUpdate(e) {
        e.preventDefault();
        const form = this;
        const submitBtn = form.querySelector('button[type="submit"]');
        const spinner = submitBtn?.querySelector('.spinner-border');
        const submitText = submitBtn?.querySelector('span:not(.spinner-border)');
        
        try {
            // Show loading state
            if (submitBtn) {
                submitBtn.disabled = true;
                if (spinner) spinner.classList.remove('d-none');
                if (submitText) submitText.textContent = 'Saving...';
            }
            
            // Clear previous errors
            clearFormErrors(form);
            
            // Get form data
            const formData = new FormData(form);
            const phone = formData.get('phone');
            
            // Add email to form data if it's disabled
            const emailInput = form.querySelector('input[name="email"]');
            if (emailInput && emailInput.disabled) {
                formData.set('email', emailInput.value);
            }
            
            // Client-side validation for phone number
            if (phone && !/^[0-9]{11}$/.test(phone)) {
                throw new Error('Phone number must be exactly 11 digits');
            }
            
            // Get CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
            
            // Add _method for Laravel to recognize PATCH
            formData.append('_method', 'PATCH');
            
            // Send request with form data
            const response = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-HTTP-Method-Override': 'PATCH'
                },
                body: formData
            });
            
            const data = await response.json();
            
            if (!response.ok) {
                // Handle validation errors
                if (response.status === 422 && data.errors) {
                    let errorMessages = [];
                    
                    // Show new error messages
                    for (const [field, messages] of Object.entries(data.errors)) {
                        const input = form.querySelector(`[name="${field}"]`);
                        
                        if (input) {
                            input.classList.add('is-invalid');
                            
                            // Remove existing error message if any
                            const existingError = input.parentNode.querySelector('.invalid-feedback');
                            if (existingError) existingError.remove();
                            
                            // Add error message after the input
                            const errorDiv = document.createElement('div');
                            errorDiv.className = 'invalid-feedback d-block';
                            errorDiv.textContent = Array.isArray(messages) ? messages[0] : messages;
                            input.parentNode.insertBefore(errorDiv, input.nextSibling);
                            
                            // Add to error messages for the alert
                            if (!errorMessages.includes(errorDiv.textContent)) {
                                errorMessages.push(errorDiv.textContent);
                            }
                            
                            // Focus on first error field
                            if (!document.querySelector('.is-invalid:focus')) {
                                input.focus();
                            }
                        }
                    }
                    
                    // Show a single alert with all error messages
                    if (errorMessages.length > 0) {
                        showAlert('danger', errorMessages.join('<br>'));
                    }
                    
                    throw new Error('Please fix the errors in the form.');
                }
                throw new Error(data.message || 'Failed to update profile');
            }
            
            // Show success message
            showAlert('success', 'Profile updated successfully!');
            
            // Update the UI with new user data if available
            if (data.user) {
                const nameElements = document.querySelectorAll('.user-name');
                const emailElements = document.querySelectorAll('.user-email');
                
                // Update name and email
                nameElements.forEach(el => el.textContent = data.user.name);
                emailElements.forEach(el => el.textContent = data.user.email);
            }
            
            // Close the modal after a short delay
            const modal = bootstrap.Modal.getInstance(form.closest('.modal'));
            if (modal) {
                setTimeout(() => modal.hide(), 1500);
            }
            
        } catch (error) {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                html: error.message || 'Something went wrong. Please try again.',
                confirmButtonText: 'OK',
                background: 'linear-gradient(135deg, #ffffff 0%, #fafbfe 100%)',
                color: '#2c3e50'
            });
        } finally {
            // Reset button state
            if (submitBtn) {
                submitBtn.disabled = false;
                if (spinner) spinner.classList.add('d-none');
                if (submitText) submitText.textContent = 'Save Changes';
            }
        }

    }

    async function handlePasswordChange(e) {
        e.preventDefault();
        const form = this;
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalBtnText = submitBtn.innerHTML;
        
        try {
            // Show loading state
            submitBtn.disabled = true;
            submitBtn.innerHTML = `
                <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                Updating...
            `;
            
            // Get form data
            const formData = new FormData(form);
            
            // Send request
            const response = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: formData
            });
            
            const data = await response.json();
            
            if (!response.ok) {
                // Handle validation errors
                if (response.status === 422 && data.errors) {
                    clearFormErrors(form);
                    
                    // Show new error messages
                    for (const [field, messages] of Object.entries(data.errors)) {
                        const input = form.querySelector(`[name="${field}"]`);
                        if (input) {
                            input.classList.add('is-invalid');
                            const errorDiv = document.createElement('div');
                            errorDiv.className = 'invalid-feedback';
                            errorDiv.textContent = messages[0];
                            input.parentNode.insertBefore(errorDiv, input.nextSibling);
                            
                            // Focus on first error field
                            if (!document.querySelector('.is-invalid:focus')) {
                                input.focus();
                            }
                        }
                    }
                    throw new Error('Please fix the errors in the form.');
                }
                throw new Error(data.message || 'An error occurred while updating your password.');
            }
            
            // Show success message
            await Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: data.message || 'Password updated successfully',
                timer: 2000,
                showConfirmButton: false,
                background: 'linear-gradient(135deg, #ffffff 0%, #fafbfe 100%)',
                color: '#2c3e50'
            });
            
            // Close modal
            const modal = bootstrap.Modal.getInstance(form.closest('.modal'));
            if (modal) {
                form.reset();
                modal.hide();
            }
            
        } catch (error) {
            console.error('Error:', error);
            await Swal.fire({
                icon: 'error',
                title: 'Error!',
                html: error.message || 'Something went wrong. Please try again.',
                confirmButtonText: 'OK',
                background: 'linear-gradient(135deg, #ffffff 0%, #fafbfe 100%)',
                color: '#2c3e50'
            });
        } finally {
            // Reset button state if still on page
            if (submitBtn && !submitBtn.isConnected === false) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText;
            }
        }
    }

    // Show success message if there's a success message in the session
    @if(session('status'))
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session('status') }}',
            timer: 3000,
            showConfirmButton: false,
            background: 'linear-gradient(135deg, #ffffff 0%, #fafbfe 100%)',
            color: '#2c3e50'
        });
    });
    @endif

    // Show validation errors if there are any
    @if($errors->any())
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'error',
            title: 'Validation Error',
            html: `{!! addslashes(implode('<br>', $errors->all())) !!}`.replace(/\n/g, '<br>'),
            background: 'linear-gradient(135deg, #ffffff 0%, #fafbfe 100%)',
            color: '#2c3e50'
        });
    });
    @endif

// Special Order Details Modal Function
function showSpecialOrderDetailsModal(orderId) {
    const modal = document.getElementById('specialOrderDetailsModal');
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
            if (data.error) {
                throw new Error(data.error);
            }
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
                        <p><strong>Quantity:</strong> ${data.quantity}</p>
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

// Special Order Track Modal Function
function showSpecialOrderTrackModal(orderId) {
    const modal = document.getElementById('specialOrderTrackModal');
    const track = document.getElementById('specialOrderTrack');
    
    track.innerHTML = `
        <div class="text-center">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-2">Loading tracking information...</p>
        </div>
    `;
    
    // Load tracking via AJAX
    fetch(`/special-order/track/${orderId}`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                throw new Error(data.error);
            }
            track.innerHTML = `
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6>Order Summary</h6>
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="bg-light d-flex align-items-center justify-content-center rounded me-3" 
                                         style="width: 60px; height: 60px;">
                                        <i class="fas fa-box-open text-muted"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1 fw-semibold">${data.product}</h6>
                                        <small class="text-muted">Qty: ${data.quantity}</small>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted">Total Amount</span>
                                    <span class="h5 gradient-text">৳${data.total}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6>Order Information</h6>
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <div class="mb-3">
                                    <small class="text-muted d-block fw-semibold">Order Number</small>
                                    <span class="fw-semibold">${data.order_number}</span>
                                </div>
                                <div class="mb-3">
                                    <small class="text-muted d-block fw-semibold">Order Date</small>
                                    <span>${data.date}</span>
                                </div>
                                <div class="mb-3">
                                    <small class="text-muted d-block fw-semibold">Tracking Number</small>
                                    <span class="badge bg-dark">
                                        <i class="fas fa-truck"></i> ${data.tracking_number || 'Not Available'}
                                    </span>
                                </div>
                                <div>
                                    <small class="text-muted d-block fw-semibold">Current Status</small>
                                    <span class="badge bg-info">${data.status}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-12">
                        <h6>Order Status Timeline</h6>
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between text-center">
                                    <div class="text-center">
                                        <div class="timeline-icon completed">
                                            <i class="fas fa-clock"></i>
                                        </div>
                                        <small class="fw-semibold">Pending</small>
                                    </div>
                                    <div class="text-center">
                                        <div class="timeline-icon ${data.status === 'Approved' || data.status === 'Processing' || data.status === 'Shipped' || data.status === 'Completed' ? 'completed' : 'text-muted'}">
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                        <small class="fw-semibold">Approved</small>
                                    </div>
                                    <div class="text-center">
                                        <div class="timeline-icon ${data.status === 'Processing' || data.status === 'Shipped' || data.status === 'Completed' ? 'completed' : 'text-muted'}">
                                            <i class="fas fa-cog"></i>
                                        </div>
                                        <small class="fw-semibold">Processing</small>
                                    </div>
                                    <div class="text-center">
                                        <div class="timeline-icon ${data.status === 'Shipped' || data.status === 'Completed' ? 'completed' : 'text-muted'}">
                                            <i class="fas fa-shipping-fast"></i>
                                        </div>
                                        <small class="fw-semibold">Shipped</small>
                                    </div>
                                    <div class="text-center">
                                        <div class="timeline-icon ${data.status === 'Completed' ? 'completed' : 'text-muted'}">
                                            <i class="fas fa-check-double"></i>
                                        </div>
                                        <small class="fw-semibold">Completed</small>
                                    </div>
                                </div>
                                
                                <div class="progress mt-4" style="height: 8px;">
                                    ${(() => {
                                        const progressMap = {
                                            'Pending': 0,
                                            'Approved': 25,
                                            'Processing': 50,
                                            'Shipped': 75,
                                            'Completed': 100
                                        };
                                        const progress = progressMap[data.status] || 0;
                                        return `<div class="progress-bar" role="progressbar" style="width: ${progress}%;" aria-valuenow="${progress}" aria-valuemin="0" aria-valuemax="100"></div>`;
                                    })()}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                ${data.admin_notes ? `
                <div class="row mt-4">
                    <div class="col-12">
                        <h6>Admin Notes</h6>
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <p class="mb-0">${data.admin_notes}</p>
                            </div>
                        </div>
                    </div>
                </div>
                ` : ''}
            `;
        })
        .catch(error => {
            track.innerHTML = `
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle"></i>
                    Error loading tracking information. Please try again.
                </div>
            `;
        });
    
    new bootstrap.Modal(modal).show();
}
</script>
@endpush
@endsection