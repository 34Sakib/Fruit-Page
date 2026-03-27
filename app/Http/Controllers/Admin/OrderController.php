<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Mail\OrderConfirmation;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['items', 'user'])
            ->latest()
            ->paginate(15);
            
        return view('backend.orders.index', [
            'orders' => $orders,
            'title' => 'All Orders'
        ]);
    }

    public function pending()
    {
        $orders = Order::with(['items', 'user'])
            ->where('status', 'pending')
            ->latest()
            ->paginate(15);
            
        return view('backend.orders.index', [
            'orders' => $orders,
            'title' => 'Pending Orders'
        ]);
    }
    public function show(Order $order)
    {
        $order->load([
            'items' => function($query) {
                $query->with([
                    'product' => function($q) {
                        $q->withDefault([
                            'name' => 'Product Not Found',
                            'image' => null,
                            'image_url' => null
                        ]);
                    }
                ]);
            },
            'user'
        ]);

        // Add image URLs to each order item
        $order->items->each(function ($item) {
            // If item has its own image, use that
            if ($item->image) {
                $imagePath = 'storage/' . ltrim($item->image, '/');
                if (file_exists(public_path($imagePath))) {
                    $item->image_url = asset($imagePath);
                }
            } 
            // Otherwise, try to use the product's image
            elseif ($item->product && $item->product->image) {
                $imagePath = 'storage/' . ltrim($item->product->image, '/');
                if (file_exists(public_path($imagePath))) {
                    $item->image_url = asset($imagePath);
                }
            }
            
            // If no image URL was set, set a default
            if (!isset($item->image_url)) {
                $item->image_url = asset('images/placeholder.png');
            }
        });

        // Debug: Log the order items and their product relationships
        \Log::info('Order items with products and image URLs:', [
            'order_id' => $order->id,
            'items' => $order->items->map(function($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'image' => $item->image,
                    'image_url' => $item->image_url ?? null,
                    'product' => $item->product ? [
                        'id' => $item->product->id,
                        'name' => $item->product->name,
                        'image' => $item->product->image,
                        'image_url' => $item->product->image_url ?? null
                    ] : null
                ];
            })
        ]);
        
        return view('backend.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled,refunded',
            'notes' => 'nullable|string|max:500'
        ]);

        try {
            DB::beginTransaction();
            
            $oldStatus = $order->status;
            
            $order->update([
                'status' => $request->status,
                'notes' => $request->filled('notes') ? $request->notes : $order->notes
            ]);
            
            // Log the status change
            Log::info('Order status updated', [
                'order_id' => $order->id,
                'old_status' => $oldStatus,
                'new_status' => $request->status,
                'updated_by' => auth()->id()
            ]);
            
            // Send email notification if status changed
            if ($order->wasChanged('status')) {
                try {
                    // Load the order with items relationship
                    $order->load(['items', 'user']);
                    
                    // Determine which email to use
                    $email = $order->user->email ?? $order->email;
                    
                    if ($email) {
                        // Send status update email
                        Mail::to($email)
                            ->send(new \App\Mail\OrderConfirmation($order));
                            
                        Log::info('Order status update email sent', [
                            'order_id' => $order->id,
                            'email' => $email,
                            'new_status' => $request->status
                        ]);
                    } else {
                        Log::warning('No email found for order status update', [
                            'order_id' => $order->id,
                            'user_id' => $order->user_id,
                            'guest_email' => $order->email
                        ]);
                    }
                    
                } catch (\Exception $e) {
                    // Log the error but don't fail the status update
                    Log::error('Failed to send status update email', [
                        'order_id' => $order->id,
                        'email' => $email ?? 'No email found',
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                }
            }
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Order status updated successfully.',
                'order' => $order->fresh()
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating order status', [
                'order_id' => $order->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to update order status. Please try again.'
            ], 500);
        }
    }
}
