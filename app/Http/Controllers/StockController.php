<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockController extends Controller
{
    /**
     * Display stock management page for tenant owner
     */
    public function index()
    {
        // Dapatkan tenant milik user yang login
        $tenant = Auth::user()->tenant;
        
        if (!$tenant) {
            return redirect()->route('tenant.dashboard')
                ->with('error', 'Anda belum memiliki tenant.');
        }

        // Dapatkan menu milik tenant ini saja
        $menus = $tenant->menus()->with('category')->get();

        return view('tenant.stocks.index', compact('menus', 'tenant'));
    }

    /**
     * Update stock for a menu
     */
    public function update(Request $request, Menu $menu)
    {
        // Authorization: pastikan menu milik tenant user yang login
        $tenant = Auth::user()->tenant;
        
        if (!$tenant || $menu->tenant_id !== $tenant->id) {
            return redirect()->back()
                ->with('error', 'Anda tidak memiliki akses untuk mengedit menu ini.');
        }

        // Validasi
        $request->validate([
            'stock' => 'required|integer|min:0'
        ]);

        // Update stok - PERHATIAN: kolom di database adalah 'stok' (Indonesia)
        $menu->update([
            'stok' => $request->stock
        ]);

        return redirect()->route('tenant.stocks.index')
            ->with('success', 'Stok ' . $menu->nama_menu . ' berhasil diperbarui!');
    }
}