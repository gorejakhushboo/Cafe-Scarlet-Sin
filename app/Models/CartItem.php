<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * CartItem Model
 * Represents a single item in a shopping cart (product + quantity)
 */
class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity',
        'price_at_add',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'price_at_add' => 'decimal:2',
    ];

    /**
     * Cart this item belongs to
     */
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    /**
     * Product this item represents
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Calculate subtotal for this item (quantity * price)
     */
    public function getSubtotalAttribute(): float
    {
        return $this->quantity * $this->price_at_add;
    }
}

