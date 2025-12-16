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

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|string|in:pending,diproses,selesai,dibatalkan,pending_cash'
        ]);

        $order->update(['status' => $request->status]);

        return back()->with('success', 'Status pesanan berhasil diperbarui');
    }

    public function export(Request $request)
    {
        $query = Order::with(['tenant', 'user']);

        if ($request->filled('tenant_id')) {
            $query->where('tenant_id', $request->tenant_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $orders = $query->latest()->get();

        $filename = 'orders_export_' . date('Y-m-d_H-i-s') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($orders) {
            $file = fopen('php://output', 'w');

            fputcsv($file, ['Kode Pesanan', 'Tenant', 'Pelanggan', 'Total', 'Status', 'Tanggal']);

            foreach ($orders as $order) {
                fputcsv($file, [
                    $order->kode_pesanan ?? $order->id,
                    $order->tenant->nama_tenant ?? 'N/A',
                    $order->user->name ?? 'N/A',
                    $order->total_harga,
                    $order->status,
                    $order->created_at->format('d M Y H:i')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
