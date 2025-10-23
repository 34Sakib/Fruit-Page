<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">Categories</h5>
    </div>
    <div class="card-body p-0">
        <div class="list-group list-group-flush">
            @foreach($categories as $category)
                <a href="{{ route('category.show', $category->slug) }}" 
                   class="list-group-item list-group-item-action d-flex justify-content-between align-items-center {{ request()->is('category/' . $category->slug) ? 'active' : '' }}">
                    <span>
                        <i class="fas {{ $category->icon ?? 'fa-folder' }} me-2"></i>
                        {{ $category->name }}
                    </span>
                    @if($category->children->count() > 0)
                        <i class="fas fa-chevron-right small"></i>
                    @endif
                </a>
                
                @if($category->children->count() > 0 && request()->is('category/' . $category->slug))
                    <div class="subcategories ps-4">
                        @foreach($category->children as $child)
                            <a href="{{ route('category.show', $child->slug) }}" 
                               class="list-group-item list-group-item-action py-2 ps-4 {{ request()->is('category/' . $child->slug) ? 'active' : '' }}">
                                <i class="fas {{ $child->icon ?? 'fa-angle-right' }} me-2"></i>
                                {{ $child->name }}
                            </a>
                        @endforeach
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</div>

<!-- Special Categories -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">Special Offers</h5>
    </div>
    <div class="card-body p-0">
        <div class="list-group list-group-flush">
            <a href="{{ route('special.page', 'organic') }}" class="list-group-item list-group-item-action">
                <i class="fas fa-leaf text-success me-2"></i>Organic Products
            </a>
            <a href="{{ route('special.page', 'seasonal') }}" class="list-group-item list-group-item-action">
                <i class="fas fa-calendar-alt text-info me-2"></i>Seasonal Fruits
            </a>
            <a href="{{ route('special.page', 'deals') }}" class="list-group-item list-group-item-action">
                <i class="fas fa-tag text-danger me-2"></i>Hot Deals
                <span class="badge bg-danger float-end">Sale!</span>
            </a>
        </div>
    </div>
</div>
