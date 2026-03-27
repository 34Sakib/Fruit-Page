@extends('frontend.layouts.master')

@push('styles')
    <link href="{{ asset('frontend/css/product-card.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Enhanced homepage styles */
        .hero-section {
            margin-bottom: 40px;
        }
        
        .section-title {
            font-size: 2.5rem;
            font-weight: 800;
            color: #2c3e50;
            margin-bottom: 25px;
            position: relative;
            padding-bottom: 15px;
            text-align: center;
        }
        
        .section-title:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 5px;
            background: linear-gradient(135deg, #2ecc71, #27ae60);
            border-radius: 2px;
        }
        
        .section-subtitle {
            text-align: center;
            font-size: 1.2rem;
            font-weight: 500;
            color: #5f6f7a;
            max-width: 760px;
            margin: 0 auto 45px;
            line-height: 1.9;
            letter-spacing: 0.4px;
            position: relative;
            padding: 18px 28px;

            /* Premium look */
            background: linear-gradient(135deg, rgba(46,204,113,0.06), rgba(39,174,96,0.03));
            border-radius: 14px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.04);

            /* Smooth animation */
            transition: all 0.3s ease;
        }

        /* Decorative top line */
        .section-subtitle::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 90px;
            height: 4px;
            background: linear-gradient(135deg, #2ecc71, #27ae60);
            border-radius: 10px;
        }

        /* Decorative bottom glow line */
        .section-subtitle::after {
            content: '';
            position: absolute;
            bottom: -6px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 2px;
            background: #2ecc71;
            opacity: 0.4;
        }

        /* Highlight words */
        .section-subtitle strong {
            color: #27ae60;
            font-weight: 600;
        }

        /* Soft hover effect */
        .section-subtitle:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 35px rgba(0,0,0,0.08);
        }
        
        .categories-section {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 50px 0;
            margin-bottom: 50px;
            border-radius: 20px;
            position: relative;
            overflow: hidden;
        }
        
        .categories-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(135deg, #2ecc71, #27ae60);
            border-radius: 20px 20px 0 0;
        }
        
        .category-card {
            text-align: center;
            padding: 30px 15px;
            border-radius: 16px;
            background: white;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            height: 100%;
            border: 2px solid transparent;
            position: relative;
            overflow: hidden;
        }
        
        .category-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(135deg, #2ecc71, #27ae60);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }
        
        .category-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.15);
            border-color: #2ecc71;
        }
        
        .category-card:hover::before {
            transform: scaleX(1);
        }
        
        .category-icon {
            width: 100px;
            height: 100px;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, rgba(46, 204, 113, 0.1), rgba(39, 174, 96, 0.05));
            border-radius: 20px;
            color: #2ecc71;
            font-size: 2.5rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .category-card:hover .category-icon {
            background: linear-gradient(135deg, #2ecc71, #27ae60);
            color: white;
            transform: scale(1.1);
        }
        
        .category-icon img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 16px;
        }
        
        .category-name {
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 8px;
            font-size: 1.1rem;
            transition: color 0.3s ease;
        }
        
        .category-card:hover .category-name {
            color: #2ecc71;
        }
        
        .product-count {
            color: #7f8c8d;
            font-size: 0.9rem;
            font-weight: 500;
            transition: color 0.3s ease;
        }
        
        .category-card:hover .product-count {
            color: #2ecc71;
        }
        
        .products-section {
            margin-bottom: 50px;
        }
        
        .product-card {
            border: none;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 25px rgba(0,0,0,0.08);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            background: white;
            height: 100%;
            position: relative;
            display: flex;
            flex-direction: column;
        }
        
        .product-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(135deg, #2ecc71, #27ae60);
            transform: scaleX(0);
            transition: transform 0.4s ease;
        }
        
        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 45px rgba(0,0,0,0.15);
        }
        
        .product-card:hover::before {
            transform: scaleX(1);
        }
        
        .product-image-container {
            position: relative;
            overflow: hidden;
            background: #f8f9fa;
            height: 220px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .product-image {
            width: 100%;
            height: 100%;
            object-fit: contain;
            transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 8px;
        }
        
        .product-card:hover .product-image {
            transform: scale(1.08);
        }
        
        .carousel-item img {
            height: 500px;
            object-fit: cover;
        }
        
        .carousel-caption h3 {
            font-size: 2.8rem;
            font-weight: 800;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }
        
        .carousel-caption p {
            font-size: 1.3rem;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
        }
        
        .btn-shop-now {
            background: linear-gradient(135deg, #2ecc71, #27ae60);
            border: none;
            padding: 14px 35px;
            font-weight: 600;
            border-radius: 30px;
            transition: all 0.3s ease;
            font-size: 1.1rem;
            box-shadow: 0 4px 15px rgba(46, 204, 113, 0.3);
        }
        
        .btn-shop-now:hover {
            background: linear-gradient(135deg, #27ae60, #219653);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(46, 204, 113, 0.4);
        }
        
        @media (max-width: 768px) {
            .carousel-item img {
                height: 350px;
            }
            
            .carousel-caption h3 {
                font-size: 2rem;
            }
            
            .carousel-caption p {
                font-size: 1.1rem;
            }
            
            .section-title {
                font-size: 2rem;
            }
            
            .category-icon {
                width: 80px;
                height: 80px;
                font-size: 2rem;
            }
            
            .section-subtitle {
                font-size: 1.1rem;
                padding: 0 15px;
            }
            
            .section-subtitle::before {
                left: 10%;
                right: 10%;
            }
        }
        
        @media (max-width: 576px) {
            .carousel-item img {
                height: 280px;
            }
            
            .carousel-caption h3 {
                font-size: 1.6rem;
            }
            
            .carousel-caption p {
                font-size: 0.9rem;
            }
            
            .section-title {
                font-size: 1.8rem;
            }
            
            .category-card {
                padding: 20px 10px;
            }
            
            .category-icon {
                width: 70px;
                height: 70px;
                font-size: 1.8rem;
            }
            
            .section-subtitle {
                font-size: 1rem;
                padding: 0 10px;
            }
            
            .section-subtitle::before {
                left: 5%;
                right: 5%;
            }
        }
    </style>
@endpush

@section('content')
    <!-- Hero Slider Section -->
    <div class="hero-section">
        <div class="container-fluid px-lg-4 px-md-3 px-2">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="slider-section">
                        @php
                            $sliders = \App\Models\Slider::active()->get();
                        @endphp
                        
                        @if($sliders->count() > 0)
                            <div id="mainCarousel" class="carousel slide rounded-4 overflow-hidden" data-bs-ride="carousel">
                                <div class="carousel-indicators">
                                    @foreach($sliders as $key => $slider)
                                        <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="{{ $key }}" 
                                            class="{{ $key === 0 ? 'active' : '' }}" 
                                            aria-current="{{ $key === 0 ? 'true' : 'false' }}"
                                            aria-label="Slide {{ $key + 1 }}">
                                        </button>
                                    @endforeach
                                </div>
                                <div class="carousel-inner rounded-4">
                                    @foreach($sliders as $key => $slider)
                                        <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                                            <img src="{{ asset('storage/' . $slider->image) }}" 
                                                class="d-block w-100" 
                                                alt="{{ $slider->title }}"
                                                style="height: 500px; object-fit: cover;">
                                            <div class="carousel-caption d-none d-md-block">
                                                <h3 class="text-white">{{ $slider->title }}</h3>
                                                @if($slider->description)
                                                    <p class="lead">{{ $slider->description }}</p>
                                                @endif
                                                @if($slider->button_text && $slider->button_link)
                                                    <a href="{{ $slider->button_link }}" class="btn btn-success btn-shop-now mt-3">
                                                        {{ $slider->button_text }}
                                                    </a>
                                                @endif
                                            </div>
                                            
                                            <!-- Mobile caption -->
                                            <div class="carousel-caption d-md-none text-white" style="background: rgba(0,0,0,0.6); border-radius: 10px; padding: 15px;">
                                                <h4>{{ $slider->title }}</h4>
                                                @if($slider->description)
                                                    <p>{{ $slider->description }}</p>
                                                @endif
                                                @if($slider->button_text && $slider->button_link)
                                                    <a href="{{ $slider->button_link }}" class="btn btn-success btn-sm">
                                                        {{ $slider->button_text }}
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        @else
                            <div class="alert alert-info text-center rounded-4 p-5">
                                <i class="fas fa-images fa-3x mb-3 text-muted"></i>
                                <h4 class="text-dark">No Sliders Available</h4>
                                <p class="mb-0 text-muted">Please add some sliders from the admin panel to showcase your offers and announcements.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Categories Section - Shortcut Hub -->
    <div class="categories-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <h3 class="section-title">Shop by Category</h3>
                    <p class="section-subtitle mb-4">Browse our wide selection of fresh products in one click</p>
                    
                    <div class="row g-4">
                        @php
                            $categories = \App\Models\Category::where('status', 'active')
                                ->whereNull('parent_id')
                                ->withCount('products')
                                ->orderBy('order', 'asc')
                                ->take(8)
                                ->get();
                            
                            $categoryIcons = [
                                'fruits' => 'fa-apple-alt',
                                'vegetables' => 'fa-carrot',
                                'meat' => 'fa-drumstick-bite',
                                'fish' => 'fa-fish',
                                'dairy' => 'fa-cheese',
                                'bakery' => 'fa-bread-slice',
                                'beverages' => 'fa-wine-bottle',
                                'snacks' => 'fa-cookie',
                                'frozen' => 'fa-snowflake',
                                'canned' => 'fa-box-open',
                                'spices' => 'fa-mortar-pestle',
                                'organic' => 'fa-leaf',
                                'default' => 'fa-shopping-basket'
                            ];
                        @endphp
                        
                        @foreach($categories as $category)
                            @php
                                $icon = $categoryIcons['default'];
                                $lowerName = strtolower($category->name);
                                
                                foreach($categoryIcons as $key => $categoryIcon) {
                                    if (str_contains($lowerName, $key)) {
                                        $icon = $categoryIcon;
                                        break;
                                    }
                                }
                            @endphp
                            <div class="col-6 col-sm-4 col-md-3 col-lg-2 mx-auto">
                                <a href="{{ route('category', $category->slug) }}" class="text-decoration-none">
                                    <div class="category-card h-100">
                                        <div class="category-icon">
                                            @if($category->image)
                                                <img src="{{ asset('storage/' . $category->image) }}" 
                                                     alt="{{ $category->name }}" 
                                                     class="w-100 h-100 rounded-3 object-fit-cover">
                                            @else
                                                <i class="fas {{ $icon }}"></i>
                                            @endif
                                        </div>
                                        <h4 class="category-name mb-1">{{ Str::limit($category->name, 12) }}</h4>
                                        <span class="product-count">{{ $category->products_count }} items</span>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Products Section -->
    <div class="featured-products products-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <h3 class="section-title">Featured Products</h3>
                    <p class="section-subtitle mb-4">Hand-picked items for you, showcasing quality and freshness</p>
                    
                    @php
                        if (!isset($featuredProducts)) {
                            $featuredProducts = \App\Models\Product::with('category')
                                ->where('status', 'active')
                                ->where('is_featured', true)
                                ->inRandomOrder()
                                ->take(8)
                                ->get();
                        }
                    @endphp

                    @if ($featuredProducts->count() > 0)
                        <div class="row g-4">
                            @foreach ($featuredProducts as $product)
                                <div class="col-xl-3 col-lg-4 col-md-6">
                                    @include('frontend.partials.product-card', ['product' => $product])
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-info text-center rounded-4 p-5">
                            <i class="fas fa-box-open fa-3x mb-3 text-muted"></i>
                            <h4 class="text-dark">No Featured Products</h4>
                            <p class="mb-0 text-muted">Currently there are no featured products available.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Top Products Section -->
    <div class="top-products products-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <h3 class="section-title">Top Products</h3>
                    <p class="section-subtitle mb-4">Our most popular choices that drive customer confidence</p>
                    
                    @php
                        if (!isset($topProducts)) {
                            $topProducts = \App\Models\Product::topProducts()
                                ->take(8)
                                ->get();
                        }
                    @endphp

                    @if ($topProducts->count() > 0)
                        <div class="row g-4">
                            @foreach ($topProducts as $product)
                                <div class="col-xl-3 col-lg-4 col-md-6">
                                    @include('frontend.partials.product-card', ['product' => $product])
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-info text-center rounded-4 p-5">
                            <i class="fas fa-chart-line fa-3x mb-3 text-muted"></i>
                            <h4 class="text-dark">No Top Products</h4>
                            <p class="mb-0 text-muted">Currently there are no top products available.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="{{ asset('frontend/js/category-menu.js') }}"></script>
<script>
// Re-initialize product actions for home page
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Bootstrap collapse for mobile menu
    const navbarToggler = document.querySelector('.navbar-toggler');
    const navbarCollapse = document.querySelector('.navbar-collapse');
    
    if (navbarToggler && navbarCollapse) {
        // Ensure Bootstrap collapse is properly initialized
        const collapse = new bootstrap.Collapse(navbarCollapse, {
            toggle: false
        });
        
        // Add click event listener to the toggler
        navbarToggler.addEventListener('click', function() {
            collapse.toggle();
        });
    }
    
    // Ensure cart and wishlist functionality is properly initialized
    if (typeof updateCartCounts === 'function') {
        updateCartCounts(window.initialCartCount || 0);
    }
    if (typeof updateWishlistCounts === 'function') {
        updateWishlistCounts(window.initialWishlistCount || 0);
    }
    
    // Re-bind product card events
    const productCards = document.querySelectorAll('.product-card');
    productCards.forEach(card => {
        const addToCartForm = card.querySelector('.add-to-cart-form');
        const wishlistBtn = card.querySelector('.product-wishlist');
        
        if (addToCartForm) {
            // Remove existing listeners to prevent duplicates
            $(addToCartForm).off('submit');
        }
        
        if (wishlistBtn) {
            // Remove existing listeners to prevent duplicates
            $(wishlistBtn).off('click');
        }
    });
    
    // Re-initialize jQuery event handlers
    if (typeof $ !== 'undefined') {
        $(document).trigger('DOMContentLoaded');
    }
});
</script>
@endpush