<?php

namespace App\Exceptions;

use Exception;

class InsufficientStockException extends Exception
{
    public function __construct(string $menuName, int $requested, int $available)
    {
        parent::__construct("Stok {$menuName} tidak mencukupi. Diminta: {$requested}, Tersedia: {$available}");
    }
}

class InvalidOrderStatusException extends Exception
{
    public function __construct(string $currentStatus, array $allowedStatuses)
    {
        $allowed = implode(', ', $allowedStatuses);
        parent::__construct("Status pesanan '{$currentStatus}' tidak dapat diubah. Status yang diizinkan: {$allowed}");
    }
}

class PaymentProcessingException extends Exception
{
    public function __construct(string $message, ?Exception $previous = null)
    {
        parent::__construct("Gagal memproses pembayaran: {$message}", 0, $previous);
    }
}