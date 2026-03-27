@if($products->count() > 0)
    <div class="row">
        @foreach($products as $product)
            <div class="col-md-4 col-6 mb-4">
                @include('frontend.partials.product-card', ['product' => $product])
            </div>
        @endforeach
    </div>
@else
    <div class="col-12">
        <div class="alert alert-info">No products found matching your criteria.</div>
    </div>
@endif
