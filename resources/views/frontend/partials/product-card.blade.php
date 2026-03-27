<div class="product-card h-100">
    <div class="product-image-container">
        <a href="{{ route('product.details', $product->slug) }}" class="text-decoration-none">
            <img src="{{ $product->image_url }}" class="product-image" alt="{{ $product->name }}">
            @if($product->sale_price < $product->price)
                <div class="product-badge">
                    {{ round((($product->price - $product->sale_price) / $product->price) * 100) }}% OFF
                </div>
            @endif
                    </a>
        <button type="button" class="product-wishlist {{ in_array($product->id, session('wishlist', [])) ? 'active' : '' }}" 
                data-product-id="{{ $product->id }}" 
                data-wishlist-url="{{ route('wishlist.add', $product->id) }}"
                data-remove-wishlist-url="{{ route('wishlist.remove', $product->id) }}">
            <i class="{{ in_array($product->id, session('wishlist', [])) ? 'fas' : 'far' }} fa-heart"></i>
        </button>
        <a href="{{ route('product.details', $product->slug) }}" class="quick-view-btn text-decoration-none">
            <i class="fas fa-eye me-1"></i> Quick View
        </a>
    </div>
    <div class="product-card-body">
        <div class="product-features">
            @if($product->category)
                <span class="feature-tag organic-tag">{{ $product->category->name }}</span>
            @endif
            @if($product->is_top_product)
                <span class="feature-tag seasonal-tag">Top Product</span>
            @endif
        </div>
        <h5 class="product-title">
            <a href="{{ route('product.details', $product->slug) }}">{{ Str::limit($product->name, 40) }}</a>
        </h5>
        <div class="product-category">
            <i class="fas fa-tag"></i> {{ $product->category->name ?? 'Uncategorized' }}
        </div>
        
        @if($product->reviews_count > 0)
        <div class="product-rating">
            <div class="rating-stars">
                @php
                    $rating = round($product->reviews_avg_rating);
                    $emptyStars = 5 - $rating;
                @endphp
                @for($i = 0; $i < $rating; $i++)
                    <i class="fas fa-star"></i>
                @endfor
                @for($i = 0; $i < $emptyStars; $i++)
                    <i class="far fa-star"></i>
                @endfor
            </div>
            <span class="rating-count">({{ $product->reviews_count }})</span>
        </div>
        @endif
        
        <div class="product-price">
            @if($product->sale_price < $product->price)
                <span class="current-price">${{ number_format($product->sale_price, 2) }}</span>
                <del class="original-price">${{ number_format($product->price, 2) }}</del>
                <div class="price-saving">
                    Save ${{ number_format($product->price - $product->sale_price, 2) }}
                </div>
            @else
                <span class="current-price">${{ number_format($product->price, 2) }}</span>
            @endif
        </div>
        
        <div class="stock-status {{ $product->quantity > 0 ? 'in-stock' : 'out-of-stock' }}">
            <i class="fas {{ $product->quantity > 0 ? 'fa-check-circle' : 'fa-times-circle' }} me-1"></i>
            {{ $product->quantity > 0 ? 'In Stock' : 'Out of Stock' }}
            @if($product->quantity > 0)
                ({{ $product->quantity }} available)
            @endif
        </div>
        
        @if($product->quantity > 0)
        <form class="product-actions add-to-cart-form" data-product-id="{{ $product->id }}">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="quantity" value="1">
            <button type="submit" class="add-to-cart-btn" data-id="{{ $product->id }}">
                <span class="add-to-cart-text">
                    <i class="fas fa-shopping-cart"></i> Add to Cart
                </span>
                <span class="view-cart-text">
                    <i class="fas fa-check"></i> View Cart
                </span>
            </button>
        </form>
        @else
        <div class="product-actions">
            <button class="add-to-cart-btn" disabled>
                <i class="fas fa-times"></i> Out of Stock
            </button>
        </div>
        @endif
    </div>
</div>
