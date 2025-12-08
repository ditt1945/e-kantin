<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerDashboardController extends Controller
{
    /**
     * Dashboard khusus untuk customer
     */
    public function index()
    {
        try {
            $user = Auth::user();
            
            // Data untuk customer dashboard
            $stats = [
                'total_orders' => $user->orders()->count(),
                'pending_orders' => $user->orders()->where('status', 'pending')->count(),
                'completed_orders' => $user->orders()->where('status', 'selesai')->count(),
                'today_spending' => $user->orders()
                    ->whereDate('created_at', today())
                    ->where('status', 'selesai')
                    ->sum('total_harga'),
                'monthly_spending' => $user->orders()
                    ->whereMonth('created_at', now()->month)
                    ->where('status', 'selesai')
                    ->sum('total_harga')
            ];

            // Pesanan terbaru customer
            $recent_orders = $user->orders()
                ->with('tenant')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();

            // Tenant favorit (berdasarkan jumlah order)
            $favorite_tenants = Tenant::whereHas('orders', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->withCount(['orders as order_count' => function($query) use ($user) {
                $query->where('user_id', $user->id);
            }])
            ->orderBy('order_count', 'desc')
            ->limit(3)
            ->get();

            return view('customer.dashboard', compact('stats', 'recent_orders', 'favorite_tenants'));
        } catch (\Exception $e) {
            \Log::error('Customer Dashboard Error: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'Error loading dashboard: ' . $e->getMessage());
        }
    }
}