<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Http\Requests\StoreContactRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;

class ContactController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['store']);
        $this->middleware('admin')->except(['store']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Contact::latest();

        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        $contacts = $query->paginate(15);

        $stats = [
            'total' => Contact::count(),
            'pending' => Contact::pending()->count(),
            'read' => Contact::read()->count(),
            'replied' => Contact::replied()->count(),
        ];

        return view('admin.contacts.index', compact('contacts', 'stats'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContactRequest $request)
    {
        $contact = Contact::create($request->validated());

        // Send email notification to admin
        try {
            Mail::to(config('mail.admin_email', 'admin@fruitmart.com'))
                ->send(new ContactFormMail($contact));
        } catch (\Exception $e) {
            \Log::error('Failed to send contact email: ' . $e->getMessage());
        }

        return redirect()->back()
            ->with('success', 'Thank you for contacting us! We will get back to you soon.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {
        // Mark as read if status is pending
        if ($contact->status === 'pending') {
            $contact->markAsRead();
        }

        return view('admin.contacts.show', compact('contact'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $contact)
    {
        return view('admin.contacts.edit', compact('contact'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contact $contact)
    {
        $request->validate([
            'admin_reply' => 'nullable|string|max:2000',
        ]);

        if ($request->has('mark_as_read')) {
            $contact->markAsRead();
            return redirect()->route('admin.contacts.show', $contact)
                ->with('success', 'Contact marked as read.');
        }

        if ($request->has('send_reply')) {
            $contact->markAsReplied($request->admin_reply);

            // Send reply email to customer
            try {
                Mail::to($contact->email)->send(new \App\Mail\ContactReplyMail($contact));
            } catch (\Exception $e) {
                \Log::error('Failed to send reply email: ' . $e->getMessage());
            }

            return redirect()->route('admin.contacts.show', $contact)
                ->with('success', 'Reply sent successfully!');
        }

        return redirect()->route('admin.contacts.index')
            ->with('success', 'Contact updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()->route('admin.contacts.index')
            ->with('success', 'Contact deleted successfully.');
    }

    /**
     * Bulk actions for contacts
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,mark_read,mark_replied',
            'contacts' => 'required|array',
            'contacts.*' => 'exists:contacts,id',
        ]);

        $contacts = Contact::whereIn('id', $request->contacts);

        switch ($request->action) {
            case 'delete':
                $contacts->delete();
                $message = 'Selected contacts deleted successfully.';
                break;
            case 'mark_read':
                $contacts->update(['status' => 'read']);
                $message = 'Selected contacts marked as read.';
                break;
            case 'mark_replied':
                $contacts->update(['status' => 'replied', 'replied_at' => now()]);
                $message = 'Selected contacts marked as replied.';
                break;
        }

        return redirect()->route('admin.contacts.index')
            ->with('success', $message);
    }
}
