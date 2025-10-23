<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index() {
        $categories = $this->getActiveCategories();
        $featuredProducts = $this->getFeaturedProducts(8);
        $seasonalProducts = $this->getSeasonalProducts(4);

        return view('home', compact('categories', 'featuredProducts', 'seasonalProducts'));
    }

    public function category($slug, Request $request) {
        $category = Category::where('slug', $slug)->where('status', 'active')->firstOrFail();
        
        $query = Product::where('status', 'active')
            ->whereHas('category', function($q) use ($category) {
                $q->where('id', $category->id);
            });

        $products = $this->applyFilters($query, $request);
        $categories = $this->getActiveCategories();

        return view('frontend.category', compact('category', 'products', 'categories'));
    }

    public function specialPage($type, Request $request) {
        $title = ucfirst($type);
        $query = Product::where('status', 'active');

        switch(strtolower($type)) {
            case 'organic':
                $query->whereHas('category', function($q) {
                    $q->where('name', 'like', '%organic%');
                });
                break;
            case 'seasonal':
                $query->where('is_seasonal', true);
                break;
            case 'deals':
                $query->whereColumn('sale_price', '<', 'price')
                      ->where('sale_price', '>', 0);
                break;
            case 'fruits':
                $query->whereHas('category', function($q) {
                    $q->where('name', 'like', '%fruit%');
                });
                break;
            case 'vegetables':
                $query->whereHas('category', function($q) {
                    $q->where('name', 'like', '%vegetable%');
                });
                break;
            default:
                abort(404);
        }

        $products = $this->applyFilters($query, $request);
        $categories = $this->getActiveCategories();

        return view('frontend.special-category', compact('title', 'products', 'categories'));
    }

    private function getActiveCategories()
    {
        return Category::where('status', 'active')
            ->whereNull('parent_id')
            ->with(['children' => function($query) {
                $query->where('status', 'active')->orderBy('order', 'asc');
            }])
            ->with('children.children')
            ->orderBy('order', 'asc')
            ->get();
    }

    private function getFeaturedProducts($limit = 8) {
        return Product::with('category')
            ->where('status', 'active')
            ->where('is_featured', true)
            ->inRandomOrder()
            ->take($limit)
            ->get();
    }

    private function getSeasonalProducts($limit = 4) {
        return Product::with('category')
            ->where('status', 'active')
            ->where('is_seasonal', true)
            ->inRandomOrder()
            ->take($limit)
            ->get();
    }
    private function applyFilters($query, $request) {
        // Apply price filter if min_price and max_price are present
        if ($request->has('min_price') && $request->has('max_price')) {
            $query->whereBetween('price', [
                $request->min_price,
                $request->max_price
            ]);
        }
        
        // Apply sorting
        switch ($request->get('sort_by')) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'newest':
                $query->latest();
                break;
            case 'rating':
                $query->orderBy('rating', 'desc');
                break;
            default:
                $query->latest();
        }
        
        return $query->paginate(12);
    }
    public function productDetails($id) {
        $product = Product::findOrFail($id);
        return view('frontend.product.details', compact('product'));
    }
    public function vegetables() {
        return view('frontend.Vegetables.vegetables');
    }
    public function organic() {
        return view('frontend.organic.organic');
    }
    public function seasonal() {
        return view('frontend.seasonal.seasonal');
    }
    public function deals() {
        return view('frontend.deals.deals');
    }
}
