<?php

namespace App\Http\Controllers;

use App\Models\Footer;
use Illuminate\Http\Request;

class FooterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $footers = Footer::latest()->paginate(10);
        return view('backend.footers.index', compact('footers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.footers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable|string',
            'facebook_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'youtube_url' => 'nullable|url',
            'linkedin_url' => 'nullable|url',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'copyright_text' => 'nullable|string|max:255',
            'status' => 'boolean',
        ]);

        $data = $request->except('logo');

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('footer', 'public');
            $data['logo'] = $logoPath;
        }

        Footer::create($data);

        return redirect()->route('admin.footers.index')
            ->with('success', 'Footer created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Footer $footer)
    {
        return view('backend.footers.show', compact('footer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Footer $footer)
    {
        return view('backend.footers.edit', compact('footer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Footer $footer)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable|string',
            'facebook_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'youtube_url' => 'nullable|url',
            'linkedin_url' => 'nullable|url',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'copyright_text' => 'nullable|string|max:255',
            'status' => 'boolean',
        ]);

        $data = $request->except('logo');

        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($footer->logo && \Storage::disk('public')->exists($footer->logo)) {
                \Storage::disk('public')->delete($footer->logo);
            }
            
            $logoPath = $request->file('logo')->store('footer', 'public');
            $data['logo'] = $logoPath;
        }

        $footer->update($data);

        return redirect()->route('admin.footers.index')
            ->with('success', 'Footer updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Footer $footer)
    {
        $footer->delete();

        return redirect()->route('admin.footers.index')
            ->with('success', 'Footer deleted successfully.');
    }
}
