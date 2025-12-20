<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'menu_id',
        'quantity',
        'harga',
        'subtotal',
        'order_type',
        'delivery_date'
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    protected $casts = [
        'quantity' => 'integer',
        'harga' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'delivery_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // ==================== PRE-ORDER METHODS ====================

    /**
     * Check if cart item is a pre-order
     */
    public function isPreorder(): bool
    {
        return $this->order_type === 'preorder';
    }

    /**
     * Check if cart item is for tomorrow
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
     * Get order type label
     */
    public function getOrderTypeLabel(): string
    {
        return match($this->order_type) {
            'preorder' => 'Pre-Order',
            'regular' => 'Langsung',
            default => 'Langsung'
        };
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($cartItem) {
            $cartItem->subtotal = $cartItem->quantity * $cartItem->harga;
        });

        static::updating(function ($cartItem) {
            $cartItem->subtotal = $cartItem->quantity * $cartItem->harga;
        });

        static::updated(function ($cartItem) {
            $cartItem->cart->updateTotalHarga();
        });

        static::created(function ($cartItem) {
            $cartItem->cart->updateTotalHarga();
        });

        static::deleted(function ($cartItem) {
            $cartItem->cart->updateTotalHarga();
        });
    }
}