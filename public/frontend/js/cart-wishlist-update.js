// Function to update cart count in the header
function updateCartCount(count) {
    // Ensure count is a number
    count = parseInt(count) || 0;
    
    // Update the cart count in the header
    const cartCountElement = document.getElementById('mobile-cart-count');
    if (cartCountElement) {
        cartCountElement.textContent = count;
        const cartBadge = cartCountElement.closest('.badge');
        if (cartBadge) {
            if (count > 0) {
                cartBadge.style.display = 'inline-block';
                cartBadge.style.visibility = 'visible';
                cartBadge.style.opacity = '1';
            } else {
                cartBadge.style.display = 'none';
            }
        }
    }
    
    // Also update any other elements with cart-count class
    document.querySelectorAll('.cart-count').forEach(element => {
        element.textContent = count;
        if (count > 0) {
            element.style.display = 'inline-block';
            element.style.visibility = 'visible';
            element.style.opacity = '1';
        } else {
            element.style.display = 'none';
        }
    });
}

// Function to update wishlist count in the header
function updateWishlistCount(count) {
    // Ensure count is a number
    count = parseInt(count) || 0;
    
    // Update the wishlist count in the header
    document.querySelectorAll('.wishlist-count, .wishlist-count-badge').forEach(element => {
        element.textContent = count;
        if (count > 0) {
            element.style.display = 'inline-block';
            element.style.visibility = 'visible';
            element.style.opacity = '1';
        } else {
            element.style.display = 'none';
        }
    });
}

// Show success message with SweetAlert2
function showSuccessMessage(message) {
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
}

// Initialize counts when the page loads
document.addEventListener('DOMContentLoaded', function() {
    // Get counts from server-side or from the DOM
    const cartCountFromDOM = parseInt(document.getElementById('mobile-cart-count')?.textContent || '0');
    const wishlistCountFromDOM = parseInt(document.querySelector('.wishlist-count-badge')?.textContent || '0');
    
    // Initialize with server-side values if available, otherwise use DOM values or 0
    const initialCartCount = typeof window.initialCartCount !== 'undefined' 
        ? window.initialCartCount 
        : (isNaN(cartCountFromDOM) ? 0 : cartCountFromDOM);
        
    const initialWishlistCount = typeof window.initialWishlistCount !== 'undefined' 
        ? window.initialWishlistCount 
        : (isNaN(wishlistCountFromDOM) ? 0 : wishlistCountFromDOM);
    
    // Update UI with initial counts
    updateCartCount(initialCartCount);
    updateWishlistCount(initialWishlistCount);
    
    // Make sure the counts stay visible
    setTimeout(() => {
        updateCartCount(initialCartCount);
        updateWishlistCount(initialWishlistCount);
    }, 100);
    
    // Listen for custom events for cart updates
    document.addEventListener('cartUpdated', function(e) {
        if (e.detail) {
            if (e.detail.count !== undefined) {
                updateCartCount(e.detail.count);
            }
            if (e.detail.message) {
                showSuccessMessage(e.detail.message);
            }
        }
    });

    // Listen for custom events for wishlist updates
    document.addEventListener('wishlistUpdated', function(e) {
        if (e.detail) {
            if (e.detail.count !== undefined) {
                updateWishlistCount(e.detail.count);
            }
            if (e.detail.message) {
                showSuccessMessage(e.detail.message);
            }
        }
    });
});

// Make functions available globally
window.updateCartCount = updateCartCount;
window.updateWishlistCount = updateWishlistCount;
