<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TermsConditions;
use Illuminate\Http\Request;

class TermsConditionsController extends Controller
{
    public function index()
    {
        $termsConditions = TermsConditions::first();
        
        return view('admin.terms-conditions.index', compact('termsConditions'));
    }

    public function create()
    {
        return view('admin.terms-conditions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'hero_title' => 'required|string|max:255',
            'hero_subtitle' => 'required|string',
            'introduction' => 'nullable|string',
            'definitions' => 'nullable|string',
            'acceptance_of_terms' => 'nullable|string',
            'registration' => 'nullable|string',
            'account_termination' => 'nullable|string',
            'product_information' => 'nullable|string',
            'order_processing' => 'nullable|string',
            'pricing' => 'nullable|string',
            'payment_methods' => 'nullable|string',
            'delivery_areas' => 'nullable|string',
            'delivery_time' => 'nullable|string',
            'delivery_charges' => 'nullable|string',
            'return_policy' => 'nullable|string',
            'refund_process' => 'nullable|string',
            'intellectual_property' => 'nullable|string',
            'user_conduct' => 'nullable|string',
            'limitation_of_liability' => 'nullable|string',
            'termination' => 'nullable|string',
            'changes_to_terms' => 'nullable|string',
            'contact_email' => 'required|email',
            'contact_phone' => 'required|string|max:20',
            'contact_address' => 'required|string|max:255',
            'is_active' => 'boolean'
        ]);

        TermsConditions::create($request->all());

        return redirect()->route('admin.terms-conditions.index')
            ->with('success', 'Terms & Conditions created successfully.');
    }

    public function edit(TermsConditions $termsConditions)
    {
        return view('admin.terms-conditions.edit', compact('termsConditions'));
    }

    public function update(Request $request, TermsConditions $termsConditions)
    {
        $request->validate([
            'hero_title' => 'required|string|max:255',
            'hero_subtitle' => 'required|string',
            'introduction' => 'nullable|string',
            'definitions' => 'nullable|string',
            'acceptance_of_terms' => 'nullable|string',
            'registration' => 'nullable|string',
            'account_termination' => 'nullable|string',
            'product_information' => 'nullable|string',
            'order_processing' => 'nullable|string',
            'pricing' => 'nullable|string',
            'payment_methods' => 'nullable|string',
            'delivery_areas' => 'nullable|string',
            'delivery_time' => 'nullable|string',
            'delivery_charges' => 'nullable|string',
            'return_policy' => 'nullable|string',
            'refund_process' => 'nullable|string',
            'intellectual_property' => 'nullable|string',
            'user_conduct' => 'nullable|string',
            'limitation_of_liability' => 'nullable|string',
            'termination' => 'nullable|string',
            'changes_to_terms' => 'nullable|string',
            'contact_email' => 'required|email',
            'contact_phone' => 'required|string|max:20',
            'contact_address' => 'required|string|max:255',
            'is_active' => 'boolean'
        ]);

        $termsConditions->update($request->all());

        return redirect()->route('admin.terms-conditions.index')
            ->with('success', 'Terms & Conditions updated successfully.');
    }

    public function destroy(TermsConditions $termsConditions)
    {
        $termsConditions->delete();

        return redirect()->route('admin.terms-conditions.index')
            ->with('success', 'Terms & Conditions deleted successfully.');
    }

    public function toggleStatus(TermsConditions $termsConditions)
    {
        $termsConditions->is_active = !$termsConditions->is_active;
        $termsConditions->save();

        return redirect()->route('admin.terms-conditions.index')
            ->with('success', 'Terms & Conditions status updated successfully.');
    }
}
