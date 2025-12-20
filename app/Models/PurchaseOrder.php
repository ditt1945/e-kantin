<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PurchaseOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'supplier_name',
        'supplier_contact',
        'po_number',
        'order_date',
        'expected_delivery_date',
        'status',
        'total_amount',
        'notes',
        'created_by'
    ];

    protected $casts = [
        'order_date' => 'date',
        'expected_delivery_date' => 'date',
        'total_amount' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the tenant that owns the purchase order.
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * Get the user who created the purchase order.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the items for the purchase order.
     */
    public function items()
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }

    /**
     * Generate unique PO number
     */
    public static function generatePoNumber(): string
    {
        $prefix = 'PO';
        $date = now()->format('Ymd');
        $lastPo = static::whereDate('created_at', now())->latest()->first();
        $sequence = $lastPo ? (int) substr($lastPo->po_number, -4) + 1 : 1;

        return sprintf('%s-%s-%04d', $prefix, $date, $sequence);
    }

    /**
     * Scope for pending POs
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for confirmed POs
     */
    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    /**
     * Scope for delivered POs
     */
    public function scopeDelivered($query)
    {
        return $query->where('status', 'delivered');
    }

    /**
     * Scope for cancelled POs
     */
    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    /**
     * Check if PO can be modified
     */
    public function isModifiable(): bool
    {
        return in_array($this->status, ['pending', 'confirmed']);
    }

    /**
     * Get status label with color
     */
    public function getStatusLabel(): array
    {
        $labels = [
            'pending' => ['text' => 'Menunggu Konfirmasi', 'color' => 'warning'],
            'confirmed' => ['text' => 'Dikonfirmasi', 'color' => 'info'],
            'delivered' => ['text' => 'Terkirim', 'color' => 'success'],
            'cancelled' => ['text' => 'Dibatalkan', 'color' => 'danger'],
        ];

        return $labels[$this->status] ?? ['text' => $this->status, 'color' => 'secondary'];
    }
}