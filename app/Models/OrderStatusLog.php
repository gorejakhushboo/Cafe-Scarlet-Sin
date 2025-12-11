<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * OrderStatusLog Model
 * Audit trail of order status changes
 */
class OrderStatusLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'old_status',
        'new_status',
        'trigger',
        'notes',
    ];

    /**
     * Order this log entry belongs to
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}

