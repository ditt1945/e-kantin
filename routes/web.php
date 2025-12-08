<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerDashboardController;
use App\Http\Controllers\TenantDashboardController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\TenantMenuController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Admin\TenantController as AdminTenantController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\MenuController as AdminMenuController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\NotificationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Public routes
Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        return match ($user->role) {
            'customer' => redirect()->route('customer.dashboard'),
            'tenant_owner' => redirect()->route('tenant.dashboard'),
            'admin' => redirect()->route('dashboard'),
            default => redirect()->route('login'),
        };
    }
    return redirect()->route('login');
});

// Auth Routes untuk guest
Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

// Midtrans Webhook (public - no auth)
Route::post('/api/payment/callback', [PaymentController::class, 'callback'])->withoutMiddleware(['VerifyCsrfToken'])->name('payment.callback');

// Auth Routes untuk semua user yang login
Route::middleware('auth')->group(function () {
    // FIXED LOGOUT ROUTE
    Route::post('/logout', function (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('success', 'Berhasil logout!');
    })->name('logout');
    
    // Home untuk redirect berdasarkan role
    Route::get('/home', [DashboardController::class, 'redirectBasedOnRole'])->name('home');
    
    // Dashboard biasa (tanpa redirect) - khusus admin
    Route::middleware('admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // Admin routes - production ready
        Route::get('/tenants', [AdminTenantController::class, 'index'])->name('tenants.index');
        Route::get('/tenants/create', [AdminTenantController::class, 'create'])->name('tenants.create');
        Route::post('/tenants', [AdminTenantController::class, 'store'])->name('tenants.store');
        Route::get('/tenants/{tenant}/edit', [AdminTenantController::class, 'edit'])->name('tenants.edit');
        Route::put('/tenants/{tenant}', [AdminTenantController::class, 'update'])->name('tenants.update');
        Route::delete('/tenants/{tenant}', [AdminTenantController::class, 'destroy'])->name('tenants.destroy');

        Route::get('/categories', [AdminCategoryController::class, 'index'])->name('categories.index');
        Route::post('/categories', [AdminCategoryController::class, 'store'])->name('categories.store');
        Route::put('/categories/{category}', [AdminCategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{category}', [AdminCategoryController::class, 'destroy'])->name('categories.destroy');

        Route::get('/menus', [AdminMenuController::class, 'index'])->name('menus.index');

        Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');

        Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
        Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
    });
    
    // Routes untuk CUSTOMER
    Route::middleware('customer')->prefix('customer')->group(function () {
        // ✅ DASHBOARD CUSTOMER
        Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('customer.dashboard');
        
        Route::get('/tenants', [CustomerController::class, 'showTenants'])->name('customer.tenants');
        // Account settings and order history for customer
        Route::get('/account', [CustomerController::class, 'account'])->name('customer.account');
        Route::put('/account', [CustomerController::class, 'updateAccount'])->name('customer.account.update');
        Route::get('/orders', [CustomerController::class, 'ordersHistory'])->name('customer.orders');
        Route::put('/orders/{order}/cancel', [CustomerController::class, 'cancelOrder'])->name('customer.orders.cancel');
        Route::get('/tenant/{tenant}/menus', [CustomerController::class, 'showMenus'])->name('customer.menus');
        Route::post('/tenant/{tenant}/menu/{menu}/add-to-cart', [CustomerController::class, 'addToCart'])->name('customer.add_to_cart');
        Route::get('/cart', [CustomerController::class, 'showCart'])->name('customer.cart');
        Route::put('/cart/item/{cartItem}', [CustomerController::class, 'updateCartItem'])->name('customer.update_cart_item');
        Route::delete('/cart/item/{cartItem}', [CustomerController::class, 'removeCartItem'])->name('customer.remove_cart_item');
        Route::post('/cart/{cart}/checkout', [CustomerController::class, 'checkout'])->name('customer.checkout');
        
        // Payment routes
        Route::get('/payment/{order}', [PaymentController::class, 'show'])->name('payment.show');
        Route::post('/payment/{order}/voucher', [PaymentController::class, 'applyVoucher'])->name('payment.voucher.apply');
        Route::delete('/payment/{order}/voucher', [PaymentController::class, 'removeVoucher'])->name('payment.voucher.remove');
        Route::get('/payment/{order}/verify', [PaymentController::class, 'verify'])->name('payment.verify');
        Route::post('/payment/{order}/cash', [PaymentController::class, 'payCash'])->name('payment.cash');
        Route::get('/payment/{payment}/check-status', [PaymentController::class, 'checkStatus'])->name('payment.check_status');
        Route::get('/payment-history', [PaymentController::class, 'history'])->name('payment.history');
        Route::get('/payment/{payment}/invoice', [PaymentController::class, 'downloadInvoice'])->name('payment.invoice');
    });

    // Notifications (global for authenticated users)
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllRead'])->name('notifications.mark_all_read');
    
    // Routes untuk TENANT OWNER
    Route::middleware('tenant_owner')->prefix('tenant')->group(function () {
        // Dashboard
        Route::get('/dashboard', [TenantDashboardController::class, 'index'])->name('tenant.dashboard');
        Route::get('/detailed-dashboard', [TenantDashboardController::class, 'detailedDashboard'])->name('tenant.detailed_dashboard');
        
        // Orders
        Route::get('/orders', [TenantDashboardController::class, 'orders'])->name('tenant.orders');
        Route::put('/orders/{order}/status', [TenantDashboardController::class, 'updateOrderStatus'])->name('tenant.orders.update_status');
        Route::post('/orders/{order}/confirm-cash', [PaymentController::class, 'confirmCashPayment'])->name('tenant.orders.confirm_cash');
            
        // Stocks Management
        Route::get('/stocks', [StockController::class, 'index'])->name('tenant.stocks.index');
        Route::put('/stocks/{menu}', [StockController::class, 'update'])->name('tenant.stocks.update');
        
        // Menu Management
        Route::get('/menus', [TenantMenuController::class, 'index'])->name('tenant.menus.index');
        Route::get('/menus/create', [TenantMenuController::class, 'create'])->name('tenant.menus.create');
        Route::post('/menus', [TenantMenuController::class, 'store'])->name('tenant.menus.store');
        Route::get('/menus/{menu}/edit', [TenantMenuController::class, 'edit'])->name('tenant.menus.edit');
        Route::put('/menus/{menu}', [TenantMenuController::class, 'update'])->name('tenant.menus.update');
        Route::delete('/menus/{menu}', [TenantMenuController::class, 'destroy'])->name('tenant.menus.destroy');
        
        // Reports & Analytics
        Route::get('/reports', [TenantDashboardController::class, 'reports'])->name('tenant.reports');
        
        // Settings
        Route::get('/settings', [TenantDashboardController::class, 'settings'])->name('tenant.settings');
        Route::put('/settings', [TenantDashboardController::class, 'updateSettings'])->name('tenant.settings.update');
    });
});
