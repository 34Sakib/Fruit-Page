<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReturnPolicy;
use Illuminate\Http\Request;

class ReturnPolicyController extends Controller
{
    public function index()
    {
        $returnPolicy = ReturnPolicy::first();
        return view('admin.return-policy.index', compact('returnPolicy'));
    }

    public function create()
    {
        return view('admin.return-policy.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'hero_title' => 'required|string|max:255',
            'hero_subtitle' => 'nullable|string',
            'introduction' => 'nullable|string',
            'fresh_produce_eligibility' => 'nullable|string',
            'dairy_perishables_eligibility' => 'nullable|string',
            'packaged_foods_eligibility' => 'nullable|string',
            'non_returnable_items' => 'nullable|string',
            'contact_customer_service' => 'nullable|string',
            'documentation_required' => 'nullable|string',
            'return_approval' => 'nullable|string',
            'product_return_step' => 'nullable|string',
            'full_refund' => 'nullable|string',
            'store_credit' => 'nullable|string',
            'product_exchange' => 'nullable|string',
            'wrong_item_delivered' => 'nullable|string',
            'quality_issues' => 'nullable|string',
            'delivery_delays' => 'nullable|string',
            // Return Timeframes
            'fresh_produce_timeframe' => 'nullable|string|max:50',
            'fresh_produce_conditions' => 'nullable|string',
            'dairy_timeframe' => 'nullable|string|max:50',
            'dairy_conditions' => 'nullable|string',
            'packaged_foods_timeframe' => 'nullable|string|max:50',
            'packaged_foods_conditions' => 'nullable|string',
            'wrong_items_timeframe' => 'nullable|string|max:50',
            'wrong_items_conditions' => 'nullable|string',
            // Customer Responsibilities
            'product_inspection' => 'nullable|string',
            'return_preparation' => 'nullable|string',
            'communication' => 'nullable|string',
            'return_hotline' => 'nullable|string|max:50',
            'return_email' => 'nullable|email|max:100',
            'support_hours' => 'nullable|string|max:100',
            'live_chat' => 'nullable|string|max:100',
            'whatsapp' => 'nullable|string|max:50',
            'is_active' => 'boolean'
        ]);

        ReturnPolicy::create($request->all());

        return redirect()->route('admin.return-policy.index')
            ->with('success', 'Return Policy created successfully.');
    }

    public function edit(ReturnPolicy $returnPolicy)
    {
        return view('admin.return-policy.edit', compact('returnPolicy'));
    }

    public function update(Request $request, ReturnPolicy $returnPolicy)
    {
        $request->validate([
            'hero_title' => 'required|string|max:255',
            'hero_subtitle' => 'nullable|string',
            'introduction' => 'nullable|string',
            'fresh_produce_eligibility' => 'nullable|string',
            'dairy_perishables_eligibility' => 'nullable|string',
            'packaged_foods_eligibility' => 'nullable|string',
            'non_returnable_items' => 'nullable|string',
            'contact_customer_service' => 'nullable|string',
            'documentation_required' => 'nullable|string',
            'return_approval' => 'nullable|string',
            'product_return_step' => 'nullable|string',
            'full_refund' => 'nullable|string',
            'store_credit' => 'nullable|string',
            'product_exchange' => 'nullable|string',
            'wrong_item_delivered' => 'nullable|string',
            'quality_issues' => 'nullable|string',
            'delivery_delays' => 'nullable|string',
            // Return Timeframes
            'fresh_produce_timeframe' => 'nullable|string|max:50',
            'fresh_produce_conditions' => 'nullable|string',
            'dairy_timeframe' => 'nullable|string|max:50',
            'dairy_conditions' => 'nullable|string',
            'packaged_foods_timeframe' => 'nullable|string|max:50',
            'packaged_foods_conditions' => 'nullable|string',
            'wrong_items_timeframe' => 'nullable|string|max:50',
            'wrong_items_conditions' => 'nullable|string',
            // Customer Responsibilities
            'product_inspection' => 'nullable|string',
            'return_preparation' => 'nullable|string',
            'communication' => 'nullable|string',
            'return_hotline' => 'nullable|string|max:50',
            'return_email' => 'nullable|email|max:100',
            'support_hours' => 'nullable|string|max:100',
            'live_chat' => 'nullable|string|max:100',
            'whatsapp' => 'nullable|string|max:50',
            'is_active' => 'boolean'
        ]);

        $returnPolicy->update($request->all());

        return redirect()->route('admin.return-policy.index')
            ->with('success', 'Return Policy updated successfully.');
    }

    public function destroy(ReturnPolicy $returnPolicy)
    {
        $returnPolicy->delete();

        return redirect()->route('admin.return-policy.index')
            ->with('success', 'Return Policy deleted successfully.');
    }

    public function toggleStatus(ReturnPolicy $returnPolicy)
    {
        $returnPolicy->is_active = !$returnPolicy->is_active;
        $returnPolicy->save();

        return redirect()->route('admin.return-policy.index')
            ->with('success', 'Return Policy status updated successfully.');
    }
}
