@extends('frontend.layouts.master')

@section('title', 'Special Order - FruitsPage')

@push('styles')
    <link rel="stylesheet" href="{{ asset('frontend/css/special-order.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endpush

@section('content')
<!-- Hero Section -->
<div class="hero-section">
    <div class="hero-content">
        <div class="hero-badge">
            <i class="fas fa-star"></i>
            <span>Premium Service</span>
        </div>
        <h1 class="hero-title">
            Special Order Request
        </h1>
        <p class="hero-subtitle">
            Can't find what you're looking for? We source rare items, custom products, and bulk orders just for you!
        </p>
        <div class="hero-features">
            <div class="feature-item">
                <i class="fas fa-gem"></i>
                <span>Rare Items</span>
            </div>
            <div class="feature-item">
                <i class="fas fa-cogs"></i>
                <span>Custom Products</span>
            </div>
            <div class="feature-item">
                <i class="fas fa-boxes"></i>
                <span>Bulk Orders</span>
            </div>
        </div>
    </div>
</div>

<!-- Trust Indicators -->
<div class="trust-indicators">
    <div class="container">
        <div class="trust-grid">
            <div class="trust-item">
                <i class="fas fa-truck"></i>
                <span>Fast Delivery</span>
            </div>
            <div class="trust-item">
                <i class="fas fa-shield-alt"></i>
                <span>Quality Guaranteed</span>
            </div>
            <div class="trust-item">
                <i class="fas fa-headset"></i>
                <span>24/7 Support</span>
            </div>
            <div class="trust-item">
                <i class="fas fa-handshake"></i>
                <span>Best Prices</span>
            </div>
        </div>
    </div>
</div>

<!-- Main Container -->
<div class="special-order-container">
    <!-- Success Message -->
    @if(session('success'))
        <div class="success-notification">
            <div class="success-content">
                <i class="fas fa-check-circle"></i>
                <div>
                    <strong>Success!</strong>
                    <p>{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Order Tracking Info -->
    <div class="tracking-info">
        <div class="tracking-content">
            <i class="fas fa-info-circle"></i>
            <div>
                <strong>Track Your Order:</strong>
                <p>Create an account to track your special order status. You can also submit without an account.</p>
            </div>
        </div>
    </div>
    <!-- Form -->
    <form id="specialOrderForm" action="{{ route('special-order.store') }}" method="POST">
        @csrf
        
        <!-- Customer Information Section -->
        <div class="form-section customer-section">
            <div class="section-header">
                <div class="section-icon">
                    <i class="fas fa-user"></i>
                </div>
                <div class="section-content">
                    <h5>Customer Information</h5>
                    <p>Tell us who you are so we can serve you better</p>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="customer_name" class="form-label">
                        <i class="fas fa-user-circle"></i> Full Name *
                    </label>
                    <input type="text" class="form-control" id="customer_name" name="customer_name" 
                           value="{{ old('customer_name') }}" placeholder="Enter your full name" required>
                    <div class="error-message">@error('customer_name'){{ $message }}@enderror</div>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">
                        <i class="fas fa-envelope"></i> Email Address *
                    </label>
                    <input type="email" class="form-control" id="email" name="email" 
                           value="{{ old('email') }}" placeholder="your@email.com" required>
                    <div class="error-message">@error('email'){{ $message }}@enderror</div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="phone" class="form-label">
                        <i class="fas fa-phone"></i> Contact Number *
                    </label>
                    <input type="tel" class="form-control" id="phone" name="phone" 
                           value="{{ old('phone') }}" placeholder="+880 1XXX-XXXXXX" required>
                    <div class="error-message">@error('phone'){{ $message }}@enderror</div>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="location" class="form-label">
                        <i class="fas fa-map-marker-alt"></i> Delivery Location *
                    </label>
                    <select class="form-select" id="location" name="is_inside_dhaka" required>
                        <option value="">Select Location</option>
                        <option value="1" {{ old('is_inside_dhaka') == '1' ? 'selected' : '' }}>Inside Dhaka</option>
                        <option value="0" {{ old('is_inside_dhaka') == '0' ? 'selected' : '' }}>Outside Dhaka</option>
                    </select>
                    <div class="error-message">@error('is_inside_dhaka'){{ $message }}@enderror</div>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="address" class="form-label">
                    <i class="fas fa-home"></i> Delivery Address *
                </label>
                <textarea class="form-control" id="address" name="address" rows="3" 
                          placeholder="Enter your complete delivery address" required>{{ old('address') }}</textarea>
                <div class="error-message">@error('address'){{ $message }}@enderror</div>
            </div>
            
            <div class="delivery-charge-info">
                <div class="charge-header">
                    <i class="fas fa-truck"></i>
                    <h6>Delivery Information</h6>
                </div>
                <div class="charge-details">
                    <div class="charge-item">
                        <span class="location">Inside Dhaka</span>
                        <span class="price">৳50</span>
                    </div>
                    <div class="charge-item">
                        <span class="location">Outside Dhaka</span>
                        <span class="price">৳120</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Information Section -->
        <div class="form-section product-section">
            <div class="section-header">
                <div class="section-icon">
                    <i class="fas fa-box"></i>
                </div>
                <div class="section-content">
                    <h5>Product Information</h5>
                    <p>Specify what you need - from existing products to custom requirements</p>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="category_id" class="form-label">
                        <i class="fas fa-tags"></i> Category *
                    </label>
                    <select class="form-select" id="category_id" name="category_id" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    <div class="error-message">@error('category_id'){{ $message }}@enderror</div>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="product_id" class="form-label">
                        <i class="fas fa-apple-alt"></i> Product (Optional)
                    </label>
                    <select class="form-select" id="product_id" name="product_id">
                        <option value="">Select Product (if available)</option>
                    </select>
                    <small class="text-muted">Leave empty if you want a custom product</small>
                    <div class="error-message">@error('product_id'){{ $message }}@enderror</div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label for="product_name" class="form-label">
                        <i class="fas fa-edit"></i> Custom Product Name
                    </label>
                    <input type="text" class="form-control" id="product_name" name="product_name" 
                           value="{{ old('product_name') }}" placeholder="Enter product name if not listed">
                    <small class="text-muted">Required if no product is selected above</small>
                    <div class="error-message">@error('product_name'){{ $message }}@enderror</div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label for="notes" class="form-label">
                        <i class="fas fa-sticky-note"></i> Order Details *
                    </label>
                    <textarea class="form-control" id="notes" name="notes" rows="4" 
                              placeholder="Please describe your requirements including quantity, desired price, and any other specifications..." required>{{ old('notes') }}</textarea>
                    <div class="help-text">
                        <i class="fas fa-lightbulb"></i>
                        <span>Perfect for: Bulk quantities, target pricing, special conditions, business events, reseller needs, or custom specifications</span>
                    </div>
                    <div class="error-message">@error('notes'){{ $message }}@enderror</div>
                </div>
            </div>
        </div>


        <!-- Submit Section -->
        <div class="submit-section">
            <div class="submit-content">
                <div class="submit-info">
                    <h6>Ready to Submit?</h6>
                    <p>Our team will review your request and contact you within 24 hours</p>
                </div>
                <button type="submit" class="btn btn-submit">
                    <i class="fas fa-paper-plane"></i> 
                    <span>Submit Special Order</span>
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('frontend/js/special-order.js') }}"></script>
@endpush
