<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\Menu;
use App\Models\Order;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    /**
     * Redirect pengguna berdasarkan role mereka
     */
    public function redirectBasedOnRole()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        return match ($user->role ?? null) {
            'customer' => redirect()->route('customer.dashboard'),
            'tenant_owner' => redirect()->route('tenant.dashboard'),
            'admin' => redirect()->route('dashboard'),
            default => redirect()->route('login')->with('error', 'Role pengguna tidak valid.'),
        };
    }

    /**
     * Tampilkan dashboard admin
     */
    public function index()
    {
        try {
            $totalTenants = Tenant::count();
            $totalCategories = Category::count();
            $totalMenus = Menu::count();
            $totalUsers = User::where('role', 'customer')->count();
            $totalOrders = Order::count();
            
            $pesananTerbaru = Order::with('tenant')
                ->latest()
                ->limit(5)
                ->get();

            return view('dashboard.index', compact(
                'totalTenants',
                'totalCategories',
                'totalMenus',
                'totalUsers',
                'totalOrders',
                'pesananTerbaru'
            ));
        } catch (\Exception $e) {
            Log::error('Error Dashboard Admin: ' . $e->getMessage() . ' | Baris: ' . $e->getLine());
            return back()->with('error', 'Gagal memuat dashboard admin: ' . $e->getMessage());
        }
    }
}