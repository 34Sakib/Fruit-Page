<div class="row">
    @forelse($products as $product)
    <div class="col-md-4 col-sm-6 mb-4">
        <div class="product-card h-100">
            <div class="product-image position-relative">
                <img src="{{ $product->image_url ?? 'https://via.placeholder.com/300' }}" class="img-fluid" alt="{{ $product->name }}">
                <div class="product-actions">
                    <a href="#" class="add-to-wishlist" title="Add to Wishlist">
                        <i class="far fa-heart"></i>
                    </a>
                    <a href="#" class="add-to-cart" title="Add to Cart">
                        <i class="fas fa-shopping-cart"></i>
                    </a>
                    <a href="#" class="quick-view" title="Quick View">
                        <i class="fas fa-search"></i>
                    </a>
                </div>
            </div>
            <div class="product-info p-3">
                <div class="product-category text-muted small mb-1">{{ $product->category->name ?? 'Fruits' }}</div>
                <h5 class="product-title mb-2">
                    <a href="{{ route('product.details', $product->id) }}">{{ $product->name }}</a>
                </h5>
                <div class="product-price mb-2">
                    <span class="current-price">${{ number_format($product->price, 2) }}</span>
                    @if($product->compare_price > $product->price)
                        <span class="original-price">${{ number_format($product->compare_price, 2) }}</span>
                    @endif
                </div>
                <div class="product-rating mb-2">
                    @for($i = 1; $i <= 5; $i++)
                        <i class="fas fa-star {{ $i <= ($product->rating ?? 0) ? 'text-warning' : 'text-muted' }}"></i>
                    @endfor
                    <span class="small text-muted">({{ $product->reviews_count ?? 0 }})</span>
                </div>
                <button class="btn btn-primary w-100 add-to-cart-btn">
                    <i class="fas fa-shopping-cart me-2"></i>Add to Cart
                </button>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center py-5">
        <div class="alert alert-info">No products found matching your criteria.</div>
    </div>
    @endforelse
</div>
