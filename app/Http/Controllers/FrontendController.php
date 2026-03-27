<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Review;
use App\Models\Contact;
use App\Models\Footer;
use App\Models\AboutUs;
use App\Models\TeamMember;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;
use Illuminate\Support\Facades\Log;

class FrontendController extends Controller
{
    public function index() {
        $categories = $this->getActiveCategories();
        $featuredProducts = $this->getFeaturedProducts(8);
        $topProducts = $this->getTopProducts(4);

        return view('home', compact('categories', 'featuredProducts', 'topProducts'));
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
        
        // Start building the query
        $query = Product::query()->where('status', 'active');

        // Apply category-specific filters
        switch(strtolower($type)) {
            case 'organic':
                $query->whereHas('category', function($q) {
                    $q->where('name', 'like', '%organic%');
                });
                break;
            case 'top':
                $query->where('is_top_product', true);
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

        // Apply filters from the request
        $products = $this->applyFilters($query, $request);
        
        // Get categories for the sidebar
        $categories = $this->getActiveCategories();
        
        // If it's an AJAX request, return only the products HTML
        if ($request->ajax() || $request->wantsJson()) {
            $view = view('frontend.partials.products-grid', [
                'products' => $products,
                'title' => $title
            ])->render();
            
            $pagination = view('pagination::bootstrap-4', [
                'paginator' => $products,
                'elements' => $products->appends(request()->query())->links()->elements
            ])->render();
            
            return response()->json([
                'html' => $view,
                'pagination' => $pagination,
                'count' => $products->total()
            ]);
        }

        // For regular requests, return the full view
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

    private function getTopProducts($limit = 4) {
        return Product::topProducts()
            ->take($limit)
            ->get();
    }

    public function productDetails($slug) {
        $product = Product::with(['category', 'reviews.user'])
            ->where('slug', $slug)
            ->where('status', 'active')
            ->firstOrFail();

        // Get related products (products from the same category)
        $relatedProducts = Product::with('category')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', 'active')
            ->inRandomOrder()
            ->take(4)
            ->get();

        // Calculate average rating
        $averageRating = $product->reviews->avg('rating');
        $totalReviews = $product->reviews->count();

        // Get approved reviews with user info
        $approvedReviews = $product->reviews()
            ->where('is_approved', true)
            ->with('user')
            ->latest()
            ->get();

        return view('frontend.products.details', compact(
            'product', 
            'relatedProducts', 
            'averageRating', 
            'totalReviews',
            'approvedReviews'
        ));
    }

    /**
     * Store a new review for a product.
     */
    public function storeReview(Request $request, Product $product)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:1000',
        ]);

        // Check if user has already reviewed this product
        $existingReview = Review::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->first();

        if ($existingReview) {
            return redirect()->back()
                ->with('error', 'You have already reviewed this product.');
        }

        $review = new Review();
        $review->product_id = $product->id;
        $review->user_id = auth()->id();
        $review->name = auth()->user()->name;
        $review->email = auth()->user()->email;
        $review->rating = $request->rating;
        $review->comment = $request->comment;
        $review->is_approved = false; // Set to false for admin approval
        $review->save();

        return redirect()->back()
            ->with('success', 'Thank you for your review! It will be visible after approval.');
    }

    /**
     * Delete a review.
     */
    public function deleteReview(Review $review)
    {
        // Check if the authenticated user is the owner of the review or an admin
        if (auth()->id() !== $review->user_id && auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $review->delete();

        return redirect()->back()
            ->with('success', 'Review deleted successfully.');
    }

    private function applyFilters($query, $request) {
        // Apply price filter if min_price and max_price are present
        if ($request->has('min_price') && is_numeric($request->min_price)) {
            $query->where('price', '>=', (float)$request->min_price);
        }
        
        if ($request->has('max_price') && is_numeric($request->max_price)) {
            $query->where('price', '<=', (float)$request->max_price);
        }
        
        // Apply availability filter
        if ($request->has('availability') && $request->availability === 'in_stock') {
            // Check if the stock_quantity column exists before applying the filter
            $table = $query->getModel()->getTable();
            $columns = \Schema::getColumnListing($table);
            
            if (in_array('stock_quantity', $columns)) {
                $query->where('stock_quantity', '>', 0);
            } elseif (in_array('quantity', $columns)) {
                // Fallback to 'quantity' column if 'stock_quantity' doesn't exist
                $query->where('quantity', '>', 0);
            }
            // If neither column exists, skip the filter to avoid errors
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
                // Check if the reviews relationship exists
                if (method_exists($query->getModel(), 'reviews')) {
                    $query->withAvg('reviews', 'rating')
                          ->orderBy('reviews_avg_rating', 'desc');
                } else {
                    $query->latest();
                }
                break;
            default:
                $query->latest();
        }
        
        // Log the generated SQL for debugging
        // \Log::debug('Generated SQL: ' . $query->toSql());
        // \Log::debug('Bindings: ', $query->getBindings());
        
        // Get the page from the request
        $page = $request->input('page', 1);
        
        // Return paginated results with error handling
        try {
            return $query->paginate(12, ['*'], 'page', $page);
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Error in applyFilters: ' . $e->getMessage());
            
            // Return empty results in case of error to prevent 500
            return $query->paginate(12, ['*'], 'page', $page)->setCollection(collect([]));
        }
    }

    public function contact()
    {
        $footer = \App\Models\Footer::where('status', true)->first();
        $contactInfo = \App\Models\ContactInfo::getActive();
        $faqs = \App\Models\Faq::getActiveOrdered();
        
        return view('frontend.contact us.index', compact('footer', 'contactInfo', 'faqs'));
    }

    public function about()
    {
        $footer = \App\Models\Footer::where('status', true)->first();
        $aboutContent = AboutUs::getContent();
        $teamMembers = TeamMember::active()->ordered()->get();
        
        return view('frontend.about us.index', compact('footer', 'aboutContent', 'teamMembers'));
    }

    public function privacyPolicy()
    {
        $footer = \App\Models\Footer::where('status', true)->first();
        $privacyPolicy = \App\Models\PrivacyPolicy::where('is_active', true)->first();
        
        return view('frontend.privacy-policy', compact('footer', 'privacyPolicy'));
    }

    public function termsConditions()
    {
        $footer = \App\Models\Footer::where('status', true)->first();
        $termsConditions = \App\Models\TermsConditions::where('is_active', true)->first();
        
        return view('frontend.terms-conditions', compact('footer', 'termsConditions'));
    }

    public function shippingPolicy()
    {
        $footer = \App\Models\Footer::where('status', true)->first();
        $shippingPolicy = \App\Models\ShippingPolicy::where('is_active', true)->first();
        
        return view('frontend.shipping-policy', compact('footer', 'shippingPolicy'));
    }

    public function returnPolicy()
    {
        $footer = \App\Models\Footer::where('status', true)->first();
        $returnPolicy = \App\Models\ReturnPolicy::where('is_active', true)->first();

        return view('frontend.return-policy', compact('footer', 'returnPolicy'));
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
    
    /**
     * Live search functionality
     */
    public function liveSearch(Request $request) {
        $query = $request->get('q');
        
        if (empty($query) || strlen($query) < 1) {
            // If AJAX request, return JSON
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['products' => []]);
            }
            // For regular requests, redirect back with error
            return redirect()->back()->with('error', 'Please enter at least 1 character to search.');
        }
        
        // Split query into words for 2-word matching
        $words = preg_split('/\s+/', trim($query));
        $wordCount = count($words);
        
        $productsQuery = Product::where('status', 'active')
            ->where(function($q) use ($query, $words, $wordCount) {
                if ($wordCount >= 2) {
                    // Match if any 2 words from the query appear in product name or category
                    for ($i = 0; $i < $wordCount - 1; $i++) {
                        $wordPair = $words[$i] . ' ' . $words[$i + 1];
                        $q->orWhere('name', 'LIKE', '%' . $wordPair . '%');
                    }
                    
                    // Also check individual words
                    foreach ($words as $word) {
                        $q->orWhere('name', 'LIKE', '%' . $word . '%');
                    }
                } else {
                    // Single word search
                    $q->where('name', 'LIKE', '%' . $query . '%');
                }
                
                // Always search in description and category
                $q->orWhere('description', 'LIKE', '%' . $query . '%')
                  ->orWhereHas('category', function($categoryQuery) use ($query) {
                      $categoryQuery->where('name', 'LIKE', '%' . $query . '%');
                  });
            })
            ->with('category');
        
        // If AJAX request, return limited results as JSON
        if ($request->ajax() || $request->wantsJson()) {
            $products = $productsQuery->limit(10)->get();
            
            $results = $products->map(function($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'price' => $product->price,
                    'sale_price' => $product->sale_price,
                    'image_url' => $product->primary_image_url,
                    'category' => $product->category ? $product->category->name : 'General',
                    'url' => route('product.details', $product->slug)
                ];
            });
            
            return response()->json([
                'products' => $results,
                'query' => $query
            ]);
        }
        
        // For regular requests, paginate and return view
        $products = $productsQuery->paginate(12);
        $categories = $this->getActiveCategories();
        
        return view('frontend.search-results', compact('products', 'categories', 'query'));
    }
}
