// Product Actions - Handles Add to Cart and Wishlist functionality
document.addEventListener('DOMContentLoaded', function() {
    // Initialize cart and wishlist counts
    updateCartCounts();
    updateWishlistCounts();
    
    // Handle Add to Cart
    $(document).on('submit', '.add-to-cart-form', function(e) {
        e.preventDefault();
        
        const form = $(this);
        const button = form.find('.add-to-cart-btn');
        const productId = form.data('product-id');
        
        // Show loading state
        button.addClass('loading').prop('disabled', true);
        
        // Get CSRF token
        const token = $('meta[name="csrf-token"]').attr('content');
        
        // Send AJAX request
        $.ajax({
            url: form.attr('action') || '/cart/add',
            type: 'POST',
            data: form.serialize(),
            headers: {
                'X-CSRF-TOKEN': token,
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function(response) {
                // Show success message
                const message = response.message || 'Product added to cart!';
                showSuccessMessage(message);
                
                // Update button to show "View Cart"
                button.addClass('added-to-cart');
                
                // Get the updated cart count from the response or use the existing count + 1
                const cartCount = response.cartCount || response.cart_count || 
                                (parseInt($('#mobile-cart-count').text() || '0') + 1);
                
                // Update the cart count in the UI
                updateCartCounts(cartCount);
                
                // Dispatch event to update other components
                document.dispatchEvent(new CustomEvent('cartUpdated', {
                    detail: {
                        count: cartCount,
                        message: message
                    }
                }));
            },
            error: function(xhr) {
                let errorMessage = 'Failed to add product to cart. Please try again.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                showError(errorMessage);
            },
            complete: function() {
                // Reset loading state after a short delay
                setTimeout(() => {
                    button.removeClass('loading').prop('disabled', false);
                }, 500);
            }
        });
    });

    // Handle Wishlist Toggle
    $(document).on('click', '.product-wishlist', function(e) {
        e.preventDefault();
        
        const button = $(this);
        const icon = button.find('i');
        const productId = button.data('product-id');
        const isActive = button.hasClass('active');
        
        // Add loading state
        const originalIcon = icon.attr('class');
        icon.attr('class', 'fas fa-spinner fa-spin');
        
        // Determine the URL and method based on current state
        const url = isActive ? 
            button.data('remove-wishlist-url') : 
            button.data('wishlist-url');
        const method = isActive ? 'DELETE' : 'POST';
        
        // Make AJAX request
        $.ajax({
            url: url,
            type: method,
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    // Only toggle active class if it's a remove operation or if product wasn't already in wishlist
                    if (isActive || !response.already_exists) {
                        button.toggleClass('active');
                    }
                    
                    // Update icon - ensure heart is filled for both new additions and existing items
                    if (isActive) {
                        icon.attr('class', 'far fa-heart');
                    } else {
                        icon.attr('class', 'fas fa-heart');
                    }
                    
                    // Get the updated wishlist count from the response
                    let newCount = response.count;
                    
                    // Update wishlist count in header
                    updateWishlistCounts(newCount);
                    
                    // Show success message
                    showSuccessMessage(response.message);
                    
                    // Dispatch event to update other components
                    document.dispatchEvent(new CustomEvent('wishlistUpdated', {
                        detail: {
                            count: newCount,
                            message: response.message
                        }
                    }));
                }
            },
            error: function(xhr) {
                // Revert icon on error
                icon.attr('class', originalIcon);
                
                if (xhr.status === 401) {
                    // Redirect to login if not authenticated
                    window.location.href = '/login';
                } else {
                    showError('An error occurred. Please try again.');
                }
            }
        });
    });
    
    // Handle click on "View Cart" text in the button
    $(document).on('click', '.view-cart-text', function(e) {
        e.preventDefault();
        e.stopPropagation();
        window.location.href = '/cart';
    });
});

// Update cart counts in UI
function updateCartCounts(count) {
    const cartCountElements = document.querySelectorAll('.cart-count, #mobile-cart-count');
    cartCountElements.forEach(element => {
        element.textContent = count || 0;
        if (count > 0) {
            element.style.display = 'inline-block';
            element.style.visibility = 'visible';
            element.style.opacity = '1';
        } else {
            element.style.display = 'none';
        }
    });
}

// Update wishlist counts in UI
function updateWishlistCounts(count) {
    const wishlistCountElements = document.querySelectorAll('.wishlist-count, .wishlist-count-badge');
    wishlistCountElements.forEach(element => {
        element.textContent = count || 0;
        if (count > 0) {
            element.style.display = 'inline-block';
            element.style.visibility = 'visible';
            element.style.opacity = '1';
        } else {
            element.style.display = 'none';
        }
    });
}

// Show success message
function showSuccessMessage(message) {
    if (typeof Swal !== 'undefined') {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });

        Toast.fire({
            icon: 'success',
            title: message
        });
    } else {
        alert(message);
    }
}

// Show error message
function showError(message) {
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: message,
            confirmButtonText: 'OK'
        });
    } else {
        alert('Error: ' + message);
    }
}

// Make functions available globally
window.updateCartCounts = updateCartCounts;
window.updateWishlistCounts = updateWishlistCounts;
