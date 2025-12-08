<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Models\User;
use App\Services\MidtransService;
use App\Services\VoucherService;
use App\Notifications\OrderStatusChanged;
use App\Notifications\NewOrderForTenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class PaymentController extends Controller
{
    public function __construct(
        private MidtransService $midtransService,
        private VoucherService $voucherService
    ){}

    /**
     * Show payment page
     */
    public function show(Order $order)
    {
        $this->ensureOrderOwner($order);

        $order->loadMissing(['orderItems.menu', 'tenant', 'payment']);

        // Check if order already paid
        if ($order->payment?->isPaid()) {
            return redirect()->route('customer.orders')->with('info', 'Pesanan sudah lunas');
        }

        $payment = $this->getOrCreatePayment($order);

        // Ensure payment amount respects discount
        if ($payment->discount_amount > 0) {
            $netAmount = max(0, $order->total_harga - $payment->discount_amount);
            if ((int) $payment->amount !== $netAmount) {
                $payment->update(['amount' => $netAmount]);
            }
        }

        $order->setRelation('payment', $payment);

        try {
            $transactionData = $this->midtransService->createTransaction($order);
        } catch (\RuntimeException $e) {
            Log::error('Midtrans transaction failed for order ' . $order->id . ': ' . $e->getMessage());
            return redirect()->route('customer.orders')->with('error', 'Gagal memulai pembayaran. Silakan coba lagi.');
        }

        return view('customer.payment', [
            'order' => $order,
            'payment' => $payment,
            'snapToken' => $transactionData['snap_token'] ?? null,
            'clientKey' => $transactionData['client_key'] ?? config('services.midtrans.client_key'),
            'redirectUrl' => $transactionData['redirect_url'] ?? null,
        ]);
    }

    public function applyVoucher(Request $request, Order $order)
    {
        $this->ensureOrderOwner($order);

        $request->validate([
            'voucher_code' => ['required', 'string', 'max:20'],
        ]);

        $payment = $this->getOrCreatePayment($order);

        try {
            $voucher = $this->voucherService->apply($request->input('voucher_code'), $order);
        } catch (\InvalidArgumentException $e) {
            return redirect()->route('payment.show', $order)->withInput()->with('error', $e->getMessage());
        }

        $payment->update([
            'voucher_code' => $voucher['code'],
            'discount_amount' => $voucher['discount'],
            'voucher_details' => ['description' => $voucher['description'] ?? null],
            'amount' => max(0, $order->total_harga - $voucher['discount']),
        ]);

        $this->regenerateInvoiceNumber($payment);

        return redirect()->route('payment.show', $order)->with('success', 'Voucher berhasil diterapkan.');
    }

    public function removeVoucher(Order $order)
    {
        $this->ensureOrderOwner($order);

        $payment = $order->payment;
        if ($payment) {
            $payment->update([
                'voucher_code' => null,
                'discount_amount' => 0,
                'voucher_details' => null,
                'amount' => $order->total_harga,
            ]);
            $this->regenerateInvoiceNumber($payment);
        }

        return redirect()->route('payment.show', $order)->with('info', 'Voucher dibatalkan.');
    }

    /**
     * Handle Midtrans callback (webhook)
     */
    public function callback(Request $request)
    {
        $payload = $request->all();

        Log::info('Midtrans Callback Received', [
            'order_id' => $payload['order_id'] ?? 'unknown',
            'transaction_status' => $payload['transaction_status'] ?? 'unknown',
            'payment_type' => $payload['payment_type'] ?? 'unknown',
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        try {
            $this->validateCallbackPayload($payload);
            $processed = $this->midtransService->processCallback($payload);

            if (!$processed) {
                $this->logCallbackFailure($payload, 'signature verification failed or payment not found');
                return response()->json(['status' => 'error', 'message' => 'Verification failed'], 400);
            }

            $this->handleSuccessfulPayment($payload);

            Log::info('Payment callback processed successfully', [
                'order_id' => $payload['order_id'],
                'transaction_status' => $payload['transaction_status']
            ]);

            return response()->json(['status' => 'success'], 200);

        } catch (\Exception $e) {
            $this->logCallbackError($payload, $e);
            return response()->json(['status' => 'error', 'message' => 'Internal server error'], 500);
        }
    }

    /**
     * Validate callback payload
     */
    private function validateCallbackPayload(array $payload): void
    {
        if (empty($payload['order_id'])) {
            throw new \InvalidArgumentException('Missing order_id in callback payload');
        }
    }

    /**
     * Log callback failure
     */
    private function logCallbackFailure(array $payload, string $reason): void
    {
        Log::warning('Payment callback verification failed', [
            'order_id' => $payload['order_id'],
            'reason' => $reason
        ]);
    }

    /**
     * Handle successful payment processing
     */
    private function handleSuccessfulPayment(array $payload): void
    {
        $payment = Payment::where('invoice_number', $payload['order_id'])
            ->with('order.tenant')
            ->first();

        if ($payment && in_array($payload['transaction_status'], ['capture', 'settlement'])) {
            $this->notifyPaymentSuccess($payment);
        }
    }

    /**
     * Send notifications for successful payment
     */
    private function notifyPaymentSuccess(Payment $payment): void
    {
        // Notify customer
        try {
            $payment->order->user->notify(new OrderStatusChanged($payment->order, 'pending', 'diproses'));
        } catch (\Exception $e) {
            Log::error('Failed to notify customer for payment ' . $payment->id . ': ' . $e->getMessage());
        }

        // Notify tenant owner
        try {
            $tenantOwner = User::where('tenant_id', $payment->order->tenant_id)
                ->where('role', 'tenant_owner')
                ->first();
            if ($tenantOwner) {
                $tenantOwner->notify(new NewOrderForTenant($payment->order));
            }
        } catch (\Exception $e) {
            Log::error('Failed to notify tenant owner for payment ' . $payment->id . ': ' . $e->getMessage());
        }
    }

    /**
     * Log callback processing error
     */
    private function logCallbackError(array $payload, \Exception $e): void
    {
        Log::error('Payment callback processing error', [
            'order_id' => $payload['order_id'] ?? 'unknown',
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
    }

    /**
     * Manual payment verification - checks directly with Midtrans API
     */
    public function verify(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            return redirect()->route('customer.orders')->with('error', 'Akses ditolak');
        }

        $payment = $order->payment;

        if (!$payment) {
            return redirect()->route('customer.orders')->with('error', 'Pembayaran tidak ditemukan');
        }

        // Check status directly from Midtrans API and update local status
        $result = $this->midtransService->checkAndUpdateStatus($payment);

        if ($result['status'] === 'paid') {
            return redirect()->route('customer.orders')->with('success', 'Verifikasi berhasil! Pembayaran telah lunas. Pesanan Anda sedang diproses.');
        } elseif ($result['status'] === 'pending') {
            // Redirect to payment page so user can pay directly
            return redirect()->route('payment.show', $order)->with('info', 'Pembayaran belum selesai. Silakan lanjutkan pembayaran di bawah ini.');
        } elseif ($result['status'] === 'failed') {
            return redirect()->route('customer.orders')->with('error', 'Verifikasi gagal! Pembayaran gagal atau kadaluarsa. Silakan buat pesanan baru.');
        }

        return redirect()->route('customer.orders')->with('info', $result['message']);
    }
    
    /**
     * Check payment status via AJAX
     */
    public function checkStatus(Payment $payment)
    {
        if ($payment->order->user_id !== Auth::id()) {
            return response()->json(['error' => 'Akses ditolak'], 403);
        }
        
        $result = $this->midtransService->checkAndUpdateStatus($payment);
        $payment->refresh();
        
        return response()->json([
            'status' => $result['status'],
            'message' => $result['message'],
            'is_paid' => $payment->isPaid(),
            'payment_status' => $payment->status
        ]);
    }

    /**
     * List payment history for user
     */
    public function history()
    {
        $payments = Payment::whereHas('order', function ($query) {
            $query->where('user_id', Auth::id());
        })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('customer.payment-history', ['payments' => $payments]);
    }

    /**
     * Download invoice
     */
    public function downloadInvoice(Payment $payment)
    {
        // Verify ownership
        if ($payment->order->user_id !== Auth::id()) {
            return redirect()->route('customer.orders')->with('error', 'Akses ditolak');
        }

        // Generate PDF invoice (using barryvdh/laravel-dompdf if needed)
        $payment->loadMissing(['order.tenant', 'order.orderItems.menu', 'order.user']);

        $pdf = Pdf::loadView('pdf.invoice', [
            'payment' => $payment,
        ])->setPaper('a4');

        return $pdf->download($payment->invoice_number . '.pdf');
    }

    /**
     * Process cash payment selection
     */
    public function payCash(Order $order)
    {
        $this->ensureOrderOwner($order);

        $payment = $order->payment;

        if (!$payment) {
            return redirect()->route('customer.orders')->with('error', 'Pembayaran tidak ditemukan');
        }

        // Check if payment is already completed
        if ($payment->status === 'completed') {
            return redirect()->route('customer.orders')->with('info', 'Pembayaran sudah selesai');
        }

        // Update payment to pending_cash status
        $payment->update([
            'payment_method' => 'cash',
            'status' => 'pending_cash',
        ]);

        // Update order status to show it's waiting for cash payment
        $order->update([
            'status' => 'pending_cash',
        ]);

        Log::info('Cash payment initiated', [
            'order_id' => $order->id,
            'payment_id' => $payment->id,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('customer.orders')->with('success', 'Pesanan berhasil dikonfirmasi untuk pembayaran tunai. Silakan bayar di kantin ' . $order->tenant->nama_tenant);
    }

    /**
     * Tenant confirms cash payment received
     */
    public function confirmCashPayment(Order $order)
    {
        $user = Auth::user();
        
        // Verify tenant ownership
        if ($user->role !== 'tenant_owner' || $user->tenant_id !== $order->tenant_id) {
            return redirect()->back()->with('error', 'Akses ditolak');
        }

        $payment = $order->payment;

        if (!$payment || $payment->status !== 'pending_cash') {
            return redirect()->back()->with('error', 'Pembayaran tidak valid untuk dikonfirmasi');
        }

        // Mark payment as completed
        $payment->update([
            'status' => 'completed',
            'paid_at' => now(),
        ]);

        // Update order status
        $order->update([
            'status' => 'diproses',
        ]);

        // Notify customer
        try {
            $order->user->notify(new OrderStatusChanged($order, 'pending_cash', 'diproses'));
        } catch (\Exception $e) {
            Log::error('Failed to notify customer for cash payment confirmation: ' . $e->getMessage());
        }

        Log::info('Cash payment confirmed by tenant', [
            'order_id' => $order->id,
            'payment_id' => $payment->id,
            'tenant_id' => $user->tenant_id,
            'confirmed_by' => $user->id,
        ]);

        return redirect()->back()->with('success', 'Pembayaran tunai berhasil dikonfirmasi');
    }

    private function ensureOrderOwner(Order $order): void
    {
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak');
        }
    }

    private function getOrCreatePayment(Order $order): Payment
    {
        if ($order->payment) {
            return $order->payment;
        }

        return Payment::create([
            'order_id' => $order->id,
            'invoice_number' => $this->generateInvoiceNumber(),
            'amount' => $order->total_harga,
            'status' => 'pending',
            'payment_method' => 'midtrans',
        ]);
    }

    private function regenerateInvoiceNumber(Payment $payment): void
    {
        $payment->update([
            'invoice_number' => $this->generateInvoiceNumber(),
        ]);
    }

    private function generateInvoiceNumber(): string
    {
        return \App\Helpers\OrderHelper::generateInvoiceNumber();
    }
}
