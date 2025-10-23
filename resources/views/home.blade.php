@extends('frontend.layouts.master')

@section('content')
    <!-- Main Content -->
    <div class="container mt-4">
        <div class="row">
            <!-- Category Menu -->
            <div class="col-lg-3">
                @php
                    $categories = $categories ?? \App\Models\Category::where('status', 'active')
                        ->whereNull('parent_id')
                        ->with(['children' => function($query) {
                            $query->where('status', 'active')->orderBy('order', 'asc');
                        }])
                        ->orderBy('order', 'asc')
                        ->get();
                @endphp
                
                <!-- Categories Card -->
                <div class="card mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0 text-success" style="border-left: 4px solid #28a745; padding-left: 10px;">Categories</h5>
                    </div>
                    <div class="card-body p-0">
                        @if($categories->count() > 0)
                            <div class="list-group list-group-flush">
                                @foreach($categories as $category)
                                    <a href="{{ route('category.show', $category->slug) }}" 
                                       class="list-group-item list-group-item-action d-flex justify-content-between align-items-center border-bottom"
                                       style="padding: 0.75rem 1.25rem; color: #333;">
                                        <span>
                                            <i class="fas {{ $category->icon ?? 'fa-folder' }} me-2 text-success"></i>
                                            <strong>{{ $category->name }}</strong>
                                        </span>
                                        @if($category->children->count() > 0)
                                            <i class="fas fa-chevron-right small text-muted"></i>
                                        @endif
                                    </a>
                                    @if($category->children->count() > 0)
                                        <div class="subcategories ps-4 bg-light">
                                            @foreach($category->children as $child)
                                                <a href="{{ route('category.show', $child->slug) }}" 
                                                   class="list-group-item list-group-item-action py-2 ps-4 d-flex align-items-center"
                                                   style="color: #6c757d; border: none; border-bottom: 1px solid #eee;">
                                                    <i class="fas {{ $child->icon ?? 'fa-angle-right' }} me-2 text-muted"></i>
                                                    {{ $child->name }}
                                                </a>
                                            @endforeach
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @else
                            <div class="p-3">
                                <div class="alert alert-info mb-0">No categories found.</div>
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Features Section -->
                <div class="mt-4">
                    <div class="feature-box">
                        <div class="feature-icon">
                            <i class="fas fa-shipping-fast"></i>
                        </div>
                        <h5 class="feature-title">Free Delivery</h5>
                        <p>Free home delivery for orders above $30</p>
                    </div>
                    <div class="feature-box">
                        <div class="feature-icon">
                            <i class="fas fa-award"></i>
                        </div>
                        <h5 class="feature-title">Quality Guarantee</h5>
                        <p>Freshness and quality guaranteed</p>
                    </div>
                    <div class="feature-box">
                        <div class="feature-icon">
                            <i class="fas fa-headset"></i>
                        </div>
                        <h5 class="feature-title">24/7 Support</h5>
                        <p>Round the clock customer support</p>
                    </div>
                </div>
            </div>
            
            <!-- Slider and Products -->
            <div class="col-lg-9">
                <!-- Slider -->
                <div class="slider-section">
                    <div id="mainCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="0" class="active"></button>
                            <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="1"></button>
                            <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="2"></button>
                        </div>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="https://images.unsplash.com/photo-1619566636858-adf3ef46400b?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" class="d-block w-100" alt="Fresh Fruits">
                                <div class="carousel-caption d-none d-md-block">
                                    <h3>Fresh Seasonal Fruits</h3>
                                    <p>Get the freshest fruits delivered to your doorstep</p>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <img src="https://images.unsplash.com/photo-1567306301408-9b74779a11af?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" class="d-block w-100" alt="Organic Fruits">
                                <div class="carousel-caption d-none d-md-block">
                                    <h3>Organic Fruits Collection</h3>
                                    <p>100% organic and pesticide-free fruits</p>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <img src="https://images.unsplash.com/photo-1574856344991-aaa31b6f4ce3?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" class="d-block w-100" alt="Exotic Fruits">
                                <div class="carousel-caption d-none d-md-block">
                                    <h3>Exotic Fruits</h3>
                                    <p>Discover unique fruits from around the world</p>
                                </div>
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                    </div>
                </div>
                
                <!-- Featured Products -->
                <div class="featured-products mb-5">
                    <h3 class="section-title">Featured Products</h3>
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
                    
                    @if($featuredProducts->count() > 0)
                        <div class="row">
                            @foreach($featuredProducts as $product)
                                <div class="col-md-3 col-sm-6 mb-4">
                                    @include('frontend.partials.product-card', ['product' => $product])
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-info">No featured products available at the moment.</div>
                    @endif
                </div>
                
                <!-- Seasonal Products -->
                <h3 class="section-title mt-5">Seasonal Picks</h3>
                @php
                    if (!isset($seasonalProducts)) {
                        $seasonalProducts = \App\Models\Product::with('category')
                            ->where('status', 'active')
                            ->where('is_seasonal', true)
                            ->inRandomOrder()
                            ->take(4)
                            ->get();
                    }
                @endphp
                
                @if($seasonalProducts->count() > 0)
                    <div class="row">
                        @foreach($seasonalProducts as $product)
                            <div class="col-md-3 col-sm-6 mb-4">
                                @include('frontend.partials.product-card', ['product' => $product])
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-info">No seasonal products available at the moment.</div>
                @endif
            </div>
        </div>
    </div>
@endsection
    