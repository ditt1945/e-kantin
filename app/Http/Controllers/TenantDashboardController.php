<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\Order;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class TenantDashboardController extends Controller
{
    /**
     * Tampilkan dashboard tenant
     */
    public function index()
    {
        try {
            $user = Auth::user();
            $tenant = $user->tenant;

            if (!$tenant) {
                Auth::logout();
                return redirect()->route('login')->with('error', 'Anda belum memiliki tenant. Silakan hubungi administrator.');
            }

            // Optimized: Get dashboard stats in single query with caching
            $dashboardStats = Cache::remember(
                "tenant_dashboard_stats_{$tenant->id}",
                now()->addMinutes(5), // Cache for 5 minutes
                function () use ($tenant) {
                    return $tenant->orders()
                        ->selectRaw('
                            COUNT(*) as total_orders,
                            COUNT(CASE WHEN DATE(created_at) = CURDATE() THEN 1 END) as orders_today,
                            COALESCE(SUM(CASE WHEN DATE(created_at) = CURDATE() THEN total_harga END), 0) as income_today
                        ')
                        ->first();
                }
            );

            $totalMenus = Cache::remember(
                "tenant_total_menus_{$tenant->id}",
                now()->addMinutes(10), // Cache for 10 minutes
                function () use ($tenant) {
                    return $tenant->menus()->count();
                }
            );

            $activeMenus = Cache::remember(
                "tenant_active_menus_{$tenant->id}",
                now()->addMinutes(5), // Cache for 5 minutes
                function () use ($tenant) {
                    return $tenant->menus()->where('is_available', true)->count();
                }
            );

            $bestSellerCount = Cache::remember(
                "tenant_best_seller_count_{$tenant->id}",
                now()->addMinutes(5), // Cache for 5 minutes
                function () use ($tenant) {
                    return $tenant->menus()->where('order_count', '>=', 10)->count();
                }
            );

            $pendingCount = Cache::remember(
                "tenant_pending_count_{$tenant->id}",
                now()->addMinutes(2), // Cache for 2 minutes
                function () use ($tenant) {
                    return $tenant->orders()->where('status', 'pending')->count();
                }
            );

            return view('tenant.dashboard', [
                'tenant' => $tenant,
                'totalMenus' => $totalMenus,
                'activeMenus' => $activeMenus,
                'bestSellerCount' => $bestSellerCount,
                'totalOrdersToday' => $dashboardStats->orders_today ?? 0,
                'pendapatanHariIni' => $dashboardStats->income_today ?? 0,
                'pendingCount' => $pendingCount
            ]);
        } catch (\Exception $e) {
            \Log::error('Error Dashboard Tenant: ' . $e->getMessage() . ' | Baris: ' . $e->getLine());
            return back()->with('error', 'Gagal memuat dashboard: ' . $e->getMessage());
        }
    }

    /**
     * Display orders for tenant
     */
    public function orders(\Illuminate\Http\Request $request)
    {
        $tenant = Auth::user()->tenant;

        if (!$tenant) {
            return redirect()->route('dashboard')
                ->with('error', 'Anda belum memiliki tenant.');
        }

        $validated = $request->validate([
            'status' => 'nullable|in:pending,diproses,selesai,dibatalkan,all',
            'from' => 'nullable|date',
            'to' => 'nullable|date'
        ]);

        $query = $tenant->orders()
            ->with(['user', 'orderItems.menu'])
            ->latest();

        if (!empty($validated['status']) && $validated['status'] !== 'all') {
            $query->where('status', $validated['status']);
        }

        if (!empty($validated['from'])) {
            $query->whereDate('created_at', '>=', $validated['from']);
        }

        if (!empty($validated['to'])) {
            $query->whereDate('created_at', '<=', $validated['to']);
        }

        $orders = $query->paginate(15)->withQueryString(); // 15 orders per page for better management

        return view('tenant.orders', compact('tenant', 'orders'));
    }

    /**
     * Display detailed dashboard with stats
     */
    public function detailedDashboard()
    {
        $tenant = Auth::user()->tenant;

        if (!$tenant) {
            return redirect()->route('dashboard')
                ->with('error', 'Anda belum memiliki tenant.');
        }

        // Optimized: Get all stats in single queries with caching
        $menuStats = $tenant->menus()
            ->selectRaw('
                COUNT(*) as total_menus,
                COUNT(CASE WHEN is_available = 1 THEN 1 END) as active_menus,
                COUNT(CASE WHEN stok = 0 THEN 1 END) as out_of_stock
            ')
            ->first();

        $orderStats = $tenant->orders()
            ->selectRaw('
                COUNT(*) as total_orders,
                COUNT(CASE WHEN status = "pending" THEN 1 END) as pending_orders,
                COUNT(CASE WHEN status = "selesai" THEN 1 END) as completed_orders,
                COALESCE(SUM(CASE WHEN DATE(created_at) = CURDATE() THEN total_harga END), 0) as today_income,
                COALESCE(SUM(CASE WHEN MONTH(created_at) = MONTH(NOW()) AND YEAR(created_at) = YEAR(NOW()) THEN total_harga END), 0) as monthly_income
            ')
            ->first();

        $stats = [
            'total_menus' => $menuStats->total_menus ?? 0,
            'active_menus' => $menuStats->active_menus ?? 0,
            'out_of_stock' => $menuStats->out_of_stock ?? 0,
            'total_orders' => $orderStats->total_orders ?? 0,
            'pending_orders' => $orderStats->pending_orders ?? 0,
            'completed_orders' => $orderStats->completed_orders ?? 0,
            'today_income' => $orderStats->today_income ?? 0,
            'monthly_income' => $orderStats->monthly_income ?? 0
        ];

        return view('tenant.detailed-dashboard', compact('tenant', 'stats'));
    }

    /**
     * Update order status
     */
    public function updateOrderStatus(Order $order, Request $request)
    {
        $request->validate(['status' => 'required|in:pending,diproses,selesai,dibatalkan']);
        
        // Validasi ownership
        if ($order->tenant_id !== Auth::user()->tenant->id) {
            return back()->with('error', 'Akses ditolak.');
        }
        
        $previousStatus = $order->status;
        $newStatus = $request->status;

        // Hanya update & kirim notifikasi jika benar-benar berubah
        if ($previousStatus === $newStatus) {
            return back()->with('info', 'Status pesanan tidak berubah.');
        }

        $order->update(['status' => $newStatus]);
        
        // Notify customer about status change
        if ($order->user) {
            try {
                $order->user->notify(new \App\Notifications\OrderStatusChanged($order, $previousStatus, $newStatus));
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Failed to notify customer for order ' . $order->id . ': ' . $e->getMessage());
            }
        }

        return back()->with('success', 'Status pesanan berhasil diupdate dari ' . $previousStatus . ' ke ' . $newStatus . '.');
    }

    /**
     * Display reports and analytics
     */
    public function reports()
    {
        $tenant = Auth::user()->tenant;
        
        $reports = [
            'daily_sales' => $tenant->orders()
                ->whereDate('created_at', today())
                ->selectRaw('DATE(created_at) as date, SUM(total_harga) as total')
                ->groupBy('date')
                ->get(),
                
            'top_menus' => $tenant->menus()
                ->withCount(['orderItems as total_sold' => function($query) {
                    $query->select(DB::raw('COALESCE(SUM(quantity), 0)'));
                }])
                ->orderBy('total_sold', 'desc')
                ->limit(10)
                ->get(),
                
            'monthly_income' => $tenant->orders()
                ->whereYear('created_at', now()->year)
                ->selectRaw('MONTH(created_at) as month, SUM(total_harga) as total')
                ->groupBy('month')
                ->get()
        ];
        
        return view('tenant.reports', compact('tenant', 'reports'));
    }

    /**
     * Display tenant settings
     */
    public function settings()
    {
        $tenant = Auth::user()->tenant;
        return view('tenant.settings', compact('tenant'));
    }

    /**
     * Update tenant settings
     */
    public function updateSettings(Request $request)
    {
        $tenant = Auth::user()->tenant;
        
        $data = $request->validate([
            'nama_tenant' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'no_telepon' => 'nullable|string|max:20',
            'is_active' => 'sometimes|boolean'
        ]);
        
        $tenant->update($data);
        
        return back()->with('success', 'Settings berhasil diupdate.');
    }
}