<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Product Model
 * Represents a menu item (coffee drink) available for purchase
 */
class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'ingredients',
        'flavor_notes',
        'origin_story',
        'category',
        'category_id',
        'price',
        'special_price',
        'is_special',
        'image_path',
        'display_order',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'special_price' => 'decimal:2',
        'is_special' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Get the effective price (special price if on sale, otherwise regular price)
     */
    public function getEffectivePriceAttribute(): float
    {
        return $this->special_price ?? $this->price;
    }

    /**
     * Cart items that reference this product
     */
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Order items that reference this product
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Scope to get only active products
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to filter by category
     */
    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

