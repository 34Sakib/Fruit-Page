<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }
    
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
        
        // Calculate total orders and revenue
        $totalOrders = Order::count();
        $totalRevenue = Order::sum('total');

        // Revenue Overview (Last 6 Months)
        $revenueData = [];
        $months = collect();
        
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthYear = $date->format('M Y');
            $months->push($monthYear);
            
            $revenue = Order::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->sum('total');
                
            $revenueData[] = number_format($revenue, 2, '.', '');
        }

        // Order Status Counts
        $orderStatuses = [
            'pending' => Order::where('status', 'pending')->count(),
            'processing' => Order::where('status', 'processing')->count(),
            'completed' => Order::where('status', 'completed')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count(),
        ];

        // Recent Orders
        $recentOrders = Order::with('user')
            ->latest()
            ->take(5)
            ->get();

        return view('backend.dashboard.index', compact(
            'categories',
            'totalProducts',
            'totalCategories',
            'totalUsers',
            'totalAdmins',
            'totalOrders',
            'totalRevenue',
            'revenueData',
            'months',
            'orderStatuses',
            'recentOrders'
        ));
    }
}
