<!-- Categories Section -->
<div class="sidebar-card">
    <div class="card-header-custom">
        <h5>
            <i class="fas fa-list-ul"></i>Product Categories
        </h5>
    </div>
    <div class="card-body p-0">
        <div class="list-group list-group-flush">
            @foreach($categories as $category)
                @php
                    // Generate unique class and icon based on category name
                    $categoryClass = '';
                    $categoryIcon = 'fa-folder';
                    $categoryName = strtolower($category->name);
                    
                    // Set category-specific styling
                    if (str_contains($categoryName, 'fruit') || str_contains($categoryName, 'apple') || str_contains($categoryName, 'orange')) {
                        $categoryClass = 'fruit-category';
                        $categoryIcon = 'fa-apple-alt';
                    } elseif (str_contains($categoryName, 'vegetable') || str_contains($categoryName, 'carrot') || str_contains($categoryName, 'tomato')) {
                        $categoryClass = 'vegetable-category';
                        $categoryIcon = 'fa-carrot';
                    } elseif (str_contains($categoryName, 'organic') || str_contains($categoryName, 'natural')) {
                        $categoryClass = 'organic-category';
                        $categoryIcon = 'fa-leaf';
                    } elseif (str_contains($categoryName, 'drink') || str_contains($categoryName, 'juice') || str_contains($categoryName, 'beverage')) {
                        $categoryClass = 'drink-category';
                        $categoryIcon = 'fa-wine-bottle';
                    } elseif (str_contains($categoryName, 'berry') || str_contains($categoryName, 'grape') || str_contains($categoryName, 'cherry')) {
                        $categoryClass = 'berry-category';
                        $categoryIcon = 'fa-wine-berries';
                    } else {
                        $categoryClass = 'default-category';
                        $categoryIcon = 'fa-shopping-basket';
                    }
                @endphp
                
                <a href="{{ route('category.show', $category->slug) }}" 
                   class="list-group-item category-item {{ $categoryClass }} {{ request()->is('category/' . $category->slug) ? 'active' : '' }}">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="icon-wrapper rounded-circle me-3 {{ $categoryClass }}-bg">
                                <i class="fas {{ $categoryIcon }} {{ $categoryClass }}-icon"></i>
                            </div>
                            <span class="category-name">{{ $category->name }}</span>
                        </div>
                        @if($category->products_count > 0)
                            <span class="category-count">{{ $category->products_count }}</span>
                        @endif
                    </div>
                </a>
                
                @if($category->children->count() > 0 && request()->is('category/' . $category->slug))
                    <div class="subcategories">
                        @foreach($category->children as $child)
                            @php
                                // Generate subcategory icon based on parent category
                                $subcategoryIcon = 'fa-circle';
                                if (str_contains(strtolower($child->name), 'organic') || str_contains(strtolower($child->name), 'fresh')) {
                                    $subcategoryIcon = 'fa-leaf';
                                } elseif (str_contains(strtolower($child->name), 'import') || str_contains(strtolower($child->name), 'exotic')) {
                                    $subcategoryIcon = 'fa-globe-americas';
                                } elseif (str_contains(strtolower($child->name), 'tropical')) {
                                    $subcategoryIcon = 'fa-umbrella-beach';
                                } elseif (str_contains(strtolower($child->name), 'local') || str_contains(strtolower($child->name), 'seasonal')) {
                                    $subcategoryIcon = 'fa-home';
                                }
                            @endphp
                            <a href="{{ route('category.show', $child->slug) }}" 
                               class="list-group-item subcategory-item {{ request()->is('category/' . $child->slug) ? 'active' : '' }}">
                                <i class="fas {{ $subcategoryIcon }} me-2" style="font-size: 0.8em;"></i>
                                {{ $child->name }}
                            </a>
                        @endforeach
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</div>

<!-- Special Offers Section -->
<div class="sidebar-card special-offers-card">
    <div class="card-header-custom">
        <h5>
            <i class="fas fa-star"></i>Special Offers
        </h5>
    </div>
    <div class="card-body p-0">
        <div class="list-group list-group-flush">
            <!-- Organic Products Offer -->
            <a href="{{ route('special.page', 'organic') }}" class="list-group-item offer-item organic-offer">
                <div class="d-flex align-items-center">
                    <div class="offer-icon-wrapper me-3">
                        <i class="fas fa-leaf fa-lg"></i>
                    </div>
                    <div class="offer-content">
                        <div class="offer-title">Organic Products</div>
                        <div class="offer-description">Fresh from the farm</div>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="offer-badge me-2">New</span>
                        <i class="fas fa-chevron-right offer-arrow"></i>
                    </div>
                </div>
            </a>
            
            <!-- Seasonal Fruits Offer -->
            <a href="{{ route('special.page', 'seasonal') }}" class="list-group-item offer-item seasonal-offer">
                <div class="d-flex align-items-center">
                    <div class="offer-icon-wrapper me-3">
                        <i class="fas fa-calendar-alt fa-lg"></i>
                    </div>
                    <div class="offer-content">
                        <div class="offer-title">Seasonal Fruits</div>
                        <div class="offer-description">Best of the season</div>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="offer-badge me-2">Limited</span>
                        <i class="fas fa-chevron-right offer-arrow"></i>
                    </div>
                </div>
            </a>
            
            <!-- Hot Deals Offer -->
            <a href="{{ route('special.page', 'deals') }}" class="list-group-item offer-item deals-offer">
                <div class="d-flex align-items-center">
                    <div class="offer-icon-wrapper me-3">
                        <i class="fas fa-tag fa-lg"></i>
                    </div>
                    <div class="offer-content">
                        <div class="offer-title">Hot Deals</div>
                        <div class="offer-description">Limited time offers</div>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="offer-badge me-2">Sale!</span>
                        <i class="fas fa-chevron-right offer-arrow"></i>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
