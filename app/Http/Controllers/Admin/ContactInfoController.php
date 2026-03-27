<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactInfo;
use Illuminate\Http\Request;

class ContactInfoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contactInfos = ContactInfo::latest()->paginate(10);
        return view('admin.contact-info.index', compact('contactInfos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.contact-info.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'header_title' => 'required|string|max:255',
            'header_subtitle' => 'nullable|string',
            'header_icon' => 'nullable|string|max:100',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'email_hours' => 'nullable|string|max:255',
            'phone_hours' => 'nullable|string|max:255',
            'map_embed_url' => 'nullable|string',
            'map_address' => 'nullable|string',
            'status' => 'boolean',
        ]);

        ContactInfo::create($request->all());

        return redirect()->route('admin.contact-info.index')
            ->with('success', 'Contact information created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ContactInfo $contactInfo)
    {
        return view('admin.contact-info.show', compact('contactInfo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ContactInfo $contactInfo)
    {
        return view('admin.contact-info.edit', compact('contactInfo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ContactInfo $contactInfo)
    {
        $request->validate([
            'header_title' => 'required|string|max:255',
            'header_subtitle' => 'nullable|string',
            'header_icon' => 'nullable|string|max:100',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'email_hours' => 'nullable|string|max:255',
            'phone_hours' => 'nullable|string|max:255',
            'map_embed_url' => 'nullable|string',
            'map_address' => 'nullable|string',
            'status' => 'boolean',
        ]);

        $contactInfo->update($request->all());

        return redirect()->route('admin.contact-info.index')
            ->with('success', 'Contact information updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContactInfo $contactInfo)
    {
        $contactInfo->delete();

        return redirect()->route('admin.contact-info.index')
            ->with('success', 'Contact information deleted successfully.');
    }
}
