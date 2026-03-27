<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function admins()
    {
        $admins = User::where('role', 'admin')
            ->latest()
            ->paginate(10);
            
        if (request()->ajax()) {
            return response()->json([
                'admins' => $admins,
                'pagination' => (string) $admins->links()
            ]);
        }
        
        return view('backend.users.admins', compact('admins'));
    }
    
    public function index(Request $request)
    {
        $users = User::latest()->paginate(10);
        
        if ($request->ajax()) {
            return response()->json([
                'users' => $users,
                'pagination' => (string) $users->links()
            ]);
        }
        
        return view('backend.users.index', compact('users'));
    }

    public function show(User $user)
    {
        // Eager load relationships to avoid N+1 queries
        $user->load([
            'orders' => function($query) {
                $query->latest()->take(5);
            }, 
            'addresses' => function($query) {
                $query->latest();
            }
        ]);
        
        // Ensure the relationships are initialized as collections to prevent errors
        if (!isset($user->orders)) {
            $user->setRelation('orders', collect());
        }
        
        if (!isset($user->addresses)) {
            $user->setRelation('addresses', collect());
        }
        
        return view('backend.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('backend.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        try {
            $validated = $request->validate([
                'role' => 'required|in:admin,user'
            ]);

            // Prevent modifying own role
            if ($user->id === auth()->id()) {
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'You cannot change your own role.'
                    ], 403);
                }
                return back()->with('error', 'You cannot change your own role.');
            }

            $user->update($validated);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'User role updated successfully.',
                    'user' => $user,
                    'redirect' => route('admin.users.users.index')
                ]);
            }

            return redirect()->route('admin.users.users.index')
                ->with('success', 'User role updated successfully.');

        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 500);
            }
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy(Request $request, User $user)
    {
        try {
            // Prevent deleting own account
            if ($user->id === auth()->id()) {
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'You cannot delete your own account.'
                    ], 403);
                }
                return back()->with('error', 'You cannot delete your own account.');
            }

            $user->delete();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'User deleted successfully.',
                    'redirect' => route('admin.users.users.index')
                ]);
            }

            return redirect()->route('admin.users.index')
                ->with('success', 'User deleted successfully.');

        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 500);
            }
            return back()->with('error', $e->getMessage());
        }
    }

}
