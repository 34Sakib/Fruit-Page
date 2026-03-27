<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlist = session()->get('wishlist', []);
        $products = Product::whereIn('id', $wishlist)
            ->with('category')
            ->get();

        return view('frontend.wishlist.index', compact('products'));
    }

    public function add(Product $product)
    {
        $wishlist = session()->get('wishlist', []);
        
        if (!in_array($product->id, $wishlist)) {
            $wishlist[] = $product->id;
            session()->put('wishlist', $wishlist);
            
            return response()->json([
                'success' => true,
                'message' => 'Product added to wishlist',
                'count' => count($wishlist),
                'already_exists' => false
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Product added to wishlist',
            'count' => count($wishlist),
            'already_exists' => true
        ]);
    }

    public function remove(Request $request, Product $product)
    {
        $wishlist = session()->get('wishlist', []);
        $wishlist = array_diff($wishlist, [$product->id]);
        session()->put('wishlist', array_values($wishlist));
        $count = count($wishlist);
        
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Product removed from wishlist',
                'count' => $count
            ]);
        }
        
        return redirect()->back()->with([
            'alert' => [
                'type' => 'success',
                'title' => 'Success!',
                'message' => 'Product removed from wishlist',
                'count' => $count
            ]
        ]);
    }

    public function clear(Request $request)
    {
        session()->forget('wishlist');
        
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Wishlist cleared successfully',
                'count' => 0
            ]);
        }
        
        return redirect()->route('wishlist.index')->with([
            'alert' => [
                'type' => 'success',
                'title' => 'Success!',
                'message' => 'Your wishlist has been cleared',
                'count' => 0
            ]
        ]);
    }
}
