<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'tenant_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Default attributes values
     *
     * @var array
     */
    protected $attributes = [
        'role' => 'customer',
    ];

    // ==================== RELATIONSHIPS ====================

    /**
     * Get the tenant that owns the user (for tenant_owner role)
     */
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * Get the carts for the user (for customer role)
     */
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    /**
     * Get the orders for the user (for customer role)
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // ==================== METHODS ====================

    /**
     * Check if user is a customer
     */
    public function isCustomer()
    {
        return $this->role === 'customer';
    }

    /**
     * Check if user is a tenant owner
     */
    public function isTenantOwner()
    {
        return $this->role === 'tenant_owner';
    }

    /**
     * Check if user is an admin (no specific role or custom role)
     */
    public function isAdmin()
    {
        return $this->role === 'admin' || is_null($this->role) || !in_array($this->role, ['customer', 'tenant_owner']);
    }

    /**
     * Get the active cart for a specific tenant
     */
    public function getCartForTenant($tenantId)
    {
        return $this->carts()->where('tenant_id', $tenantId)->first();
    }

    /**
     * Get all active carts with items count
     */
    public function getCartsWithItemsCount()
    {
        return $this->carts()->withCount('items')->get();
    }

    /**
     * Get total items in all carts
     */
    public function getTotalCartItems()
    {
        return $this->carts()->with('items')->get()->sum(function($cart) {
            return $cart->items->count();
        });
    }

    // ==================== SCOPES ====================

    /**
     * Scope a query to only include customers.
     */
    public function scopeCustomers($query)
    {
        return $query->where('role', 'customer');
    }

    /**
     * Scope a query to only include tenant owners.
     */
    public function scopeTenantOwners($query)
    {
        return $query->where('role', 'tenant_owner');
    }

    /**
     * Scope a query to only include users with tenants.
     */
    public function scopeWithTenant($query)
    {
        return $query->whereNotNull('tenant_id');
    }

    // ==================== EVENTS ====================

    /**
     * The "booted" method of the model.
     */
    protected static function booted()
    {
        // Auto set role to customer if null
        static::creating(function ($user) {
            if (is_null($user->role)) {
                $user->role = 'customer';
            }
        });

        // When user role changed to tenant_owner, ensure they have a tenant
        static::updating(function ($user) {
            if ($user->isDirty('role') && $user->role === 'tenant_owner' && is_null($user->tenant_id)) {
                // You can auto-create a tenant here or leave it null for manual assignment
            }
        });
    }
}