<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShippingPolicy;
use Illuminate\Http\Request;

class ShippingPolicyController extends Controller
{
    public function index()
    {
        $shippingPolicy = ShippingPolicy::first();
        
        return view('admin.shipping-policy.index', compact('shippingPolicy'));
    }

    public function create()
    {
        return view('admin.shipping-policy.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'hero_title' => 'required|string|max:255',
            'hero_subtitle' => 'required|string',
            // Our Shipping Commitment
            'introduction' => 'nullable|string',
            // Delivery Areas
            'current_coverage' => 'nullable|string',
            'expansion_plans' => 'nullable|string',
            // Delivery Timeframes
            'standard_delivery_time' => 'nullable|string',
            'express_delivery_time' => 'nullable|string',
            'scheduled_delivery' => 'nullable|string',
            // Shipping Charges
            'standard_delivery_rates' => 'nullable|string',
            'additional_services' => 'nullable|string',
            // Order Processing
            'order_confirmation' => 'nullable|string',
            'quality_assurance' => 'nullable|string',
            'dispatch_process' => 'nullable|string',
            // Packaging Standards
            'fresh_produce_packaging' => 'nullable|string',
            'dairy_perishables_packaging' => 'nullable|string',
            'packaged_goods_packaging' => 'nullable|string',
            // Delivery Process
            'before_delivery' => 'nullable|string',
            'during_delivery' => 'nullable|string',
            'after_delivery' => 'nullable|string',
            // Special Circumstances
            'weather_conditions' => 'nullable|string',
            'product_unavailability' => 'nullable|string',
            'failed_delivery_attempts' => 'nullable|string',
            // International Shipping
            'international_shipping' => 'nullable|string',
            // Shipping Support
            'shipping_hotline' => 'nullable|string|max:50',
            'shipping_email' => 'nullable|email',
            'support_hours' => 'nullable|string|max:100',
            'live_chat' => 'nullable|string|max:100',
            'is_active' => 'boolean'
        ]);

        ShippingPolicy::create($request->all());

        return redirect()->route('admin.shipping-policy.index')
            ->with('success', 'Shipping Policy created successfully.');
    }

    public function edit(ShippingPolicy $shippingPolicy)
    {
        return view('admin.shipping-policy.edit', compact('shippingPolicy'));
    }

    public function update(Request $request, ShippingPolicy $shippingPolicy)
    {
        $request->validate([
            'hero_title' => 'required|string|max:255',
            'hero_subtitle' => 'required|string',
            // Our Shipping Commitment
            'introduction' => 'nullable|string',
            // Delivery Areas
            'current_coverage' => 'nullable|string',
            'expansion_plans' => 'nullable|string',
            // Delivery Timeframes
            'standard_delivery_time' => 'nullable|string',
            'express_delivery_time' => 'nullable|string',
            'scheduled_delivery' => 'nullable|string',
            // Shipping Charges
            'standard_delivery_rates' => 'nullable|string',
            'additional_services' => 'nullable|string',
            // Order Processing
            'order_confirmation' => 'nullable|string',
            'quality_assurance' => 'nullable|string',
            'dispatch_process' => 'nullable|string',
            // Packaging Standards
            'fresh_produce_packaging' => 'nullable|string',
            'dairy_perishables_packaging' => 'nullable|string',
            'packaged_goods_packaging' => 'nullable|string',
            // Delivery Process
            'before_delivery' => 'nullable|string',
            'during_delivery' => 'nullable|string',
            'after_delivery' => 'nullable|string',
            // Special Circumstances
            'weather_conditions' => 'nullable|string',
            'product_unavailability' => 'nullable|string',
            'failed_delivery_attempts' => 'nullable|string',
            // International Shipping
            'international_shipping' => 'nullable|string',
            // Shipping Support
            'shipping_hotline' => 'nullable|string|max:50',
            'shipping_email' => 'nullable|email',
            'support_hours' => 'nullable|string|max:100',
            'live_chat' => 'nullable|string|max:100',
            'is_active' => 'boolean'
        ]);

        $shippingPolicy->update($request->all());

        return redirect()->route('admin.shipping-policy.index')
            ->with('success', 'Shipping Policy updated successfully.');
    }

    public function destroy(ShippingPolicy $shippingPolicy)
    {
        $shippingPolicy->delete();

        return redirect()->route('admin.shipping-policy.index')
            ->with('success', 'Shipping Policy deleted successfully.');
    }

    public function toggleStatus(ShippingPolicy $shippingPolicy)
    {
        $shippingPolicy->is_active = !$shippingPolicy->is_active;
        $shippingPolicy->save();

        return redirect()->route('admin.shipping-policy.index')
            ->with('success', 'Shipping Policy status updated successfully.');
    }
}
