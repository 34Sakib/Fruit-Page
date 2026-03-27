@extends('frontend.layouts.master')

@push('styles')
<link rel="stylesheet" href="{{ asset('frontend/css/product-details.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/css/reviews.css') }}">
<style>
    /* Enhanced Rating Styles */
    .rating-display {
        display: inline-flex;
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .rating-stars {
        color: #ffc107;
        font-size: 1.25rem;
        letter-spacing: 2px;
    }
    
    .rating-input {
        display: flex;
        flex-direction: row-reverse;
        justify-content: flex-end;
    }
    
    .rating-input input[type="radio"] {
        display: none;
    }
    
    .rating-input label {
        cursor: pointer;
        font-size: 1.5rem;
        color: #ddd;
        transition: color 0.2s;
    }
    
    .rating-input input[type="radio"]:checked ~ label,
    .rating-input label:hover,
    .rating-input label:hover ~ label {
        color: #ffc107;
    }
    
    .rating-input input[type="radio"]:checked ~ label {
        color: #ffc107;
    }
    
    /* Review Card Styles */
    .review-card {
        border: 1px solid rgba(0,0,0,0.05);
        border-radius: 0.75rem;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    
    .review-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.05);
    }
    
    .review-header {
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }
    
    .review-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background-color: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        font-weight: bold;
        color: #6c757d;
    }
    
    /* Rating Distribution */
    .rating-progress {
        height: 8px;
        border-radius: 4px;
    }
    
    /* Animation */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .review-item {
        animation: fadeIn 0.5s ease-out forwards;
        opacity: 0;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .rating-stats {
            margin-bottom: 1.5rem;
        }
    }
    
    /* Thumbnail styles */
    .thumbnail.active {
        border: 2px solid #007bff !important;
    }
    .thumbnail {
        transition: all 0.3s ease;
    }
    .thumbnail:hover {
        border-color: #007bff !important;
        transform: scale(1.05);
    }

    /* Image Zoom/Lightbox Styles */
    .image-zoom-container {
        position: relative;
        cursor: zoom-in;
        overflow: hidden;
        border-radius: 8px;
    }

    .image-zoom-container img {
        transition: transform 0.3s ease;
    }

    .image-zoom-container:hover img {
        transform: scale(1.1);
    }

    /* Lightbox Styles */
    .lightbox {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.9);
        z-index: 9999;
        cursor: zoom-out;
        animation: fadeIn 0.3s ease;
    }

    .lightbox.active {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .lightbox img {
        max-width: 90%;
        max-height: 90%;
        object-fit: contain;
        border-radius: 8px;
        box-shadow: 0 10px 50px rgba(0, 0, 0, 0.5);
        animation: zoomIn 0.3s ease;
    }

    .lightbox-close {
        position: absolute;
        top: 20px;
        right: 30px;
        color: white;
        font-size: 40px;
        font-weight: bold;
        cursor: pointer;
        z-index: 10000;
        transition: color 0.3s ease;
    }

    .lightbox-close:hover {
        color: #ff6b6b;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes zoomIn {
        from { transform: scale(0.8); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }

    /* Related Products Image Styling */
    .related-product .product-image {
        position: relative;
        width: 100%;
        height: 200px;
        overflow: hidden;
    }

    .related-product .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .related-product:hover .product-image img {
        transform: scale(1.05);
    }

    .related-product {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .related-product:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15);
    }
</style>
@endpush

@section('content')
    <!-- Product Details Section -->
    <section class="product-details">
        <div class="container">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb bg-transparent p-0 m-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}" class="text-success text-decoration-none">
                            <i class="fas fa-home me-1"></i> Home
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('category.show', $product->category->slug) }}" class="text-success text-decoration-none">
                            {{ $product->category->name }}
                        </a>
                    </li>
                    <li class="breadcrumb-item active text-success fw-medium" aria-current="page">
                        {{ $product->name }}
                    </li>
                </ol>
            </nav>

            <div class="row g-5">
                <!-- Product Gallery -->
                <div class="col-lg-6">
                    <div class="product-gallery">
                        <div class="main-image mb-4">
                            @php
                                $imageUrls = $product->image_urls;
                                $mainImagePath = !empty($imageUrls) ? $imageUrls[0] : asset('images/default-product.jpg');
                            @endphp
                            <div class="image-zoom-container" onclick="openLightbox('{{ $mainImagePath }}')">
                                <img id="mainImage" src="{{ $mainImagePath }}" alt="{{ $product->name }}" class="img-fluid rounded-3" onerror="this.src='{{ asset('images/default-product.jpg') }}'">
                            </div>
                        </div>
                        @if(!empty($imageUrls) && count($imageUrls) > 1)
                        <div class="thumbnail-container d-flex gap-3 flex-wrap">
                            @foreach($imageUrls as $index => $imageUrl)
                            <div class="thumbnail border rounded-2 overflow-hidden {{ $index == 0 ? 'active' : '' }}" style="width: 100px; height: 100px; cursor: pointer;" onclick="changeMainImage('{{ $imageUrl }}', this); openLightbox('{{ $imageUrl }}')">
                                <img src="{{ $imageUrl }}" alt="Thumbnail {{ $index+1 }}" class="img-fluid h-100 w-100 object-fit-cover" onerror="this.src='{{ asset('images/default-product.jpg') }}'">
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Product Info -->
                <div class="col-lg-6">
                    <div class="product-info">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <h1 class="product-title mb-0">{{ $product->name }}</h1>
                            @if($product->quantity > 0)
                                <span class="badge bg-success bg-opacity-10 text-success">
                                    <i class="fas fa-check-circle me-1"></i> In Stock
                                </span>
                            @else
                                <span class="badge bg-danger bg-opacity-10 text-danger">
                                    <i class="fas fa-times-circle me-1"></i> Out of Stock
                                </span>
                            @endif
                        </div>
                        
                        @php
                            $avgRating = $product->reviews->avg('rating') ?? 0;
                            $fullStars = floor($avgRating);
                            $hasHalfStar = $avgRating - $fullStars >= 0.5;
                            $emptyStars = 5 - $fullStars - ($hasHalfStar ? 1 : 0);
                            $reviewCount = $product->reviews->count();
                            $reviewText = $reviewCount === 1 ? 'review' : 'reviews';
                            
                            // Calculate rating distribution
                            $ratingDistribution = [];
                            for ($i = 5; $i >= 1; $i--) {
                                $ratingDistribution[$i] = $product->reviews->where('rating', $i)->count();
                            }
                        @endphp
                        
                        <div class="rating-display mb-3">
                                <div class="rating-stars" data-rating="{{ number_format($avgRating, 1) }}">
                                    @php
                                        // These variables are now defined above
                                    @endphp
                                    
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $fullStars)
                                            <i class="fas fa-star"></i>
                                        @elseif($i == $fullStars + 1 && $hasHalfStar)
                                            <i class="fas fa-star-half-alt"></i>
                                        @else
                                            <i class="far fa-star"></i>
                                        @endif
                                    @endfor
                                    <span class="ms-2 fw-bold">{{ number_format($avgRating, 1) }}</span>
                                    <span class="text-muted ms-1">({{ $reviewCount }} {{ $reviewText }})</span>
                                </div>
                                
                                @if($reviewCount > 0)
                                <div class="rating-breakdown mt-2">
                                    @for($i = 5; $i >= 1; $i--)
                                        @php
                                            $percentage = $reviewCount > 0 ? ($ratingDistribution[$i] / $reviewCount) * 100 : 0;
                                        @endphp
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="text-nowrap me-2" style="width: 80px;">
                                                {{ $i }} <i class="fas fa-star text-warning"></i>
                                            </div>
                                            <div class="progress flex-grow-1" style="height: 8px;">
                                                <div class="progress-bar bg-warning" role="progressbar" 
                                                     style="width: {{ $percentage }}%" 
                                                     aria-valuenow="{{ $percentage }}" 
                                                     aria-valuemin="0" 
                                                     aria-valuemax="100">
                                                </div>
                                            </div>
                                            <div class="ms-2 text-muted" style="width: 40px; text-align: right;">
                                                {{ $ratingDistribution[$i] }}
                                            </div>
                                        </div>
                                    @endfor
                                </div>
                                @endif
                        </div>

                        <div class="product-price">
                            @if($product->sale_price)
                                <span class="current-price text-success">${{ number_format($product->sale_price, 2) }}</span>
                                <span class="original-price text-danger">${{ number_format($product->price, 2) }}</span>
                                <span class="badge bg-success ms-2">{{ round((($product->price - $product->sale_price) / $product->price) * 100) }}% OFF</span>
                            @else
                                <span class="current-price text-danger">${{ number_format($product->price, 2) }}</span>
                            @endif
                        </div>

                        <div class="product-description my-4">
                            <p class="mb-0">{{ $product->description }}</p>
                        </div>

                        <div class="product-actions mb-4">
                            <div class="d-flex align-items-center flex-wrap gap-3">
                                <div class="quantity-selector">
                                    <button type="button" class="quantity-btn minus" onclick="decreaseQuantity()">-</button>
                                    <input type="number" id="quantity" name="quantity" value="1" min="1" max="{{ $product->quantity }}" class="quantity-input">
                                    <button type="button" class="quantity-btn plus btn-success" onclick="increaseQuantity()">+</button>
                                </div>

                                <form id="add-to-cart-form" action="{{ route('cart.add') }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1" id="form-quantity">
                                    <button type="submit" class="add-to-cart-btn" {{ $product->quantity <= 0 ? 'disabled' : '' }}>
                                        <i class="fas fa-shopping-cart me-2"></i> Add to Cart
                                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                    </button>
                                </form>
                                
                                <button type="button" 
                                        class="product-wishlist wishlist-btn {{ in_array($product->id, session('wishlist', [])) ? 'active' : '' }}" 
                                        data-product-id="{{ $product->id }}"
                                        data-wishlist-url="{{ route('wishlist.add', $product->id) }}"
                                        data-remove-wishlist-url="{{ route('wishlist.remove', $product->id) }}"
                                        title="{{ in_array($product->id, session('wishlist', [])) ? 'Remove from Wishlist' : 'Add to Wishlist' }}">
                                    <i class="{{ in_array($product->id, session('wishlist', [])) ? 'fas' : 'far' }} fa-heart"></i>
                                </button>
                            </div>
                        </div>

                        <div class="product-meta">
                            <div class="d-flex align-items-center mb-3">
                                <span class="meta-title me-2">Category:</span>
                                <a href="{{ route('category.show', $product->category->slug) }}" class="text-decoration-none">
                                    <span class="badge bg-primary bg-opacity-10 text-primary">{{ $product->category->name }}</span>
                                </a>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <span class="meta-title me-2">Availability:</span>
                                <span class="fw-medium">{{ $product->quantity > 0 ? 'In Stock' : 'Out of Stock' }}</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <span class="meta-title me-3">Share:</span>
                                <div class="social-links">
                                    <a href="#" class="facebook" title="Share on Facebook"><i class="fab fa-facebook-f"></i></a>
                                    <a href="#" class="twitter" title="Share on Twitter"><i class="fab fa-twitter"></i></a>
                                    <a href="#" class="instagram" title="Share on Instagram"><i class="fab fa-instagram"></i></a>
                                    <a href="#" class="whatsapp" title="Share on WhatsApp"><i class="fab fa-whatsapp"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Tabs -->
            <div class="row mt-5">
                <div class="col-12">
                    <div class="product-tabs">
                        <ul class="nav nav-tabs" id="productTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab" aria-controls="description" aria-selected="true">Description</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab" aria-controls="reviews" aria-selected="false">Reviews</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="productTabsContent">
                            <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                                <div class="p-4">
                                    <h5 class="mb-3 fw-bold">Product Description</h5>
                                    <p class="mb-4">{{ $product->description }}</p>
                                    
                                    <h5 class="mb-3 fw-bold">Key Features</h5>
                                    <ul class="list-unstyled">
                                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Freshly harvested and carefully selected</li>
                                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i> 100% natural and organic</li>
                                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Rich in essential vitamins and nutrients</li>
                                        @if(str_contains(strtolower($product->name), 'local'))
                                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Locally sourced from trusted Bangladeshi farms</li>
                                        @endif
                                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Carefully packaged to maintain freshness</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                                <div class="p-4">
                                    <h4 class="mb-4 fw-bold text-primary">
                                        <i class="fas fa-star text-warning me-2"></i>Customer Reviews 
                                        <span class="badge bg-primary rounded-pill ms-2">{{ $totalReviews }}</span>
                                    </h4>
                                    
                                    @if($totalReviews > 0)
                                        <div class="bg-light p-4 rounded-3 mb-4">
                                            <div class="d-flex align-items-center mb-2">
                                                <div class="rating me-3" style="font-size: 1.5rem;">
                                                    @php
                                                        $avgRating = $product->reviews->avg('rating');
                                                        $fullStars = floor($avgRating);
                                                        $hasHalfStar = $avgRating - $fullStars >= 0.5;
                                                    @endphp
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <= $fullStars)
                                                            <i class="fas fa-star text-warning"></i>
                                                        @elseif($i == $fullStars + 1 && $hasHalfStar)
                                                            <i class="fas fa-star-half-alt text-warning"></i>
                                                        @else
                                                            <i class="far fa-star text-warning"></i>
                                                        @endif
                                                    @endfor
                                                </div>
                                                <h3 class="mb-0 text-primary">{{ number_format($avgRating, 1) }} <small class="text-muted">out of 5</small></h3>
                                            </div>
                                            <p class="text-muted mb-0">
                                                <i class="fas fa-users me-1"></i> 
                                                Based on {{ $totalReviews }} {{ Str::plural('review', $totalReviews) }} from our customers
                                            </p>
                                        </div>
                                    @endif

                                    @auth
                                        <div class="card mb-4 border-0 shadow-sm review-form-card">
                                            <div class="card-header bg-white py-3 border-0">
                                                <h5 class="mb-0 text-primary">
                                                    <i class="fas fa-edit me-2"></i>Write a Review
                                                </h5>
                                            </div>
                                            <div class="card-body px-4">
                                                <form action="{{ route('review.store', $product) }}" method="POST" id="reviewForm">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                    
                                                    <div class="mb-4">
                                                        <label class="form-label fw-bold d-block mb-2">Your Rating</label>
                                                        <div class="rating-input">
                                                            @for($i = 5; $i >= 1; $i--)
                                                                <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" 
                                                                    {{ old('rating') == $i ? 'checked' : '' }} required>
                                                                <label for="star{{ $i }}" title="{{ $i }} stars">
                                                                    <i class="far fa-star"></i>
                                                                </label>
                                                            @endfor
                                                        </div>
                                                        @error('rating')
                                                            <div class="text-danger small mt-2">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    
                                                    <div class="mb-4">
                                                        <label for="comment" class="form-label fw-bold">Your Review</label>
                                                        <textarea class="form-control @error('comment') is-invalid @enderror" 
                                                              id="comment" name="comment" rows="4" required 
                                                              placeholder="Share your experience with this product. What did you like or dislike?"
                                                              style="min-height: 120px;">{{ old('comment') }}</textarea>
                                                        @error('comment')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    
                                                    <div class="d-flex justify-content-end">
                                                        <button type="submit" class="btn btn-primary px-4 py-2" id="submitReviewBtn">
                                                            <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                                            <span class="ms-1">Submit Review</span>
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    @else
                                        <div class="alert alert-info d-flex align-items-center mb-4" role="alert">
                                            <i class="fas fa-info-circle me-3" style="font-size: 1.5rem;"></i>
                                            <div>
                                                <h5 class="alert-heading mb-1">Want to share your experience?</h5>
                                                <p class="mb-0">Please <a href="{{ route('login') }}" class="alert-link fw-bold">login</a> to write a review and help other customers with your feedback!</p>
                                            </div>
                                        </div>
                                    @endauth

                                    @if($approvedReviews->count() > 0)
                                        <div class="reviews-list">
                                            <div class="d-flex justify-content-between align-items-center mb-4">
                                                <h5 class="mb-0 text-primary">
                                                    <i class="fas fa-comments me-2"></i>Customer Reviews
                                                </h5>
                                                <div class="dropdown">
                                                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" id="sortReviewsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fas fa-sort me-1"></i> Sort by
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="sortReviewsDropdown">
                                                        <li><a class="dropdown-item sort-reviews active" href="#" data-sort="newest">Newest First</a></li>
                                                        <li><a class="dropdown-item sort-reviews" href="#" data-sort="highest">Highest Rating</a></li>
                                                        <li><a class="dropdown-item sort-reviews" href="#" data-sort="lowest">Lowest Rating</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            @foreach($approvedReviews as $index => $review)
                                            <div class="review-item mb-4 pb-4 border-bottom" data-rating="{{ $review->rating }}" data-date="{{ $review->created_at->timestamp }}">
                                                <div class="review-card p-4">
                                                    <div class="review-header d-flex justify-content-between align-items-center mb-3 pb-2">
                                                        <div class="d-flex align-items-center">
                                                            <div class="me-3">
                                                                @if($review->user && $review->user->profile_photo_path)
                                                                    <img src="{{ asset('storage/' . $review->user->profile_photo_path) }}" alt="{{ $review->name }}" class="rounded-circle" width="50" height="50" style="object-fit: cover;">
                                                                @else
                                                                    <div class="review-avatar bg-primary bg-opacity-10 text-primary">
                                                                        {{ substr($review->name, 0, 1) }}
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <div>
                                                                <h6 class="mb-0 fw-bold">{{ $review->name }}</h6>
                                                                <div class="text-muted small">
                                                                    <i class="far fa-clock me-1"></i> {{ $review->created_at->diffForHumans() }}
                                                                    <span class="mx-2">•</span>
                                                                    <i class="fas fa-check-circle text-success me-1"></i> Verified Purchase
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="rating">
                                                            @for($i = 1; $i <= 5; $i++)
                                                                @if($i <= $review->rating)
                                                                    <i class="fas fa-star text-warning"></i>
                                                                @else
                                                                    <i class="far fa-star text-warning"></i>
                                                                @endif
                                                            @endfor
                                                        </div>
                                                    </div>
                                                    <div class="review-body ps-4 ms-2 border-start border-2 border-primary">
                                                        <h6 class="fw-bold mb-2">{{ $review->title ?? 'Great Product!' }}</h6>
                                                        <p class="mb-3">{{ $review->comment }}</p>
                                                        
                                                        @if($review->images && $review->images->count() > 0)
                                                            <div class="review-images d-flex gap-2 mb-3">
                                                                @foreach($review->images->take(3) as $image)
                                                                    <a href="{{ asset('storage/' . $image->path) }}" data-lightbox="review-{{ $review->id }}" class="d-block" style="width: 80px; height: 80px; overflow: hidden; border-radius: 8px;">
                                                                        <img src="{{ asset('storage/' . $image->path) }}" alt="Review Image" class="img-fluid h-100 w-100" style="object-fit: cover;">
                                                                    </a>
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                        
                                                        @if($review->user_id === auth()->id() || (auth()->check() && auth()->user()->isAdmin()))
                                                            <div class="mt-3 pt-2 border-top">
                                                                @if($review->user_id === auth()->id())
                                                                    <button class="btn btn-sm btn-outline-primary edit-review" data-review-id="{{ $review->id }}">
                                                                        <i class="far fa-edit me-1"></i> Edit
                                                                    </button>
                                                                @endif
                                                                <form action="{{ route('review.destroy', $review) }}" method="POST" class="d-inline ms-2">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this review?')">
                                                                        <i class="far fa-trash-alt me-1"></i> Delete
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        </div>
                                    @else
                                        <div class="text-center py-5">
                                            <div class="mb-3">
                                                <i class="far fa-comment-dots text-muted" style="font-size: 3rem;"></i>
                                            </div>
                                            <h5 class="text-muted mb-3">No Reviews Yet</h5>
                                            <p class="text-muted mb-0">Be the first to share your thoughts about this product!</p>
                                            @guest
                                                <a href="{{ route('login') }}" class="btn btn-outline-primary mt-3">
                                                    <i class="fas fa-sign-in-alt me-2"></i>Login to Review
                                                </a>
                                            @endguest
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
    <section class="related-products py-5 bg-white">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="h4 mb-0 fw-bold">You May Also Like</h2>
                <a href="{{ route('category.show', $product->category->slug) }}" class="btn btn-link text-success text-decoration-none p-0 fw-bold">
                    View All <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="row g-4">
                @foreach($relatedProducts as $relatedProduct)
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="related-product h-100 bg-white rounded-3 overflow-hidden shadow-sm">
                        <div class="position-relative">
                            <div class="product-badges">
                                @if($relatedProduct->sale_price)
                                    <span class="badge bg-danger"><i class="fas fa-tag me-1"></i>Sale</span>
                                @endif
                                @if($relatedProduct->is_featured)
                                    <span class="badge bg-success">Featured</span>
                                @endif
                            </div>
                            <a href="{{ route('product.details', $relatedProduct->slug) }}" class="text-decoration-none">
                                <div class="product-image">
                                    @php
                                        $imageUrls = $relatedProduct->image_urls;
                                        $imagePath = !empty($imageUrls) ? $imageUrls[0] : asset('images/default-product.jpg');
                                    @endphp
                                    <img src="{{ $imagePath }}" alt="{{ $relatedProduct->name }}" class="img-fluid" onerror="this.src='{{ asset('images/default-product.jpg') }}'">
                                </div>
                            </a>
                        </div>
                        <div class="p-3">
                            <h5 class="product-title mb-2">
                                <a href="{{ route('product.details', $relatedProduct->slug) }}" class="text-decoration-none text-dark">
                                    {{ $relatedProduct->name }}
                                </a>
                            </h5>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="price">
                                    @if($relatedProduct->sale_price)
                                        <span class="d-block fw-bold text-success">${{ number_format($relatedProduct->sale_price, 2) }}</span>
                                        <span class="text-danger text-decoration-line-through small">${{ number_format($relatedProduct->price, 2) }}</span>
                                    @else
                                        <span class="d-block fw-bold text-success">${{ number_format($relatedProduct->price, 2) }}</span>
                                    @endif
                                </div>
                                <form action="" method="POST">
                                    @csrf
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $relatedProduct->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn btn-sm btn-success rounded-circle add-to-cart-related" title="Add to Cart" {{ $relatedProduct->quantity <= 0 ? 'disabled' : '' }}>
                                        <i class="fas fa-plus"></i>
                                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/lightgallery@2.7.0/lightgallery.umd.min.js"></script>
    
    <!-- Add CSRF Token Meta Tag -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/lightgallery@2.7.0/plugins/zoom/lg-zoom.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/lightgallery@2.7.0/plugins/thumbnail/lg-thumbnail.umd.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/lightgallery@2.7.0/css/lightgallery-bundle.min.css" />
    <script>
        // Ensure dropdowns work properly on this page
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize the user dropdown specifically
            const userDropdown = document.getElementById('userDropdown');
            if (userDropdown) {
                try {
                    new bootstrap.Dropdown(userDropdown);
                    console.log('User dropdown initialized successfully');
                } catch (e) {
                    console.warn('Failed to initialize user dropdown:', e);
                }
            }
            
            // Initialize all other dropdowns as well
            const dropdowns = document.querySelectorAll('[data-bs-toggle="dropdown"]');
            dropdowns.forEach(function(dropdown) {
                try {
                    if (!dropdown.dataset.bsInitialized) {
                        new bootstrap.Dropdown(dropdown);
                        dropdown.dataset.bsInitialized = 'true';
                    }
                } catch (e) {
                    console.warn('Failed to initialize dropdown:', e);
                }
            });
        });
        
        function increaseQuantity() {
            const quantityInput = document.getElementById('quantity');
            const formQuantity = document.getElementById('form-quantity');
            const max = parseInt(quantityInput.getAttribute('max'));
            if (parseInt(quantityInput.value) < max) {
                quantityInput.value = parseInt(quantityInput.value) + 1;
                formQuantity.value = quantityInput.value;
            }
        }

        function decreaseQuantity() {
            const quantityInput = document.getElementById('quantity');
            const formQuantity = document.getElementById('form-quantity');
            if (parseInt(quantityInput.value) > 1) {
                quantityInput.value = parseInt(quantityInput.value) - 1;
                formQuantity.value = quantityInput.value;
            }
        }

        function changeMainImage(imageSrc, thumbnailElement) {
            const mainImage = document.getElementById('mainImage');
            mainImage.style.opacity = '0.7';
            
            // Smooth transition effect
            setTimeout(() => {
                mainImage.src = imageSrc;
                mainImage.style.opacity = '1';
            }, 150);
            
            // Update active thumbnail
            document.querySelectorAll('.thumbnail').forEach(thumb => {
                thumb.classList.remove('active');
            });
            thumbnailElement.classList.add('active');
        }

        // Change main image when clicking on thumbnails
        document.querySelectorAll('.thumbnail img').forEach(thumbnail => {
            thumbnail.addEventListener('click', function() {
                const mainImage = document.querySelector('.main-image img');
                mainImage.style.opacity = '0.7';
                
                // Smooth transition effect
                setTimeout(() => {
                    mainImage.src = this.src;
                    mainImage.alt = this.alt;
                    mainImage.style.opacity = '1';
                }, 150);
                
                // Update active thumbnail
                document.querySelectorAll('.thumbnail').forEach(thumb => {
                    thumb.style.border = '1px solid #dee2e6';
                });
                this.parentElement.style.border = '2px solid var(--primary)';
            });
        });

        // Initialize first thumbnail as active
        const firstThumbnail = document.querySelector('.thumbnail');
        if (firstThumbnail) {
            firstThumbnail.style.border = '2px solid var(--primary)';
        }

        // Add to cart form submission
        document.getElementById('add-to-cart-form')?.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const button = this.querySelector('button[type="submit"]');
            const spinner = button.querySelector('.spinner-border');
            const originalText = button.innerHTML;
            
            // Disable button and show spinner
            button.disabled = true;
            spinner.classList.remove('d-none');
            
            // Get form data
            const formData = new FormData(this);
            
            // Send AJAX request
            fetch(this.action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update cart count in header
                    const cartCountElements = document.querySelectorAll('#header-cart-count, #mobile-cart-count');
                    cartCountElements.forEach(el => {
                        el.textContent = data.cartCount;
                    });
                    
                    // Show success message
                    showToast('Item added to cart!', 'success');
                    
                    // Redirect to cart page after a short delay
                    setTimeout(() => {
                        window.location.href = data.redirect || '{{ route("cart.index") }}';
                    }, 800);
                } else {
                    showToast(data.message || 'Failed to add item to cart', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('An error occurred. Please try again.', 'error');
            })
            .finally(() => {
                // Re-enable button and hide spinner
                button.disabled = false;
                spinner.classList.add('d-none');
            });
        });
        
        // Show toast notification
        function showToast(message, type = 'info') {
            const toast = document.createElement('div');
            toast.className = `position-fixed bottom-0 end-0 m-3 toast align-items-center text-white bg-${type === 'success' ? 'success' : 'danger'} border-0`;
            toast.setAttribute('role', 'alert');
            toast.setAttribute('aria-live', 'assertive');
            toast.setAttribute('aria-atomic', 'true');
            
            toast.innerHTML = `
                <div class="d-flex">
                    <div class="toast-body">
                        ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            `;
            
            document.body.appendChild(toast);
            const bsToast = new bootstrap.Toast(toast);
            bsToast.show();
            
            // Remove toast after it's hidden
            toast.addEventListener('hidden.bs.toast', function () {
                toast.remove();
            });
        }
        
        // Add to cart animation for related products
        document.querySelectorAll('.add-to-cart-related').forEach(button => {
            button.addEventListener('click', function(e) {
                if (this.getAttribute('disabled')) {
                    e.preventDefault();
                    return false;
                }
                
                // Add animation class
                this.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Adding...';
                this.classList.add('disabled');
                
                // Submit the form after a short delay for better UX
                setTimeout(() => {
                    this.closest('form').submit();
                }, 500);
                el.style.transform = 'translateY(20px)';
                el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                observer.observe(el);
            });
        });
    </script>

    <!-- Lightbox HTML -->
    <div id="lightbox" class="lightbox" onclick="closeLightbox()">
        <span class="lightbox-close" onclick="closeLightbox()">&times;</span>
        <img id="lightboxImage" src="" alt="Product Image">
    </div>

    <script>
        // Lightbox functionality
        function openLightbox(imageSrc) {
            const lightbox = document.getElementById('lightbox');
            const lightboxImage = document.getElementById('lightboxImage');
            
            lightboxImage.src = imageSrc;
            lightbox.classList.add('active');
            document.body.style.overflow = 'hidden'; // Prevent scrolling when lightbox is open
        }

        function closeLightbox() {
            const lightbox = document.getElementById('lightbox');
            lightbox.classList.remove('active');
            document.body.style.overflow = 'auto'; // Restore scrolling
        }

        // Close lightbox on Escape key press
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeLightbox();
            }
        });

        // Update changeMainImage function to also update lightbox current image
        function changeMainImage(imageSrc, thumbnailElement) {
            const mainImage = document.getElementById('mainImage');
            mainImage.src = imageSrc;
            
            // Update active thumbnail
            document.querySelectorAll('.thumbnail').forEach(thumb => {
                thumb.classList.remove('active');
            });
            thumbnailElement.classList.add('active');
            
            // Update the onclick handler for the main image container
            const zoomContainer = document.querySelector('.image-zoom-container');
            if (zoomContainer) {
                zoomContainer.setAttribute('onclick', `openLightbox('${imageSrc}')`);
            }
        }
    </script>
@endpush
