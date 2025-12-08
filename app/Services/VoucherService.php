<?php

namespace App\Services;

use App\Models\Order;
use InvalidArgumentException;

class VoucherService
{
    /**
     * Validate voucher and return discount meta data
     */
    public function apply(string $rawCode, Order $order): array
    {
        $code = strtoupper(trim($rawCode));
        $voucher = config('vouchers.' . $code);

        if (!$voucher) {
            throw new InvalidArgumentException('Kode voucher tidak ditemukan.');
        }

        $minOrder = (int) ($voucher['min_order'] ?? 0);
        if ($order->total_harga < $minOrder) {
            throw new InvalidArgumentException('Minimal belanja Rp ' . number_format($minOrder, 0, ',', '.') . ' untuk voucher ini.');
        }

        $discount = $this->calculateDiscount($voucher, (int) $order->total_harga);
        if ($discount <= 0) {
            throw new InvalidArgumentException('Voucher tidak memberikan diskon pada pesanan ini.');
        }

        return [
            'code' => $code,
            'discount' => $discount,
            'description' => $voucher['description'] ?? null,
        ];
    }

    private function calculateDiscount(array $voucher, int $orderTotal): int
    {
        $type = $voucher['type'] ?? 'flat';
        $value = (int) ($voucher['value'] ?? 0);

        $discount = $type === 'percent'
            ? (int) floor($orderTotal * ($value / 100))
            : $value;

        $max = $voucher['max_discount'] ?? null;
        if ($max !== null) {
            $discount = min($discount, (int) $max);
        }

        $cap = $voucher['cap'] ?? null;
        if ($cap !== null) {
            $discount = min($discount, (int) $cap);
        }

        return max($discount, 0);
    }
}
