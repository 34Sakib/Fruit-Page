<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function index()
    {
        // Get cart content
        $cartItems = Cart::getContent();
        
        // If cart is empty, just return the view with empty cart
        if (Cart::isEmpty()) {
            return view('frontend.cart.index', compact('cartItems'));
        }
        
        // Get product details for all items in cart
        $productIds = $cartItems->pluck('id')->toArray();
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');
        
        // Add product details to each cart item
        $cartItems->each(function ($item) use ($products) {
            $item->product = $products->get($item->id);
        });
        
        // Calculate totals
        $subtotal = Cart::getSubTotal();
        $total = Cart::getTotal();
        
        return view('frontend.cart.index', compact(
            'cartItems', 
            'subtotal', 
            'total'
        ));
    }

    public function store(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        
        // Check if product is in stock
        if ($product->quantity < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, there are only ' . $product->quantity . ' items in stock.'
            ], 400);
        }
        
        // Check if product already in cart
        $cartItem = Cart::get($product->id);
        
        if ($cartItem) {
            // Check if adding more than available
            if (($cartItem->quantity + $request->quantity) > $product->quantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'You already have ' . $cartItem->quantity . ' in your cart. Only ' . ($product->quantity - $cartItem->quantity) . ' more available.'
                ], 400);
            }
            
            // Update quantity if already in cart
            Cart::update($product->id, [
                'quantity' => [
                    'relative' => true,
                    'value' => $request->quantity
                ]
            ]);
        } else {
            // Add new item to cart
            Cart::add([
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->sale_price ?? $product->price,
                'quantity' => $request->quantity,
                'attributes' => [
                    'image' => $product->image_url,
                    'slug' => $product->slug
                ]
            ]);
        }
        
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Item added to cart!',
                'cartCount' => Cart::getTotalQuantity(),
                'redirect' => route('cart.index')
            ]);
        }
        
        return redirect()->route('cart.index')
            ->with('success', 'Item added to cart!');
    }

    
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|numeric|min:1'
        ]);

        if ($validator->fails()) {
            return response([
                'success' => false,
                'message' => 'Invalid quantity.',
                'errors' => $validator->errors()
            ], 400);
        }
        
        $product = Product::find($id);
        
        if (!$product) {
            return response([
                'success' => false,
                'message' => 'Product not found.'
            ], 404);
        }
        
        // Check if product is in stock
        if ($product->quantity < $request->quantity) {
            return response([
                'success' => false,
                'message' => 'Only ' . $product->quantity . ' items available in stock.'
            ], 400);
        }
        
        // Update cart
        Cart::update($id, [
            'quantity' => [
                'relative' => false,
                'value' => $request->quantity
            ]
        ]);
        
        return response([
            'success' => true,
            'message' => 'Cart updated successfully',
            'cart' => [
                'subtotal' => number_format(Cart::getSubTotal(), 2),
                'total' => number_format(Cart::getTotal(), 2),
                'count' => Cart::getTotalQuantity()
            ]
        ]);
    }

    public function destroy(Request $request, $id)
    {
        Cart::remove($id);
        
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Item removed from cart',
                'cart' => [
                    'subtotal' => number_format(Cart::getSubTotal(), 2),
                    'total' => number_format(Cart::getTotal(), 2),
                    'count' => Cart::getTotalQuantity()
                ]
            ]);
        }
        
        return redirect()->back()->with('success', 'Item removed from cart');
    }

    public function clear(Request $request)
    {
        Cart::clear();
        
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Cart cleared successfully',
                'cart' => [
                    'count' => Cart::getTotalQuantity(),
                    'subtotal' => number_format(Cart::getSubTotal(), 2),
                    'total' => number_format(Cart::getTotal(), 2)
                ]
            ]);
        }
        
        return redirect()->route('cart.index')
            ->with('success', 'Cart cleared successfully');
    }
}
