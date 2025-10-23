@extends('frontend.layouts.master')
@section('title', '🍎 FruitsPage - Fresh Fruits Online Store')
@section('css')
<link href="{{ asset('frontend/css/fruits.css') }}" rel="stylesheet">
@endsection

@section('content')

    <!-- Breadcrumb -->
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fas fa-home"></i> Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Fruits</li>
            </ol>
        </nav>
    </div>

    <!-- Page Header -->
    <div class="page-header">
        <div class="container">
            <h1 class="page-title">Fresh Fruits</h1>
            <p class="page-description">Discover our wide selection of fresh, organic fruits sourced directly from local farms. From seasonal favorites to exotic varieties, we have everything to satisfy your fruit cravings.</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container">
        <div class="row">
            <!-- Sidebar with Filters -->
            <div class="col-lg-3">
                <div class="category-menu">
                    <a class="nav-link active" href="#"><i class="fas fa-apple-alt"></i> All Fruits</a>
                    <a class="nav-link" href="#"><i class="fas fa-lemon"></i> Citrus Fruits</a>
                    <a class="nav-link" href="#"><i class="fas fa-seedling"></i> Berries</a>
                    <a class="nav-link" href="#"><i class="fas fa-pagelines"></i> Tropical Fruits</a>
                    <a class="nav-link" href="#"><i class="fas fa-tree"></i> Stone Fruits</a>
                    <a class="nav-link" href="#"><i class="fas fa-leaf"></i> Melons</a>
                    <a class="nav-link" href="#"><i class="fas fa-apple-alt"></i> Apples & Pears</a>
                    <a class="nav-link" href="#"><i class="fas fa-gem"></i> Exotic Fruits</a>
                    <a class="nav-link" href="#"><i class="fas fa-certificate"></i> Organic Fruits</a>
                </div>
                
                <div class="filter-section">
                    <h5 class="filter-title">Filter by Price</h5>
                    <form id="priceFilterForm">
                        @csrf
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Price: $<span id="priceRangeValue">0</span> - $<span id="priceRangeMax">100</span></span>
                            </div>
                            <div class="d-flex gap-2 mb-2">
                                <input type="number" class="form-control form-control-sm" id="minPrice" name="min_price" min="0" max="100" value="0" placeholder="Min">
                                <input type="number" class="form-control form-control-sm" id="maxPrice" name="max_price" min="0" max="100" value="100" placeholder="Max">
                            </div>
                            <input type="range" class="form-range" id="priceRange" min="0" max="100" step="1" value="100">
                            <div class="d-flex justify-content-between">
                                <small>$0</small>
                                <small>$100</small>
                            </div>
                        </div>
                    </form>
                    
                    <h5 class="filter-title mt-4">Availability</h5>
                    <ul class="filter-options">
                        <li>
                            <a href="#">
                                <span>In Stock</span>
                                <span class="count">(42)</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span>Out of Stock</span>
                                <span class="count">(8)</span>
                            </a>
                        </li>
                    </ul>
                    
                    <h5 class="filter-title mt-4">Brand</h5>
                    <ul class="filter-options">
                        <li>
                            <a href="#">
                                <span>Fresh Farms</span>
                                <span class="count">(18)</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span>Organic Valley</span>
                                <span class="count">(12)</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span>Tropical Delight</span>
                                <span class="count">(9)</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span>Local Harvest</span>
                                <span class="count">(11)</span>
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
                                <span class="count">(16)</span>
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
                                <span class="count">(10)</span>
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
                
                <div class="row">
                    <!-- Product 1 -->
                    <div class="col-md-4 col-sm-6">
                        <div class="product-card">
                            <div class="product-image position-relative">
                                <span class="badge-discount">15% OFF</span>
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
                                <div class="product-price">$4.99 <del>$5.99</del></div>
                                <button class="btn-add-to-cart">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Product 2 -->
                    <div class="col-md-4 col-sm-6">
                        <div class="product-card">
                            <div class="product-image">
                                <img src="https://images.unsplash.com/photo-1553279768-865429fa0078?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Banana">
                            </div>
                            <div class="product-info">
                                <h5 class="product-title">Fresh Bananas (1kg)</h5>
                                <div class="product-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <span class="ms-1">(32)</span>
                                </div>
                                <div class="product-price">$2.99</div>
                                <button class="btn-add-to-cart">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Product 3 -->
                    <div class="col-md-4 col-sm-6">
                        <div class="product-card">
                            <div class="product-image position-relative">
                                <span class="badge-discount">10% OFF</span>
                                <img src="https://images.unsplash.com/photo-1557800636-894a64c1696f?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Orange">
                            </div>
                            <div class="product-info">
                                <h5 class="product-title">Fresh Oranges (1kg)</h5>
                                <div class="product-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <span class="ms-1">(67)</span>
                                </div>
                                <div class="product-price">$3.49 <del>$3.99</del></div>
                                <button class="btn-add-to-cart">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Product 4 -->
                    <div class="col-md-4 col-sm-6">
                        <div class="product-card">
                            <div class="product-image">
                                <img src="https://images.unsplash.com/photo-1571771894821-ce9b6c11b08e?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Strawberry">
                            </div>
                            <div class="product-info">
                                <h5 class="product-title">Fresh Strawberries (500g)</h5>
                                <div class="product-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                    <span class="ms-1">(28)</span>
                                </div>
                                <div class="product-price">$5.99</div>
                                <button class="btn-add-to-cart">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Product 5 -->
                    <div class="col-md-4 col-sm-6">
                        <div class="product-card">
                            <div class="product-image">
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
                                <div class="product-price">$6.99</div>
                                <button class="btn-add-to-cart">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Product 6 -->
                    <div class="col-md-4 col-sm-6">
                        <div class="product-card">
                            <div class="product-image position-relative">
                                <span class="badge-discount">20% OFF</span>
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
                                <div class="product-price">$4.99 <del>$6.49</del></div>
                                <button class="btn-add-to-cart">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Product 7 -->
                    <div class="col-md-4 col-sm-6">
                        <div class="product-card">
                            <div class="product-image">
                                <img src="https://images.unsplash.com/photo-1592924357228-91a4daadcfea?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Pineapple">
                            </div>
                            <div class="product-info">
                                <h5 class="product-title">Fresh Pineapple (1pc)</h5>
                                <div class="product-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <span class="ms-1">(24)</span>
                                </div>
                                <div class="product-price">$3.99</div>
                                <button class="btn-add-to-cart">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Product 8 -->
                    <div class="col-md-4 col-sm-6">
                        <div class="product-card">
                            <div class="product-image">
                                <img src="https://images.unsplash.com/photo-1571575173700-afb9492e6a50?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Grapes">
                            </div>
                            <div class="product-info">
                                <h5 class="product-title">Fresh Grapes (500g)</h5>
                                <div class="product-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <span class="ms-1">(42)</span>
                                </div>
                                <div class="product-price">$4.49</div>
                                <button class="btn-add-to-cart">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Product 9 -->
                    <div class="col-md-4 col-sm-6">
                        <div class="product-card">
                            <div class="product-image position-relative">
                                <span class="badge-discount">5% OFF</span>
                                <img src="https://images.unsplash.com/photo-1553279768-865429fa0078?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Kiwi">
                            </div>
                            <div class="product-info">
                                <h5 class="product-title">Fresh Kiwi (500g)</h5>
                                <div class="product-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                    <i class="far fa-star"></i>
                                    <span class="ms-1">(19)</span>
                                </div>
                                <div class="product-price">$5.49 <del>$5.79</del></div>
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
@push('scripts')
<script>
$(document).ready(function() {
    // Initialize price range slider
    const priceRange = document.getElementById('priceRange');
    const priceRangeValue = document.getElementById('priceRangeValue');
    const priceRangeMax = document.getElementById('priceRangeMax');
    const minPriceInput = document.getElementById('minPrice');
    const maxPriceInput = document.getElementById('maxPrice');
    
    // Update the max price input when the range slider changes
    priceRange.addEventListener('input', function() {
        maxPriceInput.value = this.value;
        priceRangeMax.textContent = this.value;
        filterProducts();
    });
    
    // Update the range slider when the max price input changes
    maxPriceInput.addEventListener('change', function() {
        if (parseInt(this.value) > 100) this.value = 100;
        if (parseInt(this.value) < parseInt(minPriceInput.value)) this.value = minPriceInput.value;
        priceRange.value = this.value;
        priceRangeMax.textContent = this.value;
        filterProducts();
    });
    
    // Update the min price input and validate
    minPriceInput.addEventListener('change', function() {
        if (parseInt(this.value) < 0) this.value = 0;
        if (parseInt(this.value) > parseInt(maxPriceInput.value)) this.value = maxPriceInput.value;
        priceRangeValue.textContent = this.value;
        filterProducts();
    });
    
    // Function to filter products based on price range
    function filterProducts() {
        const minPrice = minPriceInput.value;
        const maxPrice = maxPriceInput.value;
        
        // Show loading state
        $('#products-container').html('<div class="text-center py-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>');
        
        // Make AJAX request
        $.ajax({
            url: '{{ route("fruits") }}',
            type: 'GET',
            data: {
                min_price: minPrice,
                max_price: maxPrice,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                $('#products-container').html(response.view);
            },
            error: function(xhr) {
                console.error('Error filtering products:', xhr);
                $('#products-container').html('<div class="alert alert-danger">Error loading products. Please try again.</div>');
            }
        });
    }
    
    // Initialize the price range display
    priceRangeValue.textContent = minPriceInput.value;
    priceRangeMax.textContent = maxPriceInput.value;
});
</script>
@endpush

@endsection
