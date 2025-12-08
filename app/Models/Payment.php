<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'invoice_number',
        'amount',
        'status',
        'payment_method',
        'discount_amount',
        'voucher_code',
        'voucher_details',
        'transaction_id',
        'response_data',
        'paid_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'paid_at' => 'datetime',
        'response_data' => 'array',
        'voucher_details' => 'array',
    ];

    // ==================== RELATIONSHIPS ====================

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // ==================== SCOPES ====================

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    public function scopeExpired($query)
    {
        return $query->where('status', 'expired');
    }

    // ==================== METHODS ====================

    public function isPaid(): bool
    {
        return $this->status === 'completed';
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isPendingCash(): bool
    {
        return $this->status === 'pending_cash';
    }

    public function isFailed(): bool
    {
        return $this->status === 'failed';
    }

    public function markAsPaid($transactionId = null)
    {
        $this->update([
            'status' => 'completed',
            'transaction_id' => $transactionId,
            'paid_at' => now(),
        ]);
    }

    public function markAsFailed()
    {
        $this->update(['status' => 'failed']);
    }
}
