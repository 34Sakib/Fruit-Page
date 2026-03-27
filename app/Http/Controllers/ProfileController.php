<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile page.
     */
    public function show(Request $request): View
    {
        // Eager load user with their relationships
        $user = $request->user()->load([
            'orders.items.product',
            'orders.statusUpdates' => function($query) {
                $query->latest();
            },
            'specialOrders.category',
            'specialOrders.product',
            'addresses'
        ]);
        
        // Get paginated orders for the view
        $orders = $user->orders()
            ->with(['items.product', 'statusUpdates'])
            ->latest()
            ->paginate(10);
            
        // Get all addresses
        $addresses = $user->addresses;

        // Define status order for the view
        $statusOrder = [
            'pending',
            'processing',
            'shipped',
            'delivered',
            'completed',
            'cancelled',
            'refunded'
        ];

        return view('frontend.profile.show', [
            'user' => $user,
            'orders' => $orders,
            'addresses' => $addresses,
            'statusOrder' => $statusOrder
        ]);
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request)
    {
        $user = $request->user();
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully!',
                'user' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone
                ],
                'redirect' => route('profile.show')
            ]);
        }

        return redirect()->route('profile.show')
            ->with('success', 'Profile updated successfully!');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
