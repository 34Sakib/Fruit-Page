<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SpecialOrder;
use App\Models\Category;
use App\Models\Product;
use App\Models\CourierService;

class SpecialOrderController extends Controller
{
    public function create()
    {
        $categories = Category::where('status', 'active')->get();
        return view('frontend.special-order.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'product_id' => 'nullable|exists:products,id',
            'product_name' => 'nullable|string|max:255',
            'notes' => 'required|string|max:2000',
            'is_inside_dhaka' => 'required|boolean',
        ]);

        $data = $request->all();
        $data['order_number'] = SpecialOrder::generateOrderNumber();
        $data['delivery_charge'] = $request->is_inside_dhaka ? 50 : 120;

        SpecialOrder::create($data);

        return redirect()->route('special-order.create')
            ->with('success', 'Your special order has been submitted successfully! We will contact you soon.');
    }

    public function index(Request $request)
    {
        $specialOrders = SpecialOrder::with(['category', 'product', 'courierService'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.special-orders.index', compact('specialOrders'));
    }

    public function show(SpecialOrder $specialOrder)
    {
        $specialOrder->load(['category', 'product', 'courierService']);
        $courierServices = CourierService::active()->get();
        return view('admin.special-orders.show', compact('specialOrder', 'courierServices'));
    }

    public function updateStatus(Request $request, SpecialOrder $specialOrder)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected,processing,completed',
        ]);

        $specialOrder->update(['status' => $request->status]);

        // If order is approved and doesn't have final price or quantity, require it
        if ($request->status === 'approved' && (!$specialOrder->final_price || !$specialOrder->quantity)) {
            return redirect()->back()
                ->with('error', 'Please set both final price and quantity before approving the order.');
        }

        // If order is approved and both final price and quantity are set, generate tracking and send invoice
        if ($request->status === 'approved' && $specialOrder->final_price && $specialOrder->quantity) {
            // Generate tracking number
            $specialOrder->update([
                'tracking_number' => $specialOrder->generateTrackingNumber()
            ]);

            // Send invoice
            $specialOrder->sendInvoice();

            return redirect()->back()
                ->with('success', 'Order approved successfully. Invoice has been sent to the customer.');
        }

        return redirect()->back()
            ->with('success', 'Order status updated successfully.');
    }

    public function updateNotes(Request $request, SpecialOrder $specialOrder)
    {
        $request->validate([
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $specialOrder->update(['admin_notes' => $request->admin_notes]);

        return redirect()->back()
            ->with('success', 'Admin notes updated successfully.');
    }

    public function updateFinalPrice(Request $request, SpecialOrder $specialOrder)
    {
        $request->validate([
            'final_price' => 'required|numeric|min:0',
            'quantity' => 'nullable|numeric|min:0.1',
        ]);

        $updateData = ['final_price' => $request->final_price];
        
        if ($request->has('quantity')) {
            $updateData['quantity'] = $request->quantity;
        }

        $specialOrder->update($updateData);

        return redirect()->back()
            ->with('success', 'Order details updated successfully.');
    }

    public function sendInvoice(SpecialOrder $specialOrder)
    {
        if (!$specialOrder->final_price || !$specialOrder->quantity) {
            return redirect()->back()
                ->with('error', 'Please set both final price and quantity before sending invoice.');
        }

        $specialOrder->sendInvoice();

        return redirect()->back()
            ->with('success', 'Invoice has been sent to the customer.');
    }

    public function getProductsByCategory($categoryId)
    {
        $products = Product::where('category_id', $categoryId)
            ->where('status', 'active')
            ->select('id', 'name')
            ->get();

        return response()->json($products);
    }

    public function showDetails($id)
    {
        $specialOrder = SpecialOrder::with(['category', 'product'])
            ->where('id', $id)
            ->first();

        if (!$specialOrder) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        // Verify order belongs to logged-in user
        if (auth()->check() && $specialOrder->email !== auth()->user()->email) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return view('frontend.special-orders.details', compact('specialOrder'));
    }

    public function trackOrderView($id)
    {
        $specialOrder = SpecialOrder::with(['category', 'product'])
            ->where('id', $id)
            ->first();

        if (!$specialOrder) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        // Verify order belongs to logged-in user
        if (auth()->check() && $specialOrder->email !== auth()->user()->email) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return view('frontend.special-orders.track', compact('specialOrder'));
    }

    public function getOrderDetails($id)
    {
        $specialOrder = SpecialOrder::with(['category', 'product'])
            ->where('id', $id)
            ->first();

        if (!$specialOrder) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        // Verify order belongs to logged-in user
        if (auth()->check() && $specialOrder->email !== auth()->user()->email) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json([
            'order_number' => $specialOrder->order_number,
            'date' => $specialOrder->created_at->format('M j, Y'),
            'status' => ucfirst($specialOrder->status),
            'tracking_number' => $specialOrder->tracking_number,
            'product' => $specialOrder->product ? $specialOrder->product->name : $specialOrder->product_name,
            'quantity' => $specialOrder->quantity ? number_format($specialOrder->quantity, 2) . ' kg' : 'Not finalized',
            'notes' => $specialOrder->notes,
            'total' => number_format($specialOrder->total_price, 2),
            'admin_notes' => $specialOrder->admin_notes
        ]);
    }

    public function trackOrder($id)
    {
        $specialOrder = SpecialOrder::with(['category', 'product'])
            ->where('id', $id)
            ->first();

        if (!$specialOrder) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        // Verify the order belongs to the logged-in user
        if (auth()->check() && $specialOrder->email !== auth()->user()->email) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json([
            'order_number' => $specialOrder->order_number,
            'date' => $specialOrder->created_at->format('M j, Y'),
            'status' => ucfirst($specialOrder->status),
            'tracking_number' => $specialOrder->tracking_number,
            'courier_tracking_number' => $specialOrder->courier_tracking_number,
            'courier_service' => $specialOrder->courierService ? $specialOrder->courierService->name : 'Not assigned',
            'product' => $specialOrder->product ? $specialOrder->product->name : $specialOrder->product_name,
            'quantity' => $specialOrder->quantity ? number_format($specialOrder->quantity, 2) . ' kg' : 'Not finalized',
            'notes' => $specialOrder->notes,
            'total' => number_format($specialOrder->total_price, 2),
            'admin_notes' => $specialOrder->admin_notes
        ]);
    }

    public function updateCourierService(Request $request, SpecialOrder $specialOrder)
    {
        $request->validate([
            'courier_service_id' => 'nullable|exists:courier_services,id',
            'courier_charge' => 'nullable|numeric|min:0',
            'courier_tracking_number' => 'nullable|string|max:255',
        ]);

        $updateData = [];
        
        if ($request->has('courier_service_id')) {
            $updateData['courier_service_id'] = $request->courier_service_id;
            
            // Auto-calculate courier charge if service is selected
            if ($request->courier_service_id && !$request->has('courier_charge')) {
                $courierService = CourierService::find($request->courier_service_id);
                if ($courierService) {
                    $baseCharge = $courierService->getChargeForLocation($specialOrder->is_inside_dhaka);
                    $updateData['courier_charge'] = $baseCharge;
                }
            }
        }
        
        if ($request->has('courier_charge')) {
            $updateData['courier_charge'] = $request->courier_charge;
        }
        
        if ($request->has('courier_tracking_number')) {
            $updateData['courier_tracking_number'] = $request->courier_tracking_number;
        }

        $specialOrder->update($updateData);

        return redirect()->back()
            ->with('success', 'Courier service updated successfully.');
    }

    public function markAsShipped(Request $request, SpecialOrder $specialOrder)
    {
        $request->validate([
            'courier_tracking_number' => 'required|string|max:255',
        ]);

        $specialOrder->update([
            'courier_tracking_number' => $request->courier_tracking_number,
            'shipped_at' => now(),
            'status' => 'processing',
        ]);

        return redirect()->back()
            ->with('success', 'Order marked as shipped successfully.');
    }
}
