<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', '🌱 GreenRootMart - Fresh & Organic Groceries')</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <!-- Axios for AJAX requests -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <!-- Bootstrap & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    
    <!-- Main CSS Files -->
    <link href="{{ asset('frontend/css/home.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/loading.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/sidebar-modern.css') }}" rel="stylesheet">
    
    <!-- Live Search Styles -->
    <style>
        .search-box {
            position: relative;
        }
        
        .search-results-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #ddd;
            border-radius: 0 0 8px 8px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
            max-height: 400px;
            overflow-y: auto;
            z-index: 99999;
            display: none;
            margin-top: 0;
        }
        
        .search-results-dropdown.active {
            display: block !important;
            opacity: 1 !important;
            transform: translateY(0) !important;
        }
        
        .search-result-item {
            padding: 12px 15px;
            border-bottom: 1px solid #f0f0f0;
            cursor: pointer;
            transition: background-color 0.2s ease;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .search-result-item:hover {
            background-color: #f8f9fa;
        }
        
        .search-result-item:last-child {
            border-bottom: none;
        }
        
        .search-view-all {
            background-color: #f8f9fa;
            border-top: 2px solid #27ae60;
            font-weight: 500;
        }
        
        .search-view-all:hover {
            background-color: #e8f5e8;
        }
        
        .search-result-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 6px;
            border: 1px solid #e0e0e0;
        }
        
        .search-result-details {
            flex: 1;
            min-width: 0;
        }
        
        .search-result-name {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .search-result-price {
            color: #27ae60;
            font-weight: 500;
            font-size: 14px;
        }
        
        .search-result-category {
            color: #7f8c8d;
            font-size: 12px;
            margin-top: 2px;
        }
        
        .search-no-results {
            padding: 20px;
            text-align: center;
            color: #7f8c8d;
        }
        
        .search-loading {
            padding: 20px;
            text-align: center;
            color: #27ae60;
        }
        
        .search-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 2px solid #f3f3f3;
            border-top: 2px solid #27ae60;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-right: 10px;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .search-results-dropdown {
                max-height: 300px;
            }
            
            .search-result-item {
                padding: 10px 12px;
            }
            
            .search-result-image {
                width: 40px;
                height: 40px;
            }
        }
    </style>
    
    <!-- Custom CSS -->
    @stack('styles')

        
</head>
<body>
    @include('frontend.body.header')

    @yield('content')

    @include('frontend.body.footer')
    
    <!-- Loading Spinner -->
    <div id="loading-spinner" class="loading-spinner" style="display: none;"></div>

    <!-- Load additional scripts -->
    @stack('scripts')
    
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Initialize cart and wishlist counts -->
    <script>
        window.initialCartCount = {{ Cart::getTotalQuantity() }};
        window.initialWishlistCount = {{ count(session('wishlist', [])) }};
    </script>
    
    <!-- Cart and Wishlist Update Scripts -->
    <script src="{{ asset('frontend/js/cart-wishlist-update.js') }}"></script>
    <script src="{{ asset('frontend/js/product-actions.js') }}"></script>
    
    <script>
    // Show/hide loading spinner when body has loading class
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.attributeName === 'class') {
                const spinner = document.getElementById('loading-spinner');
                if (document.body.classList.contains('loading')) {
                    spinner.style.display = 'block';
                } else {
                    spinner.style.display = 'none';
                }
            }
        });
    });
    
    observer.observe(document.body, { attributes: true });
    
    // Initialize all dropdowns
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Bootstrap dropdowns with better error handling
        var dropdownElementList = [].slice.call(document.querySelectorAll('[data-bs-toggle="dropdown"]'));
        var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
            try {
                return new bootstrap.Dropdown(dropdownToggleEl);
            } catch (e) {
                console.warn('Failed to initialize dropdown:', e);
                return null;
            }
        });
        
        // Re-initialize dropdowns after a short delay to ensure they're ready
        setTimeout(function() {
            var dropdownElements = document.querySelectorAll('[data-bs-toggle="dropdown"]');
            dropdownElements.forEach(function(element) {
                try {
                    if (!element.dataset.bsInitialized) {
                        new bootstrap.Dropdown(element);
                        element.dataset.bsInitialized = 'true';
                    }
                } catch (e) {
                    console.warn('Failed to re-initialize dropdown:', e);
                }
            });
        }, 100);
        
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
        
        // Add smooth scroll to top when clicking on category links
        document.querySelectorAll('.category-item, .offer-item').forEach(link => {
            link.addEventListener('click', function(e) {
                // Add active class to clicked category
                if (this.classList.contains('category-item')) {
                    document.querySelectorAll('.category-item').forEach(item => {
                        item.classList.remove('active');
                    });
                    this.classList.add('active');
                }
                
                // Smooth scroll to top
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        });
    });
    </script>
    <script>
    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Bootstrap tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
        
        // Add smooth scroll to top when clicking on category links
        document.querySelectorAll('.category-item, .offer-item').forEach(link => {
            link.addEventListener('click', function(e) {
                // Add active class to clicked category
                if (this.classList.contains('category-item')) {
                    document.querySelectorAll('.category-item').forEach(item => {
                        item.classList.remove('active');
                    });
                    this.classList.add('active');
                }
                
                // Smooth scroll to top
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        });
        
        // Toggle subcategories on mobile
        const categoryItems = document.querySelectorAll('.category-item');
        categoryItems.forEach(item => {
            item.addEventListener('click', function(e) {
                if (window.innerWidth < 992) {
                    const subcategories = this.nextElementSibling;
                    if (subcategories && subcategories.classList.contains('subcategories')) {
                        e.preventDefault();
                        subcategories.style.display = subcategories.style.display === 'none' ? 'block' : 'none';
                    }
                }
            });
        });
    });
    </script>
    
    <!-- Live Search Script -->
    <script src="{{ asset('frontend/js/live-search.js') }}?v={{ time() }}"></script>
</body>
</html>
