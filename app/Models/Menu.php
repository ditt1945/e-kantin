<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'category_id',
        'nama_menu',
        'deskripsi',
        'harga',
        'stok',
        'gambar',
        'is_available',
        'is_po_based',
        'po_minimum_quantity',
        'po_lead_time_days',
        'order_count',
        'total_revenue'
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function purchaseOrderItems()
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }

    // ==================== SCOPES ====================

    public function scopeAvailable($query)
    {
        return $query->where('is_available', true)->where('stok', '>', 0);
    }

    public function scopeOutOfStock($query)
    {
        return $query->where('stok', '<=', 0);
    }

    public function scopeLowStock($query)
    {
        return $query->where('stok', '<=', 5)->where('stok', '>', 0);
    }

    // ==================== METHODS ====================

    public function isAvailable(): bool
    {
        return $this->is_available && $this->stok > 0;
    }

    public function isOutOfStock(): bool
    {
        return $this->stok <= 0;
    }

    public function isLowStock(): bool
    {
        return $this->stok <= 5 && $this->stok > 0;
    }

    public function decreaseStock(int $quantity): bool
    {
        if ($this->stok < $quantity) {
            return false;
        }

        // Use database locking to prevent race conditions
        $affected = static::where('id', $this->id)
            ->where('stok', '>=', $quantity)
            ->decrement('stok', $quantity);

        if ($affected > 0) {
            $this->refresh(); // Refresh the model instance
            // Update availability status if stock is now zero
            if ($this->stok <= 0) {
                $this->update(['is_available' => false]);
            }
            return true;
        }

        return false;
    }

    /**
     * Decrease stock with exception
     */
    public function decreaseStockOrFail(int $quantity): void
    {
        if (!$this->decreaseStock($quantity)) {
            throw new \App\Exceptions\InsufficientStockException(
                $this->nama_menu,
                $quantity,
                $this->stok
            );
        }
    }

    public function increaseStock(int $quantity): void
    {
        $this->increment('stok', $quantity);

        // Update availability status if stock is now positive
        if ($this->stok > 0 && !$this->is_available) {
            $this->update(['is_available' => true]);
        }
    }

    // ==================== PRE-ORDER SYSTEM METHODS ====================

    /**
     * Check if menu is heavy meal suitable for pre-order
     */
    public function isHeavyMeal(): bool
    {
        // Check if category is heavy meal (makanan berat)
        return $this->category && in_array(strtolower($this->category->nama_kategori), [
            'makanan berat', 'nasi', 'lauk', 'sayur', 'lauk pauk', 'hidangan utama'
        ]);
    }

    /**
     * Check if menu requires pre-order
     */
    public function requiresPreorder(): bool
    {
        // Heavy meals require pre-order for next day
        return $this->isHeavyMeal();
    }

    /**
     * Get preorder cutoff time (last time to order for tomorrow)
     */
    public function getPreorderCutoffTime(): string
    {
        return '20:00'; // 8 PM cutoff for tomorrow orders
    }

    /**
     * Check if customer can still pre-order for tomorrow
     */
    public function canPreorderForTomorrow(): bool
    {
        if (!$this->requiresPreorder()) {
            return false;
        }

        // Check if current time is before cutoff
        $cutoffTime = $this->getPreorderCutoffTime();
        $currentTime = now()->format('H:i');

        return $currentTime < $cutoffTime;
    }

    /**
     * Get preorder deadline message
     */
    public function getPreorderDeadlineMessage(): string
    {
        if (!$this->requiresPreorder()) {
            return '';
        }

        if ($this->canPreorderForTomorrow()) {
            return "Pre-order untuk besok sebelum pukul {$this->getPreorderCutoffTime()}";
        }

        return "Pre-order untuk besok telah ditutup. Pesan sekarang untuk lusa";
    }

    /**
     * Check if customer can order this item now
     */
    public function canOrderNow(): bool
    {
        // Regular availability check
        if (!$this->isAvailable()) {
            return false;
        }

        // Heavy meals require pre-order
        if ($this->requiresPreorder()) {
            return $this->canPreorderForTomorrow();
        }

        return true;
    }

    /**
     * Get ordering restriction message
     */
    public function getRestrictionMessage(): string
    {
        if (!$this->isAvailable()) {
            return 'Stok habis';
        }

        if ($this->requiresPreorder()) {
            return $this->getPreorderDeadlineMessage();
        }

        return 'Tersedia';
    }

    /**
     * Scope for heavy meals
     */
    public function scopeHeavyMeals($query)
    {
        return $query->whereHas('category', function($q) {
            $q->whereIn('nama_kategori', ['Makanan Berat', 'Nasi', 'Lauk', 'Sayur', 'Lauk Pauk', 'Hidangan Utama']);
        });
    }

    /**
     * Scope for light snacks
     */
    public function scopeLightSnacks($query)
    {
        return $query->whereHas('category', function($q) {
            $q->whereNotIn('nama_kategori', ['Makanan Berat', 'Nasi', 'Lauk', 'Sayur', 'Lauk Pauk', 'Hidangan Utama']);
        });
    }

    /**
     * Scope for menus available for pre-order
     */
    public function scopeAvailableForPreorder($query)
    {
        return $query->whereHas('category', function($q) {
            $q->whereIn('nama_kategori', ['Makanan Berat', 'Nasi', 'Lauk', 'Sayur', 'Lauk Pauk', 'Hidangan Utama']);
        })->where('is_available', true);
    }

    /**
     * Scope for PO-based menus (deprecated)
     */
    public function scopePoBased($query)
    {
        return $query->where('is_po_based', true);
    }

    /**
     * Scope for regular menus (non-PO) (deprecated)
     */
    public function scopeRegular($query)
    {
        return $query->where('is_po_based', false);
    }

    // ==================== BEST SELLER METHODS ====================

    /**
     * Check if menu is a best seller
     */
    public function isBestSeller(): bool
    {
        return $this->order_count >= 10; // Consider best seller if ordered 10+ times
    }

    /**
     * Get best seller level
     */
    public function getBestSellerLevel(): string
    {
        if ($this->order_count >= 50) {
            return 'premium';
        } elseif ($this->order_count >= 25) {
            return 'gold';
        } elseif ($this->order_count >= 10) {
            return 'silver';
        }
        return 'none';
    }

    /**
     * Get best seller badge color
     */
    public function getBestSellerBadgeColor(): string
    {
        return match($this->getBestSellerLevel()) {
            'premium' => 'danger',
            'gold' => 'warning',
            'silver' => 'info',
            default => 'secondary'
        };
    }

    /**
     * Get best seller label
     */
    public function getBestSellerLabel(): string
    {
        return match($this->getBestSellerLevel()) {
            'premium' => '🔥 Best Seller',
            'gold' => '⭐ Populer',
            'silver' => '👍 Rekomendasi',
            default => ''
        };
    }

    /**
     * Scope for best sellers
     */
    public function scopeBestSellers($query)
    {
        return $query->where('order_count', '>=', 10)
                    ->orderBy('order_count', 'desc');
    }

    /**
     * Scope for tenant best sellers
     */
    public function scopeTenantBestSellers($query, $tenantId)
    {
        return $query->where('tenant_id', $tenantId)
                    ->where('order_count', '>=', 5)
                    ->orderBy('order_count', 'desc')
                    ->limit(3);
    }

    /**
     * Update order count and revenue
     */
    public function updateOrderStats(int $quantity, float $price): void
    {
        $this->increment('order_count', $quantity);
        $this->increment('total_revenue', $quantity * $price);
    }

    // ==================== POPULARITY / RATING ====================

    /**
     * Get a 0-5 popularity rating based on unique buyers count.
     */
    public function getPopularityRating(?int $buyersCount = null): float
    {
        $buyers = $buyersCount ?? $this->buyers_count ?? 0;

        return match (true) {
            $buyers >= 100 => 5.0,
            $buyers >= 50  => 4.8,
            $buyers >= 25  => 4.5,
            $buyers >= 10  => 4.2,
            $buyers >= 5   => 4.0,
            $buyers >= 3   => 3.8,
            $buyers >= 1   => 3.5,
            default        => 0.0,
        };
    }

    /**
     * Label describing popularity level.
     */
    public function getPopularityLabel(?int $buyersCount = null): string
    {
        $buyers = $buyersCount ?? $this->buyers_count ?? 0;

        return match (true) {
            $buyers >= 100 => 'Paling diminati',
            $buyers >= 50  => 'Top pilihan konsumen',
            $buyers >= 25  => 'Sangat populer',
            $buyers >= 10  => 'Populer',
            $buyers >= 5   => 'Mulai banyak dicari',
            default        => ''
        };
    }
}
