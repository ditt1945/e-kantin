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
        'is_available'
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
}
