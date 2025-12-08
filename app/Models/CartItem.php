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
        'subtotal'
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class);
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