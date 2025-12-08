<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tenant_id', 
        'total_harga'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    // Hitung ulang total harga berdasarkan data terbaru di database
    public function updateTotalHarga()
    {
        $this->total_harga = $this->items()->sum('subtotal');
        $this->save();
        $this->load('items.menu');
    }
}