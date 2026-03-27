<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\Response;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the orders.
     */
    public function index(): View
    {
        $orders = Auth::user()->orders()
            ->with(['items.product', 'shippingAddress', 'billingAddress'])
            ->latest()
            ->paginate(10);

        return view('frontend.orders.index', compact('orders'));
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order): View
    {
        $this->authorize('view', $order);
        
        $order->load(['items.product', 'shippingAddress', 'billingAddress', 'statusUpdates']);
        
        return view('frontend.orders.show', compact('order'));
    }

    /**
     * Track an order.
     */
    public function track(Order $order): View
    {
        $this->authorize('view', $order);
        
        $order->load(['statusUpdates' => function($query) {
            $query->latest();
        }]);
        
        return view('frontend.orders.track', compact('order'));
    }

    /**
     * Cancel an order.
     */
    public function cancel(Request $request, Order $order)
    {
        $this->authorize('cancel', $order);
        
        // Store the previous status before updating
        $previousStatus = $order->status;
        
        $order->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
            'cancellation_reason' => $request->reason === 'other' 
                ? $request->other_reason 
                : $request->reason,
        ]);
        
        // Add status update with previous status
        $order->statusUpdates()->create([
            'user_id' => auth()->id(),
            'previous_status' => $previousStatus,
            'new_status' => 'cancelled',
            'notes' => $request->reason === 'other' 
                ? 'Order was cancelled by customer. Reason: ' . $request->other_reason
                : 'Order was cancelled by customer. Reason: ' . $request->reason,
        ]);
        
        // TODO: Send cancellation email
        
        return redirect()->route('orders.show', $order)
            ->with('success', 'Your order has been cancelled successfully.');
    }

    /**
     * Generate order invoice PDF.
     */
    public function invoice(Order $order)
    {
        $this->authorize('view', $order);
        
        $order->load(['items.product', 'shippingAddress', 'billingAddress']);
        
        $pdf = PDF::loadView('frontend.orders.invoice', compact('order'));
        
        return $pdf->download("invoice-{$order->order_number}.pdf");
    }

    /**
     * Handle return request.
     */
    /**
     * Handle return request.
     */
    public function returnOrder(Request $request, Order $order)
    {
        $this->authorize('update', $order);
        
        if ($order->status !== 'completed') {
            return back()->with('error', 'Only completed orders can be returned.');
        }
        
        if ($order->return_requested_at) {
            return back()->with('error', 'A return has already been requested for this order.');
        }
        
        $validated = $request->validate([
            'items' => 'required|array',
            'items.*' => 'exists:order_items,id,order_id,' . $order->id,
            'reason' => 'required|string|max:255',
            'notes' => 'nullable|string|max:1000',
        ]);
        
        // Create return request
        $order->update([
            'return_requested_at' => now(),
            'return_reason' => $validated['reason'],
            'return_notes' => $validated['notes'] ?? null,
        ]);
        
        // Update order items with return status
        $order->items()->whereIn('id', array_keys($validated['items']))
            ->update(['return_requested' => true]);
        
        // Add status update
        $order->statusUpdates()->create([
            'status' => 'return_requested',
            'notes' => 'Return requested by customer',
        ]);
        
        // TODO: Send return request email
        
        return redirect()->route('orders.show', $order)
            ->with('success', 'Your return request has been submitted. We will contact you shortly.');
    }

    /**
     * Show the contact support page.
     */
    public function support(Request $request)
    {
        $orderNumber = $request->query('order');
        
        if ($orderNumber) {
            $order = Order::where('order_number', $orderNumber)
                ->where('user_id', auth()->id())
                ->first();
        }

        return view('frontend.orders.support', [
            'order' => $order ?? null
        ]);
    }
}
