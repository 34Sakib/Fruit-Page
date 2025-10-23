@extends('frontend.layouts.master')
@section('title', '🍎 Vegetables - Fresh Vegetables Online Store')
@section('css')
<link href="{{ asset('frontend/css/vegetables.css') }}" rel="stylesheet">
@endsection
@section('content')
    <!-- Breadcrumb -->
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fas fa-home"></i> Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Vegetables</li>
            </ol>
        </nav>
    </div>

    <!-- Page Header -->
    <div class="page-header">
        <div class="container">
            <h1 class="page-title">Fresh Vegetables</h1>
            <p class="page-description">Discover our premium selection of farm-fresh vegetables. From leafy greens to root vegetables, we bring you the highest quality produce straight from local farms to your table.</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container">
        <!-- Features Section -->
        <div class="row">
            <div class="col-md-4">
                <div class="feature-box">
                    <div class="feature-icon">
                        <i class="fas fa-truck"></i>
                    </div>
                    <h4 class="feature-title">Fresh Delivery</h4>
                    <p>We deliver within 24 hours of harvesting to ensure maximum freshness</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-box">
                    <div class="feature-icon">
                        <i class="fas fa-leaf"></i>
                    </div>
                    <h4 class="feature-title">100% Organic</h4>
                    <p>All our vegetables are grown without pesticides or harmful chemicals</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-box">
                    <div class="feature-icon">
                        <i class="fas fa-award"></i>
                    </div>
                    <h4 class="feature-title">Quality Guarantee</h4>
                    <p>We guarantee the quality and freshness of all our vegetable products</p>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Sidebar with Filters -->
            <div class="col-lg-3">
                <div class="category-menu">
                    <a class="nav-link active" href="#"><i class="fas fa-carrot"></i> All Vegetables</a>
                    <a class="nav-link" href="#"><i class="fas fa-leaf"></i> Leafy Greens</a>
                    <a class="nav-link" href="#"><i class="fas fa-seedling"></i> Root Vegetables</a>
                    <a class="nav-link" href="#"><i class="fas fa-pepper-hot"></i> Peppers & Chilies</a>
                    <a class="nav-link" href="#"><i class="fas fa-apple-alt"></i> Tomatoes & Cucumbers</a>
                    <a class="nav-link" href="#"><i class="fas fa-tree"></i> Cruciferous Vegetables</a>
                    <a class="nav-link" href="#"><i class="fas fa-utensils"></i> Cooking Vegetables</a>
                    <a class="nav-link" href="#"><i class="fas fa-certificate"></i> Organic Vegetables</a>
                    <a class="nav-link" href="#"><i class="fas fa-fire"></i> Seasonal Specials</a>
                </div>
                
                <div class="filter-section">
                    <h5 class="filter-title">Filter by Price</h5>
                    <div class="mb-3">
                        <input type="range" class="form-range" id="priceRange" min="0" max="50" step="2">
                        <div class="d-flex justify-content-between">
                            <span>$0</span>
                            <span>$50</span>
                        </div>
                    </div>
                    
                    <h5 class="filter-title mt-4">Availability</h5>
                    <ul class="filter-options">
                        <li>
                            <a href="#">
                                <span>In Stock</span>
                                <span class="count">(38)</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span>Out of Stock</span>
                                <span class="count">(5)</span>
                            </a>
                        </li>
                    </ul>
                    
                    <h5 class="filter-title mt-4">Type</h5>
                    <ul class="filter-options">
                        <li>
                            <a href="#">
                                <span>Organic</span>
                                <span class="count">(22)</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span>Conventional</span>
                                <span class="count">(16)</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span>Local</span>
                                <span class="count">(28)</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span>Imported</span>
                                <span class="count">(10)</span>
                            </a>
                        </li>
                    </ul>
                    
                    <h5 class="filter-title mt-4">Rating</h5>
                    <ul class="filter-options">
                        <li>
                            <a href="#">
                                <span>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                </span>
                                <span class="count">(18)</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="far fa-star text-warning"></i>
                                </span>
                                <span class="count">(12)</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="far fa-star text-warning"></i>
                                    <i class="far fa-star text-warning"></i>
                                </span>
                                <span class="count">(8)</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- Products Section -->
            <div class="col-lg-9">
                <div class="sort-options">
                    <div>
                        <span class="me-2">Sort by:</span>
                        <select class="form-select sort-select">
                            <option selected>Popularity</option>
                            <option>Price: Low to High</option>
                            <option>Price: High to Low</option>
                            <option>Newest First</option>
                            <option>Customer Rating</option>
                        </select>
                    </div>
                    <div class="view-options">
                        <span class="me-2">View:</span>
                        <button class="active"><i class="fas fa-th"></i></button>
                        <button><i class="fas fa-list"></i></button>
                    </div>
                </div>
                
                <h3 class="section-title">Popular Vegetables</h3>
                <div class="row">
                    <!-- Product 1 -->
                    <div class="col-md-4 col-sm-6">
                        <div class="product-card">
                            <div class="product-image position-relative">
                                <span class="badge-discount">15% OFF</span>
                                <span class="badge-organic">ORGANIC</span>
                                <img src="https://images.unsplash.com/photo-1598170845058-32b9d6a5da37?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Carrots">
                            </div>
                            <div class="product-info">
                                <h5 class="product-title">Fresh Organic Carrots (500g)</h5>
                                <div class="product-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                    <span class="ms-1">(36)</span>
                                </div>
                                <div class="product-price">$2.99 <del>$3.49</del></div>
                                <button class="btn-add-to-cart">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Product 2 -->
                    <div class="col-md-4 col-sm-6">
                        <div class="product-card">
                            <div class="product-image position-relative">
                                <span class="badge-organic">ORGANIC</span>
                                <img src="https://images.unsplash.com/photo-1540420773420-3366772f4999?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Broccoli">
                            </div>
                            <div class="product-info">
                                <h5 class="product-title">Fresh Broccoli (1 piece)</h5>
                                <div class="product-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <span class="ms-1">(28)</span>
                                </div>
                                <div class="product-price">$3.49</div>
                                <button class="btn-add-to-cart">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Product 3 -->
                    <div class="col-md-4 col-sm-6">
                        <div class="product-card">
                            <div class="product-image position-relative">
                                <span class="badge-discount">10% OFF</span>
                                <img src="https://images.unsplash.com/photo-1566385101042-1a0aa0c1268c?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Tomatoes">
                            </div>
                            <div class="product-info">
                                <h5 class="product-title">Fresh Red Tomatoes (1kg)</h5>
                                <div class="product-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <span class="ms-1">(42)</span>
                                </div>
                                <div class="product-price">$4.29 <del>$4.79</del></div>
                                <button class="btn-add-to-cart">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Product 4 -->
                    <div class="col-md-4 col-sm-6">
                        <div class="product-card">
                            <div class="product-image position-relative">
                                <span class="badge-organic">ORGANIC</span>
                                <img src="https://images.unsplash.com/photo-1570197788417-0e82375c9371?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Spinach">
                            </div>
                            <div class="product-info">
                                <h5 class="product-title">Fresh Spinach Leaves (250g)</h5>
                                <div class="product-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                    <span class="ms-1">(31)</span>
                                </div>
                                <div class="product-price">$2.79</div>
                                <button class="btn-add-to-cart">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Product 5 -->
                    <div class="col-md-4 col-sm-6">
                        <div class="product-card">
                            <div class="product-image position-relative">
                                <span class="badge-discount">20% OFF</span>
                                <img src="https://images.unsplash.com/photo-1518977676601-b53f82aba655?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Bell Peppers">
                            </div>
                            <div class="product-info">
                                <h5 class="product-title">Mixed Bell Peppers (500g)</h5>
                                <div class="product-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <span class="ms-1">(25)</span>
                                </div>
                                <div class="product-price">$5.99 <del>$7.49</del></div>
                                <button class="btn-add-to-cart">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Product 6 -->
                    <div class="col-md-4 col-sm-6">
                        <div class="product-card">
                            <div class="product-image position-relative">
                                <span class="badge-organic">ORGANIC</span>
                                <img src="https://images.unsplash.com/photo-1592924357228-91a4daadcfea?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Cucumber">
                            </div>
                            <div class="product-info">
                                <h5 class="product-title">Fresh Cucumbers (500g)</h5>
                                <div class="product-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                    <span class="ms-1">(33)</span>
                                </div>
                                <div class="product-price">$2.49</div>
                                <button class="btn-add-to-cart">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <h3 class="section-title">Leafy Greens</h3>
                <div class="row">
                    <!-- Product 7 -->
                    <div class="col-md-4 col-sm-6">
                        <div class="product-card">
                            <div class="product-image position-relative">
                                <span class="badge-organic">ORGANIC</span>
                                <img src="https://images.unsplash.com/photo-1576045057995-568f588f82fb?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Lettuce">
                            </div>
                            <div class="product-info">
                                <h5 class="product-title">Fresh Lettuce (1 head)</h5>
                                <div class="product-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <span class="ms-1">(27)</span>
                                </div>
                                <div class="product-price">$1.99</div>
                                <button class="btn-add-to-cart">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Product 8 -->
                    <div class="col-md-4 col-sm-6">
                        <div class="product-card">
                            <div class="product-image position-relative">
                                <span class="badge-discount">5% OFF</span>
                                <span class="badge-organic">ORGANIC</span>
                                <img src="https://images.unsplash.com/photo-1540420773420-3366772f4999?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Kale">
                            </div>
                            <div class="product-info">
                                <h5 class="product-title">Fresh Kale Leaves (200g)</h5>
                                <div class="product-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                    <i class="far fa-star"></i>
                                    <span class="ms-1">(19)</span>
                                </div>
                                <div class="product-price">$3.29 <del>$3.49</del></div>
                                <button class="btn-add-to-cart">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Product 9 -->
                    <div class="col-md-4 col-sm-6">
                        <div class="product-card">
                            <div class="product-image position-relative">
                                <span class="badge-organic">ORGANIC</span>
                                <img src="https://images.unsplash.com/photo-1592417817098-8fd3d9eb14a7?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Arugula">
                            </div>
                            <div class="product-info">
                                <h5 class="product-title">Fresh Arugula (150g)</h5>
                                <div class="product-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <span class="ms-1">(22)</span>
                                </div>
                                <div class="product-price">$4.49</div>
                                <button class="btn-add-to-cart">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Pagination -->
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1">Previous</a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
@endsection