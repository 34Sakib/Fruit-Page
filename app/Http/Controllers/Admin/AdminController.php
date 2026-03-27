<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\SpecialOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function getDashboardData()
    {
        try {
            // Get order statistics
            $statusCounts = Order::select('status', DB::raw('count(*) as count'))
                ->groupBy('status')
                ->pluck('count', 'status')
                ->toArray();
                
            // Get recent orders
            $recentOrders = Order::with('items')
                ->latest()
                ->take(5)
                ->get()
                ->map(function($order) {
                    return [
                        'id' => $order->id,
                        'order_number' => $order->order_number,
                        'first_name' => $order->first_name,
                        'last_name' => $order->last_name,
                        'status' => $order->status,
                        'total' => $order->total,
                        'created_at' => $order->created_at->toDateTimeString(),
                        'view_url' => route('admin.orders.show', $order->id)
                    ];
                });
            
            // Get monthly revenue data for the last 6 months
            $sixMonthsAgo = now()->subMonths(6)->startOfMonth();
            $monthlyRevenue = Order::select(
                    DB::raw('SUM(total) as revenue'),
                    DB::raw('MONTH(created_at) as month'),
                    DB::raw('YEAR(created_at) as year')
                )
                ->where('created_at', '>=', $sixMonthsAgo)
                ->whereNotIn('status', ['cancelled', 'refunded'])
                ->groupBy('year', 'month')
                ->orderBy('year', 'asc')
                ->orderBy('month', 'asc')
                ->get();
                
            // Get special orders revenue for chart
            $specialMonthlyRevenue = SpecialOrder::select(
                    DB::raw('SUM(final_price + delivery_charge) as revenue'),
                    DB::raw('MONTH(created_at) as month'),
                    DB::raw('YEAR(created_at) as year')
                )
                ->where('created_at', '>=', $sixMonthsAgo)
                ->where('status', 'completed')
                ->whereNotNull('final_price')
                ->groupBy('year', 'month')
                ->orderBy('year', 'asc')
                ->orderBy('month', 'asc')
                ->get();
                
            // Merge and group by month/year
            $combinedRevenue = $monthlyRevenue->concat($specialMonthlyRevenue)
                ->groupBy(function($item) {
                    return $item->year . '-' . str_pad($item->month, 2, '0', STR_PAD_LEFT);
                })
                ->map(function($group) {
                    $first = $group->first();
                    return (object)[
                        'revenue' => $group->sum('revenue'),
                        'month' => $first->month,
                        'year' => $first->year
                    ];
                })
                ->sortBy('year')
                ->sortBy('month')
                ->values();
            
            // Generate labels for the last 6 months
            $chartData = [
                'labels' => [],
                'data' => array_fill(0, 6, 0) // Initialize with 6 months of zeros
            ];
            
            // Fill in the data for months that have orders
            foreach ($combinedRevenue as $revenue) {
                $date = \Carbon\Carbon::createFromDate($revenue->year, $revenue->month, 1);
                $monthsAgo = now()->diffInMonths($date);
                $index = 5 - $monthsAgo; // 0-5 for last 6 months
                
                if ($index >= 0 && $index < 6) {
                    $chartData['data'][$index] = (float) $revenue->revenue;
                }
            }
            
            // Generate labels for the last 6 months
            for ($i = 5; $i >= 0; $i--) {
                $month = now()->subMonths($i);
                $chartData['labels'][] = $month->format('M Y');
            }
            
            // Ensure we have exactly 6 data points
            $chartData['data'] = array_slice($chartData['data'], -6, 6, true);
            
            // Calculate total revenue from the last 6 months
            $regularOrderRevenue = Order::where('created_at', '>=', $sixMonthsAgo)
                ->whereNotIn('status', ['cancelled', 'refunded'])
                ->sum('total');
                
            $specialOrderRevenue = SpecialOrder::where('created_at', '>=', $sixMonthsAgo)
                ->where('status', 'completed')
                ->whereNotNull('final_price')
                ->sum(DB::raw('final_price + delivery_charge'));
                
            $totalRevenue = $regularOrderRevenue + $specialOrderRevenue;
                
            // Get total number of orders directly from the database
            $totalOrders = Order::count();
            
            // Debug log
            \Log::info('Dashboard Data', [
                'totalOrders' => $totalOrders,
                'statusCounts' => $statusCounts,
                'orderCount' => Order::count()
            ]);
            
            return response()->json([
                'success' => true,
                'pendingOrders' => $statusCounts['pending'] ?? 0,
                'completedOrders' => $statusCounts['completed'] ?? 0,
                'cancelledOrders' => $statusCounts['cancelled'] ?? 0,
                'totalOrders' => $totalOrders,
                'recentOrders' => $recentOrders,
                'chartData' => $chartData,
                'totalRevenue' => number_format($totalRevenue, 2)
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Dashboard data error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to load dashboard data: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function dashboard()
    {
        // Get counts
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalUsers = User::where('role', '!=', 'admin')->count();
        $totalAdmins = User::where('role', 'admin')->count();
        
        // Order Statistics
        $totalOrders = Order::count();
        
        // Calculate revenue from regular orders (excluding cancelled/refunded)
        $regularOrderRevenue = Order::whereNotIn('status', ['cancelled', 'refunded'])->sum('total');
        
        // Calculate revenue from completed special orders
        $specialOrderRevenue = SpecialOrder::where('status', 'completed')
            ->whereNotNull('final_price')
            ->sum(DB::raw('final_price + delivery_charge'));
        
        $totalRevenue = $regularOrderRevenue + $specialOrderRevenue;
        
        // Get all possible status values from the database
        $statusCounts = Order::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();
            
        $pendingOrders = $statusCounts['pending'] ?? 0;
        $completedOrders = $statusCounts['completed'] ?? 0;
        $cancelledOrders = $statusCounts['cancelled'] ?? 0;
        
        // Debug log
        \Log::info('Dashboard Loaded', [
            'totalOrders' => $totalOrders,
            'statusCounts' => $statusCounts,
            'directCount' => Order::count()
        ]);
        $cancelledOrders = $statusCounts['cancelled'] ?? 0;
        
        // Recent Orders
        $recentOrders = Order::with('items')
            ->latest()
            ->take(5)
            ->get();
            
        // Monthly Revenue Data for Chart
        $monthlyRevenue = Order::select(
                DB::raw('SUM(total) as revenue'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('YEAR(created_at) as year'),
                DB::raw('"regular" as order_type')
            )
            ->where('created_at', '>=', now()->subMonths(6))
            ->whereNotIn('status', ['cancelled', 'refunded'])
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();
            
        // Get special orders revenue for chart
        $specialMonthlyRevenue = SpecialOrder::select(
                DB::raw('SUM(final_price + delivery_charge) as revenue'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('YEAR(created_at) as year'),
                DB::raw('"special" as order_type')
            )
            ->where('created_at', '>=', now()->subMonths(6))
            ->where('status', 'completed')
            ->whereNotNull('final_price')
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();
            
        // Merge and group by month/year
        $combinedRevenue = $monthlyRevenue->concat($specialMonthlyRevenue)
            ->groupBy(function($item) {
                return $item->year . '-' . str_pad($item->month, 2, '0', STR_PAD_LEFT);
            })
            ->map(function($group) {
                $first = $group->first();
                return (object)[
                    'revenue' => $group->sum('revenue'),
                    'month' => $first->month,
                    'year' => $first->year
                ];
            })
            ->sortBy('year')
            ->sortBy('month')
            ->values();
            
        // Format data for chart
        $chartLabels = [];
        $chartData = [];
        
        foreach ($combinedRevenue as $revenue) {
            $date = \Carbon\Carbon::createFromDate($revenue->year, $revenue->month, 1);
            $chartLabels[] = $date->format('M Y');
            $chartData[] = $revenue->revenue;
        }

        // Ensure all variables are properly passed to the view
        $data = [
            'totalProducts' => $totalProducts,
            'totalCategories' => $totalCategories,
            'totalUsers' => $totalUsers,
            'totalAdmins' => $totalAdmins,
            'totalOrders' => $totalOrders,
            'totalRevenue' => $totalRevenue,
            'pendingOrders' => $pendingOrders,
            'completedOrders' => $completedOrders,
            'cancelledOrders' => $cancelledOrders,
            'recentOrders' => $recentOrders,
            'chartLabels' => $chartLabels,
            'chartData' => $chartData,
            'orderStatuses' => $statusCounts,
            'revenueData' => $chartData,
            'months' => $chartLabels
        ];

        return view('backend.dashboard.index', $data);
    }
}
