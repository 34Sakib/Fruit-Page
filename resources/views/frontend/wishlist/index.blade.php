@extends('frontend.layouts.master')

@push('styles')
    <link href="{{ asset('frontend/css/wishlist.css') }}" rel="stylesheet">
    <style>
        body { margin: 0; padding: 0; }
        
        /* Hide wishlist count only in the wishlist page body, not in header */
        .wishlist-page .wishlist-count {
            display: none !important;
        }
        
        /* Move action buttons to the right side */
        .wishlist-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .wishlist-actions {
            display: flex;
            gap: 0.5rem;
            margin-left: auto;
        }
    </style>
@endpush

@section('content')
<!-- Wishlist Page -->
<section class="wishlist-page">
    <!-- Page Header -->
    <div class="page-header">
        <div class="container">
            <div class="wishlist-icon">
                <i class="fas fa-heart"></i>
            </div>
            <h1 class="page-title">My Wishlist</h1>
            <p class="page-subtitle">Save your favorite organic products and access them anytime. Never miss out on deals for items you love!</p>
        </div>
    </div>

    <div class="container wishlist-container">
        <!-- Wishlist Header -->
        <div class="wishlist-header">
            <div class="wishlist-count">
                <i class="fas fa-heart text-danger me-2"></i> 
                <span id="wishlist-count">{{ count($products) }}</span> 
                {{ Str::plural('item', count($products)) }} in your wishlist
            </div>
            @if(count($products) > 0)
            <div class="wishlist-actions">
                <a href="{{ route('home') }}" class="action-btn continue-shopping" onclick="window.location.href='{{ route('home') }}'; return false;">
                    <i class="fas fa-shopping-bag"></i> Continue Shopping
                </a>
                <button type="button" class="action-btn clear-all-btn" id="clear-wishlist">
                    <i class="fas fa-trash"></i> Clear All
                </button>
            </div>
            @endif
        </div>

        <!-- Wishlist Items -->
        <div class="wishlist-items" id="wishlist-items">
            @if(count($products) > 0)
                @foreach($products as $product)
                <div class="wishlist-item" id="wishlist-item-{{ $product->id }}">
                    <img src="{{ $product->image_url }}" 
                         class="wishlist-item-image" alt="{{ $product->name }}">
                    <div class="wishlist-item-content">
                        <div class="wishlist-item-header">
                            <div>
                                <a href="{{ route('product.details', $product->slug) }}" class="wishlist-item-title">{{ $product->name }}</a>
                                <div class="wishlist-item-category">
                                    <i class="fas fa-tag"></i> {{ $product->category->name ?? 'Uncategorized' }}
                                </div>
                            </div>
                            <button class="remove-wishlist" data-product-id="{{ $product->id }}">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        
                        <div class="product-features">
                            @if($product->category)
                                <span class="feature-tag organic-tag">{{ $product->category->name }}</span>
                            @endif
                            @if($product->is_seasonal)
                                <span class="feature-tag seasonal-tag">Seasonal</span>
                            @endif
                            @if($product->is_featured)
                                <span class="feature-tag featured-tag">Featured</span>
                            @endif
                        </div>
                        
                        <div class="wishlist-item-details">
                            <div class="price-section">
                                @if($product->sale_price < $product->price)
                                    <span class="current-price">${{ number_format($product->sale_price, 2) }}</span>
                                    <del class="original-price">${{ number_format($product->price, 2) }}</del>
                                    <div class="price-saving">Save ${{ number_format($product->price - $product->sale_price, 2) }}</div>
                                @else
                                    <span class="current-price">${{ number_format($product->price, 2) }}</span>
                                @endif
                                <div class="stock-status {{ $product->quantity > 0 ? 'in-stock' : 'out-of-stock' }}">
                                    <i class="fas {{ $product->quantity > 0 ? 'fa-check-circle' : 'fa-times-circle' }} me-1"></i>
                                    {{ $product->quantity > 0 ? 'In Stock' : 'Out of Stock' }}
                                </div>
                            </div>
                            <div class="wishlist-item-actions">
                                @if($product->quantity > 0)
                                <form action="{{ route('cart.add') }}" method="POST" class="add-to-cart-form" data-product-id="{{ $product->id }}">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="add-to-cart-btn" {{ $product->quantity <= 0 ? 'disabled' : '' }}>
                                        <i class="fas fa-shopping-cart"></i> Add to Cart
                                    </button>
                                </form>
                                @else
                                <button class="add-to-cart-btn" disabled>
                                    <i class="fas fa-times-circle"></i> Out of Stock
                                </button>
                                @endif
                                <a href="{{ route('product.details', $product->slug) }}" class="view-details-btn">View Details</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
            <div class="empty-wishlist">
                <div class="empty-wishlist-icon">
                    <i class="far fa-heart"></i>
                </div>
                <h3 class="empty-wishlist-title">Your wishlist is empty</h3>
                <p class="empty-wishlist-text">
                    You haven't added any products to your wishlist yet. Start exploring our organic collection and save your favorites for later!
                </p>
                <a href="{{ route('home') }}" class="browse-products-btn">
                    <i class="fas fa-shopping-bag me-2"></i> Browse Products
                </a>
            </div>
            @endif
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Make sure Swal is available
        if (typeof Swal === 'undefined') {
            console.error('SweetAlert2 is not loaded');
            return;
        }
        // Remove item from wishlist
        $(document).on('click', '.remove-wishlist', function(e) {
            e.preventDefault();
            const productId = $(this).data('product-id');
            const wishlistItem = $(`#wishlist-item-${productId}`);
            const productName = wishlistItem.find('.wishlist-item-title').text().trim();

            Swal.fire({
                title: 'Remove Item',
                text: `Are you sure you want to remove ${productName} from your wishlist?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#2ecc71',
                cancelButtonColor: '#95a5a6',
                confirmButtonText: 'Yes, remove it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading state
                    const button = $(this);
                    const originalHtml = button.html();
                    button.html('<i class="fas fa-spinner fa-spin"></i>');

                    // Make AJAX request
                    $.ajax({
                        url: `{{ route('wishlist.remove', '') }}/${productId}`,
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            _method: 'DELETE'
                        },
                        success: function(response) {
                            // Show success message
                            Swal.fire({
                                icon: 'success',
                                title: 'Removed!',
                                text: `${productName} has been removed from your wishlist.`,
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true
                            });

                            // Remove item from DOM with animation
                            wishlistItem.fadeOut(300, function() {
                                $(this).remove();
                                updateWishlistCount(response.count);
                                
                                // If no items left, reload the page to show empty state
                                if (response.count === 0) {
                                    window.location.reload();
                                }
                            });
                        },
                        error: function(xhr) {
                            console.error(xhr);
                            button.html(originalHtml);
                            
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to remove item from wishlist',
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000
                            });
                        }
                    });
                }
            });
        });

        // Clear all wishlist items
        $('#clear-wishlist').on('click', function(e) {
            e.preventDefault();
            
            Swal.fire({
                title: 'Clear Wishlist',
                text: 'Are you sure you want to remove all items from your wishlist?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#2ecc71',
                cancelButtonColor: '#95a5a6',
                confirmButtonText: 'Yes, clear it!',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    const button = $(this);
                    const originalHtml = button.html();
                    button.html('<i class="fas fa-spinner fa-spin"></i> Clearing...');
                    
                    // Make AJAX request to clear wishlist
                    $.ajax({
                        url: '{{ route("wishlist.clear") }}',
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            _method: 'DELETE'
                        },
                        success: function(response) {
                            // Update UI first
                            $('.wishlist-items').fadeOut(300, function() {
                                $('.wishlist-actions').fadeOut(300, function() {
                                    updateWishlistCount(0);
                                    
                                    // Show success message after UI updates
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Cleared!',
                                        text: 'Your wishlist has been cleared.',
                                        showConfirmButton: false,
                                        timer: 1500
                                    }).then(() => {
                                        window.location.reload();
                                    });
                                });
                            });
                        },
                        error: function(xhr) {
                            console.error(xhr);
                            button.html(originalHtml);
                            
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to clear wishlist',
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000
                            });
                        }
                    });
                }
            });
        });

        // Function to update wishlist count in the header
        function updateWishlistCount(count) {
            $('#wishlist-count').text(count);
            $('.wishlist-count-badge').text(count);
            
            // Update the count in the header
            if (count === 0) {
                $('.wishlist-count-badge').addClass('d-none');
            } else {
                $('.wishlist-count-badge').removeClass('d-none');
            }
        }

        // Show any alert messages from the server
        @if(session('alert'))
            const alert = @json(session('alert'));
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: alert.type || 'info',
                    title: alert.title || 'Notice',
                    text: alert.message,
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
                
                // Update count if provided
                if (typeof alert.count !== 'undefined') {
                    updateWishlistCount(alert.count);
                }
            }
        @endif
    });
</script>
@endpush
