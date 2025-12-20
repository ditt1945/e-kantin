<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // Status constants
    public const STATUS_PENDING = 'pending';
    public const STATUS_DIPROSES = 'diproses';
    public const STATUS_SELESAI = 'selesai';
    public const STATUS_DIBATALKAN = 'dibatalkan';

    public const STATUSES = [
        self::STATUS_PENDING => 'Menunggu Konfirmasi',
        self::STATUS_DIPROSES => 'Sedang Diproses',
        self::STATUS_SELESAI => 'Selesai',
        self::STATUS_DIBATALKAN => 'Dibatalkan',
    ];

    protected $fillable = [
        'kode_pesanan',
        'tenant_id',
        'user_id',
        'total_harga',
        'status',
        'order_type',
        'delivery_date',
        'catatan',
        'preorder_notes'
    ];

    protected $casts = [
        'total_harga' => 'decimal:2',
        'delivery_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    // Accessors
    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status] ?? 'Unknown';
    }

    public function getIsPendingAttribute(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function getIsProcessingAttribute(): bool
    {
        return $this->status === self::STATUS_DIPROSES;
    }

    public function getIsCompletedAttribute(): bool
    {
        return $this->status === self::STATUS_SELESAI;
    }

    public function getIsCancelledAttribute(): bool
    {
        return $this->status === self::STATUS_DIBATALKAN;
    }

    // Methods
    public function canBeCancelled(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function canUpdateStatus(string $newStatus): bool
    {
        if (!array_key_exists($newStatus, self::STATUSES)) {
            return false;
        }

        // Business rules for status transitions
        return match ($this->status) {
            self::STATUS_PENDING => in_array($newStatus, [self::STATUS_DIPROSES, self::STATUS_DIBATALKAN]),
            self::STATUS_DIPROSES => in_array($newStatus, [self::STATUS_SELESAI, self::STATUS_DIBATALKAN]),
            default => false,
        };
    }

    // ==================== PRE-ORDER METHODS ====================

    /**
     * Check if order is a pre-order
     */
    public function isPreorder(): bool
    {
        return $this->order_type === 'preorder';
    }

    /**
     * Check if order is regular
     */
    public function isRegular(): bool
    {
        return $this->order_type === 'regular';
    }

    /**
     * Get order type label
     */
    public function getOrderTypeLabel(): string
    {
        return match($this->order_type) {
            'preorder' => 'Pre-Order',
            'regular' => 'Langsung',
            default => 'Unknown'
        };
    }

    /**
     * Check if order is for tomorrow
     */
    public function isForTomorrow(): bool
    {
        return $this->delivery_date && $this->delivery_date->isTomorrow();
    }

    /**
     * Get delivery date formatted
     */
    public function getDeliveryDateFormatted(): string
    {
        return $this->delivery_date ? $this->delivery_date->format('d/m/Y') : '';
    }

    /**
     * Scope for pre-orders
     */
    public function scopePreorder($query)
    {
        return $query->where('order_type', 'preorder');
    }

    /**
     * Scope for regular orders
     */
    public function scopeRegular($query)
    {
        return $query->where('order_type', 'regular');
    }

    /**
     * Scope for orders by delivery date
     */
    public function scopeForDeliveryDate($query, $date)
    {
        return $query->whereDate('delivery_date', $date);
    }

    /**
     * Scope for tomorrow's orders
     */
    public function scopeForTomorrow($query)
    {
        return $query->whereDate('delivery_date', now()->addDay());
    }

    /**
     * Scope for active orders (not expired)
     */
    public function scopeActive($query)
    {
        return $query->where(function($q) {
            // Regular orders: show for 24 hours
            $q->where(function($subQ) {
                $subQ->where('order_type', 'regular')
                     ->where('created_at', '>=', now()->subHours(24));
            })
            // Preorder orders: show until delivery date + 24 hours
            ->orWhere(function($subQ) {
                $subQ->where('order_type', 'preorder')
                     ->whereRaw('(COALESCE(delivery_date, created_at) >= ?)', [now()->subHours(24)]);
            });
        });
    }

    /**
     * Check if order is expired (should be hidden from history)
     */
    public function isExpired(): bool
    {
        if ($this->order_type === 'preorder') {
            // Preorder expires 24 hours after delivery date
            $expiryDate = $this->delivery_date ? $this->delivery_date->addHours(24) : $this->created_at->addHours(48);
        } else {
            // Regular orders expire after 24 hours
            $expiryDate = $this->created_at->addHours(24);
        }

        return now()->gt($expiryDate);
    }

    /**
     * Get expiry date/time for this order
     */
    public function getExpiryDate(): ?\Illuminate\Support\Carbon
    {
        if ($this->order_type === 'preorder') {
            return $this->delivery_date ? $this->delivery_date->addHours(24) : $this->created_at->addHours(48);
        }

        return $this->created_at->addHours(24);
    }

    /**
     * Get remaining time before expiry
     */
    public function getRemainingTime(): string
    {
        $expiryDate = $this->getExpiryDate();
        if (!$expiryDate) return '';

        $now = now();
        if ($now->gt($expiryDate)) return 'Kadaluarsa';

        $diff = $now->diff($expiryDate);

        if ($diff->days > 0) {
            return "{$diff->days} hari {$diff->h} jam";
        } elseif ($diff->h > 0) {
            return "{$diff->h} jam {$diff->i} menit";
        } else {
            return "{$diff->i} menit";
        }
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            if (empty($order->kode_pesanan)) {
                $prefix = $order->order_type === 'preorder' ? 'PO' : 'ORD';
                $order->kode_pesanan = $prefix . '-' . now()->format('Ymd') . '-' .
                    str_pad(static::whereDate('created_at', today())->count() + 1, 4, '0', STR_PAD_LEFT);
            }
        });
    }
}