<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PurchaseOrderController extends Controller
{
    // Middleware sudah dihandle di routes/web.php

    /**
     * Display listing of purchase orders.
     */
    public function index(Request $request)
    {
        $tenant = Auth::user()->tenant;

        if (!$tenant) {
            return redirect()->route('tenant.dashboard')->with('error', 'Tenant tidak ditemukan');
        }

        $query = $tenant->purchaseOrders()->with(['creator', 'items.menu']);

        // Apply status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Apply date range filter
        if ($request->filled('date_range')) {
            $days = (int) $request->date_range;
            $query->where('created_at', '>=', now()->subDays($days));
        }

        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('po_number', 'like', "%{$search}%")
                  ->orWhere('supplier_name', 'like', "%{$search}%");
            });
        }

        $purchaseOrders = $query->latest()->get();

        return view('tenant.po.index', compact('purchaseOrders', 'tenant'));
    }

    /**
     * Show the form for creating a new purchase order.
     */
    public function create()
    {
        $tenant = Auth::user()->tenant;

        if (!$tenant) {
            return redirect()->route('tenant.dashboard')->with('error', 'Tenant tidak ditemukan');
        }

        $menus = $tenant->menus()->orderBy('nama_menu')->get();

        return view('tenant.po.create', compact('menus', 'tenant'));
    }

    /**
     * Store a newly created purchase order in storage.
     */
    public function store(Request $request)
    {
        $tenant = Auth::user()->tenant;

        if (!$tenant) {
            return redirect()->route('tenant.dashboard')->with('error', 'Tenant tidak ditemukan');
        }

        try {
            DB::beginTransaction();

            $request->validate([
                'supplier_name' => 'required|string|max:255',
                'supplier_contact' => 'nullable|string|max:255',
                'order_date' => 'required|date',
                'expected_delivery_date' => 'required|date|after_or_equal:order_date',
                'total_amount' => 'required|numeric|min:0',
                'notes' => 'nullable|string',
                'items' => 'required|array|min:1',
                'items.*.name' => 'required|string|max:255',
                'items.*.quantity' => 'required|numeric|min:0.1',
                'items.*.price' => 'required|numeric|min:0',
                'items.*.notes' => 'nullable|string',
            ]);

            // Create Purchase Order
            $po = PurchaseOrder::create([
                'tenant_id' => $tenant->id,
                'supplier_name' => $request->supplier_name,
                'supplier_contact' => $request->supplier_contact,
                'po_number' => PurchaseOrder::generatePoNumber(),
                'order_date' => $request->order_date,
                'expected_delivery_date' => $request->expected_delivery_date,
                'status' => 'pending',
                'total_amount' => $request->total_amount,
                'notes' => $request->notes,
                'created_by' => Auth::id(),
            ]);

            // Create PO Items
            foreach ($request->items as $itemData) {
                PurchaseOrderItem::create([
                    'purchase_order_id' => $po->id,
                    'menu_id' => $itemData['menu_id'] ?? null,
                    'item_name' => $itemData['name'],
                    'quantity' => $itemData['quantity'],
                    'unit_price' => $itemData['price'],
                    'total_price' => $itemData['quantity'] * $itemData['price'],
                    'notes' => $itemData['notes'] ?? null,
                ]);
            }

            DB::commit();

            return redirect()->route('tenant.po.show', $po)
                ->with('success', 'Purchase Order berhasil dibuat');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating PO: ' . $e->getMessage());

            return back()->with('error', 'Gagal membuat Purchase Order: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified purchase order.
     */
    public function show(PurchaseOrder $po)
    {
        $this->authorize('view', $po);

        $po->load(['creator', 'items.menu']);

        return view('tenant.po.show', compact('po'));
    }

    /**
     * Show the form for editing the specified purchase order.
     */
    public function edit(PurchaseOrder $po)
    {
        $this->authorize('update', $po);

        if (!$po->isModifiable()) {
            return back()->with('error', 'PO tidak dapat diedit pada status ini');
        }

        $po->load('items');
        $tenant = Auth::user()->tenant;
        $menus = $tenant->menus()->orderBy('nama_menu')->get();

        return view('tenant.po.edit', compact('po', 'menus', 'tenant'));
    }

    /**
     * Update the specified purchase order in storage.
     */
    public function update(Request $request, PurchaseOrder $po)
    {
        $this->authorize('update', $po);

        if (!$po->isModifiable()) {
            return back()->with('error', 'PO tidak dapat diupdate pada status ini');
        }

        $request->validate([
            'supplier_name' => 'required|string|max:255',
            'supplier_contact' => 'nullable|string|max:255',
            'expected_delivery_date' => 'required|date|after_or_equal:order_date',
            'total_amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.name' => 'required|string|max:255',
            'items.*.quantity' => 'required|numeric|min:0.1',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.notes' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            // Update PO
            $po->update([
                'supplier_name' => $request->supplier_name,
                'supplier_contact' => $request->supplier_contact,
                'expected_delivery_date' => $request->expected_delivery_date,
                'total_amount' => $request->total_amount,
                'notes' => $request->notes,
            ]);

            // Delete existing items and create new ones
            $po->items()->delete();

            foreach ($request->items as $itemData) {
                PurchaseOrderItem::create([
                    'purchase_order_id' => $po->id,
                    'menu_id' => $itemData['menu_id'] ?? null,
                    'item_name' => $itemData['name'],
                    'quantity' => $itemData['quantity'],
                    'unit_price' => $itemData['price'],
                    'total_price' => $itemData['quantity'] * $itemData['price'],
                    'notes' => $itemData['notes'] ?? null,
                ]);
            }

            DB::commit();

            return redirect()->route('tenant.po.show', $po)
                ->with('success', 'Purchase Order berhasil diupdate');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating PO: ' . $e->getMessage());

            return back()->with('error', 'Gagal update Purchase Order: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Confirm purchase order.
     */
    public function confirm(PurchaseOrder $po)
    {
        $this->authorize('update', $po);

        if ($po->status !== 'pending') {
            return back()->with('error', 'PO tidak dapat dikonfirmasi pada status ini');
        }

        try {
            $po->update(['status' => 'confirmed']);

            return back()->with('success', 'PO berhasil dikonfirmasi');
        } catch (\Exception $e) {
            Log::error('Error confirming PO: ' . $e->getMessage());
            return back()->with('error', 'Gagal konfirmasi PO');
        }
    }

    /**
     * Cancel purchase order.
     */
    public function cancel(PurchaseOrder $po)
    {
        $this->authorize('update', $po);

        if (!$po->isModifiable()) {
            return back()->with('error', 'PO tidak dapat dibatalkan pada status ini');
        }

        try {
            $po->update(['status' => 'cancelled']);

            return back()->with('success', 'PO berhasil dibatalkan');
        } catch (\Exception $e) {
            Log::error('Error cancelling PO: ' . $e->getMessage());
            return back()->with('error', 'Gagal batalkan PO');
        }
    }

    /**
     * Show receive items form.
     */
    public function receive(PurchaseOrder $po)
    {
        $this->authorize('update', $po);

        if ($po->status !== 'confirmed') {
            return back()->with('error', 'PO tidak dapat diterima pada status ini');
        }

        $po->load('items.menu');

        return view('tenant.po.receive', compact('po'));
    }

    /**
     * Process received items.
     */
    public function processReceive(Request $request, PurchaseOrder $po)
    {
        $this->authorize('update', $po);

        if ($po->status !== 'confirmed') {
            return back()->with('error', 'PO tidak dapat diterima pada status ini');
        }

        $request->validate([
            'received_quantities' => 'required|array',
            'received_quantities.*' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            $allReceived = true;
            $totalReceived = 0;

            foreach ($request->received_quantities as $itemId => $receivedQty) {
                $item = $po->items()->find($itemId);
                if ($item) {
                    $item->update(['received_quantity' => $receivedQty]);

                    // Update menu stock if item has menu_id
                    if ($item->menu_id) {
                        $menu = $item->menu;
                        $menu->increaseStock((int) $receivedQty);
                    }

                    if ($receivedQty < $item->quantity) {
                        $allReceived = false;
                    }
                    $totalReceived += $receivedQty;
                }
            }

            // Update PO status based on completion
            $status = $allReceived ? 'delivered' : 'confirmed';
            $po->update(['status' => $status]);

            DB::commit();

            $message = $allReceived
                ? 'Semua item berhasil diterima'
                : 'Sebagian item berhasil diterima';

            return redirect()->route('tenant.po.show', $po)
                ->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error processing PO receipt: ' . $e->getMessage());
            return back()->with('error', 'Gagal memproses penerimaan: ' . $e->getMessage());
        }
    }
}