<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }
    /**
     * Display the admin dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        $categories = Category::withCount('products')
            ->latest()
            ->take(5)
            ->get();

        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalUsers = User::count();
        $totalAdmins = User::where('role', 'admin')->count();
        $totalOrders = 0; // You can update this when you implement orders
        $totalRevenue = 0; // You can update this when you implement orders

        return view('backend.dashboard.index', compact(
            'categories',
            'totalProducts',
            'totalCategories',
            'totalUsers',
            'totalAdmins',
            'totalOrders',
            'totalRevenue'
        ));
    }
}
