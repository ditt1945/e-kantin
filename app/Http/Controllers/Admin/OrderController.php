<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Tenant;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['tenant', 'user'])->latest();

        if ($request->filled('tenant_id')) {
            $query->where('tenant_id', $request->tenant_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->paginate(15)->withQueryString();
        $tenants = Tenant::orderBy('nama_tenant')->get();

        return view('admin.orders.index', compact('orders', 'tenants'));
    }

    public function show(Order $order)
    {
        $order->load(['tenant', 'user', 'orderItems.menu', 'payment']);

        return view('admin.orders.show', compact('order'));
    }
}
