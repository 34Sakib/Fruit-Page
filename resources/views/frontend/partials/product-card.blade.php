<div class="product-card">
    @if($product->sale_price < $product->price)
        <div class="position-absolute top-0 end-0 m-2">
            <span class="badge bg-danger">
                {{ round((($product->price - $product->sale_price) / $product->price) * 100) }}% OFF
            </span>
        </div>
    @endif
    <div class="product-image">
        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="img-fluid">
    </div>
    <div class="product-info p-3">
        <h5 class="product-title mb-1">{{ $product->name }}</h5>
        <div class="text-muted small mb-2">{{ $product->category->name }}</div>
        <div class="product-price d-flex align-items-center justify-content-between">
            <div>
                @if($product->sale_price < $product->price)
                    <span class="text-danger fw-bold">${{ number_format($product->sale_price, 2) }}</span>
                    <del class="text-muted small ms-2">${{ number_format($product->price, 2) }}</del>
                @else
                    <span class="fw-bold">${{ number_format($product->price, 2) }}</span>
                @endif
            </div>
            <button class="btn btn-sm btn-outline-primary">
                <i class="fas fa-cart-plus"></i>
            </button>
        </div>
    </div>
</div>
