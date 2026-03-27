<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmation;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'process']);
    }
    
    public function index()
    {
        // Redirect to cart if empty
        if (Cart::isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty. Please add some products before checkout.');
        }

        // Get cart data
        $cartItems = Cart::getContent();
        $subtotal = Cart::getSubTotal();
        $total = Cart::getTotal();
        $tax = 0;
        $discount = 0;

        // Get tax and discount from conditions
        $conditions = Cart::getConditions();
        foreach ($conditions as $condition) {
            if ($condition->getType() === 'tax') {
                $tax = $condition->getCalculatedValue($subtotal);
            } elseif ($condition->getType() === 'discount') {
                $discount = $condition->getValue();
            }
        }

        // Get user data if authenticated
        $user = Auth::user();
        $userData = [];
        
        if ($user) {
            $userData = [
                'first_name' => $user->first_name ?? '',
                'last_name' => $user->last_name ?? '',
                'email' => $user->email,
                'phone' => $user->phone ?? '',
                'address' => $user->address ?? '',
                'city' => $user->city ?? '',
                'postal_code' => $user->postal_code ?? '',
            ];
        }

        return view('frontend.checkout.index', [
            'cartItems' => $cartItems,
            'subtotal' => $subtotal,
            'total' => $total,
            'tax' => $tax,
            'discount' => $discount,
            'itemCount' => $cartItems->count(),
            'userData' => $userData
        ]);
    }

    
    public function process(Request $request)
    {
        \Log::info('Checkout process started', ['request' => $request->all()]);
        
        // Validate the request
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:1000',
            'shipping_method' => 'required|string|in:inside_dhaka,outside_dhaka',
            'payment_method' => 'required|string|in:cod', // Only COD is enabled in the form
            'terms' => 'required|accepted',
        ]);
        
        // Log the validated data
        \Log::info('Form validation passed', [
            'validated' => $validated,
            'has_first_name' => isset($validated['first_name']),
            'has_last_name' => isset($validated['last_name']),
            'has_email' => isset($validated['email']),
            'has_phone' => isset($validated['phone']),
            'has_address' => isset($validated['address']),
            'has_city' => isset($validated['city']),
            'has_postal_code' => isset($validated['postal_code']),
            'has_country' => isset($validated['country']),
            'has_shipping_method' => isset($validated['shipping_method']),
            'has_payment_method' => isset($validated['payment_method']),
        ]);

        // Check if cart is empty
        if (Cart::isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty. Please add some products before checkout.');
        }

        // Calculate cart totals
        $cartItems = Cart::getContent();
        $subtotal = Cart::getSubTotal();
        $total = Cart::getTotal();
        $tax = 0;
        $discount = 0;
        // Calculate shipping cost based on the selected method
        $shippingCost = 0;
        if ($validated['shipping_method'] === 'outside_dhaka') {
            $shippingCost = 120; // Outside Dhaka
        } else {
            $shippingCost = 50; // Inside Dhaka
        }

        // Get tax and discount from conditions
        $conditions = Cart::getConditions();
        foreach ($conditions as $condition) {
            if ($condition->getType() === 'tax') {
                $tax = $condition->getCalculatedValue($subtotal);
            } elseif ($condition->getType() === 'discount') {
                $discount = $condition->getValue();
            }
        }

        // Calculate final total
        $grandTotal = $total + $shippingCost;

        // Start database transaction
        DB::beginTransaction();
        
        \Log::info('Starting database transaction');
        
        try {
            // Log the data that will be used to create the order
            $orderData = [
                'order_number' => Order::generateOrderNumber(),
                'user_id' => Auth::id(),
                'first_name' => $validated['first_name'] ?? null,
                'last_name' => $validated['last_name'] ?? null,
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                
                'subtotal' => $subtotal,
                'tax' => $tax,
                'discount' => $discount,
                'shipping_cost' => $shippingCost,
                'total' => $grandTotal,
                'payment_method' => $validated['payment_method'],
                'payment_status' => $validated['payment_method'] === 'cod' ? 'pending' : 'processing',
                'delivery_method' => $validated['shipping_method'] === 'outside_dhaka' ? 'Outside Dhaka' : 'Inside Dhaka',
                'delivery_status' => 'pending',
                'notes' => $validated['notes'] ?? null,
                'ip_address' => $request->ip(),
                'status' => 'pending',
            ];
            
            \Log::info('Creating order with data:', $orderData);
            
            // Validate required fields
            $requiredFields = ['first_name', 'last_name', 'email', 'phone', 'address'];
            $missingFields = [];
            foreach ($requiredFields as $field) {
                if (empty($orderData[$field])) {
                    $missingFields[] = $field;
                }
            }
            
            if (!empty($missingFields)) {
                throw new \Exception('Missing required fields: ' . implode(', ', $missingFields));
            }
            
            // Create the order using create() instead of new Order() to trigger mass assignment protection
            $order = Order::create($orderData);
            
            if (!$order) {
                throw new \Exception('Failed to create order');
            }
            
            \Log::info('Order created successfully', [
                'order_id' => $order->id,
                'order_number' => $order->order_number
            ]);
            
            \Log::info('Order saved successfully', ['order_id' => $order->id, 'order_number' => $order->order_number]);

            // Create order items
            \Log::info('Creating order items', ['cart_items_count' => count($cartItems)]);
            
            foreach ($cartItems as $item) {
                $orderItem = new OrderItem();
                $orderItem->order_id = $order->id;
                $orderItem->product_id = $item->associatedModel->id ?? null;
                $orderItem->name = $item->name;
                $orderItem->price = $item->price;
                $orderItem->quantity = $item->quantity;
                $orderItem->total = $item->getPriceSum();
                $orderItem->options = $item->attributes->toArray();
                
                // Save the product image if it exists
                if ($item->associatedModel) {
                    // Get the product with the image relationship
                    $product = Product::with('images')->find($item->associatedModel->id);
                    
                    if ($product && $product->images->isNotEmpty()) {
                        // Get the first image path
                        $orderItem->image = $product->images->first()->path;
                    } elseif ($product && $product->image) {
                        // Fallback to the old image field if no images relationship
                        $orderItem->image = $product->image;
                    }
                    
                    // Add product description and SKU
                    $orderItem->description = $product->description;
                    $orderItem->sku = $product->sku;
                }
                
                if (!$orderItem->save()) {
                    throw new \Exception('Failed to save order item: ' . json_encode($orderItem->getErrors()));
                }
                
                \Log::info('Order item saved', ['order_item_id' => $orderItem->id]);

                // Update product stock if needed
                if ($orderItem->product) {
                    $product = $orderItem->product;
                    $product->decrement('quantity', $item->quantity);
                    
                    // Update product popularity or sales count
                    $product->increment('sold_count', $item->quantity);
                    
                    \Log::info('Updated product stock and sales count', [
                        'product_id' => $product->id,
                        'quantity_reduced' => $item->quantity,
                        'new_quantity' => $product->quantity,
                        'sold_count_increased' => $item->quantity,
                        'new_sold_count' => $product->sold_count
                    ]);
                } else {
                    \Log::warning('Product not found for order item', [
                        'order_item_id' => $orderItem->id,
                        'product_id' => $orderItem->product_id
                    ]);
                }
            }

            // Commit the transaction
            DB::commit();

            // Clear the cart
            Cart::clear();

            // Send order confirmation email with error handling
            try {
                // Load the order with items relationship
                $order->load('items');
                
                // Send the email
                Mail::to($order->email)
                    ->send(new \App\Mail\OrderConfirmation($order));
                    
                \Log::info('Order confirmation email sent', [
                    'order_id' => $order->id,
                    'email' => $order->email
                ]);
                
            } catch (\Exception $e) {
                // Log the error but don't fail the order
                \Log::error('Failed to send order confirmation email', [
                    'order_id' => $order->id,
                    'email' => $order->email,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
            }

            // Store order number in session for the success page
            session(['order_placed' => $order->order_number]);
            
            // Redirect to success page with order details
            return redirect()->route('checkout.success', ['order' => $order->order_number])
                ->with('success', 'Your order #' . $order->order_number . ' has been placed successfully!');

        } catch (\Exception $e) {
            // Rollback the transaction on error
            DB::rollBack();
            \Log::error('Order processing error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);
            
            return redirect()->back()
                ->with('error', 'An error occurred while processing your order: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function success(Request $request)
    {
        $order = null;
        $orderNumber = $request->query('order');
        
        // If no order number in URL but we have a success message, try to get the last order
        if (!$orderNumber && session()->has('order_placed')) {
            $orderNumber = session('order_placed');
        }
        
        // If still no order number, redirect to home
        if (!$orderNumber) {
            return redirect()->route('home');
        }
        
        // Get order details
        $order = Order::where('order_number', $orderNumber)
            ->with(['items' => function($query) {
                $query->with('product');
            }])
            ->first();
            
        // If order not found but we have an order number, still show success page
        if (!$order) {
            return view('frontend.checkout.success', [
                'order' => null,
                'orderNumber' => $orderNumber
            ]);
        }
        
        // If user is logged in, verify order belongs to them
        if (Auth::check() && $order->user_id !== Auth::id()) {
            return redirect()->route('home')
                ->with('error', 'You are not authorized to view this order.');
        }

        // Clear the order from session
        session()->forget('order_placed');
        
        return view('frontend.checkout.success', [
            'order' => $order,
            'orderNumber' => $order->order_number
        ]);
    }
}
