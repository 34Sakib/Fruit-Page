@extends('frontend.layouts.master')

@push('styles')
    <link href="{{ asset('frontend/css/product-card.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/category-menu.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Sidebar with categories -->
        <div class="col-lg-3">
            @include('frontend.partials.category-sidebar', ['categories' => $categories])
            
           <!-- Filters -->
                <div class="filter-card">
                    <div class="filter-header">
                        <h5><i class="fas fa-sliders-h"></i>Filters</h5>
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
                                    <option value="">Default Sorting</option>
                                    <option value="price_asc">Price: Low to High</option>
                                    <option value="price_desc">Price: High to Low</option>
                                    <option value="newest">Newest First</option>
                                    <option value="rating">Top Rated</option>
                                </select>
                            </div>

                            <!-- Availability -->
                            <div class="filter-section">
                                <div class="filter-title">
                                    <i class="fas fa-box"></i>Availability
                                </div>
                                <div class="filter-options">
                                    <div class="filter-option">
                                        <input type="radio" id="in-stock" name="availability" value="in_stock">
                                        <label for="in-stock">In Stock Only</label>
                                    </div>
                                    <div class="filter-option">
                                        <input type="radio" id="all-items" name="availability" value="all" checked>
                                        <label for="all-items">Show All Items</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Filter Buttons -->
                            <div class="filter-buttons">
                                <button type="submit" class="apply-btn">
                                    <i class="fas fa-check me-2"></i>Apply Filters
                                </button>
                                <button type="reset" class="reset-btn">
                                    <i class="fas fa-redo me-2"></i>Reset
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
        </div>

        <!-- Main content -->
        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h4 mb-0 text-white text-center px-3 py-2 rounded"
                        style="background: linear-gradient(135deg, #2ecc71, #1abc9c); 
           box-shadow: 0 4px 15px rgba(46, 204, 113, 0.3);">
                        {{ $category->name }}
                    </h1>
                    <div class="text-white px-3 py-2 rounded"
                        style="background: linear-gradient(135deg, #2ecc71, #1abc9c);">
                        <i class="fas fa-check-circle me-2"></i>
                        <strong>{{ $products->total() }}</strong> items found
                    </div>
                </div>

            <div class="row" id="product-container">
                @foreach($products as $product)
                    <div class="col-md-4 col-6 mb-4">
                        @include('frontend.partials.product-card', ['product' => $product])
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="{{ asset('frontend/js/category.js') }}"></script>
@endpush
@endsection
