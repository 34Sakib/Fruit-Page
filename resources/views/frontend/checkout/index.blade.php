@extends('frontend.layouts.master')

@section('title', 'Checkout - Organic Fresh')

@push('styles')
    <link rel="stylesheet" href="{{ asset('frontend/css/checkout.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Add active state for payment method */
        .payment-method {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .payment-method:hover {
            border-color: #0d6efd;
        }
        
        .payment-method.active {
            border-color: #0d6efd;
            background-color: rgba(13, 110, 253, 0.05);
        }
        
        .payment-method input[type="radio"] {
            display: none;
        }
        
        /* Style for delivery options */
        .delivery-option {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .delivery-option:hover {
            border-color: #0d6efd;
        }
        
        .delivery-option.selected {
            border-color: #0d6efd;
            background-color: rgba(13, 110, 253, 0.05);
        }
        
        .delivery-option input[type="radio"] {
            display: none;
        }
        
        /* Style for form validation */
        .was-validated .form-control:invalid, .form-control.is-invalid {
            border-color: #dc3545;
            padding-right: calc(1.5em + 0.75rem);
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right calc(0.375em + 0.1875rem) center;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
        }
        
        .was-validated .form-control:valid, .form-control.is-valid {
            border-color: #198754;
            padding-right: calc(1.5em + 0.75rem);
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%23198754' d='M2.3 6.73L.6 4.53c-.4-1.04.46-1.4 1.1-.8l1.1 1.4 3.4-3.8c.6-.63 1.6-.27 1.2.7l-4 4.6c-.43.5-.8.4-1.1.1z'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right calc(0.375em + 0.1875rem) center;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
        }
        
        .invalid-feedback {
            display: none;
            width: 100%;
            margin-top: 0.25rem;
            font-size: 0.875em;
            color: #dc3545;
        }
        
        .was-validated .form-control:invalid ~ .invalid-feedback,
        .was-validated .form-control:invalid ~ .invalid-tooltip,
        .form-control.is-invalid ~ .invalid-feedback,
        .form-control.is-invalid ~ .invalid-tooltip {
            display: block;
        }
    </style>
@endpush

@section('content')
    <!-- Checkout Page -->
    <section class="checkout-page">
        <div class="container">
            <h1 class="page-title">Checkout</h1>

            <!-- Step Indicator -->
            <div class="step-indicator">
                <div class="step completed">
                    <div class="step-number">1</div>
                    <div class="step-label">Cart</div>
                </div>
                <div class="step active">
                    <div class="step-number">2</div>
                    <div class="step-label">Details</div>
                </div>
                <div class="step">
                    <div class="step-number">3</div>
                    <div class="step-label">Confirmation</div>
                </div>
            </div>

            <div class="row">
                <!-- Checkout Form -->
                <div class="col-lg-8">
                    <div class="checkout-container">
                        <h3 class="section-title">Delivery Information</h3>
                        
                        <form id="checkout-form" action="{{ route('checkout.process') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="first_name" class="form-label">First Name</label>
                                        <input type="text" class="form-control" id="first_name" name="first_name" 
                                               value="{{ old('first_name', auth()->user()->first_name ?? '') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="last_name" class="form-label">Last Name</label>
                                        <input type="text" class="form-control" id="last_name" name="last_name"
                                               value="{{ old('last_name', auth()->user()->last_name ?? '') }}" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email"
                                       value="{{ old('email', auth()->user()->email ?? '') }}" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control" id="phone" name="phone"
                                       value="{{ old('phone', auth()->user()->phone ?? '') }}" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="address" class="form-label">Delivery Address</label>
                                <textarea class="form-control" id="address" name="address" rows="3" required>{{ old('address') }}</textarea>
                            </div>
                            
                            <input type="hidden" name="country" value="Bangladesh">
                            
                            <h3 class="section-title mt-5">Delivery Area</h3>
                            
                            <div class="delivery-option selected" onclick="selectDeliveryOption('inside_dhaka', this)">
                                <input type="radio" name="shipping_method" value="inside_dhaka" checked hidden>
                                <div class="delivery-icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <h5>Inside Dhaka</h5>
                                <p class="text-muted">Delivery within 1-2 business days</p>
                                <div class="d-flex justify-content-between">
                                    <span class="fw-bold">৳50.00</span>
                                    <span class="text-success">Selected</span>
                                </div>
                            </div>
                            
                            <div class="delivery-option" onclick="selectDeliveryOption('outside_dhaka', this)">
                                <input type="radio" name="shipping_method" value="outside_dhaka" hidden>
                                <div class="delivery-icon">
                                    <i class="fas fa-truck"></i>
                                </div>
                                <h5>Outside Dhaka</h5>
                                <p class="text-muted">Delivery within 2-4 business days</p>
                                <div class="d-flex justify-content-between">
                                    <span class="fw-bold">৳120.00</span>
                                    <span class="text-success" style="display: none;">Selected</span>
                                </div>
                            </div>
                            
                            <h3 class="section-title mt-5">Payment Method</h3>
                            
                            <div class="payment-method" onclick="selectPaymentMethod('cod')">
                                <input type="radio" name="payment_method" id="payment_cod" value="cod" checked>
                                <div class="payment-icon">
                                    <i class="fas fa-money-bill-wave"></i>
                                </div>
                                <h5>Cash on Delivery</h5>
                                <p class="text-muted">Pay when you receive your order</p>
                                <div class="alert alert-info mt-3">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>Note:</strong> Please have exact change ready for the delivery person.
                                </div>
                            </div>
                            
                            <div class="form-check mt-4">
                                <input class="form-check-input @error('terms') is-invalid @enderror" type="checkbox" id="termsCheck" name="terms" value="1" {{ old('terms') ? 'checked' : '' }} required>
                                <label class="form-check-label" for="termsCheck">
                                    I agree to the <a href="#" class="text-primary">Terms & Conditions</a> and 
                                    <a href="#" class="text-primary">Privacy Policy</a>
                                </label>
                                @error('terms')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            
                            <!-- Hidden fields for order data -->
                            <input type="hidden" name="order_subtotal" value="{{ $subtotal }}">
                            <input type="hidden" name="order_tax" value="{{ $tax }}">
                            <input type="hidden" name="order_discount" value="{{ $discount ?? 0 }}">
                            <input type="hidden" name="order_total" id="order_total" value="{{ $total }}">
                            
                            <button type="submit" class="place-order-btn mt-4">
                                <i class="fas fa-check-circle me-2"></i> Place Order
                            </button>
                        </form>
                        
                        <a href="{{ route('cart.index') }}" class="back-to-cart">
                            <i class="fas fa-arrow-left me-2"></i> Back to Cart
                        </a>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="col-lg-4">
                    <div class="order-summary">
                        <h3 class="section-title">Order Summary</h3>
                        
                        @forelse($cartItems as $item)
                        <div class="order-item">
                            <div class="order-item-image">
                                <img src="{{ $item->attributes->image ?? asset('images/default-product.jpg') }}" 
                                     alt="{{ $item->name }}" class="img-fluid">
                            </div>
                            <div class="order-item-details">
                                <div class="order-item-title">{{ $item->name }}</div>
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted">Qty: {{ $item->quantity }}</span>
                                    <span class="order-item-price">${{ number_format($item->price * $item->quantity, 2) }}</span>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="alert alert-info">
                            Your cart is empty. <a href="{{ route('home') }}">Continue shopping</a>
                        </div>
                        @endforelse
                        
                        <div class="summary-rows">
                            <div class="summary-row">
                                <span>Subtotal ({{ $itemCount }} {{ $itemCount == 1 ? 'item' : 'items' }})</span>
                                <span id="subtotal-amount">${{ number_format($subtotal, 2) }}</span>
                            </div>
                            
                            <div class="summary-row">
                                <span>Shipping</span>
                                <span id="shipping-cost">$0.00</span>
                            </div>
                            
                            @if($tax > 0)
                            <div class="summary-row">
                                <span>Tax</span>
                                <span id="tax-amount">${{ number_format($tax, 2) }}</span>
                            </div>
                            @endif
                            
                            @if($discount > 0)
                            <div class="summary-row">
                                <span>Discount</span>
                                <span class="text-success" id="discount-amount">-${{ number_format($discount, 2) }}</span>
                            </div>
                            @endif
                            
                            <div class="summary-row summary-total">
                                <span>Total</span>
                                <span id="order-total">${{ number_format($total, 2) }}</span>
                            </div>
                        </div>

                        <div class="mt-4 text-center">
                            <p class="text-muted small">
                                <i class="fas fa-lock me-1"></i>
                                Your information is secure and encrypted
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    // Cart data from server
    const cartData = {
        subtotal: {{ $subtotal }},
        tax: {{ $tax }},
        discount: {{ $discount ?? 0 }},
        total: {{ $total }}
    };

    function selectDeliveryOption(option, element) {
        // Remove selected class from all delivery options
        document.querySelectorAll('.delivery-option').forEach(el => {
            el.classList.remove('selected');
            // Reset all text-muted and text-success spans
            const textMuted = el.querySelectorAll('.text-muted');
            const textSuccess = el.querySelectorAll('.text-success');
            textMuted.forEach(el => el.style.display = 'none');
            textSuccess.forEach(el => el.style.display = 'none');
            // Show the select text for non-selected options
            if (el !== element) {
                const selectText = el.querySelector('.text-muted:not(.d-none)');
                if (selectText) selectText.style.display = 'inline';
            }
        });
        
        // Add selected class to clicked option
        element.classList.add('selected');
        
        // Update the radio input
        const radioInput = element.querySelector('input[type="radio"]');
        if (radioInput) {
            radioInput.checked = true;
            
            // Update the display text
            const textMuted = element.querySelectorAll('.text-muted');
            const textSuccess = element.querySelectorAll('.text-success');
            
            textMuted.forEach(el => el.style.display = 'none');
            textSuccess.forEach(el => el.style.display = 'inline');
            
            // Update shipping cost in order summary
            let shippingCost = 0;
            if (option === 'inside_dhaka') {
                shippingCost = 50;
            } else if (option === 'outside_dhaka') {
                shippingCost = 120;
            }
            const shippingCostElement = document.getElementById('shipping-cost');
            if (shippingCostElement) {
                shippingCostElement.textContent = `৳${shippingCost.toFixed(2)}`;
            }
            
            // Update total
            updateOrderTotal(shippingCost);
        }
    }
    
    function updateOrderTotal(shippingCost = 0) {
        const subtotal = cartData.subtotal;
        const tax = cartData.tax;
        const discount = cartData.discount || 0;
        
        // Calculate new total
        const total = subtotal + parseFloat(shippingCost) + tax - discount;
        
        // Update the displayed total
        document.getElementById('order-total').textContent = '$' + total.toFixed(2);
        
        // Update the form's total for submission
        if (document.getElementById('order_total')) {
            document.getElementById('order_total').value = total.toFixed(2);
        }
    }

    // Handle payment method selection
    function selectPaymentMethod(method) {
        // Remove active class from all payment methods
        document.querySelectorAll('.payment-method').forEach(el => {
            el.classList.remove('active');
        });
        
        // Add active class to selected payment method
        const selectedMethod = document.querySelector(`.payment-method input[value="${method}"]`).parentNode;
        selectedMethod.classList.add('active');
        
        // Update the radio button
        document.querySelector(`#payment_${method}`).checked = true;
    }
    
    // Simple form submission handling
    document.addEventListener('DOMContentLoaded', function() {
        const checkoutForm = document.getElementById('checkout-form');
        
        if (checkoutForm) {
            checkoutForm.addEventListener('submit', function() {
                const submitBtn = this.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Processing...';
                }
            });
        }

        // Initialize animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        const animatedElements = document.querySelectorAll('.checkout-container, .order-summary');
        animatedElements.forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(el);
        });
        
        // Initialize delivery option
        const defaultDelivery = document.querySelector('input[name="shipping_method"]:checked');
        if (defaultDelivery) {
            let shippingCost = 0;
            if (defaultDelivery.value === 'inside_dhaka') {
                shippingCost = 50;
            } else if (defaultDelivery.value === 'outside_dhaka') {
                shippingCost = 120;
            }
            updateOrderTotal(shippingCost);
        }
    });
    
    // Function to format price
    function formatPrice(price) {
        return '৳' + parseFloat(price).toFixed(2);
    }
</script>
@endpush
