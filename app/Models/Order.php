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
        'catatan'
    ];

    protected $casts = [
        'total_harga' => 'decimal:2',
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

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            if (empty($order->kode_pesanan)) {
                $order->kode_pesanan = 'ORD-' . now()->format('Ymd') . '-' .
                    str_pad(static::whereDate('created_at', today())->count() + 1, 4, '0', STR_PAD_LEFT);
            }
        });
    }
}