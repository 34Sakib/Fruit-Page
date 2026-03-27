<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PrivacyPolicy;
use Illuminate\Http\Request;

class PrivacyPolicyController extends Controller
{
    public function index()
    {
        $privacyPolicy = PrivacyPolicy::first();
        
        return view('admin.privacy-policy.index', compact('privacyPolicy'));
    }

    public function create()
    {
        return view('admin.privacy-policy.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'hero_title' => 'required|string|max:255',
            'hero_subtitle' => 'required|string',
            'introduction' => 'nullable|string',
            'personal_info' => 'nullable|string',
            'auto_collected_info' => 'nullable|string',
            'information_usage' => 'nullable|string',
            'data_sharing' => 'nullable|string',
            'data_security' => 'nullable|string',
            'cookies_tracking' => 'nullable|string',
            'privacy_rights' => 'nullable|string',
            'third_party_links' => 'nullable|string',
            'children_privacy' => 'nullable|string',
            'policy_changes' => 'nullable|string',
            'contact_email' => 'required|email',
            'contact_phone' => 'required|string|max:20',
            'contact_address' => 'required|string|max:255',
            'is_active' => 'boolean'
        ]);

        PrivacyPolicy::create($request->all());

        return redirect()->route('admin.privacy-policy.index')
            ->with('success', 'Privacy Policy created successfully.');
    }

    public function edit(PrivacyPolicy $privacyPolicy)
    {
        return view('admin.privacy-policy.edit', compact('privacyPolicy'));
    }

    public function update(Request $request, PrivacyPolicy $privacyPolicy)
    {
        $request->validate([
            'hero_title' => 'required|string|max:255',
            'hero_subtitle' => 'required|string',
            'introduction' => 'nullable|string',
            'personal_info' => 'nullable|string',
            'auto_collected_info' => 'nullable|string',
            'information_usage' => 'nullable|string',
            'data_sharing' => 'nullable|string',
            'data_security' => 'nullable|string',
            'cookies_tracking' => 'nullable|string',
            'privacy_rights' => 'nullable|string',
            'third_party_links' => 'nullable|string',
            'children_privacy' => 'nullable|string',
            'policy_changes' => 'nullable|string',
            'contact_email' => 'required|email',
            'contact_phone' => 'required|string|max:20',
            'contact_address' => 'required|string|max:255',
            'is_active' => 'boolean'
        ]);

        $privacyPolicy->update($request->all());

        return redirect()->route('admin.privacy-policy.index')
            ->with('success', 'Privacy Policy updated successfully.');
    }

    public function destroy(PrivacyPolicy $privacyPolicy)
    {
        $privacyPolicy->delete();

        return redirect()->route('admin.privacy-policy.index')
            ->with('success', 'Privacy Policy deleted successfully.');
    }

    public function toggleStatus(PrivacyPolicy $privacyPolicy)
    {
        $privacyPolicy->is_active = !$privacyPolicy->is_active;
        $privacyPolicy->save();

        return redirect()->route('admin.privacy-policy.index')
            ->with('success', 'Privacy Policy status updated successfully.');
    }
}
