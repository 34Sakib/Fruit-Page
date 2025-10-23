@extends('frontend.layouts.master')

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Sidebar with categories -->
        <div class="col-lg-3">
            @include('frontend.partials.category-sidebar', ['categories' => $categories])
            
            <!-- Filters -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Filters</h5>
                </div>
                <div class="card-body">
                    <form id="filter-form">
                        <div class="mb-3">
                            <label class="form-label">Price Range</label>
                            <div class="d-flex align-items-center">
                                <input type="number" class="form-control form-control-sm" name="min_price" placeholder="Min" id="min-price">
                                <span class="mx-2">-</span>
                                <input type="number" class="form-control form-control-sm" name="max_price" placeholder="Max" id="max-price">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Sort By</label>
                            <select class="form-select form-select-sm" name="sort_by" id="sort-by">
                                <option value="">Default</option>
                                <option value="price_asc">Price: Low to High</option>
                                <option value="price_desc">Price: High to Low</option>
                                <option value="newest">Newest First</option>
                                <option value="rating">Top Rated</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm w-100">Apply Filters</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h4 mb-0">{{ $category->name }}</h1>
                <div class="text-muted">{{ $products->total() }} items found</div>
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
<script>
$(document).ready(function() {
    // Handle filter form submission
    $('#filter-form').on('submit', function(e) {
        e.preventDefault();
        loadProducts();
    });

    // Handle pagination
    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        loadProducts(page);
    });

    function loadProducts(page) {
        var url = '{{ url()->current() }}' + '?' + $('#filter-form').serialize();
        if (page) {
            url += '&page=' + page;
        }

        $.ajax({
            url: url,
            type: 'GET',
            success: function(data) {
                $('#product-container').html($(data).find('#product-container').html());
                $('.pagination').html($(data).find('.pagination').html());
                window.scrollTo(0, 0);
            }
        });
    }
});
</script>
@endpush
@endsection
