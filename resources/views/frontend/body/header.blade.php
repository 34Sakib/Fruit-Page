<!-- Premium Top Bar -->
<div class="premium-top-bar">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-7">
                @php
                    $footer = \App\Models\Footer::getActive();
                @endphp
                <div class="contact-info">
                    @if($footer)
                        @if($footer->phone)
                            <span class="contact-item">
                                <i class="fas fa-phone-alt"></i> 
                                <span class="d-none d-md-inline">Hotline:</span> {{ $footer->phone }}
                            </span>
                        @endif
                        @if($footer->email)
                            <span class="contact-item">
                                <i class="fas fa-envelope"></i> 
                                <span class="d-none d-md-inline">Email:</span> {{ $footer->email }}
                            </span>
                        @endif
                    @else
                        <span class="contact-item">
                            <i class="fas fa-phone-alt"></i> 
                            <span class="d-none d-md-inline">Hotline:</span> 01641555173
                        </span>
                        <span class="contact-item">
                            <i class="fas fa-envelope"></i> 
                            <span class="d-none d-md-inline">Email:</span> support@fruitspage.com
                        </span>
                    @endif
                </div>
            </div>
            <div class="col-lg-6 col-md-5 text-md-end">
                <div class="user-actions">
                    @auth
                        <div class="dropdown d-inline-block me-3">
                            <a href="#" class="user-dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user-circle"></i> 
                                <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                                <i class="fas fa-chevron-down ms-1"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="{{ route('profile.show') }}">
                                    <i class="fas fa-user me-2"></i> My Profile
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('orders.index') }}">
                                    <i class="fas fa-shopping-bag me-2"></i> My Orders
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('wishlist.index') }}">
                                    <i class="fas fa-heart me-2"></i> My Wishlist
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm me-2">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-user-plus"></i> Register
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Navigation Header -->
<header class="main-header">
    <div class="container">
        <div class="header-content">
            <!-- Logo Section -->
            <div class="logo-section">
                @php
                    $footerData = \App\Models\Footer::getActive();
                @endphp
                <a class="brand-logo" href="{{ url('/') }}">
                    @if($footerData && $footerData->logo)
                        <img src="{{ asset('storage/' . $footerData->logo) }}" alt="{{ $footerData->title ?? 'GreenRootMart' }}" class="logo-img">
                    @else
                        <img src="{{ asset('images/greenrootmart-logo.png') }}" alt="GreenRootMart" class="logo-img">
                    @endif
                    <div class="brand-text">
                        <span class="brand-name">{{ $footerData->title ?? 'GreenRootMart' }}</span>
                        <span class="brand-tagline">Fresh & Organic</span>
                    </div>
                </a>
            </div>

            <!-- Search Section -->
            <div class="search-section">
                <div class="search-container">
                    <div class="search-box-wrapper">
                        <div class="search-category-dropdown">
                            <button type="button" class="category-popup-btn" data-bs-toggle="modal" data-bs-target="#categoriesModal">
                                <i class="fas fa-th-large"></i>
                                <span>All Categories</span>
                                <i class="fas fa-chevron-down"></i>
                            </button>
                        </div>
                        <div class="search-input-wrapper">
                            <i class="fas fa-search search-icon"></i>
                            <input type="text" id="liveSearch" class="search-input" placeholder="Search for fresh fruits, vegetables, and more..." autocomplete="off">
                        </div>
                        <button type="button" class="search-btn">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                    <div id="searchResults" class="search-results-dropdown"></div>
                </div>
            </div>

            <!-- Header Actions -->
            <div class="header-actions">
                <!-- Wishlist -->
                <a href="{{ route('wishlist.index') }}" class="header-action-btn">
                    <i class="fas fa-heart"></i>
                    <span class="action-text d-none d-lg-inline">Wishlist</span>
                    <span class="action-count wishlist-count">{{ count(session('wishlist', [])) }}</span>
                </a>

                <!-- Cart -->
                <a href="{{ route('cart.index') }}" class="header-action-btn cart-btn">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="action-text d-none d-lg-inline">Cart</span>
                    <span class="action-count cart-count">{{ \Darryldecode\Cart\Facades\CartFacade::getTotalQuantity() }}</span>
                </a>

                <!-- CTA Button -->
                <a href="{{ route('special-order.create') }}" class="cta-btn">
                    <i class="fas fa-star"></i>
                    <span class="d-none d-md-inline">Special Order</span>
                </a>

                <!-- Header Hotline -->
                <div class="header-hotline">
                    <div class="hotline-content">
                        <i class="fas fa-phone-alt"></i>
                        <div class="hotline-text">
                            <span class="hotline-label">Need Help?</span>
                            <span class="hotline-number">{{ $footer->phone ?? '01641555173' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Menu -->
    <nav class="main-navigation">
        <div class="container">
            <div class="navigation-wrapper">
                <!-- Mobile Menu Toggle -->
                <button class="mobile-menu-toggle" data-bs-toggle="collapse" data-bs-target="#mainNavMenu">
                    <i class="fas fa-bars"></i>
                </button>

                <!-- Main Navigation -->
                <div class="collapse navbar-collapse" id="mainNavMenu">
                    <ul class="main-nav-menu">
                        <li class="nav-item">
                            <a href="{{ url('/') }}" class="nav-link {{ request()->is('/') ? 'active' : '' }}">
                                <i class="fas fa-home"></i> Home
                            </a>
                        </li>
                        
                        <!-- Categories Dropdown -->
                        <li class="nav-item dropdown mega-dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                                <i class="fas fa-th-large"></i> Categories
                                <i class="fas fa-chevron-down"></i>
                            </a>
                            <div class="dropdown-menu mega-menu">
                                <div class="mega-menu-content">
                                    @php
                                        $mainCategories = \App\Models\Category::where('status', 'active')
                                            ->whereNull('parent_id')
                                            ->with(['children' => function($query) {
                                                $query->where('status', 'active')->orderBy('order', 'asc');
                                            }])
                                            ->orderBy('order', 'asc')
                                            ->take(6)
                                            ->get();
                                    @endphp
                                    @foreach($mainCategories as $category)
                                        <div class="mega-menu-column">
                                            <h6 class="mega-menu-title">
                                                <a href="{{ route('category', $category->slug) }}">{{ $category->name }}</a>
                                            </h6>
                                            @if($category->children->count() > 0)
                                                <ul class="mega-menu-list">
                                                    @foreach($category->children->take(5) as $child)
                                                        <li>
                                                            <a href="{{ route('category', $child->slug) }}">{{ $child->name }}</a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </div>
                                    @endforeach
                                    <div class="mega-menu-column promo-column">
                                        <div class="promo-content">
                                            <h6>Special Offers</h6>
                                            <p>Get up to 30% off on selected items!</p>
                                            <a href="{{ url('/deals') }}" class="btn btn-success btn-sm">View Deals</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('/deals') }}" class="nav-link {{ request()->is('deals') ? 'active' : '' }}">
                                <i class="fas fa-tags"></i> Deals
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('special-order.create') }}" class="nav-link {{ request()->is('special-order*') ? 'active' : '' }}">
                                <i class="fas fa-star"></i> Special Order
                            </a>
                        </li>

                        <!-- Quick Links -->
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                                <i class="fas fa-link"></i> Quick Links
                                <i class="fas fa-chevron-down"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ url('/about') }}">About Us</a></li>
                                <li><a class="dropdown-item" href="{{ url('/contact') }}">Contact</a></li>
                                <li><a class="dropdown-item" href="{{ url('/faq') }}">FAQ</a></li>
                                <li><a class="dropdown-item" href="{{ url('/delivery') }}">Delivery Info</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </nav>
</header>

<!-- Categories Modal -->
<div class="modal fade" id="categoriesModal" tabindex="-1" aria-labelledby="categoriesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="categoriesModalLabel">
                    <i class="fas fa-th-large"></i> All Categories
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="categories-grid">
                    @php
                        $mainCategories = \App\Models\Category::where('status', 'active')
                            ->whereNull('parent_id')
                            ->with(['children' => function($query) {
                                $query->where('status', 'active')->orderBy('order', 'asc');
                            }])
                            ->orderBy('order', 'asc')
                            ->get();
                    @endphp
                    @foreach($mainCategories as $category)
                        <div class="category-card">
                            <div class="category-header">
                                @if($category->image)
                                    <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="category-icon">
                                @else
                                    <div class="category-icon-placeholder">
                                        <i class="fas fa-leaf"></i>
                                    </div>
                                @endif
                                <h6 class="category-title">
                                    <a href="{{ route('category.show', $category->slug) }}" class="category-title-link">{{ $category->name }}</a>
                                </h6>
                            </div>
                            @if($category->children->count() > 0)
                                <div class="subcategory-list">
                                    @foreach($category->children->take(6) as $child)
                                        <a href="{{ route('category.show', $child->slug) }}" class="subcategory-item">
                                            <i class="fas fa-angle-right"></i> {{ $child->name }}
                                        </a>
                                    @endforeach
                                    @if($category->children->count() > 6)
                                        <a href="{{ route('category.show', $category->slug) }}" class="subcategory-item view-all">
                                            <i class="fas fa-ellipsis-h"></i> View All
                                        </a>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
                
                <!-- Featured Categories Section -->
                <div class="featured-categories">
                    <h6 class="featured-title">Popular Categories</h6>
                    <div class="featured-tags">
                        <a href="{{ route('category.show', 'fruits') }}" class="featured-tag">
                            <i class="fas fa-apple-alt"></i> Fresh Fruits
                        </a>
                        <a href="{{ route('category.show', 'vegetables') }}" class="featured-tag">
                            <i class="fas fa-carrot"></i> Vegetables
                        </a>
                        <a href="{{ route('category.show', 'dairy') }}" class="featured-tag">
                            <i class="fas fa-cheese"></i> Dairy Products
                        </a>
                        <a href="{{ route('category.show', 'bakery') }}" class="featured-tag">
                            <i class="fas fa-bread-slice"></i> Bakery
                        </a>
                        <a href="{{ route('category.show', 'beverages') }}" class="featured-tag">
                            <i class="fas fa-coffee"></i> Beverages
                        </a>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a href="{{ url('/categories') }}" class="btn btn-success">
                    <i class="fas fa-th"></i> View All Categories
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Header Styles -->
<link rel="stylesheet" href="{{ asset('frontend/css/header.css') }}">

<!-- Categories Modal Script -->
<script src="{{ asset('frontend/js/categories-modal.js') }}"></script>