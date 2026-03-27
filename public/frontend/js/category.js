// Ensure jQuery is loaded
if (typeof jQuery === 'undefined') {
    throw new Error('jQuery is not loaded');
}

jQuery(document).ready(function($) {
    // Initialize filter values from URL parameters
    function initializeFiltersFromUrl() {
        const urlParams = new URLSearchParams(window.location.search);
        
        // Set min and max price inputs
        if (urlParams.has('min_price')) {
            $('#min-price').val(urlParams.get('min_price'));
        }
        if (urlParams.has('max_price')) {
            $('#max-price').val(urlParams.get('max_price'));
        }
        
        // Set the select for sort_by
        const sortBy = urlParams.get('sort_by');
        if (sortBy) {
            $('#sort-by').val(sortBy);
        } else {
            $('#sort-by').val('');
        }

        // Set availability filter
        if (urlParams.has('availability')) {
            $(`input[name="availability"][value="${urlParams.get('availability')}"]`).prop('checked', true);
        }
    }
    
    // Initialize price range slider
    function initPriceSlider() {
        const priceRange = $('#price-range');
        const minPriceInput = $('#min-price');
        const maxPriceInput = $('#max-price');
        
        // Set initial slider value from max price or default to 1000
        const maxPrice = maxPriceInput.val() || 1000;
        priceRange.val(maxPrice);
        
        // Update slider when price inputs change
        function updateSlider() {
            const max = Math.max(minPriceInput.val() || 0, maxPriceInput.val() || 1000);
            priceRange.val(max);
        }
        
        // Update inputs when slider changes
        priceRange.on('input', function() {
            maxPriceInput.val(this.value).trigger('input');
        });
        
        // Update slider when max price changes
        maxPriceInput.on('input', updateSlider);
    }
    
    // Call the function to initialize filters when page loads
    initializeFiltersFromUrl();
    initPriceSlider();

    // Handle filter changes
    function handleFilterChange() {
        // Update URL with current filter values
        updateUrlWithFilters();
        // Load products with current filters
        loadProducts();
    }

    // Update URL with current filter values
    function updateUrlWithFilters() {
        const params = new URLSearchParams();
        
        // Add price filters if they have values
        const minPrice = $('#min-price').val();
        const maxPrice = $('#max-price').val();
        
        if (minPrice) params.set('min_price', minPrice);
        if (maxPrice) params.set('max_price', maxPrice);
        
        // Add sort by if selected
        const sortBy = $('#sort-by').val();
        if (sortBy) params.set('sort_by', sortBy);
        
        // Add availability filter
        const availability = $('input[name="availability"]:checked').val();
        if (availability && availability !== 'all') {
            params.set('availability', availability);
        }
        
        // Update URL without page reload
        const newUrl = window.location.pathname + (params.toString() ? '?' + params.toString() : '');
        window.history.pushState({ path: newUrl }, '', newUrl);
    }

    // Handle filter changes
    $(document).on('change', '#sort-by, input[name="availability"]', function() {
        handleFilterChange();
    });
    
    // Add debounce for price inputs
    var priceTimeout;
    $(document).on('input', '#min-price, #max-price', function() {
        clearTimeout(priceTimeout);
        priceTimeout = setTimeout(handleFilterChange, 500);
    });
    
    // Reset all filters
    $('.reset-btn').on('click', function(e) {
        e.preventDefault();
        $('#min-price, #max-price').val('');
        $('#sort-by').val('');
        $('input[name="availability"][value="all"]').prop('checked', true);
        handleFilterChange();
    });
    
    // Prevent form submission
    $('#filter-form').on('submit', function(e) {
        e.preventDefault();
        handleFilterChange();
    });
    
    // Initialize filters from URL on page load
    initializeFiltersFromUrl();
    handleFilterChange();

    // Handle pagination
    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        const page = $(this).attr('href').split('page=')[1];
        loadProducts(page);
    });

    function loadProducts(page = 1) {
        // Get current URL and create URLSearchParams
        const url = new URL(window.location.href);
        
        // Remove existing page parameter if it exists
        url.searchParams.delete('page');
        
        // Add the new page number
        if (page && page > 1) {
            url.searchParams.set('page', page);
        }
        
        // Show loading state
        const $productContainer = $('#product-container');
        const $pagination = $('.pagination');
        const $loadingHtml = `
            <div class="col-12 text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2">Loading products...</p>
            </div>`;
        
        // Store current scroll position
        const scrollPosition = window.scrollY;
        
        // Set loading state
        $productContainer.html($loadingHtml);
        $pagination.hide();
        
        // Add loading class to body
        document.body.classList.add('loading');
        
        // Make the AJAX request
        fetch(url.toString(), {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'text/html',
            },
            cache: 'no-cache'
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.text();
        })
        .then(html => {
            // Create a temporary div to parse the HTML
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = html;
            
            // Update the product container
            const newContent = tempDiv.querySelector('#product-container');
            if (newContent) {
                $productContainer.html(newContent.innerHTML);
            } else {
                $productContainer.html('<div class="col-12"><div class="alert alert-info">No products found matching your criteria.</div></div>');
            }
            
            // Update pagination
            const newPagination = tempDiv.querySelector('.pagination');
            if (newPagination && newPagination.innerHTML.trim() !== '') {
                $pagination.html(newPagination.outerHTML).show();
            } else {
                $pagination.hide();
            }
            
            // Restore scroll position and remove loading class
            window.scrollTo(0, scrollPosition);
            document.body.classList.remove('loading');
        })
        .catch(error => {
            console.error('Error loading products:', error);
            $productContainer.html(`
                <div class="col-12">
                    <div class="alert alert-danger">
                        Error loading products. Please try again.
                    </div>
                </div>`
            );
            document.body.classList.remove('loading');
        });
    }
}); // End of document ready