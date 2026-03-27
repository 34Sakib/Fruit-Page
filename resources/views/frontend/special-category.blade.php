@extends('frontend.layouts.master')

@push('styles')
<link href="{{ asset('frontend/css/product-card.css') }}" rel="stylesheet">
<link href="{{ asset('frontend/css/category-menu.css') }}" rel="stylesheet">
<link href="{{ asset('frontend/css/active-filters.css') }}" rel="stylesheet">
@endpush


@section('content')
    <div class="container py-5">
        <div class="row">
            <!-- Sidebar with categories -->
            <div class="col-lg-3">
                @include('frontend.partials.category-sidebar', ['categories' => $categories])

                <!-- Active Filters -->
                <div class="card mb-4 active-filters-card">
                    <div class="card-header">
                        <div class="active-filters-header">
                            <div class="active-filters-icon">
                                <i class="fas fa-filter"></i>
                            </div>
                            <h5 class="active-filters-title mb-0">Active Filters</h5>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="active-filter-list" id="active-filter-list">
                            <div class="active-filters-empty">
                                <i class="fas fa-sliders-h"></i>
                                <p class="mb-0">No active filters selected</p>
                                <small>Select filters from below to see them here</small>
                            </div>
                            <!-- Active filters will be added here dynamically -->
                        </div>
                    </div>
                </div>

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
                        {{ $title }}
                    </h1>
                    <div class="text-white px-3 py-2 rounded"
                        style="background: linear-gradient(135deg, #2ecc71, #1abc9c);">
                        <i class="fas fa-check-circle me-2"></i>
                        <strong>{{ $products->total() }}</strong> items found
                    </div>
                </div>

                @if ($title === 'Deals')
                    <div class="alert alert-warning border-0 shadow-sm mb-4"
                        style="background: linear-gradient(135deg, #fff3cd 0%, #ffeeba 100%); border-left: 4px solid #ffc107 !important;">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-tag fa-2x text-warning me-3"></i>
                                    </div>
                                    <div>
                                        <h5 class="alert-heading text-warning mb-1"><i class="fas fa-bolt me-2"></i>HOT
                                            DEALS!</h5>
                                        <p class="mb-0 text-dark">Special limited time offers! These deals won't last long.
                                            <span class="badge bg-danger ms-2">Limited Time</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mt-3 mt-md-0">
                                <div class="countdown-timer text-center">
                                    <div class="countdown-label mb-1">Offer ends in:</div>
                                    <div class="d-flex justify-content-center">
                                        <div class="countdown-item">
                                            <div class="countdown-value" id="days">07</div>
                                            <div class="countdown-label">Days</div>
                                        </div>
                                        <div class="countdown-separator">:</div>
                                        <div class="countdown-item">
                                            <div class="countdown-value" id="hours">23</div>
                                            <div class="countdown-label">Hours</div>
                                        </div>
                                        <div class="countdown-separator">:</div>
                                        <div class="countdown-item">
                                            <div class="countdown-value" id="minutes">59</div>
                                            <div class="countdown-label">Mins</div>
                                        </div>
                                        <div class="countdown-separator">:</div>
                                        <div class="countdown-item">
                                            <div class="countdown-value" id="seconds">59</div>
                                            <div class="countdown-label">Secs</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="row" id="product-container">
                    @forelse($products as $product)
                        <div class="col-md-4 col-6 mb-4">
                            @include('frontend.partials.product-card', ['product' => $product])
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info">No products found in this category.</div>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if ($products->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $products->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('styles')
        <link rel="stylesheet" href="{{ asset('frontend/css/active-filters.css') }}">
    @endpush

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="{{ asset('frontend/js/special-category.js') }}"></script>
    @endpush

@endsection
