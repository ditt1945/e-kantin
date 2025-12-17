<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Tenant;
use App\Models\Menu;
use App\Models\User;
use App\Models\Category;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminReportController extends Controller
{
    // No constructor - middleware will be handled in routes

    /**
     * Display comprehensive admin reports and analytics
     */
    public function index()
    {
        try {
            // Date range parameters
            $startDate = request()->get('start_date', now()->subDays(30)->format('Y-m-d'));
            $endDate = request()->get('end_date', now()->format('Y-m-d'));

            $startDate = Carbon::parse($startDate);
            $endDate = Carbon::parse($endDate);

        // Overall Statistics
        $stats = [
            'total_revenue' => Order::whereBetween('created_at', [$startDate, $endDate])->sum('total_harga'),
            'total_orders' => Order::whereBetween('created_at', [$startDate, $endDate])->count(),
            'active_tenants' => Tenant::where('is_active', true)->count(),
            'total_customers' => User::where('role', 'customer')->count(),
            'total_menus' => Menu::count(),
            'avg_order_value' => Order::whereBetween('created_at', [$startDate, $endDate])->avg('total_harga') ?? 0,
        ];

        // Daily Sales Trend
        $dailySales = Order::whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('DATE(created_at) as date, COUNT(*) as orders, SUM(total_harga) as revenue')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Top Performing Tenants
        $topTenants = Tenant::with(['orders' => function($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }])
            ->get()
            ->map(function($tenant) use ($startDate, $endDate) {
                $orders = $tenant->orders->filter(function($order) use ($startDate, $endDate) {
                    return $order->created_at->between($startDate, $endDate);
                });
                $tenant->orders_count = $orders->count();
                $tenant->orders_sum_total_harga = $orders->sum('total_harga');
                return $tenant;
            })
            ->sortByDesc('orders_sum_total_harga')
            ->take(10);

        // Top Selling Menu Items
        $topMenus = Menu::with(['orderItems.order' => function($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }])
            ->get()
            ->map(function($menu) use ($startDate, $endDate) {
                $orderItems = $menu->orderItems->filter(function($item) use ($startDate, $endDate) {
                    return $item->order && $item->order->created_at->between($startDate, $endDate);
                });
                $menu->total_sold = $orderItems->sum('quantity');
                $menu->revenue = $orderItems->sum('subtotal');
                return $menu;
            })
            ->sortByDesc('total_sold')
            ->take(10);

        // Monthly Revenue Comparison
        $monthlyRevenue = Order::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, SUM(total_harga) as revenue')
            ->whereBetween('created_at', [$startDate->copy()->subYear(), $endDate])
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        // Payment Methods Distribution
        $paymentMethods = Payment::selectRaw('payment_method, COUNT(*) as count, SUM(amount) as total')
            ->whereHas('order', function($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            })
            ->groupBy('payment_method')
            ->get();

        // Order Status Distribution
        $orderStatuses = Order::selectRaw('status, COUNT(*) as count')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('status')
            ->get();

        // Category Performance
        $categoryPerformance = Category::with(['menus' => function($query) {
                $query->where('is_available', 1);
            }, 'menus.orderItems.order'])
            ->get()
            ->map(function($category) use ($startDate, $endDate) {
                $category->menus_count = $category->menus->count();
                $totalSold = 0;
                foreach ($category->menus as $menu) {
                    $orderItems = $menu->orderItems->filter(function($item) use ($startDate, $endDate) {
                        return $item->order && $item->order->created_at->between($startDate, $endDate);
                    });
                    $totalSold += $orderItems->sum('quantity');
                }
                $category->total_sold = $totalSold;
                return $category;
            })
            ->sortByDesc('total_sold');

        // New Customer Registration Trend
        $newCustomers = User::where('role', 'customer')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('admin.reports.index', compact(
            'stats',
            'dailySales',
            'topTenants',
            'topMenus',
            'monthlyRevenue',
            'paymentMethods',
            'orderStatuses',
            'categoryPerformance',
            'newCustomers',
            'startDate',
            'endDate'
        ));
        } catch (\Exception $e) {
            // Log the error and return with error message
            \Log::error('Admin Report Error: ' . $e->getMessage());
            return back()->with('error', 'Gagal memuat laporan: ' . $e->getMessage());
        }
    }

    /**
     * Export reports to PDF/Excel
     */
    public function export()
    {
        $format = request()->get('format', 'pdf');
        $type = request()->get('type', 'summary');
        $startDate = request()->get('start_date', now()->subDays(30)->format('Y-m-d'));
        $endDate = request()->get('end_date', now()->format('Y-m-d'));

        // Implementation for export functionality can be added here
        return back()->with('info', 'Fitur export akan segera tersedia');
    }
}