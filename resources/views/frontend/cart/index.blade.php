@extends('frontend.layouts.master')

@push('styles')
    <link rel="stylesheet" href="{{ asset('frontend/css/cart-premium.css') }}">
    <style>
        /* Premium Toast Notifications */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            pointer-events: none;
        }

        .toast-notification {
            background: white;
            border-radius: 12px;
            padding: 16px 20px;
            margin-bottom: 12px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 300px;
            max-width: 400px;
            pointer-events: all;
            transform: translateX(400px);
            transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            border-left: 4px solid;
        }

        .toast-notification.show {
            transform: translateX(0);
        }

        .toast-notification.success {
            border-left-color: #10b981;
        }

        .toast-notification.error {
            border-left-color: #ef4444;
        }

        .toast-notification.info {
            border-left-color: #3b82f6;
        }

        .toast-icon {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .toast-notification.success .toast-icon {
            background: #10b981;
            color: white;
        }

        .toast-notification.error .toast-icon {
            background: #ef4444;
            color: white;
        }

        .toast-notification.info .toast-icon {
            background: #3b82f6;
            color: white;
        }

        .toast-content {
            flex: 1;
        }

        .toast-title {
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 2px;
            color: #1f2937;
        }

        .toast-message {
            font-size: 13px;
            color: #6b7280;
            line-height: 1.4;
        }

        .toast-close {
            background: none;
            border: none;
            color: #9ca3af;
            cursor: pointer;
            padding: 4px;
            border-radius: 4px;
            transition: all 0.2s;
        }

        .toast-close:hover {
            background: #f3f4f6;
            color: #4b5563;
        }

        /* Loading States */
        .quantity-btn:disabled,
        .btn-remove:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            pointer-events: none;
        }

        .skeleton {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
        }

        @keyframes loading {
            0% {
                background-position: 200% 0;
            }

            100% {
                background-position: -200% 0;
            }
        }

        /* Smooth transitions */
        .cart-item-updating {
            opacity: 0.6;
            pointer-events: none;
        }

        .cart-item-removing {
            animation: slideOut 0.4s ease-out forwards;
        }

        @keyframes slideOut {
            to {
                transform: translateX(-100%);
                opacity: 0;
            }
        }
    </style>
@endpush

@section('content')
    <!-- Premium Page Header -->
    <div class="page-header">
        <div class="container">
            <div class="header-content">
                <div class="cart-icon">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="cart-badge">{{ $cartItems->count() }}</span>
                </div>
                <div class="header-text">
                    <h1 class="page-title">Your Shopping Cart</h1>
                    <p class="page-subtitle">Review your items and proceed to secure checkout</p>
                </div>
            </div>
        </div>
        <div class="header-waves">
            <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M0 120L60 110C120 100 240 80 360 70C480 60 600 60 720 65C840 70 960 80 1080 85C1200 90 1320 90 1380 90L1440 90V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0V120Z"
                    fill="white" fill-opacity="0.1" />
                <path
                    d="M0 120L60 105C120 90 240 60 360 45C480 30 600 30 720 37.5C840 45 960 60 1080 67.5C1200 75 1320 75 1380 75L1440 75V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0V120Z"
                    fill="white" fill-opacity="0.2" />
            </svg>
        </div>
    </div>

    <!-- Premium Cart Content -->
    <div class="cart-content">
        <div class="container">
            <div class="row g-4">
                <!-- Cart Items -->
                <div class="col-lg-8">
                    <div class="cart-container">
                        @if (count($cartItems) > 0)
                            <div class="cart-header">
                                <h2>Your Cart ({{ $cartItems->count() }})</h2>
                            </div>

                            <div class="cart-items">
                                @foreach ($cartItems as $item)
                                    <div class="cart-item" id="cart-item-{{ $item->id }}">
                                        <div class="cart-item-image">
                                            @php
                                                $image = is_array($item->attributes)
                                                    ? $item->attributes['image'] ?? null
                                                    : $item->attributes->image ?? null;
                                            @endphp
                                            <img src="{{ $image }}" alt="{{ $item->name }}" class="img-fluid"
                                                onerror="this.onerror=null; this.src='{{ asset('images/default-product.png') }}';">
                                            <div class="product-overlay">
                                                <i class="fas fa-eye"></i>
                                            </div>
                                        </div>
                                        <div class="cart-item-details">
                                            <div class="cart-item-header">
                                                <h3 class="cart-item-title">
                                                    <a
                                                        href="{{ route('product.details', $item->attributes->slug) }}">{{ $item->name }}</a>
                                                </h3>
                                                <div class="item-actions">
                                                    <button type="button" class="btn-wishlist" title="Add to wishlist">
                                                        <i class="far fa-heart"></i>
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="cart-item-meta">
                                                <span class="cart-item-category">
                                                    @if ($item->product && $item->product->category)
                                                        <i class="fas fa-tag"></i> {{ $item->product->category->name }}
                                                    @else
                                                        <i class="fas fa-exclamation-circle"></i> Unavailable
                                                    @endif
                                                </span>
                                            </div>

                                            <div class="cart-item-price-section">
                                                <div class="cart-item-price">
                                                    ${{ number_format($item->price, 2) }}
                                                    @if ($item->product && $item->product->sale_price && $item->product->sale_price < $item->product->price)
                                                        <span
                                                            class="cart-item-original-price">${{ number_format($item->product->price, 2) }}</span>
                                                        <span
                                                            class="discount-badge">-{{ round((($item->product->price - $item->product->sale_price) / $item->product->price) * 100) }}%</span>
                                                    @endif
                                                </div>
                                                <div class="quantity-section">
                                                    <div class="quantity-control">
                                                        <button type="button" class="quantity-btn" onclick="updateQuantity('{{ $item->id }}', -1)">
                                                            <i class="fas fa-minus"></i>
                                                        </button>
                                                        <input type="number" 
                                                               id="qty-{{ $item->id }}" 
                                                               class="quantity-input" 
                                                               value="{{ $item->quantity }}" 
                                                               min="1" 
                                                               max="{{ $item->product ? $item->product->quantity : 999 }}"
                                                               onchange="updateQuantity('{{ $item->id }}', 0, this)">
                                                        <button type="button" class="quantity-btn" onclick="updateQuantity('{{ $item->id }}', 1)">
                                                            <i class="fas fa-plus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="stock-status-section">
                                                @if ($item->product)
                                                    <div
                                                        class="stock-status {{ $item->product->quantity > 0 ? 'in-stock' : 'out-of-stock' }}">
                                                        <i
                                                            class="fas {{ $item->product->quantity > 0 ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                                                        <span>{{ $item->product->quantity > 0 ? 'In Stock' : 'Out of Stock' }}</span>
                                                        @if ($item->product->quantity > 0)
                                                            <small>({{ $item->product->quantity }} available)</small>
                                                        @endif
                                                    </div>
                                                @else
                                                    <div class="stock-status out-of-stock">
                                                        <i class="fas fa-exclamation-circle"></i>
                                                        <span>Product no longer available</span>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="cart-item-actions">
                                                <button type="button" class="btn-remove" onclick="removeItem('{{ $item->id }}', event)">
                                                    <i class="fas fa-trash"></i>
                                                    Remove
                                                </button>
                                            </div>

                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="empty-cart">
                                <div class="empty-cart-icon">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                                <div class="empty-cart-content">
                                    <h3>Your cart is empty</h3>
                                    <p>Looks like you haven't added anything to your cart yet. Start shopping to fill it up!
                                    </p>
                                    <div class="empty-cart-actions">
                                        <a href="/" class="btn btn-primary shop-now-btn">
                                            <i class="fas fa-shopping-bag me-2"></i>Continue Shopping
                                        </a>
                                        <a href="{{ route('category', 'featured') }}" class="btn btn-outline-secondary">
                                            <i class="fas fa-star me-2"></i>Featured Products
                                        </a>
                                    </div>
                                </div>
                                <div class="empty-cart-illustration">
                                    <div class="floating-items">
                                        <i class="fas fa-apple-alt fruit-1"></i>
                                        <i class="fas fa-carrot fruit-2"></i>
                                        <i class="fas fa-lemon fruit-3"></i>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Premium Order Summary -->
                @if (count($cartItems) > 0)
                    <div class="col-lg-4 order-summary-col">
                        <div class="cart-summary">
                            <div class="summary-header">
                                <i class="fas fa-receipt"></i>
                                <h3 class="summary-title">Order Summary</h3>
                            </div>

                            <div class="summary-content">
                                <div class="summary-row">
                                    <div class="summary-label">
                                        <i class="fas fa-shopping-bag"></i>
                                        <span>Subtotal ({{ $cartItems->sum('quantity') }} items)</span>
                                    </div>
                                    <span class="summary-value">${{ number_format($subtotal, 2) }}</span>
                                </div>

                                <div class="summary-row">
                                    <div class="summary-label">
                                        <i class="fas fa-truck"></i>
                                        <span>Shipping</span>
                                    </div>
                                    <span class="summary-value text-success">Free</span>
                                </div>

                                <div class="summary-row">
                                    <div class="summary-label">
                                        <i class="fas fa-percentage"></i>
                                        <span>Tax</span>
                                    </div>
                                    <span class="summary-value">${{ number_format($tax = 0, 2) }}</span>
                                </div>

                                @if ($subtotal > 100)
                                    <div class="summary-row discount-row">
                                        <div class="summary-label">
                                            <i class="fas fa-gift"></i>
                                            <span>Free Shipping Discount</span>
                                        </div>
                                        <span class="summary-value text-success">-$10.00</span>
                                    </div>
                                @endif

                                <div class="summary-divider"></div>

                                <div class="summary-row total">
                                    <div class="summary-label">
                                        <i class="fas fa-calculator"></i>
                                        <span>Total</span>
                                    </div>
                                    <span class="summary-value">${{ number_format($total, 2) }}</span>
                                </div>
                            </div>

                            <div class="summary-actions">
                                <a href="{{ route('checkout.index') }}" class="btn-checkout">
                                    Proceed to Checkout
                                    <i class="fas fa-arrow-right"></i>
                                </a>

                                <div class="continue-shopping">
                                    <a href="/">
                                        <i class="fas fa-arrow-left"></i>
                                        <span>Continue Shopping</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <!-- Toast Container -->
    <div class="toast-container" id="toastContainer"></div>

    <script>
        // Set up Axios defaults and premium interactions
        document.addEventListener('DOMContentLoaded', function() {
            axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]')
                .getAttribute('content');
            axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

            // Initialize premium animations
            initializeAnimations();

            // Make functions globally available
            // Premium toast notification system
            window.showToast = function(message, type = 'info', title = null) {
                const toastContainer = document.getElementById('toastContainer');
                if (!toastContainer) return;

                const toast = document.createElement('div');
                toast.className = `toast-notification ${type}`;

                const icons = {
                    success: 'fa-check',
                    error: 'fa-exclamation',
                    info: 'fa-info',
                    warning: 'fa-exclamation-triangle'
                };

                const titles = {
                    success: title || 'Success',
                    error: title || 'Error',
                    info: title || 'Info',
                    warning: title || 'Warning'
                };

                toast.innerHTML = `
            <div class="toast-icon">
                <i class="fas ${icons[type]}"></i>
            </div>
            <div class="toast-content">
                <div class="toast-title">${titles[type]}</div>
                <div class="toast-message">${message}</div>
            </div>
            <button class="toast-close" onclick="this.parentElement.remove()">
                <i class="fas fa-times"></i>
            </button>
        `;

                toastContainer.appendChild(toast);

                // Trigger animation
                setTimeout(() => toast.classList.add('show'), 10);

                // Auto remove after 4 seconds
                setTimeout(() => {
                    toast.classList.remove('show');
                    setTimeout(() => {
                        if (toast.parentElement) {
                            toast.remove();
                        }
                    }, 400);
                }, 4000);
            };

            // Update order summary with smooth animations
            function updateOrderSummary(subtotal, total, itemCount) {
                try {
                    const subtotalNum = parseFloat(subtotal) || 0;
                    const totalNum = parseFloat(total) || 0;
                    const itemCountNum = parseInt(itemCount) || 0;

                    // Update cart count in header with animation
                    const cartBadge = document.querySelector('.cart-badge');
                    if (cartBadge) {
                        cartBadge.style.transform = 'scale(1.2)';
                        setTimeout(() => {
                            cartBadge.textContent = itemCountNum;
                            cartBadge.style.transform = 'scale(1)';
                        }, 200);
                    }

                    // Update summary rows with smooth transitions
                    const summaryRows = document.querySelectorAll('.summary-row');
                    if (summaryRows.length > 0) {
                        // Update subtotal row
                        const firstRow = summaryRows[0];
                        if (firstRow) {
                            const countSpan = firstRow.querySelector('.summary-label span');
                            const valueSpan = firstRow.querySelector('.summary-value');

                            if (countSpan) {
                                const itemText = itemCountNum === 1 ? 'item' : 'items';
                                animateText(countSpan, `Subtotal (${itemCountNum} ${itemText})`);
                            }

                            if (valueSpan) {
                                animateValue(valueSpan, '$' + subtotalNum.toFixed(2));
                            }
                        }

                        // Update total row
                        const totalRow = document.querySelector('.summary-row.total .summary-value');
                        if (totalRow) {
                            animateValue(totalRow, '$' + totalNum.toFixed(2));
                        }
                    }

                } catch (error) {
                    console.error('Error updating order summary:', error);
                }
            }

            // Animate text changes
            function animateText(element, newText) {
                element.style.opacity = '0.5';
                element.style.transform = 'translateY(-2px)';
                setTimeout(() => {
                    element.textContent = newText;
                    element.style.opacity = '1';
                    element.style.transform = 'translateY(0)';
                }, 150);
            }

            // Animate value changes
            function animateValue(element, newValue) {
                element.style.transform = 'scale(1.1)';
                element.style.color = 'var(--primary)';
                setTimeout(() => {
                    element.textContent = newValue;
                    element.style.transform = 'scale(1)';
                    element.style.color = 'var(--text-dark)';
                }, 150);
            }

            // Premium quantity update function
            window.updateQuantity = function(productId, change, inputElement = null) {
                const input = inputElement || document.getElementById(`qty-${productId}`);
                if (!input) return;

                // Calculate new quantity
                let currentQty = parseInt(input.value) || 0;
                let newQty;

                if (inputElement) {
                    newQty = Math.max(1, currentQty);
                } else {
                    newQty = currentQty + (change > 0 ? 1 : -1);
                    const maxQty = parseInt(input.getAttribute('max')) || 9999;
                    newQty = Math.max(1, Math.min(newQty, maxQty));
                }

                if (newQty === currentQty) return;

                // Update input value with animation
                input.style.transform = 'scale(1.1)';
                input.value = newQty;
                setTimeout(() => {
                    input.style.transform = 'scale(1)';
                }, 150);

                // Disable controls during update
                const cartItem = document.getElementById(`cart-item-${productId}`);
                const buttons = document.querySelectorAll(`[onclick*="updateQuantity('${productId}'"]`);

                if (cartItem) cartItem.classList.add('cart-item-updating');
                buttons.forEach(btn => btn.disabled = true);

                // Build the update URL
                const updateUrl = '{{ url('cart/update') }}/' + productId;

                // Send the request
                axios({
                        method: 'post',
                        url: updateUrl,
                        data: {
                            quantity: newQty,
                            _token: '{{ csrf_token() }}',
                            update_summary: true
                        },
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => {
                        if (response.data.success) {
                            // Update cart count in header
                            const cartCount = document.querySelector('.cart-count');
                            if (cartCount && response.data.cart) {
                                animateValue(cartCount, response.data.cart.count);
                            }

                            // Update order summary
                            const subtotal = response.data.cart?.subtotal || response.data.subtotal || 0;
                            const total = response.data.cart?.total || response.data.total || 0;
                            const count = response.data.cart?.count || response.data.cart_count || 0;

                            updateOrderSummary(
                                String(subtotal).replace(/,/g, ''),
                                String(total).replace(/,/g, ''),
                                count
                            );

                            // Update individual item total
                            const itemTotal = cartItem?.querySelector('.item-total');
                            if (itemTotal) {
                                const newTotal = (parseFloat(response.data.item_price || input.value) *
                                    newQty).toFixed(2);
                                animateValue(itemTotal, 'Total: $' + newTotal);
                            }

                            showToast('Cart updated successfully', 'success', 'Updated');
                        }
                    })
                    .catch(error => {
                        console.error('Error updating quantity:', error);
                        let errorMessage =
                            'An error occurred while updating the quantity. Please try again.';

                        if (error.response && error.response.data && error.response.data.message) {
                            errorMessage = error.response.data.message;
                        }

                        showToast(errorMessage, 'error', 'Update Failed');
                        // Revert input value on error
                        input.value = currentQty;
                    })
                    .finally(() => {
                        // Re-enable controls and restore state
                        buttons.forEach(btn => btn.disabled = false);
                        if (cartItem) cartItem.classList.remove('cart-item-updating');
                    });
            };

            // Premium remove item function
            window.removeItem = function(productId, event) {
                if (event) event.preventDefault();

                const cartItem = document.getElementById(`cart-item-${productId}`);
                if (!cartItem) return false;

                const productName = cartItem.querySelector('.cart-item-title a')?.textContent.trim() ||
                    'this item';

                // Show beautiful confirmation dialog
                Swal.fire({
                    title: 'Remove Item?',
                    html: `Are you sure you want to remove <strong>${productName}</strong> from your cart?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Yes, remove it',
                    cancelButtonText: 'Keep it',
                    customClass: {
                        popup: 'border-radius-16',
                        confirmButton: 'btn btn-danger',
                        cancelButton: 'btn btn-secondary',
                        title: 'h4',
                        htmlContainer: 'text-muted'
                    },
                    buttonsStyling: false,
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Disable all remove buttons
                        const removeBtns = document.querySelectorAll('.btn-remove');
                        removeBtns.forEach(btn => btn.disabled = true);

                        // Add removing animation
                        cartItem.classList.add('cart-item-removing');

                        // Show loading state
                        Swal.fire({
                            title: 'Removing Item',
                            html: 'Please wait...',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        // Build the remove URL
                        const removeUrl = '{{ url('cart/remove') }}/' + productId;

                        // Send the request
                        axios({
                                method: 'post',
                                url: removeUrl,
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    _method: 'DELETE'
                                },
                                headers: {
                                    'Content-Type': 'application/x-www-form-urlencoded',
                                    'Accept': 'application/json'
                                }
                            })
                            .then(response => {
                                if (response.data.success) {
                                    // Close loading dialog
                                    Swal.close();

                                    // Show success message
                                    showToast(`${productName} has been removed from your cart`,
                                        'success', 'Item Removed');

                                    // Wait for animation then remove element
                                    setTimeout(() => {
                                        cartItem.remove();

                                        // Update cart count
                                        if (response.data.cart && response.data.cart
                                            .count !== undefined) {
                                            const cartBadge = document.querySelector(
                                                '.cart-badge');
                                            if (cartBadge) {
                                                animateValue(cartBadge, response.data.cart
                                                    .count);
                                            }

                                            // If cart is empty, reload page
                                            if (response.data.cart.count === 0) {
                                                setTimeout(() => window.location.reload(),
                                                    1000);
                                            }
                                        }

                                        // Update order summary
                                        if (response.data.cart) {
                                            updateOrderSummary(
                                                String(response.data.cart.subtotal)
                                                .replace(/,/g, ''),
                                                String(response.data.cart.total)
                                                .replace(/,/g, ''),
                                                response.data.cart.count
                                            );
                                        }
                                    }, 400);
                                }
                            })
                            .catch(error => {
                                console.error('Error removing item:', error);

                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Failed to remove item from cart. Please try again.',
                                    icon: 'error',
                                    confirmButtonText: 'OK',
                                    customClass: {
                                        popup: 'border-radius-16',
                                        confirmButton: 'btn btn-danger',
                                        title: 'h4'
                                    },
                                    buttonsStyling: false
                                });

                                // Restore state
                                removeBtns.forEach(btn => btn.disabled = false);
                                cartItem.classList.remove('cart-item-removing');
                            });
                    }
                });

                return false;
            };

            // Initialize premium animations
            function initializeAnimations() {
                // Animate cart items on load
                const cartItems = document.querySelectorAll('.cart-item');
                cartItems.forEach((item, index) => {
                    item.style.opacity = '0';
                    item.style.transform = 'translateY(20px)';
                    setTimeout(() => {
                        item.style.transition = 'all 0.5s ease-out';
                        item.style.opacity = '1';
                        item.style.transform = 'translateY(0)';
                    }, index * 100);
                });

                // Animate summary card
                const summary = document.querySelector('.cart-summary');
                if (summary) {
                    summary.style.opacity = '0';
                    summary.style.transform = 'translateY(20px)';
                    setTimeout(() => {
                        summary.style.transition = 'all 0.5s ease-out';
                        summary.style.opacity = '1';
                        summary.style.transform = 'translateY(0)';
                    }, cartItems.length * 100);
                }
            }

            // Add wishlist functionality
            document.querySelectorAll('.btn-wishlist').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    this.classList.toggle('active');
                    const icon = this.querySelector('i');

                    if (this.classList.contains('active')) {
                        icon.classList.remove('far');
                        icon.classList.add('fas');
                        showToast('Added to wishlist', 'success', 'Wishlist');
                    } else {
                        icon.classList.remove('fas');
                        icon.classList.add('far');
                        showToast('Removed from wishlist', 'info', 'Wishlist');
                    }
                });
            });


            // Initialize tooltips if Bootstrap is available
            if (typeof bootstrap !== 'undefined') {
                const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                tooltipTriggerList.forEach(function(tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
            }
        }); // End of DOMContentLoaded
    </script>
@endpush
