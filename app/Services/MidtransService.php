<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Payment;
use Midtrans\Config as MidtransConfig;
use Midtrans\Snap;
use Midtrans\Transaction;
use Illuminate\Support\Facades\Log;

class MidtransService
{
    private $serverKey;
    private $clientKey;
    private $environment;
    private $isProduction;
    private $merchantId;
    private $paymentTimeoutMinutes;

    public function __construct()
    {
        $this->serverKey = config('services.midtrans.server_key');
        $this->clientKey = config('services.midtrans.client_key');
        $this->environment = config('services.midtrans.environment', 'sandbox');
        $this->merchantId = config('services.midtrans.merchant_id');
        $this->isProduction = filter_var(config('services.midtrans.is_production', false), FILTER_VALIDATE_BOOL) || $this->environment === 'production';
        $this->paymentTimeoutMinutes = (int) env('PAYMENT_TIMEOUT_MINUTES', 30);

        MidtransConfig::$serverKey = $this->serverKey;
        MidtransConfig::$clientKey = $this->clientKey;
        MidtransConfig::$isProduction = $this->isProduction;
        MidtransConfig::$isSanitized = true;
        MidtransConfig::$is3ds = true;
    }

    /**
     * Check transaction status directly from Midtrans API
     * and update local payment status if needed
     */
    public function checkAndUpdateStatus(Payment $payment): array
    {
        try {
            $status = Transaction::status($payment->invoice_number);
            
            $transactionStatus = $status->transaction_status ?? 'unknown';
            $fraudStatus = $status->fraud_status ?? null;
            
            Log::info('Midtrans status check', [
                'invoice' => $payment->invoice_number,
                'status' => $transactionStatus,
                'fraud' => $fraudStatus
            ]);

            // Update local payment based on Midtrans status
            if (in_array($transactionStatus, ['capture', 'settlement'])) {
                if (!$payment->isPaid()) {
                    $payment->markAsPaid($status->transaction_id ?? null);
                    $payment->order->update(['status' => 'diproses']);
                }
                return ['status' => 'paid', 'message' => 'Pembayaran berhasil'];
            } elseif ($transactionStatus === 'pending') {
                $payment->update(['status' => 'pending']);
                return ['status' => 'pending', 'message' => 'Menunggu pembayaran'];
            } elseif (in_array($transactionStatus, ['deny', 'cancel', 'expire'])) {
                $payment->markAsFailed();
                $payment->order->update(['status' => 'dibatalkan']);
                return ['status' => 'failed', 'message' => 'Pembayaran gagal atau kadaluarsa'];
            }

            return ['status' => $transactionStatus, 'message' => 'Status: ' . $transactionStatus];
        } catch (\Exception $e) {
            Log::error('Failed to check Midtrans status', [
                'invoice' => $payment->invoice_number,
                'error' => $e->getMessage()
            ]);
            return ['status' => 'error', 'message' => 'Gagal mengecek status: ' . $e->getMessage()];
        }
    }

    /**
     * Create Midtrans transaction
     */
    public function createTransaction(Order $order): array
    {
        $order->loadMissing(['payment', 'orderItems.menu', 'user']);

        $payment = $order->payment ?? Payment::create([
            'order_id' => $order->id,
            'invoice_number' => \App\Helpers\OrderHelper::generateInvoiceNumber(),
            'amount' => $order->total_harga,
            'status' => 'pending',
            'payment_method' => 'midtrans',
        ]);

        $grossAmount = (int) ($payment->amount ?? $order->total_harga);

        $transactionDetails = [
            'order_id' => $payment->invoice_number,
            'gross_amount' => $grossAmount,
        ];

        $customerDetails = [
            'first_name' => $order->user->name,
            'email' => $order->user->email,
            'phone' => $order->user->phone ?? '',
        ];

        $items = $order->orderItems->map(function ($item) {
            return [
                'id' => $item->menu_id,
                'price' => (int) $item->harga,
                'quantity' => $item->quantity,
                'name' => $item->menu->nama_menu,
            ];
        })->toArray();

        if ($payment->discount_amount > 0) {
            $items[] = [
                'id' => 'DISC-' . ($payment->voucher_code ?? 'CUSTOM'),
                'price' => -(int) $payment->discount_amount,
                'quantity' => 1,
                'name' => 'Voucher ' . strtoupper($payment->voucher_code ?? 'Diskon'),
            ];
        }

        $payload = [
            'transaction_details' => $transactionDetails,
            'customer_details' => $customerDetails,
            'item_details' => $items,
            'callbacks' => [
                'finish' => route('payment.verify', $order),
            ],
            'expiry' => [
                'unit' => 'minutes',
                'duration' => $this->paymentTimeoutMinutes,
            ],
        ];

        try {
            $snapResponse = Snap::createTransaction($payload);
        } catch (\Exception $e) {
            throw new \RuntimeException('Gagal membuat transaksi Midtrans: ' . $e->getMessage(), 0, $e);
        }

        return [
            'invoice_number' => $payment->invoice_number,
            'amount' => $order->total_harga,
            'client_key' => $this->clientKey,
            'payload' => $payload,
            'snap_token' => $snapResponse->token ?? null,
            'redirect_url' => $snapResponse->redirect_url ?? null,
        ];
    }

    /**
     * Verify payment dari Midtrans callback
     */
    public function verifyPayment(array $data): bool
    {
        $requiredKeys = ['signature_key', 'order_id', 'status_code', 'gross_amount'];

        foreach ($requiredKeys as $key) {
            if (!array_key_exists($key, $data)) {
                return false;
            }
        }

        $signature = $data['signature_key'];
        $orderId = $data['order_id'];
        $statusCode = $data['status_code'];
        $grossAmount = $data['gross_amount'];

        $signatureKey = hash('sha512', $orderId . $statusCode . $grossAmount . $this->serverKey);

        return $signatureKey === $signature;
    }

    /**
     * Process payment callback
     */
    public function processCallback(array $data): bool
    {
        if (!$this->verifyPayment($data)) {
            return false;
        }

        $payment = Payment::where('invoice_number', $data['order_id'])->first();
        
        if (!$payment) {
            return false;
        }

        $transactionStatus = $data['transaction_status'];

        if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
            $payment->markAsPaid($data['transaction_id']);
            $payment->order->update(['status' => 'diproses']);
        } elseif ($transactionStatus == 'pending') {
            $payment->update(['status' => 'processing']);
        } elseif ($transactionStatus == 'deny' || $transactionStatus == 'cancel' || $transactionStatus == 'expire') {
            $payment->markAsFailed();
            $payment->order->update(['status' => 'dibatalkan']);
        }

        return true;
    }
}
