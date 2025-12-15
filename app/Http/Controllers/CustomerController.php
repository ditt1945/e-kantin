<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\Menu;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Notifications\NewOrderForTenant;
use App\Http\Requests\UpdateCartItemRequest;
use App\Rules\SufficientStock;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function showTenants()
    {
        $tenants = Tenant::withCount('menus')
            ->where('is_active', true)
            ->paginate(9); // Show 9 tenants per page (3x3 grid)
        return view('customer.tenants', compact('tenants'));
    }

    public function showMenus(Tenant $tenant)
    {
        $menus = $tenant->menus()
            ->with('category')
            ->where('is_available', true)
            ->paginate(12); // Show 12 menus per page

        return view('customer.menus', compact('tenant', 'menus'));
    }

    public function addToCart(Request $request, Tenant $tenant, Menu $menu)
    {
        $request->validate([
            'quantity' => ['required', 'integer', 'min:1', new SufficientStock($menu->id)]
        ]);

        // Pastikan menu yang dipilih memang milik tenant pada URL
        if ($menu->tenant_id !== $tenant->id) {
            abort(404);
        }

        $user = Auth::user();

        // Cari atau buat cart untuk user dan tenant ini
        $cart = Cart::firstOrCreate(
            [
                'user_id' => $user->id,
                'tenant_id' => $tenant->id
            ],
            [
                'total_harga' => 0
            ]
        );

        // Cari item di cart, jika ada update quantity, jika tidak buat baru
        $cartItem = CartItem::firstOrNew(
            [
                'cart_id' => $cart->id,
                'menu_id' => $menu->id
            ]
        );

        $newQuantity = $cartItem->exists ? $cartItem->quantity + $request->quantity : $request->quantity;

        // Validasi total quantity tidak melebihi stok
        if ($newQuantity > $menu->stok) {
            return back()->with('error', 'Total quantity melebihi stok! Stok tersedia: ' . $menu->stok);
        }

        if ($cartItem->exists) {
            $cartItem->quantity = $newQuantity;
        } else {
            $cartItem->quantity = $request->quantity;
            $cartItem->harga = $menu->harga;
        }

        $cartItem->save();

        return back()->with('success', 'Menu berhasil ditambahkan ke keranjang!');
    }

    public function showCart()
    {
        $user = Auth::user();
        $carts = Cart::with(['tenant', 'items.menu'])
            ->where('user_id', $user->id)
            ->get();

        $stockWarnings = $this->synchronizeCartStock($carts);

        if (!empty($stockWarnings)) {
            $carts = Cart::with(['tenant', 'items.menu'])
                ->where('user_id', $user->id)
                ->get();
        }

        return view('customer.cart', [
            'carts' => $carts,
            'stockWarnings' => $stockWarnings,
        ]);
    }

    public function updateCartItem(UpdateCartItemRequest $request, CartItem $cartItem)
    {
        if ($cartItem->cart->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        // Validasi stok real-time agar tidak melebihi persediaan
        $menu = $cartItem->menu;

        if (!$menu) {
            $cartItem->delete();
            return back()->with('error', 'Menu tidak tersedia lagi dan telah dihapus dari keranjang.');
        }

        if ($menu->stok === 0) {
            return back()->with('error', 'Stok untuk menu ini habis. Silakan hapus dari keranjang.');
        }

        if ($request->quantity > $menu->stok) {
            return back()->with('error', 'Quantity melebihi stok! Stok tersedia: ' . $menu->stok);
        }

        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        return back()->with('success', 'Keranjang berhasil diupdate!');
    }

    public function removeCartItem(CartItem $cartItem)
    {
        if ($cartItem->cart->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        $cartItem->delete();
        return back()->with('success', 'Item berhasil dihapus dari keranjang!');
    }

    public function checkout(Cart $cart)
    {
        // Validasi ownership cart
        if ($cart->user_id !== Auth::id()) {
            return back()->with('error', 'Akses ditolak.');
        }

        $cart->loadMissing(['items.menu', 'tenant']);

        if ($cart->items->isEmpty()) {
            return back()->with('error', 'Keranjang kosong.');
        }

        // Validasi stok sebelum checkout
        foreach ($cart->items as $item) {
            $menu = $item->menu;
            if (!$menu) {
                return back()->with('error', "Menu tidak ditemukan!");
            }
            if ($menu->stok < $item->quantity) {
                return back()->with('error', "Stok {$menu->nama_menu} tidak cukup! Tersedia: {$menu->stok}");
            }
        }

        try {
            $order = $this->processCheckout($cart);
            $this->notifyTenantOwner($order);

            return redirect()->route('payment.show', $order)
                ->with('success', 'Pesanan berhasil dibuat! Lanjutkan pembayaran melalui Midtrans untuk kode ' . $order->kode_pesanan . '.');
        } catch (\App\Exceptions\InsufficientStockException $e) {
            Log::warning('Checkout gagal - stok tidak cukup: ' . $e->getMessage());
            return back()->with('error', $e->getMessage());
        } catch (\RuntimeException $e) {
            Log::warning('Checkout gagal - runtime: ' . $e->getMessage());
            return back()->with('error', $e->getMessage());
        } catch (\Exception $e) {
            Log::error('Checkout gagal: ' . $e->getMessage() . ' | Trace: ' . $e->getTraceAsString());
            return back()->with('error', 'Terjadi kesalahan saat membuat pesanan. Silakan coba lagi.');
        }
    }

    /**
     * Process checkout transaction
     */
    private function processCheckout(Cart $cart): Order
    {
        return DB::transaction(function () use ($cart) {
            $order = $this->createOrder($cart);
            $totalHarga = $this->processOrderItems($order, $cart);
            $this->finalizeOrder($order, $totalHarga);
            $this->cleanupCart($cart);

            return $order;
        });
    }

    /**
     * Create new order
     */
    private function createOrder(Cart $cart): Order
    {
        return Order::create([
            'tenant_id' => $cart->tenant_id,
            'user_id' => Auth::id(),
            'total_harga' => 0,
            'status' => Order::STATUS_PENDING,
        ]);
    }

    /**
     * Process order items and calculate total
     */
    private function processOrderItems(Order $order, Cart $cart): float
    {
        $totalHarga = 0;

        foreach ($cart->items as $cartItem) {
            $menu = $this->validateAndReserveStock($cartItem, $cart);
            $orderItem = $this->createOrderItem($order, $cartItem, $menu);
            $totalHarga += $orderItem->subtotal;
        }

        return $totalHarga;
    }

    /**
     * Validate menu and reserve stock
     */
    private function validateAndReserveStock(CartItem $cartItem, Cart $cart): Menu
    {
        $menu = Menu::whereKey($cartItem->menu_id)->lockForUpdate()->first();

        if (!$menu || $menu->tenant_id !== $cart->tenant_id) {
            throw new \RuntimeException('Menu tidak valid untuk tenant ini.');
        }

        $menu->decreaseStockOrFail($cartItem->quantity);

        return $menu;
    }

    /**
     * Create order item
     */
    private function createOrderItem(Order $order, CartItem $cartItem, Menu $menu): OrderItem
    {
        return OrderItem::create([
            'order_id' => $order->id,
            'menu_id' => $cartItem->menu_id,
            'quantity' => $cartItem->quantity,
            'harga' => $cartItem->harga,
            'subtotal' => $cartItem->quantity * $cartItem->harga
        ]);
    }

    /**
     * Finalize order with total price
     */
    private function finalizeOrder(Order $order, float $totalHarga): void
    {
        $order->update(['total_harga' => $totalHarga]);
    }

    /**
     * Clean up cart after successful checkout
     */
    private function cleanupCart(Cart $cart): void
    {
        $cart->items()->delete();
        $cart->delete();
    }

    /**
     * Notify tenant owner about new order
     */
    private function notifyTenantOwner(Order $order): void
    {
        $tenantOwner = User::where('tenant_id', $order->tenant_id)
            ->where('role', 'tenant_owner')
            ->first();

        if ($tenantOwner) {
            try {
                $tenantOwner->notify(new NewOrderForTenant($order));
            } catch (\Exception $e) {
                Log::error('Failed to notify tenant owner for order ' . $order->id . ': ' . $e->getMessage());
            }
        }
    }

    private function synchronizeCartStock($carts): array
    {
        $warnings = [];

        foreach ($carts as $cart) {
            foreach ($cart->items as $item) {
                $menu = $item->menu;
                $menuName = $menu->nama_menu ?? 'Menu';

                if (!$menu || $menu->stok <= 0) {
                    $item->delete();
                    $warnings[] = $menu ? "$menuName dihapus karena stok habis." : 'Item dihapus karena menu tidak tersedia.';
                    continue;
                }

                if ($item->quantity > $menu->stok) {
                    $item->quantity = $menu->stok;
                    $item->save();
                    $warnings[] = "$menuName disesuaikan menjadi {$menu->stok} karena stok terbatas.";
                }
            }

            if ($cart->items()->count() === 0) {
                $cart->delete();
            }
        }

        return $warnings;
    }

    /**
     * Show account settings form for customer
     */
    public function account()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        return view('customer.account', compact('user'));
    }

    /**
     * Update customer account
     */
    public function updateAccount(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|confirmed|min:6'
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Show customer order history
     */
    public function ordersHistory(MidtransService $midtransService)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $orders = $user->orders()->with('tenant', 'orderItems.menu', 'payment')->latest()->paginate(10);
        
        // Auto-check payment status for pending payments from Midtrans
        foreach ($orders as $order) {
            if ($order->payment && $order->payment->isPending()) {
                try {
                    $midtransService->checkAndUpdateStatus($order->payment);
                    // Reload the payment to get updated status
                    $order->payment->refresh();
                } catch (\Exception $e) {
                    Log::warning('Failed to check payment status for order ' . $order->id . ': ' . $e->getMessage());
                }
            }
        }
        
        return view('customer.orders', compact('orders'));
    }

    /**
     * Cancel an order (customer action)
     */
    public function cancelOrder(Order $order)
    {
        $user = Auth::user();

        // Ownership check
        if ($order->user_id !== $user->id) {
            return back()->with('error', 'Akses ditolak.');
        }

        // Only allow cancel if still pending
        if ($order->status !== 'pending') {
            return back()->with('error', 'Pesanan tidak bisa dibatalkan jika sudah diproses.');
        }

        $order->status = 'dibatalkan';
        $order->save();

        return back()->with('success', 'Pesanan berhasil dibatalkan.');
    }
}