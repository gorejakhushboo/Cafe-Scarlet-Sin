<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * OrderItem Model
 * Represents a single item in an order (product snapshot + quantity + price)
 */
class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'quantity',
        'unit_price',
        'total_price',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
    ];

    /**
     * Order this item belongs to
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Product this item represents (may have changed since order was placed)
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

