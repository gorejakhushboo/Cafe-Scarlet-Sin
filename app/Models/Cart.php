<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Cart Model
 * Represents a shopping cart session (session-based, not user-based)
 */
class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'user_id',
    ];

    /**
     * Items in this cart
     */
    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * User who owns this cart (optional, for logged-in users)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Calculate total price of all items in cart
     */
    public function getTotalAttribute(): float
    {
        return $this->items->sum(function ($item) {
            return $item->quantity * $item->price_at_add;
        });
    }

    /**
     * Get total quantity of items in cart
     */
    public function getTotalQuantityAttribute(): int
    {
        return $this->items->sum('quantity');
    }

    /**
     * Find or create cart for current session
     */
    public static function getOrCreateCart(string $sessionId, ?int $userId = null): self
    {
        return self::firstOrCreate(
            ['session_id' => $sessionId],
            ['user_id' => $userId]
        );
    }
}

