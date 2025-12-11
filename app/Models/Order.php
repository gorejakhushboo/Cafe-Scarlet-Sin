<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

/**
 * Order Model
 * Represents a customer order with status tracking and time-responsive state machine
 */
class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'session_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_address',
        'shipping_notes',
        'status',
        'status_changed_at',
        'accepted_at',
        'shipped_at',
        'delivered_at',
        'cancelled_at',
        'subtotal',
        'tax',
        'shipping',
        'total',
    ];

    protected $casts = [
        'status_changed_at' => 'datetime',
        'accepted_at' => 'datetime',
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'subtotal' => 'decimal:2',
        'tax' => 'decimal:2',
        'shipping' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    /**
     * Items in this order
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Payment for this order
     */
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    /**
     * Status change logs for this order
     */
    public function statusLogs()
    {
        return $this->hasMany(OrderStatusLog::class)->orderBy('created_at', 'desc');
    }

    /**
     * User who placed this order (optional)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Calculate current status based on time-responsive logic
     * This method checks timestamps and configurable thresholds to determine if status should auto-advance
     */
    public function calculateCurrentStatus(): string
    {
        // If already in final states, return as-is
        if (in_array($this->status, ['delivered', 'cancelled', 'auto_cancelled'])) {
            return $this->status;
        }

        $config = config('order_status');
        $now = Carbon::now();

        // Check if order is new and acceptance window has expired
        if ($this->status === 'new') {
            $acceptWindow = $config['accept_window'] ?? 900; // Default 15 minutes
            $acceptDeadline = $this->created_at->copy()->addSeconds($acceptWindow);
            
            if ($now->greaterThan($acceptDeadline)) {
                return 'auto_cancelled';
            }
        }

        // Check if accepted and should move to on_the_way
        if ($this->status === 'accepted' && $this->accepted_at) {
            $processingTime = $config['processing_time'] ?? 900; // Default 15 minutes
            $shipDeadline = $this->accepted_at->copy()->addSeconds($processingTime);
            
            if ($now->greaterThan($shipDeadline)) {
                return 'on_the_way';
            }
        }

        // Check if on_the_way and should move to delivered
        if ($this->status === 'on_the_way' && $this->shipped_at) {
            $deliveryTime = $config['delivery_time'] ?? 1800; // Default 30 minutes
            $deliveryDeadline = $this->shipped_at->copy()->addSeconds($deliveryTime);
            
            if ($now->greaterThan($deliveryDeadline)) {
                return 'delivered';
            }
        }

        return $this->status;
    }

    /**
     * Get time remaining until next status change (in seconds)
     */
    public function getTimeUntilNextStatus(): ?int
    {
        $config = config('order_status');
        $now = Carbon::now();

        if ($this->status === 'new') {
            $acceptWindow = $config['accept_window'] ?? 900;
            $deadline = $this->created_at->copy()->addSeconds($acceptWindow);
            return max(0, $now->diffInSeconds($deadline, false));
        }

        if ($this->status === 'accepted' && $this->accepted_at) {
            $processingTime = $config['processing_time'] ?? 900;
            $deadline = $this->accepted_at->copy()->addSeconds($processingTime);
            return max(0, $now->diffInSeconds($deadline, false));
        }

        if ($this->status === 'on_the_way' && $this->shipped_at) {
            $deliveryTime = $config['delivery_time'] ?? 1800;
            $deadline = $this->shipped_at->copy()->addSeconds($deliveryTime);
            return max(0, $now->diffInSeconds($deadline, false));
        }

        return null;
    }

    /**
     * Get human-readable status label
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'new' => 'New Order',
            'accepted' => 'Accepted',
            'on_the_way' => 'On The Way',
            'delivered' => 'Delivered',
            'cancelled' => 'Cancelled',
            'auto_cancelled' => 'Auto-Cancelled',
            default => ucfirst(str_replace('_', ' ', $this->status)),
        };
    }

    /**
     * Generate unique order number
     */
    public static function generateOrderNumber(): string
    {
        $date = now()->format('Ymd');
        $lastOrder = self::whereDate('created_at', today())
            ->orderBy('id', 'desc')
            ->first();
        
        $sequence = $lastOrder ? (int)substr($lastOrder->order_number, -3) + 1 : 1;
        
        return sprintf('ORD-%s-%03d', $date, $sequence);
    }
}

