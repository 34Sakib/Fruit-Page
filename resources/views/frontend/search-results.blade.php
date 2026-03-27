@extends('frontend.layouts.master')

@push('styles')
    <link href="{{ asset('frontend/css/product-card.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/category-menu.css') }}" rel="stylesheet">
    <style>
        /* Search Results Page Specific Styles */
        .search-hero {
            background: linear-gradient(135deg, rgba(46, 204, 113, 0.05), rgba(26, 188, 156, 0.05));
            border-radius: 20px;
            padding: 2.5rem;
            margin-bottom: 2rem;
            border: 1px solid rgba(46, 204, 113, 0.1);
            position: relative;
            overflow: hidden;
        }
        
        .search-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(46, 204, 113, 0.1), transparent);
            animation: shimmer 3s infinite;
        }
        
        @keyframes shimmer {
            0% { left: -100%; }
            100% { left: 100%; }
        }
        
        .search-title {
            font-size: 2rem;
            font-weight: 800;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .search-query {
            color: var(--primary);
            background: rgba(46, 204, 113, 0.1);
            padding: 0.25rem 0.75rem;
            border-radius: 8px;
            font-weight: 600;
        }
        
        .search-stats {
            display: flex;
            align-items: center;
            gap: 2rem;
            margin-top: 1rem;
            flex-wrap: wrap;
        }
        
        .stat-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--text-light);
            font-size: 0.95rem;
        }
        
        .stat-item i {
            color: var(--primary);
            font-size: 1.1rem;
        }
        
        .stat-number {
            font-weight: 700;
            color: var(--text-dark);
        }
        
        /* Enhanced Sidebar */
        .search-sidebar {
            position: sticky;
            top: 2rem;
        }
        
        .sidebar-card {
            border: none;
            border-radius: 16px;
            box-shadow: var(--shadow);
            overflow: hidden;
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
            background: white;
        }
        
        .sidebar-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-hover);
        }
        
        .card-header-custom {
            background: var(--gradient-primary);
            color: white;
            padding: 1.25rem 1.5rem;
            border-bottom: none;
            position: relative;
        }
        
        .card-header-custom::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: rgba(255, 255, 255, 0.3);
        }
        
        .card-header-custom h5 {
            margin: 0;
            font-weight: 700;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
        }
        
        .card-header-custom h5 i {
            margin-right: 0.75rem;
            font-size: 1.2rem;
        }
        
        /* Enhanced Product Grid */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.5rem;
            animation: fadeInUp 0.6s ease-out;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Enhanced Sorting Bar */
        .sorting-bar {
            background: white;
            border-radius: 12px;
            padding: 1rem 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
            border: 1px solid #f1f3f4;
        }
        
        .view-options {
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }
        
        .view-btn {
            background: transparent;
            border: 2px solid #e9ecef;
            color: var(--text-light);
            padding: 0.5rem 0.75rem;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .view-btn:hover, .view-btn.active {
            background: var(--primary);
            border-color: var(--primary);
            color: white;
        }
        
        .sort-dropdown {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .sort-dropdown select {
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
            background: white;
            cursor: pointer;
            transition: all 0.3s ease;
            min-width: 180px;
        }
        
        .sort-dropdown select:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 0.2rem rgba(46, 204, 113, 0.25);
        }
        
        /* Enhanced Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            background: white;
            border-radius: 20px;
            box-shadow: var(--shadow);
            margin: 2rem 0;
        }
        
        .empty-state-icon {
            width: 120px;
            height: 120px;
            margin: 0 auto 2rem;
            background: linear-gradient(135deg, rgba(46, 204, 113, 0.1), rgba(26, 188, 156, 0.1));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: var(--primary);
        }
        
        .empty-state h3 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 1rem;
        }
        
        .empty-state p {
            color: var(--text-light);
            margin-bottom: 2rem;
            font-size: 1.1rem;
            line-height: 1.6;
        }
        
        .empty-state-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .btn-primary-custom {
            background: var(--gradient-primary);
            color: white;
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 10px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(46, 204, 113, 0.3);
        }
        
        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(46, 204, 113, 0.4);
            color: white;
        }
        
        .btn-secondary-custom {
            background: white;
            color: var(--text-dark);
            border: 2px solid #e9ecef;
            padding: 0.75rem 2rem;
            border-radius: 10px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }
        
        .btn-secondary-custom:hover {
            border-color: var(--primary);
            color: var(--primary);
            transform: translateY(-2px);
        }
        
        /* Loading State */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.9);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            backdrop-filter: blur(2px);
        }
        
        .loading-spinner {
            width: 60px;
            height: 60px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid var(--primary);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .search-hero {
                padding: 1.5rem;
            }
            
            .search-title {
                font-size: 1.5rem;
            }
            
            .search-stats {
                gap: 1rem;
            }
            
            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
                gap: 1rem;
            }
            
            .sorting-bar {
                flex-direction: column;
                align-items: stretch;
            }
            
            .sort-dropdown {
                justify-content: space-between;
            }
            
            .sort-dropdown select {
                flex: 1;
            }
        }
        
        @media (max-width: 576px) {
            .products-grid {
                grid-template-columns: 1fr;
            }
            
            .empty-state-actions {
                flex-direction: column;
            }
            
            .btn-primary-custom, .btn-secondary-custom {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
@endpush

@section('title', 'Search Results for "' . $query . '" - GreenRootMart')

@section('content')
<!-- Loading Overlay -->
<div class="loading-overlay" id="loadingOverlay">
    <div class="loading-spinner"></div>
</div>

<div class="container py-5">
    <!-- Search Hero Section -->
    <div class="search-hero">
        <div class="search-title">
            <i class="fas fa-search"></i>
            Search Results
            <span class="search-query">"{{ $query }}"</span>
        </div>
        <div class="search-stats">
            <div class="stat-item">
                <i class="fas fa-box"></i>
                <span class="stat-number">{{ $products->total() }}</span>
                <span>Products Found</span>
            </div>
            @if($products->total() > 0)
                <div class="stat-item">
                    <i class="fas fa-clock"></i>
                    <span>{{ number_format($products->total() / 12, 1) }} seconds</span>
                    <span>Browse Time</span>
                </div>
                <div class="stat-item">
                    <i class="fas fa-filter"></i>
                    <span>{{ $categories->count() }}</span>
                    <span>Categories</span>
                </div>
            @endif
        </div>
    </div>

    <div class="row">
        <!-- Enhanced Sidebar -->
        <div class="col-lg-3">
            <div class="search-sidebar">
                @include('frontend.partials.category-sidebar', ['categories' => $categories])
                
                <!-- Enhanced Filters -->
                <div class="filter-card">
                    <div class="filter-header">
                        <h5><i class="fas fa-sliders-h"></i>Smart Filters</h5>
                    </div>
                    <div class="filter-body">
                        <form id="filter-form">
                            <!-- Price Range Section -->
                            <div class="filter-section">
                                <div class="filter-title">
                                    <i class="fas fa-tag"></i>Price Range
                                </div>
                                <div class="price-inputs">
                                    <div class="price-input-group">
                                        <label for="min-price">Min Price</label>
                                        <input type="number" class="price-input" name="min_price" placeholder="0"
                                            id="min-price">
                                    </div>
                                    <div class="price-input-group">
                                        <label for="max-price">Max Price</label>
                                        <input type="number" class="price-input" name="max_price" placeholder="1000"
                                            id="max-price">
                                    </div>
                                </div>
                                <div class="price-slider-container">
                                    <input type="range" class="price-slider" id="price-range" min="0"
                                        max="1000" value="1000">
                                </div>
                            </div>

                            <!-- Sort By Section -->
                            <div class="filter-section">
                                <div class="filter-title">
                                    <i class="fas fa-sort-amount-down"></i>Sort By
                                </div>
                                <select class="sort-select" name="sort_by" id="sort-by">
                                    <option value="">Default</option>
                                    <option value="price_asc">Price: Low to High</option>
                                    <option value="price_desc">Price: High to Low</option>
                                    <option value="newest">Newest First</option>
                                    <option value="rating">Highest Rated</option>
                                </select>
                            </div>

                            <!-- Availability Section -->
                            <div class="filter-section">
                                <div class="filter-title">
                                    <i class="fas fa-check-circle"></i>Availability
                                </div>
                                <div class="filter-options">
                                    <div class="filter-option">
                                        <input type="checkbox" name="availability" 
                                               value="in_stock" id="in-stock">
                                        <label for="in-stock">In Stock Only</label>
                                    </div>
                                    <div class="filter-option">
                                        <input type="checkbox" name="availability" 
                                               value="on_sale" id="on-sale">
                                        <label for="on-sale">On Sale</label>
                                    </div>
                                    <div class="filter-option">
                                        <input type="checkbox" name="availability" 
                                               value="featured" id="featured">
                                        <label for="featured">Featured Products</label>
                                    </div>
                                </div>
                            </div>

                            <div class="filter-buttons">
                                <button type="submit" class="apply-btn">
                                    <i class="fas fa-filter"></i> Apply Filters
                                </button>
                                <button type="button" class="reset-btn" onclick="resetFilters()">
                                    <i class="fas fa-redo"></i> Reset
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-lg-9">
            <!-- Enhanced Sorting Bar -->
            <div class="sorting-bar">
                <div class="view-options">
                    <span class="text-muted">View:</span>
                    <button class="view-btn active" data-view="grid" onclick="setViewMode('grid')">
                        <i class="fas fa-th"></i>
                    </button>
                    <button class="view-btn" data-view="list" onclick="setViewMode('list')">
                        <i class="fas fa-list"></i>
                    </button>
                </div>
                <div class="sort-dropdown">
                    <span class="text-muted">Sort by:</span>
                    <select name="sort_by" id="mobile-sort-by" onchange="applyFilters()">
                        <option value="">Default</option>
                        <option value="price_asc">Price: Low to High</option>
                        <option value="price_desc">Price: High to Low</option>
                        <option value="newest">Newest First</option>
                        <option value="rating">Highest Rated</option>
                        <option value="popularity">Most Popular</option>
                        <option value="discount">Biggest Discount</option>
                    </select>
                </div>
            </div>

            <!-- Products Grid -->
            @if($products->count() > 0)
                <div class="products-grid" id="products-container">
                    @foreach($products as $product)
                        <div class="product-item">
                            @include('frontend.partials.product-card', ['product' => $product])
                        </div>
                    @endforeach
                </div>

                <!-- Enhanced Pagination -->
                <div class="mt-5 d-flex justify-content-center">
                    {{ $products->links() }}
                </div>
            @else
                <!-- Enhanced Empty State -->
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fas fa-search"></i>
                    </div>
                    <h3>No Products Found</h3>
                    <p>
                        We couldn't find any products matching "<strong>{{ $query }}</strong>". 
                        Try searching with different keywords or browse our categories.
                    </p>
                    <div class="empty-state-actions">
                        <a href="{{ url('/') }}" class="btn-primary-custom">
                            <i class="fas fa-home"></i> Back to Home
                        </a>
                        <button type="button" class="btn-secondary-custom" onclick="history.back()">
                            <i class="fas fa-arrow-left"></i> Go Back
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterForm = document.getElementById('filter-form');
    const mobileSortBy = document.getElementById('mobile-sort-by');
    const loadingOverlay = document.getElementById('loadingOverlay');
    
    // Handle filter form submission
    if (filterForm) {
        filterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            applyFilters();
        });
    }
    
    // Handle mobile sort change
    if (mobileSortBy) {
        mobileSortBy.addEventListener('change', function() {
            applyFilters();
        });
    }
    
    // Sync sort selects
    const sortBySelect = document.getElementById('sort-by');
    if (sortBySelect && mobileSortBy) {
        sortBySelect.addEventListener('change', function() {
            mobileSortBy.value = this.value;
            applyFilters();
        });
    }
    
    // Price slider functionality
    const priceSlider = document.getElementById('price-range');
    const maxPriceInput = document.getElementById('max-price');
    
    if (priceSlider && maxPriceInput) {
        priceSlider.addEventListener('input', function() {
            maxPriceInput.value = this.value;
        });
        
        maxPriceInput.addEventListener('input', function() {
            if (this.value <= 1000) {
                priceSlider.value = this.value;
            }
        });
    }
    
    function applyFilters() {
        showLoading();
        const formData = new FormData(filterForm);
        const params = new URLSearchParams();
        
        // Add search query
        params.set('q', '{{ $query }}');
        
        // Add filter parameters
        for (let [key, value] of formData.entries()) {
            if (value) {
                params.set(key, value);
            }
        }
        
        // Redirect to filtered search results
        setTimeout(() => {
            window.location.href = `/live-search?${params.toString()}`;
        }, 500);
    }
    
    function showLoading() {
        loadingOverlay.style.display = 'flex';
    }
    
    function hideLoading() {
        loadingOverlay.style.display = 'none';
    }
    
    // Add smooth scroll behavior
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // Add animation to product cards on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);
    
    // Observe product cards
    document.querySelectorAll('.product-card').forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(card);
    });
});

// View mode switching
function setViewMode(mode) {
    const container = document.getElementById('products-container');
    const viewButtons = document.querySelectorAll('.view-btn');
    
    // Update button states
    viewButtons.forEach(btn => {
        btn.classList.remove('active');
        if (btn.dataset.view === mode) {
            btn.classList.add('active');
        }
    });
    
    // Update container class
    if (mode === 'list') {
        container.classList.add('list-view');
        container.classList.remove('grid-view');
    } else {
        container.classList.add('grid-view');
        container.classList.remove('list-view');
    }
    
    // Save preference
    localStorage.setItem('preferredViewMode', mode);
}

// Reset filters function
function resetFilters() {
    const form = document.getElementById('filter-form');
    if (form) {
        form.reset();
        // Reset price slider
        const priceSlider = document.getElementById('price-range');
        const maxPriceInput = document.getElementById('max-price');
        if (priceSlider && maxPriceInput) {
            priceSlider.value = 1000;
            maxPriceInput.value = 1000;
        }
        // Apply reset
        window.location.href = `/live-search?q={{ $query }}`;
    }
}

// Load saved view mode on page load
document.addEventListener('DOMContentLoaded', function() {
    const savedViewMode = localStorage.getItem('preferredViewMode');
    if (savedViewMode) {
        setViewMode(savedViewMode);
    }
});
</script>
@endpush
