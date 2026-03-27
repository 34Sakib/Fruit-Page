// Countdown Timer Script
function updateCountdown() {
    // Set the date we're counting down to (7 days from now)
    const countDownDate = new Date();
    countDownDate.setDate(countDownDate.getDate() + 7);

    // Update the countdown every 1 second
    const x = setInterval(function() {
        // Get today's date and time
        const now = new Date().getTime();

        // Find the distance between now and the countdown date
        const distance = countDownDate - now;

        // Time calculations for days, hours, minutes and seconds
        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Display the result
        const daysEl = document.getElementById('days');
        const hoursEl = document.getElementById('hours');
        const minutesEl = document.getElementById('minutes');
        const secondsEl = document.getElementById('seconds');

        if (daysEl) daysEl.innerHTML = days.toString().padStart(2, '0');
        if (hoursEl) hoursEl.innerHTML = hours.toString().padStart(2, '0');
        if (minutesEl) minutesEl.innerHTML = minutes.toString().padStart(2, '0');
        if (secondsEl) secondsEl.innerHTML = seconds.toString().padStart(2, '0');

        // If the countdown is finished, clear the interval
        if (distance < 0) {
            clearInterval(x);
            if (daysEl) daysEl.innerHTML = '00';
            if (hoursEl) hoursEl.innerHTML = '00';
            if (minutesEl) minutesEl.innerHTML = '00';
            if (secondsEl) secondsEl.innerHTML = '00';
        }
    }, 1000);
}

// Main document ready function
jQuery(document).ready(function($) {
    // Initialize filter values from URL parameters
    function initializeFiltersFromUrl() {
        const urlParams = new URLSearchParams(window.location.search);

        // Set price range
        if (urlParams.has('min_price')) {
            $('#min-price').val(urlParams.get('min_price'));
        }
        if (urlParams.has('max_price')) {
            $('#max-price').val(urlParams.get('max_price'));
        }

        // Set sort by
        if (urlParams.has('sort_by')) {
            $('#sort-by').val(urlParams.get('sort_by'));
        }

        // Set availability
        if (urlParams.has('availability')) {
            $(`input[name="availability"][value="${urlParams.get('availability')}"]`).prop('checked', true);
        }

        // Update active filters display
        updateActiveFilters();
    }

    // Update URL with current filter values
    function updateUrl() {
        const url = new URL(window.location.href);
        const params = new URLSearchParams();

        // Add price filters
        const minPrice = $('#min-price').val();
        const maxPrice = $('#max-price').val();
        if (minPrice) params.set('min_price', minPrice);
        if (maxPrice) params.set('max_price', maxPrice);

        // Add sort by
        const sortBy = $('#sort-by').val();
        if (sortBy) params.set('sort_by', sortBy);

        // Add availability
        const availability = $('input[name="availability"]:checked').val();
        if (availability && availability !== 'all') {
            params.set('availability', availability);
        }

        // Update URL without page reload
        const newUrl = `${window.location.pathname}?${params.toString()}`;
        window.history.pushState({
            path: newUrl
        }, '', newUrl);

        // Update active filters display
        updateActiveFilters();

        return params;
    }

    // Update active filters display
    function updateActiveFilters() {
        const activeFilters = [];

        // Price range
        const minPrice = $('#min-price').val();
        const maxPrice = $('#max-price').val();
        if (minPrice || maxPrice) {
            activeFilters.push({
                name: 'Price',
                value: `$${minPrice || '0'} - $${maxPrice || '∞'}`,
                type: 'price'
            });
        }

        // Sort by
        const sortBy = $('#sort-by').val();
        if (sortBy) {
            const sortText = $('#sort-by option:selected').text();
            activeFilters.push({
                name: 'Sort',
                value: sortText,
                type: 'sort'
            });
        }

        // Availability
        const availability = $('input[name="availability"]:checked');
        if (availability.length && availability.val() !== 'all') {
            activeFilters.push({
                name: 'Availability',
                value: availability.next('label').text().trim(),
                type: 'availability'
            });
        }

        // Update the active filters display
        const activeFilterList = $('#active-filter-list');
        activeFilterList.empty();

        if (activeFilters.length === 0) {
            activeFilterList.append('<div class="text-muted small">No active filters</div>');
        } else {
            activeFilters.forEach(filter => {
                activeFilterList.append(`
                    <span class="active-filter-tag">
                        ${filter.name}: ${filter.value}
                        <i class="fas fa-times" data-type="${filter.type}"></i>
                    </span>
                `);
            });
        }
    }

    // Handle filter form submission
    $('#filter-form').on('submit', function(e) {
        e.preventDefault();
        updateUrl();
        loadProducts(1); // Reset to first page when filters change
    });

    // Handle reset button
    $('#filter-form').on('reset', function() {
        setTimeout(() => {
            updateUrl();
            loadProducts(1);
        }, 0);
    });

    // Handle removing active filters
    $(document).on('click', '.active-filter-tag i', function() {
        const filterType = $(this).data('type');

        switch (filterType) {
            case 'price':
                $('#min-price, #max-price').val('');
                break;
            case 'sort':
                $('#sort-by').val('');
                break;
            case 'availability':
                $('#all-items').prop('checked', true);
                break;
        }

        updateUrl();
        loadProducts(1);
    });

    // Price range slider
    const priceSlider = document.getElementById('price-range');
    const minPriceInput = document.getElementById('min-price');
    const maxPriceInput = document.getElementById('max-price');

    if (priceSlider && minPriceInput && maxPriceInput) {
        // Initialize slider values
        function updatePriceSlider() {
            const min = parseInt(minPriceInput.value) || 0;
            const max = parseInt(maxPriceInput.value) || 1000;

            // Update the slider's max value if needed
            if (max > parseInt(priceSlider.max)) {
                priceSlider.max = max;
            }

            // Update the slider's value to match the max price
            priceSlider.value = max;
        }

        // Update inputs when slider changes
        priceSlider.addEventListener('input', function() {
            const value = this.value;
            minPriceInput.value = minPriceInput.value || '0'; // Keep min price or set to 0
            maxPriceInput.value = value;

            // Update active filters
            updateActiveFilters();
        });

        // Update slider when inputs change
        minPriceInput.addEventListener('input', function() {
            if (parseInt(this.value) > parseInt(maxPriceInput.value)) {
                this.value = maxPriceInput.value;
            }
            updatePriceSlider();
        });

        maxPriceInput.addEventListener('input', function() {
            if (parseInt(this.value) < parseInt(minPriceInput.value)) {
                this.value = minPriceInput.value;
            }
            updatePriceSlider();
        });

        // Initialize filters from URL on page load
        updatePriceSlider();
    }

    // Handle form submission
    $('#filter-form').on('submit', function(e) {
        e.preventDefault();
        updateUrl();
        loadProducts(1);
        return false;
    });

    // Handle reset button
    $('.reset-btn').on('click', function(e) {
        e.preventDefault();
        // Reset form
        $('#filter-form')[0].reset();
        // Clear URL parameters
        window.history.pushState({}, document.title, window.location.pathname);
        // Reload products without filters
        loadProducts(1);
    });

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
                // Update cart count in header if exists
                if (response.cart_count) {
                    $('.cart-count').text(response.cart_count);
                }

                // Show success message
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Added to Cart!',
                        text: response.message || 'Product has been added to your cart.',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }

                // Update button to show "View Cart"
                button.addClass('added-to-cart');
            },
            error: function(xhr) {
                let errorMessage = 'Failed to add product to cart. Please try again.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }

                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: errorMessage,
                        confirmButtonText: 'OK'
                    });
                } else {
                    alert(errorMessage);
                }
            },
            complete: function() {
                // Reset loading state after a short delay
                setTimeout(() => {
                    button.removeClass('loading').prop('disabled', false);
                }, 500);
            }
        });
    });

    // Handle click on "View Cart" button
    $(document).on('click', '.view-cart-text', function(e) {
        e.preventDefault();
        e.stopPropagation();
        window.location.href = '/cart';
    });

    // Handle wishlist toggle
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
        const url = isActive ? `/wishlist/remove/${productId}` : `/wishlist/add/${productId}`;
        const method = isActive ? 'DELETE' : 'POST';

        // Make AJAX request
        $.ajax({
            url: url,
            type: method,
            data: {
                _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            success: function(response) {
                if (response.success) {
                    // Toggle active class
                    button.toggleClass('active');

                    // Update icon
                    if (isActive) {
                        icon.attr('class', 'far fa-heart');
                    } else {
                        icon.attr('class', 'fas fa-heart');
                    }

                    // Update wishlist count in header
                    $('.wishlist-count-badge').text(response.count);

                    // Show success message
                    const message = isActive ? 'Removed from wishlist' : 'Added to wishlist';

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
            },
            error: function(xhr) {
                // Revert icon on error
                icon.attr('class', originalIcon);

                if (xhr.status === 401) {
                    // Redirect to login if not authenticated
                    window.location.href = '/login';
                } else {
                    const errorMessage = xhr.responseJSON?.message || 'An error occurred. Please try again.';

                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: errorMessage
                        });
                    } else {
                        alert(errorMessage);
                    }
                }
            }
        });
    });

    // Handle quick view
    $(document).on('click', '.quick-view-btn', function(e) {
        e.preventDefault();
        const slug = $(this).data('slug');
        window.location.href = `/product/${slug}`;
    });

    // Add to cart button animation
    $(document).on('click', '.add-to-cart-btn:not(.disabled)', function(e) {
        const button = $(this);
        button.addClass('animating');

        // Remove animation class after it completes
        setTimeout(() => {
            button.removeClass('animating');
        }, 500);
    });

    // Handle direct changes to filter inputs
    function handleFilterChange() {
        updateUrl();
        loadProducts(1);
    }

    // Price input with debounce
    $('.price-input').on('keyup', function(e) {
        clearTimeout(window.priceTimeout);
        window.priceTimeout = setTimeout(handleFilterChange, 500);
    });

    // Other filter inputs
    $('#sort-by, input[name="availability"]').on('change', handleFilterChange);

    // Apply button
    $('.apply-btn').on('click', function(e) {
        e.preventDefault();
        handleFilterChange();
    });

    // Debounce function to prevent too many AJAX calls
    function debounce(func, wait) {
        let timeout;
        return function() {
            const context = this;
            const args = arguments;
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                func.apply(context, args);
            }, wait);
        };
    }

    // Loading state for AJAX requests
    function setLoading(loading) {
        if (loading) {
            $('body').addClass('loading');
            $('.loading-spinner').show();
        } else {
            $('body').removeClass('loading');
            $('.loading-spinner').hide();
        }
    }

    // Make AJAX request to load products
    function loadProducts(page = 1) {
        setLoading(true);

        // Get all filter values
        const minPrice = $('#min-price').val();
        const maxPrice = $('#max-price').val();
        const sortBy = $('#sort-by').val();
        const availability = $('input[name="availability"]:checked').val();

        // Create URL with all parameters
        const url = new URL(window.location.href);
        const params = new URLSearchParams();

        // Add filter parameters
        if (minPrice && minPrice > 0) params.set('min_price', minPrice);
        if (maxPrice && maxPrice > 0) params.set('max_price', maxPrice);
        if (sortBy) params.set('sort_by', sortBy);
        if (availability && availability !== 'all') {
            params.set('availability', availability);
        }

        // Add pagination
        if (page > 1) {
            params.set('page', page);
        }

        // Show loading state
        $('#product-container').addClass('loading');

        // Make AJAX request
        $.ajax({
            url: window.location.pathname,
            type: 'GET',
            data: params.toString(),
            dataType: 'json',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                // Update products grid
                if (response.html) {
                    $('#product-container').html(response.html);
                } else {
                    $('#product-container').html(
                        '<div class="col-12"><div class="alert alert-info">No products found matching your criteria.</div></div>'
                    );
                }

                // Update pagination
                if (response.pagination) {
                    $('.pagination').closest('.d-flex').replaceWith(response.pagination);
                } else {
                    $('.pagination').closest('.d-flex').remove();
                }

                // Update product count
                if (response.count !== undefined) {
                    $('.text-muted').text(response.count + ' items found');
                }

                // Update URL without page reload
                const newUrl = `${window.location.pathname}?${params.toString()}`;
                window.history.pushState({
                    path: newUrl
                }, '', newUrl);

                // Update active filters
                updateActiveFilters();
            },
            error: function(xhr, status, error) {
                console.error('Error loading products:', error);
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to load products. Please try again.'
                    });
                } else {
                    alert('Failed to load products. Please try again.');
                }
            },
            complete: function() {
                setLoading(false);
                $('#product-container').removeClass('loading');
            }
        });
    }

    // Handle pagination clicks
    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        const page = $(this).attr('href').split('page=')[1];
        loadProducts(page);
    });

    // Handle browser back/forward buttons
    window.addEventListener('popstate', function() {
        loadProducts();
    });

    // Initialize filters from URL on page load
    initializeFiltersFromUrl();
    updateActiveFilters();

    // Initialize countdown timer if element exists
    if (document.getElementById('days')) {
        updateCountdown();
    }

    // Initialize tooltips if Bootstrap tooltip is available
    if (typeof $.fn.tooltip === 'function') {
        $('[data-bs-toggle="tooltip"]').tooltip();
    }
});

// Ensure CSRF token is available for AJAX requests
if (typeof jQuery !== 'undefined') {
    jQuery.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
}
