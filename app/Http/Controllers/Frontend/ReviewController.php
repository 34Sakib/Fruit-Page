<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with(['product', 'user'])
            ->latest()
            ->paginate(15);
            
        return view('backend.reviews.index', compact('reviews'));
    }

    public function edit(Review $review)
    {
        return view('backend.reviews.edit', compact('review'));
    }

    public function update(Request $request, Review $review)
    {
        $validated = $request->validate([
            'comment' => 'required|string|min:10|max:1000',
            'rating' => 'required|integer|min:1|max:5',
            'is_approved' => 'boolean',
        ]);

        $review->update($validated);

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review updated successfully.');
    }

    public function approve(Review $review)
    {
        $review->update(['is_approved' => true]);
        
        return back()->with('success', 'Review approved successfully.');
    }

    public function destroy(Review $review)
    {
        $review->delete();
        
        return back()->with('success', 'Review deleted successfully.');
    }
    
    public function pending()
    {
        $reviews = Review::with(['product', 'user'])
            ->where('is_approved', false)
            ->latest()
            ->paginate(15);
            
        return view('backend.reviews.pending', compact('reviews'));
    }
}
