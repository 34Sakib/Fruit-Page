@extends('frontend.layouts.master')
@section('title', '🍎 Organic Products - FruitMart')
@section('css')
<link href="{{ asset('frontend/css/organic.css') }}" rel="stylesheet">
@endsection
@section('content')

    <!-- Breadcrumb -->
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fas fa-home"></i> Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Organic Products</li>
            </ol>
        </nav>
    </div>

    <!-- Page Header -->
    <div class="page-header">
        <div class="container">
            <h1 class="page-title">Certified Organic Products</h1>
            <p class="page-description">Discover our premium selection of 100% certified organic fruits, vegetables, and products. Grown naturally without synthetic pesticides, chemicals, or GMOs for your health and the environment.</p>
            <div class="certification-badge">
                <i class="fas fa-certificate me-2"></i> USDA & EU Organic Certified
            </div>
        </div>
    </div>

    <!-- Benefits Section -->
    <div class="benefits-section">
        <div class="container">
            <h2 class="text-center mb-5">Why Choose Organic?</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="fas fa-heart"></i>
                        </div>
                        <h4 class="benefit-title">Better for Health</h4>
                        <p>No synthetic pesticides, herbicides, or chemical fertilizers. Higher nutrient content and better taste.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="fas fa-leaf"></i>
                        </div>
                        <h4 class="benefit-title">Environment Friendly</h4>
                        <p>Organic farming reduces pollution, conserves water, and improves soil health without toxic chemicals.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h4 class="benefit-title">No GMOs</h4>
                        <p>All our organic products are guaranteed to be free from genetically modified organisms.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Certification Logos -->
    <div class="container">
        <div class="certification-logos">
            <div class="cert-logo">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/33/USDA_Organic_seal.svg/1200px-USDA_Organic_seal.svg.png" alt="USDA Organic">
                <div class="cert-name">USDA Organic</div>
            </div>
            <div class="cert-logo">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/65/EU_organic_logo.svg/1200px-EU_organic_logo.svg.png" alt="EU Organic">
                <div class="cert-name">EU Organic</div>
            </div>
            <div class="cert-logo">
                <img src="https://www.ecocert.com/sites/default/files/2021-10/certification-ecocert-en.png" alt="Ecocert">
                <div class="cert-name">Ecocert</div>
            </div>
            <div class="cert-logo">
                <img src="https://www.soilassociation.org/media/13064/sa_symbol_rgb.jpg" alt="Soil Association">
                <div class="cert-name">Soil Association</div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container">
        <div class="row">
            <!-- Sidebar with Filters -->
            <div class="col-lg-3">
                <div class="category-menu">
                    <a class="nav-link active" href="#"><i class="fas fa-seedling"></i> All Organic Products</a>
                    <a class="nav-link" href="#"><i class="fas fa-apple-alt"></i> Organic Fruits</a>
                    <a class="nav-link" href="#"><i class="fas fa-carrot"></i> Organic Vegetables</a>
                    <a class="nav-link" href="#"><i class="fas fa-wine-bottle"></i> Organic Juices</a>
                    <a class="nav-link" href="#"><i class="fas fa-mortar-pestle"></i> Dried Organic</a>
                    <a class="nav-link" href="#"><i class="fas fa-ice-cream"></i> Frozen Organic</a>
                    <a class="nav-link" href="#"><i class="fas fa-bread-slice"></i> Organic Pantry</a>
                    <a class="nav-link" href="#"><i class="fas fa-wheat"></i> Organic Grains</a>
                    <a class="nav-link" href="#"><i class="fas fa-tags"></i> Organic Deals</a>
                </div>
                
                <div class="filter-section">
                    <h5 class="filter-title">Filter by Price</h5>
                    <div class="mb-3">
                        <input type="range" class="form-range" id="priceRange" min="0" max="100" step="5">
                        <div class="d-flex justify-content-between">
                            <span>$0</span>
                            <span>$100</span>
                        </div>
                    </div>
                    
                    <h5 class="filter-title mt-4">Certification</h5>
                    <ul class="filter-options">
                        <li>
                            <a href="#">
                                <span>USDA Organic</span>
                                <span class="count">(32)</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span>EU Organic</span>
                                <span class="count">(28)</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span>Both Certifications</span>
                                <span class="count">(15)</span>
                            </a>
                        </li>
                    </ul>
                    
                    <h5 class="filter-title mt-4">Product Type</h5>
                    <ul class="filter-options">
                        <li>
                            <a href="#">
                                <span>Fresh Produce</span>
                                <span class="count">(45)</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span>Processed Foods</span>
                                <span class="count">(22)</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span>Beverages</span>
                                <span class="count">(18)</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span>Pantry Items</span>
                                <span class="count">(14)</span>
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
                                <span class="count">(26)</span>
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
                                <span class="count">(34)</span>
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
                                <span class="count">(15)</span>
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
                
                <h3 class="section-title">Organic Fruits</h3>
                <div class="row">
                    <!-- Product 1 -->
                    <div class="col-md-4 col-sm-6">
                        <div class="product-card">
                            <div class="product-image position-relative">
                                <span class="badge-discount">10% OFF</span>
                                <span class="badge-organic">ORGANIC</span>
                                <img src="https://images.unsplash.com/photo-1568702846914-96b305d2aaeb?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Organic Apples">
                            </div>
                            <div class="product-info">
                                <h5 class="product-title">Organic Red Apples (1kg)</h5>
                                <div class="product-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                    <span class="ms-1">(42)</span>
                                </div>
                                <div class="product-price">$5.99 <del>$6.49</del></div>
                                <button class="btn-add-to-cart">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Product 2 -->
                    <div class="col-md-4 col-sm-6">
                        <div class="product-card">
                            <div class="product-image position-relative">
                                <span class="badge-organic">ORGANIC</span>
                                <img src="https://images.unsplash.com/photo-1553279768-865429fa0078?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Organic Bananas">
                            </div>
                            <div class="product-info">
                                <h5 class="product-title">Organic Bananas (1kg)</h5>
                                <div class="product-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <span class="ms-1">(38)</span>
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
                                <span class="badge-discount">15% OFF</span>
                                <span class="badge-organic">ORGANIC</span>
                                <img src="https://images.unsplash.com/photo-1557800636-894a64c1696f?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Organic Oranges">
                            </div>
                            <div class="product-info">
                                <h5 class="product-title">Organic Oranges (1kg)</h5>
                                <div class="product-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <span class="ms-1">(51)</span>
                                </div>
                                <div class="product-price">$4.99 <del>$5.79</del></div>
                                <button class="btn-add-to-cart">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <h3 class="section-title">Organic Vegetables</h3>
                <div class="row">
                    <!-- Product 4 -->
                    <div class="col-md-4 col-sm-6">
                        <div class="product-card">
                            <div class="product-image position-relative">
                                <span class="badge-organic">ORGANIC</span>
                                <img src="https://images.unsplash.com/photo-1598170845058-32b9d6a5da37?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Organic Carrots">
                            </div>
                            <div class="product-info">
                                <h5 class="product-title">Organic Carrots (500g)</h5>
                                <div class="product-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                    <span class="ms-1">(36)</span>
                                </div>
                                <div class="product-price">$3.49</div>
                                <button class="btn-add-to-cart">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Product 5 -->
                    <div class="col-md-4 col-sm-6">
                        <div class="product-card">
                            <div class="product-image position-relative">
                                <span class="badge-discount">5% OFF</span>
                                <span class="badge-organic">ORGANIC</span>
                                <img src="https://images.unsplash.com/photo-1540420773420-3366772f4999?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Organic Broccoli">
                            </div>
                            <div class="product-info">
                                <h5 class="product-title">Organic Broccoli (1 piece)</h5>
                                <div class="product-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <span class="ms-1">(29)</span>
                                </div>
                                <div class="product-price">$3.99 <del>$4.19</del></div>
                                <button class="btn-add-to-cart">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Product 6 -->
                    <div class="col-md-4 col-sm-6">
                        <div class="product-card">
                            <div class="product-image position-relative">
                                <span class="badge-organic">ORGANIC</span>
                                <img src="https://images.unsplash.com/photo-1576045057995-568f588f82fb?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Organic Lettuce">
                            </div>
                            <div class="product-info">
                                <h5 class="product-title">Organic Lettuce (1 head)</h5>
                                <div class="product-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <span class="ms-1">(27)</span>
                                </div>
                                <div class="product-price">$2.49</div>
                                <button class="btn-add-to-cart">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <h3 class="section-title">Organic Pantry & Others</h3>
                <div class="row">
                    <!-- Product 7 -->
                    <div class="col-md-4 col-sm-6">
                        <div class="product-card">
                            <div class="product-image position-relative">
                                <span class="badge-discount">20% OFF</span>
                                <span class="badge-organic">ORGANIC</span>
                                <img src="https://images.unsplash.com/photo-1615485500836-44e18cfc515d?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Organic Olive Oil">
                            </div>
                            <div class="product-info">
                                <h5 class="product-title">Organic Extra Virgin Olive Oil (500ml)</h5>
                                <div class="product-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <span class="ms-1">(44)</span>
                                </div>
                                <div class="product-price">$12.99 <del>$15.99</del></div>
                                <button class="btn-add-to-cart">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Product 8 -->
                    <div class="col-md-4 col-sm-6">
                        <div class="product-card">
                            <div class="product-image position-relative">
                                <span class="badge-organic">ORGANIC</span>
                                <img src="https://images.unsplash.com/photo-1598965675045-8b5d8dd58cba?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Organic Honey">
                            </div>
                            <div class="product-info">
                                <h5 class="product-title">Organic Raw Honey (350g)</h5>
                                <div class="product-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                    <span class="ms-1">(39)</span>
                                </div>
                                <div class="product-price">$8.99</div>
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
