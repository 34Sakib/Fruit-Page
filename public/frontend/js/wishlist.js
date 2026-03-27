// Wishlist functionality
document.addEventListener('DOMContentLoaded', function() {
    // Add to wishlist
    $(document).on('click', '.product-wishlist', function(e) {
        e.preventDefault();
        const button = $(this);
        const icon = button.find('i');
        const productId = button.data('product-id');
        const isActive = button.hasClass('active');
        
        // Add loading state
        const originalIcon = icon.attr('class');
        icon.attr('class', 'fas fa-spinner fa-spin');
        
        // Make AJAX request
        const url = isActive ? `/wishlist/remove/${productId}` : `/wishlist/add/${productId}`;
        const method = isActive ? 'DELETE' : 'POST';
        
        $.ajax({
            url: url,
            type: method,
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    // Toggle active class
                    button.tClass('active');
                    
                    // Update icon
                    if (isActive) {
                        icon.attr('class', 'far fa-heart');
                        button.removeClass('active');
                    } else {
                        icon.attr('class', 'fas fa-heart');
                        button.addClass('active');
                    }
                    
                    // Update wishlist count in header
                    $('.wishlist-count-badge').text(response.count);
                    
                    // Show success message
                    const message = isActive ? 'Removed from wishlist' : 'Added to wishlist';
                    showToast('success', message);
                }
            },
            error: function(xhr) {
                // Revert icon on error
                icon.attr('class', originalIcon);
                
                if (xhr.status === 401) {
                    // Redirect to login if not authenticated
                    window.location.href = '/login';
                } else {
                    showToast('error', 'An error occurred. Please try again.');
                }
            }
        });
    });
    
    // Quick view functionality (placeholder)
    $(document).on('click', '.quick-view-btn', function(e) {
        e.preventDefault();
        const slug = $(this).data('slug');
        // Implement quick view modal here
        window.location.href = `/product/${slug}`;
    });
});

// Helper function to show toast messages
function showToast(type, message) {
    // Check if Toastr is available
    if (typeof toastr !== 'undefined') {
        toastr[type](message);
    } else if (typeof Swal !== 'undefined') {
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
            icon: type,
            title: message
        });
    } else {
        // Fallback to alert if no toast library is available
        alert(message);
    }
}

// Add toggle class method to jQuery
$.fn.toggleClass = function(className) {
    return this.each(function() {
        $(this).toggleClass(className);
    });
};
