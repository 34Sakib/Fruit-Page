@extends('frontend.layouts.master')
@section('title', '🍎 Seasonal Products - FruitMart')
@section('css')
<link href="{{ asset('frontend/css/seasonal.css') }}" rel="stylesheet">
@endsection

@section('content')

    <!-- Breadcrumb -->
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fas fa-home"></i> Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Seasonal Products</li>
            </ol>
        </nav>
    </div>

    <!-- Page Header -->
    <div class="page-header">
        <div class="container">
            <h1 class="page-title">Seasonal Specials</h1>
            <p class="page-description">Discover the freshest seasonal fruits and vegetables at their peak flavor. Our seasonal selection changes throughout the year to bring you the best nature has to offer.</p>
            <div class="season-badge">
                <i class="fas fa-calendar-alt me-2"></i> Currently in Season: Summer Fruits
            </div>
        </div>
    </div>

    <!-- Seasonal Calendar -->
    <div class="container">
        <div class="season-calendar">
            <h3 class="calendar-title">Seasonal Availability Calendar</h3>
            <div class="calendar-grid">
                <div class="calendar-season">
                    <div class="season-name spring">Spring</div>
                    <div class="season-months">March - May</div>
                    <div class="season-items">Strawberries, Asparagus, Peas, Rhubarb, Artichokes</div>
                </div>
                <div class="calendar-season">
                    <div class="season-name summer">Summer</div>
                    <div class="season-months">June - August</div>
                    <div class="season-items">Berries, Melons, Peaches, Tomatoes, Corn, Zucchini</div>
                </div>
                <div class="calendar-season">
                    <div class="season-name autumn">Autumn</div>
                    <div class="season-months">September - November</div>
                    <div class="season-items">Apples, Pears, Pumpkins, Squash, Grapes, Mushrooms</div>
                </div>
                <div class="calendar-season">
                    <div class="season-name winter">Winter</div>
                    <div class="season-months">December - February</div>
                    <div class="season-items">Citrus Fruits, Pomegranates, Kale, Brussels Sprouts, Root Vegetables</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Seasons Overview -->
    <div class="container">
        <div class="row season-section">
            <div class="col-md-3">
                <div class="season-card">
                    <div class="season-icon spring">
                        <i class="fas fa-seedling"></i>
                    </div>
                    <h4 class="season-title">Spring</h4>
                    <p>Fresh greens, tender vegetables, and the first sweet berries of the year.</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="season-card">
                    <div class="season-icon summer">
                        <i class="fas fa-sun"></i>
                    </div>
                    <h4 class="season-title">Summer</h4>
                    <p>Juicy fruits, vibrant vegetables, and sun-ripened goodness at its peak.</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="season-card">
                    <div class="season-icon autumn">
                        <i class="fas fa-leaf"></i>
                    </div>
                    <h4 class="season-title">Autumn</h4>
                    <p>Harvest fruits, hearty vegetables, and earthy flavors for cozy meals.</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="season-card">
                    <div class="season-icon winter">
                        <i class="fas fa-snowflake"></i>
                    </div>
                    <h4 class="season-title">Winter</h4>
                    <p>Citrus brightness, robust greens, and comforting root vegetables.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container">
        <div class="row">
            <!-- Sidebar with Filters -->
            <div class="col-lg-3">
                <div class="category-menu">
                    <a class="nav-link active" href="#"><i class="fas fa-fire"></i> All Seasonal</a>
                    <a class="nav-link" href="#"><i class="fas fa-sun"></i> Summer Specials</a>
                    <a class="nav-link" href="#"><i class="fas fa-seedling"></i> Spring Harvest</a>
                    <a class="nav-link" href="#"><i class="fas fa-leaf"></i> Autumn Collection</a>
                    <a class="nav-link" href="#"><i class="fas fa-snowflake"></i> Winter Selection</a>
                    <a class="nav-link" href="#"><i class="fas fa-apple-alt"></i> Seasonal Fruits</a>
                    <a class="nav-link" href="#"><i class="fas fa-carrot"></i> Seasonal Vegetables</a>
                    <a class="nav-link" href="#"><i class="fas fa-certificate"></i> Organic Seasonal</a>
                    <a class="nav-link" href="#"><i class="fas fa-tags"></i> Seasonal Deals</a>
                </div>
                
                <div class="filter-section">
                    <h5 class="filter-title">Filter by Season</h5>
                    <ul class="filter-options">
                        <li>
                            <a href="#">
                                <span>Spring</span>
                                <span class="count">(18)</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span>Summer</span>
                                <span class="count">(24)</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span>Autumn</span>
                                <span class="count">(16)</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span>Winter</span>
                                <span class="count">(12)</span>
                            </a>
                        </li>
                    </ul>
                    
                    <h5 class="filter-title mt-4">Availability</h5>
                    <ul class="filter-options">
                        <li>
                            <a href="#">
                                <span>In Season Now</span>
                                <span class="count">(22)</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span>Coming Soon</span>
                                <span class="count">(8)</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span>End of Season</span>
                                <span class="count">(6)</span>
                            </a>
                        </li>
                    </ul>
                    
                    <h5 class="filter-title mt-4">Product Type</h5>
                    <ul class="filter-options">
                        <li>
                            <a href="#">
                                <span>Fruits</span>
                                <span class="count">(32)</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span>Vegetables</span>
                                <span class="count">(28)</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span>Berries</span>
                                <span class="count">(14)</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span>Melons</span>
                                <span class="count">(8)</span>
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
                                <span class="count">(19)</span>
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
                                <span class="count">(26)</span>
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
                            <option selected>Seasonal Priority</option>
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
                
                <h3 class="section-title">Summer Specials</h3>
                <div class="row">
                    <!-- Product 1 -->
                    <div class="col-md-4 col-sm-6">
                        <div class="product-card">
                            <div class="product-image position-relative">
                                <span class="badge-discount">15% OFF</span>
                                <span class="badge-seasonal">SUMMER</span>
                                <span class="badge-organic">ORGANIC</span>
                                <img src="https://images.unsplash.com/photo-1571771894821-ce9b6c11b08e?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Strawberries">
                            </div>
                            <div class="product-info">
                                <h5 class="product-title">Fresh Summer Strawberries (500g)</h5>
                                <div class="product-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                    <span class="ms-1">(47)</span>
                                </div>
                                <div class="product-price">$5.99 <del>$6.99</del></div>
                                <button class="btn-add-to-cart">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Product 2 -->
                    <div class="col-md-4 col-sm-6">
                        <div class="product-card">
                            <div class="product-image position-relative">
                                <span class="badge-seasonal">SUMMER</span>
                                <img src="https://images.unsplash.com/photo-1594282482151-58ad4aa9ade1?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Watermelon">
                            </div>
                            <div class="product-info">
                                <h5 class="product-title">Fresh Watermelon (1 piece)</h5>
                                <div class="product-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                    <span class="ms-1">(39)</span>
                                </div>
                                <div class="product-price">$6.49</div>
                                <button class="btn-add-to-cart">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Product 3 -->
                    <div class="col-md-4 col-sm-6">
                        <div class="product-card">
                            <div class="product-image position-relative">
                                <span class="badge-discount">10% OFF</span>
                                <span class="badge-seasonal">SUMMER</span>
                                <span class="badge-organic">ORGANIC</span>
                                <img src="https://images.unsplash.com/photo-1550258987-190a2d41a8ba?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Mango">
                            </div>
                            <div class="product-info">
                                <h5 class="product-title">Summer Mangoes (1kg)</h5>
                                <div class="product-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <span class="ms-1">(51)</span>
                                </div>
                                <div class="product-price">$7.99 <del>$8.79</del></div>
                                <button class="btn-add-to-cart">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <h3 class="section-title">Berries & Summer Fruits</h3>
                <div class="row">
                    <!-- Product 4 -->
                    <div class="col-md-4 col-sm-6">
                        <div class="product-card">
                            <div class="product-image position-relative">
                                <span class="badge-seasonal">SUMMER</span>
                                <span class="badge-organic">ORGANIC</span>
                                <img src="https://images.unsplash.com/photo-1498557850523-fd3d118b962e?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Blueberries">
                            </div>
                            <div class="product-info">
                                <h5 class="product-title">Fresh Blueberries (250g)</h5>
                                <div class="product-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <span class="ms-1">(42)</span>
                                </div>
                                <div class="product-price">$4.99</div>
                                <button class="btn-add-to-cart">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Product 5 -->
                    <div class="col-md-4 col-sm-6">
                        <div class="product-card">
                            <div class="product-image position-relative">
                                <span class="badge-discount">5% OFF</span>
                                <span class="badge-seasonal">SUMMER</span>
                                <img src="https://images.unsplash.com/photo-1592400374405-2f63f1d714d0?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Raspberries">
                            </div>
                            <div class="product-info">
                                <h5 class="product-title">Fresh Raspberries (200g)</h5>
                                <div class="product-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                    <span class="ms-1">(35)</span>
                                </div>
                                <div class="product-price">$5.49 <del>$5.79</del></div>
                                <button class="btn-add-to-cart">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Product 6 -->
                    <div class="col-md-4 col-sm-6">
                        <div class="product-card">
                            <div class="product-image position-relative">
                                <span class="badge-seasonal">SUMMER</span>
                                <span class="badge-organic">ORGANIC</span>
                                <img src="https://images.unsplash.com/photo-1592924357228-91a4daadcfea?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Pineapple">
                            </div>
                            <div class="product-info">
                                <h5 class="product-title">Fresh Pineapple (1 piece)</h5>
                                <div class="product-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <span class="ms-1">(28)</span>
                                </div>
                                <div class="product-price">$3.99</div>
                                <button class="btn-add-to-cart">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <h3 class="section-title">Summer Vegetables</h3>
                <div class="row">
                    <!-- Product 7 -->
                    <div class="col-md-4 col-sm-6">
                        <div class="product-card">
                            <div class="product-image position-relative">
                                <span class="badge-seasonal">SUMMER</span>
                                <img src="https://images.unsplash.com/photo-1566385101042-1a0aa0c1268c?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Tomatoes">
                            </div>
                            <div class="product-info">
                                <h5 class="product-title">Summer Tomatoes (1kg)</h5>
                                <div class="product-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <span class="ms-1">(46)</span>
                                </div>
                                <div class="product-price">$4.29</div>
                                <button class="btn-add-to-cart">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Product 8 -->
                    <div class="col-md-4 col-sm-6">
                        <div class="product-card">
                            <div class="product-image position-relative">
                                <span class="badge-discount">20% OFF</span>
                                <span class="badge-seasonal">SUMMER</span>
                                <span class="badge-organic">ORGANIC</span>
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
                                    <span class="ms-1">(31)</span>
                                </div>
                                <div class="product-price">$5.99 <del>$7.49</del></div>
                                <button class="btn-add-to-cart">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Product 9 -->
                    <div class="col-md-4 col-sm-6">
                        <div class="product-card">
                            <div class="product-image position-relative">
                                <span class="badge-seasonal">SUMMER</span>
                                <img src="https://images.unsplash.com/photo-1592924357228-91a4daadcfea?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Zucchini">
                            </div>
                            <div class="product-info">
                                <h5 class="product-title">Fresh Zucchini (500g)</h5>
                                <div class="product-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                    <span class="ms-1">(27)</span>
                                </div>
                                <div class="product-price">$3.49</div>
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
