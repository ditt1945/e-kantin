<?php

namespace App\Helpers;

class OrderHelper
{
    public const ORDER_CODE_PREFIX = 'ORD-';
    public const INVOICE_CODE_PREFIX = 'INV-';

    /**
     * Generate order code
     */
    public static function generateOrderCode(): string
    {
        $date = now()->format('Ymd');
        $count = \App\Models\Order::whereDate('created_at', today())->count() + 1;
        return self::ORDER_CODE_PREFIX . $date . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Generate invoice number
     */
    public static function generateInvoiceNumber(): string
    {
        do {
            $prefix = config('app.invoice_prefix', 'INV');
            $timestamp = now()->format('YmdHis');
            $random = strtoupper(substr(md5(microtime()), 0, 4));
            $invoiceNumber = $prefix . '-' . $timestamp . '-' . $random;
        } while (\App\Models\Payment::where('invoice_number', $invoiceNumber)->exists());

        return $invoiceNumber;
    }

    /**
     * Format currency
     */
    public static function formatCurrency(float $amount): string
    {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }

    /**
     * Calculate discount amount
     */
    public static function calculateDiscount(float $total, float $discountPercent): float
    {
        return $total * ($discountPercent / 100);
    }
}