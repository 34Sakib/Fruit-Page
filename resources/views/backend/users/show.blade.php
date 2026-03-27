@extends('backend.layouts.master')

@section('title', 'User Details - Admin Panel')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link rel="stylesheet" href="{{ asset('backend/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('backend/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">

<style>
    .profile-header {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        color: white;
        padding: 2rem 0;
        margin: -20px -20px 2rem -20px;
        border-radius: 0;
    }
    
    .card {
        border: none;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
        margin-bottom: 1.5rem;
        border-radius: 0.35rem;
    }
    
    .card-header {
        background-color: #f8f9fc;
        border-bottom: 1px solid #e3e6f0;
        padding: 1rem 1.25rem;
    }
    
    .card-title {
        color: #4e73df;
        font-weight: 600;
        margin-bottom: 0;
        font-size: 1.1rem;
    }
    
    .info-label {
        font-weight: 600;
        color: #5a5c69;
        font-size: 0.9rem;
        margin-bottom: 0.25rem;
    }
    
    .info-value {
        color: #4e73df;
        margin-bottom: 1rem;
        font-size: 1rem;
    }
    
    .table th {
        background-color: #f8f9fc;
        color: #4e73df;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.7rem;
        letter-spacing: 0.5px;
    }
    
    .badge {
        font-weight: 500;
        padding: 0.35em 0.65em;
        font-size: 85%;
    }
    
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.8rem;
    }
    
    .stat-card {
        border-left: 3px solid #4e73df;
        padding: 1rem;
        margin-bottom: 1rem;
        background-color: #f8f9fc;
        border-radius: 0.35rem;
    }
    
    .stat-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: #4e73df;
        line-height: 1.2;
    }
    
    .stat-label {
        font-size: 0.75rem;
        color: #858796;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .profile-img {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        border: 5px solid rgba(255, 255, 255, 0.2);
        object-fit: cover;
    }
    
    .nav-tabs .nav-link {
        color: #6e707e;
        border: none;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
    }
    
    .nav-tabs .nav-link.active {
        color: #4e73df;
        border-bottom: 2px solid #4e73df;
        background: transparent;
    }
    
    .nav-tabs {
        border-bottom: 1px solid #e3e6f0;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Profile Header -->
    <div class="profile-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-auto">
                    @if($user->profile_photo_path)
                        <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="Profile Image" class="profile-img">
                    @else
                        <div class="profile-img bg-white text-primary d-flex align-items-center justify-content-center">
                            <i class="fas fa-user fa-4x"></i>
                        </div>
                    @endif
                </div>
                <div class="col">
                    <h2 class="mb-1">{{ $user->name }}</h2>
                    <p class="mb-2">{{ $user->email }}</p>
                    <div>
                        <span class="badge {{ $user->isAdmin() ? 'bg-success' : 'bg-primary' }}">
                            {{ $user->isAdmin() ? 'Administrator' : 'Customer' }}
                        </span>
                        @if($user->email_verified_at)
                            <span class="badge bg-success ms-2">
                                <i class="fas fa-check-circle"></i> Verified
                            </span>
                        @else
                            <span class="badge bg-warning ms-2">
                                <i class="fas fa-exclamation-circle"></i> Unverified
                            </span>
                        @endif
                    </div>
                </div>
                <div class="col-auto">
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-light">
                        <i class="fas fa-edit me-1"></i> Edit Profile
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Left Column -->
        <div class="col-lg-4">
            <!-- User Details Card -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-user-circle me-2"></i>
                        User Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <div>
                            <p class="mb-1 text-muted">Account Status</p>
                            <span class="badge {{ $user->is_active ? 'bg-success' : 'bg-danger' }}">
                                {{ $user->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                        <div class="text-end">
                            <p class="mb-1 text-muted">Member Since</p>
                            <p class="mb-0">{{ $user->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>

                    <hr>

                    <div class="mb-3">
                        <p class="mb-1 text-muted">Email Address</p>
                        <p class="mb-3">
                            {{ $user->email }}
                            @if($user->email_verified_at)
                                <span class="badge bg-success ms-2">
                                    <i class="fas fa-check-circle"></i> Verified
                                </span>
                            @else
                                <span class="badge bg-warning ms-2">
                                    <i class="fas fa-exclamation-circle"></i> Unverified
                                </span>
                            @endif
                        </p>

                        @if($user->phone)
                            <p class="mb-1 text-muted">Phone Number</p>
                            <p class="mb-3">
                                <a href="tel:{{ $user->phone }}" class="text-decoration-none">
                                    <i class="fas fa-phone me-2"></i>{{ $user->phone }}
                                </a>
                            </p>
                        @endif

                        <p class="mb-1 text-muted">Last Login</p>
                        <p class="mb-0">
                            {{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Never logged in' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Account Statistics -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-pie me-2"></i>
                        Account Statistics
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6 mb-3">
                            <div class="stat-card">
                                <div class="stat-value">{{ $user->orders->count() }}</div>
                                <div class="stat-label">Total Orders</div>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="stat-card">
                                <div class="stat-value">{{ $user->orders->where('status', 'completed')->count() }}</div>
                                <div class="stat-label">Completed</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-card">
                                <div class="stat-value">{{ $user->addresses->count() }}</div>
                                <div class="stat-label">Addresses</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-card">
                                <div class="stat-value">{{ $user->created_at->diffForHumans(null, true) }}</div>
                                <div class="stat-label">Member For</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Right Column -->
        <div class="col-lg-8">
            <!-- Recent Orders -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-shopping-bag mr-2"></i>
                        Recent Orders
                    </h5>
                    <a href="#" class="btn btn-sm btn-primary">View All</a>
                </div>
                <div class="card-body p-0">
                    @if($user->orders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Order #</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Total</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($user->orders->take(5) as $order)
                                    <tr>
                                        <td>#{{ $order->order_number }}</td>
                                        <td>{{ $order->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <span class="badge 
                                                @if($order->status === 'completed') bg-success
                                                @elseif($order->status === 'processing') bg-primary
                                                @elseif($order->status === 'cancelled') bg-danger
                                                @elseif($order->status === 'refunded') bg-secondary
                                                @else bg-warning @endif">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td>{{ number_format($order->total, 2) }} {{ config('settings.currency_symbol') }}</td>
                                        <td>
                                            <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-shopping-bag fa-3x text-muted mb-3"></i>
                            <p class="mb-0">No orders found for this user.</p>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- User Addresses -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-address-book mr-2"></i>
                        Address Book
                    </h5>
                </div>
                <div class="card-body">
                    @if($user->addresses->count() > 0)
                        <div class="row">
                            @foreach($user->addresses->take(2) as $address)
                            <div class="col-md-6 mb-3">
                                <div class="border p-3 rounded">
                                    <h6 class="font-weight-bold">
                                        {{ $address->is_default ? 'Default ' : '' }}{{ ucfirst($address->type) }} Address
                                        @if($address->is_default)
                                            <span class="badge bg-success ml-2">Default</span>
                                        @endif
                                    </h6>
                                    <p class="mb-1">{{ $address->address_line1 }}</p>
                                    @if($address->address_line2)
                                        <p class="mb-1">{{ $address->address_line2 }}</p>
                                    @endif
                                    <p class="mb-1">
                                        {{ $address->city }}, {{ $address->state }} {{ $address->postal_code }}
                                    </p>
                                    <p class="mb-0">{{ $address->country }}</p>
                                    @if($address->phone)
                                        <p class="mb-0">
                                            <i class="fas fa-phone-alt mr-1"></i> 
                                            {{ $address->phone }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                        
                        @if($user->addresses->count() > 2)
                            <div class="text-center mt-2">
                                <a href="#" class="btn btn-sm btn-outline-primary">
                                    View All Addresses ({{ $user->addresses->count() }})
                                </a>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-3">
                            <i class="fas fa-map-marker-alt fa-3x text-muted mb-3"></i>
                            <p class="mb-0">No saved addresses found.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Any additional JavaScript can go here
</script>
@endpush
