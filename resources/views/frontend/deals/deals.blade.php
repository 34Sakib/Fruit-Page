@extends('frontend.layouts.master')
@section('title', '🍎 Special Deals - FruitMart')
@section('css')
<link href="{{ asset('frontend/css/deals.css') }}" rel="stylesheet">
@endsection

@section('content')

    <!-- Breadcrumb -->
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fas fa-home"></i> Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Special Deals</li>
            </ol>
        </nav>
    </div>

    <!-- Page Header -->
    <div class="page-header">
        <div class="container">
            <h1 class="page-title">Special Deals & Discounts</h1>
            <p class="page-description">Discover amazing discounts, limited-time offers, and special promotions on our freshest fruits and vegetables. Don't miss out on these incredible savings!</p>
            <div class="deal-badge">
                <i class="fas fa-tags me-2"></i> Up to 50% OFF on Selected Items
            </div>
        </div>
    </div>

    <!-- Flash Sale Banner -->
    <div class="container">
        <div class="flash-sale-banner">
            <h3 class="flash-sale-title">FLASH SALE! 🚀</h3>
            <p class="flash-sale-subtitle">Limited time offers - Up to 60% off on summer fruits! Sale ends soon.</p>
        </div>
    </div>

    <!-- Countdown Timer -->
    <div class="container">
        <div class="countdown-timer">
            <h3 class="timer-title">Flash Sale Ends In:</h3>
            <div class="timer-display">
                <div class="timer-unit">
                    <div class="timer-value" id="days">02</div>
                    <div class="timer-label">Days</div>
                </div>
                <div class="timer-unit">
                    <div class="timer-value" id="hours">12</div>
                    <div class="timer-label">Hours</div>
                </div>
                <div class="timer-unit">
                    <div class="timer-value" id="minutes">45</div>
                    <div class="timer-label">Minutes</div>
                </div>
                <div class="timer-unit">
                    <div class="timer-value" id="seconds">30</div>
                    <div class="timer-label">Seconds</div>
                </div>
            </div>
            <button class="btn btn-danger btn-lg">Shop Flash Sale</button>
        </div>
    </div>

    <!-- Special Deals -->
    <div class="container">
        <div class="row deals-section">
            <div class="col-md-4">
                <div class="deal-card">
                    <div class="deal-icon">
                        <i class="fas fa-shopping-basket"></i>
                    </div>
                    <h4 class="deal-title">Buy 1 Get 1 Free</h4>
                    <p class="deal-description">Select fruits and vegetables. Limited time offer.</p>
                    <div class="deal-code">CODE: BOGO50</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="deal-card secondary">
                    <div class="deal-icon">
                        <i class="fas fa-truck"></i>
                    </div>
                    <h4 class="deal-title">Free Delivery</h4>
                    <p class="deal-description">On orders above $30. No code needed.</p>
                    <div class="deal-code">AUTOMATIC</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="deal-card tertiary">
                    <div class="deal-icon">
                        <i class="fas fa-percentage"></i>
                    </div>
                    <h4 class="deal-title">30% Off Organic</h4>
                    <p class="deal-description">All organic products this week only.</p>
                    <div class="deal-code">CODE: ORGANIC30</div>
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
                    <a class="nav-link active" href="#"><i class="fas fa-fire"></i> All Deals</a>
                    <a class="nav-link" href="#"><i class="fas fa-bolt"></i> Flash Sales</a>
                    <a class="nav-link" href="#"><i class="fas fa-percentage"></i> Discounts Over 50%</a>
                    <a class="nav-link" href="#"><i class="fas fa-shopping-basket"></i> Buy 1 Get 1</a>
                    <a class="nav-link" href="#"><i class="fas fa-gift"></i> Bundle Offers</a>
                    <a class="nav-link" href="#"><i class="fas fa-apple-alt"></i> Fruit Deals</a>
                    <a class="nav-link" href="#"><i class="fas fa-carrot"></i> Vegetable Deals</a>
                    <a class="nav-link" href="#"><i class="fas fa-leaf"></i> Organic Deals</a>
                    <a class="nav-link" href="#"><i class="fas fa-clock"></i> Ending Soon</a>
                </div>
                
                <div class="filter-section">
                    <h5 class="filter-title">Discount Range</h5>
                    <ul class="filter-options">
                        <li>
                            <a href="#">
                                <span>70% or More</span>
                                <span class="count">(8)</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span>50% - 70%</span>
                                <span class="count">(15)</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span>30% - 50%</span>
                                <span class="count">(22)</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span>10% - 30%</span>
                                <span class="count">(18)</span>
                            </a>
                        </li>
                    </ul>
                    
                    <h5 class="filter-title mt-4">Deal Type</h5>
                    <ul class="filter-options">
                        <li>
                            <a href="#">
                                <span>Percentage Discount</span>
                                <span class="count">(42)</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span>Buy 1 Get 1</span>
                                <span class="count">(12)</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span>Bundle Offers</span>
                                <span class="count">(8)</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span>Free Shipping</span>
                                <span class="count">(5)</span>
                            </a>
                        </li>
                    </ul>
                    
                    <h5 class="filter-title mt-4">Time Remaining</h5>
                    <ul class="filter-options">
                        <li>
                            <a href="#">
                                <span>Ending Today</span>
                                <span class="count">(6)</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span>This Week</span>
                                <span class="count">(18)</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span>This Month</span>
                                <span class="count">(25)</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span>Ongoing</span>
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
                                <span class="count">(24)</span>
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
                                <span class="count">(28)</span>
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
                                <span class="count">(11)</span>
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
                            <option selected>Highest Discount</option>
                            <option>Most Popular</option>
                            <option>Price: Low to High</option>
                            <option>Price: High to Low</option>
                            <option>Ending Soon</option>
                        </select>
                    </div>
                    <div class="view-options">
                        <span class="me-2">View:</span>
                        <button class="active"><i class="fas fa-th"></i></button>
                        <button><i class="fas fa-list"></i></button>
                    </div>
                </div>
                
                <h3 class="section-title">Flash Sale Items</h3>
                <div class="row">
                    <!-- Product 1 -->
                    <div class="col-md-4 col-sm-6">
                        <div class="product-card">
                            <div class="product-image position-relative">
                                <span class="badge-discount">60% OFF</span>
                                <span class="badge-hot">HOT DEAL</span>
                                <span class="badge-organic">ORGANIC</span>
                                <img src="https://images.unsplash.com/photo-1571771894821-ce9b6c11b08e?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Strawberries">
                            </div>
                            <div class="product-info">
                                <h5 class="product-title">Organic Strawberries (500g)</h5>
                                <div class="product-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                    <span class="ms-1">(47)</span>
                                </div>
                                <div class="product-price">$3.99 <del>$9.99</del></div>
                                <button class="btn-add-to-cart">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Product 2 -->
                    <div class="col-md-4 col-sm-6">
                        <div class="product-card">
                            <div class="product-image position-relative">
                                <span class="badge-discount">55% OFF</span>
                                <span class="badge-hot">HOT DEAL</span>
                                <img src="https://images.unsplash.com/photo-1550258987-190a2d41a8ba?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Mango">
                            </div>
                            <div class="product-info">
                                <h5 class="product-title">Fresh Mangoes (1kg)</h5>
                                <div class="product-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <span class="ms-1">(51)</span>
                                </div>
                                <div class="product-price">$4.49 <del>$9.99</del></div>
                                <button class="btn-add-to-cart">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Product 3 -->
                    <div class="col-md-4 col-sm-6">
                        <div class="product-card">
                            <div class="product-image position-relative">
                                <span class="badge-discount">50% OFF</span>
                                <span class="badge-hot">HOT DEAL</span>
                                <span class="badge-organic">ORGANIC</span>
                                <img src="https://images.unsplash.com/photo-1557800636-894a64c1696f?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Orange">
                            </div>
                            <div class="product-info">
                                <h5 class="product-title">Organic Oranges (1kg)</h5>
                                <div class="product-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <span class="ms-1">(67)</span>
                                </div>
                                <div class="product-price">$2.99 <del>$5.99</del></div>
                                <button class="btn-add-to-cart">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <h3 class="section-title">Best Discounts</h3>
                <div class="row">
                    <!-- Product 4 -->
                    <div class="col-md-4 col-sm-6">
                        <div class="product-card">
                            <div class="product-image position-relative">
                                <span class="badge-discount">40% OFF</span>
                                <img src="https://images.unsplash.com/photo-1568702846914-96b305d2aaeb?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Apple">
                            </div>
                            <div class="product-info">
                                <h5 class="product-title">Fresh Red Apples (1kg)</h5>
                                <div class="product-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                    <span class="ms-1">(45)</span>
                                </div>
                                <div class="product-price">$3.59 <del>$5.99</del></div>
                                <button class="btn-add-to-cart">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Product 5 -->
                    <div class="col-md-4 col-sm-6">
                        <div class="product-card">
                            <div class="product-image position-relative">
                                <span class="badge-discount">35% OFF</span>
                                <span class="badge-organic">ORGANIC</span>
                                <img src="https://images.unsplash.com/photo-1598170845058-32b9d6a5da37?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Carrots">
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
                                <div class="product-price">$2.27 <del>$3.49</del></div>
                                <button class="btn-add-to-cart">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Product 6 -->
                    <div class="col-md-4 col-sm-6">
                        <div class="product-card">
                            <div class="product-image position-relative">
                                <span class="badge-discount">30% OFF</span>
                                <img src="https://images.unsplash.com/photo-1594282482151-58ad4aa9ade1?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Watermelon">
                            </div>
                            <div class="product-info">
                                <h5 class="product-title">Fresh Watermelon (1pc)</h5>
                                <div class="product-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                    <span class="ms-1">(39)</span>
                                </div>
                                <div class="product-price">$4.54 <del>$6.49</del></div>
                                <button class="btn-add-to-cart">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <h3 class="section-title">Bundle Deals</h3>
                <div class="row">
                    <!-- Product 7 -->
                    <div class="col-md-4 col-sm-6">
                        <div class="product-card">
                            <div class="product-image position-relative">
                                <span class="badge-discount">25% OFF</span>
                                <span class="badge-hot">BUNDLE</span>
                                <img src="https://images.unsplash.com/photo-1518977676601-b53f82aba655?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Bell Peppers">
                            </div>
                            <div class="product-info">
                                <h5 class="product-title">Mixed Vegetable Bundle</h5>
                                <div class="product-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <span class="ms-1">(31)</span>
                                </div>
                                <div class="product-price">$12.99 <del>$17.32</del></div>
                                <button class="btn-add-to-cart">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Product 8 -->
                    <div class="col-md-4 col-sm-6">
                        <div class="product-card">
                            <div class="product-image position-relative">
                                <span class="badge-discount">20% OFF</span>
                                <span class="badge-hot">BUNDLE</span>
                                <span class="badge-organic">ORGANIC</span>
                                <img src="https://images.unsplash.com/photo-1576045057995-568f588f82fb?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Lettuce">
                            </div>
                            <div class="product-info">
                                <h5 class="product-title">Organic Salad Bundle</h5>
                                <div class="product-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <span class="ms-1">(27)</span>
                                </div>
                                <div class="product-price">$8.99 <del>$11.24</del></div>
                                <button class="btn-add-to-cart">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Product 9 -->
                    <div class="col-md-4 col-sm-6">
                        <div class="product-card">
                            <div class="product-image position-relative">
                                <span class="badge-discount">15% OFF</span>
                                <span class="badge-hot">BUNDLE</span>
                                <img src="https://images.unsplash.com/photo-1553279768-865429fa0078?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Banana">
                            </div>
                            <div class="product-info">
                                <h5 class="product-title">Tropical Fruit Bundle</h5>
                                <div class="product-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <span class="ms-1">(38)</span>
                                </div>
                                <div class="product-price">$15.99 <del>$18.81</del></div>
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

    <script>
        // Countdown timer functionality
        function updateCountdown() {
            const days = document.getElementById('days');
            const hours = document.getElementById('hours');
            const minutes = document.getElementById('minutes');
            const seconds = document.getElementById('seconds');
            
            // Set the countdown date (2 days from now)
            const countdownDate = new Date();
            countdownDate.setDate(countdownDate.getDate() + 2);
            countdownDate.setHours(12, 0, 0, 0);
            
            function update() {
                const now = new Date().getTime();
                const distance = countdownDate - now;
                
                const daysValue = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hoursValue = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutesValue = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const secondsValue = Math.floor((distance % (1000 * 60)) / 1000);
                
                days.textContent = daysValue.toString().padStart(2, '0');
                hours.textContent = hoursValue.toString().padStart(2, '0');
                minutes.textContent = minutesValue.toString().padStart(2, '0');
                seconds.textContent = secondsValue.toString().padStart(2, '0');
                
                if (distance < 0) {
                    clearInterval(countdownTimer);
                    days.textContent = '00';
                    hours.textContent = '00';
                    minutes.textContent = '00';
                    seconds.textContent = '00';
                }
            }
            
            update();
            const countdownTimer = setInterval(update, 1000);
        }
        
        document.addEventListener('DOMContentLoaded', updateCountdown);
    </script>
@endsection