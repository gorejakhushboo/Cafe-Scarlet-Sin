<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderStatusLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

/**
 * OrderController
 * Handles order viewing and status management
 */
class OrderController extends Controller
{
    /**
     * Display order status page with time-responsive status calculation
     */
    public function show(Order $order)
    {
        // Calculate current status (may have auto-progressed)
        $calculatedStatus = $order->calculateCurrentStatus();
        
        // If status has changed, update it
        if ($calculatedStatus !== $order->status) {
            $this->updateOrderStatus($order, $calculatedStatus, 'automatic');
            $order->refresh();
        }

        // Get status timeline/logs
        $statusLogs = $order->statusLogs()->orderBy('created_at', 'asc')->get();
        
        // Calculate time until next status
        $timeUntilNext = $order->getTimeUntilNextStatus();
        
        // Get order items
        $items = $order->items()->with('product')->get();
        
        // Payment info
        $payment = $order->payment;

        return view('order-status', compact('order', 'statusLogs', 'timeUntilNext', 'items', 'payment'));
    }

    /**
     * Accept order (POST from accept button)
     */
    public function accept(Order $order)
    {
        // Verify order can be accepted (status must be 'new' and within accept window)
        if ($order->status !== 'new') {
            return redirect()->route('orders.show', $order)
                ->with('error', 'Order cannot be accepted in its current status.');
        }

        $config = config('order_status');
        $acceptWindow = $config['accept_window'] ?? 900;
        $acceptDeadline = $order->created_at->copy()->addSeconds($acceptWindow);

        if (Carbon::now()->greaterThan($acceptDeadline)) {
            return redirect()->route('orders.show', $order)
                ->with('error', 'Acceptance window has expired. Order will be auto-cancelled.');
        }

        $this->updateOrderStatus($order, 'accepted', 'manual', now(), 'accepted_at');

        return redirect()->route('orders.show', $order)
            ->with('success', 'Order accepted!');
    }

    /**
     * Mark order as on the way (POST from admin/staff action)
     */
    public function ship(Order $order)
    {
        if ($order->status !== 'accepted') {
            return redirect()->route('orders.show', $order)
                ->with('error', 'Order must be accepted before shipping.');
        }

        $this->updateOrderStatus($order, 'on_the_way', 'manual', now(), 'shipped_at');

        return redirect()->route('orders.show', $order)
            ->with('success', 'Order marked as on the way!');
    }

    /**
     * Mark order as delivered (POST from delivery action)
     */
    public function deliver(Order $order)
    {
        if ($order->status !== 'on_the_way') {
            return redirect()->route('orders.show', $order)
                ->with('error', 'Order must be on the way before delivery.');
        }

        $this->updateOrderStatus($order, 'delivered', 'manual', now(), 'delivered_at');

        // Update payment status to paid
        if ($order->payment) {
            $order->payment->update([
                'payment_status' => 'paid',
                'paid_at' => now(),
            ]);
        }

        return redirect()->route('orders.show', $order)
            ->with('success', 'Order delivered!');
    }

    /**
     * Cancel order (POST from cancel action)
     */
    public function cancel(Order $order)
    {
        if (in_array($order->status, ['delivered', 'cancelled', 'auto_cancelled'])) {
            return redirect()->route('orders.show', $order)
                ->with('error', 'Order cannot be cancelled in its current status.');
        }

        $this->updateOrderStatus($order, 'cancelled', 'manual', now(), 'cancelled_at');

        return redirect()->route('orders.show', $order)
            ->with('success', 'Order cancelled.');
    }

    /**
     * Helper method to update order status and log the change
     */
    private function updateOrderStatus(
        Order $order,
        string $newStatus,
        string $trigger = 'manual',
        ?Carbon $timestamp = null,
        ?string $timestampField = null
    ): void {
        $oldStatus = $order->status;
        $timestamp = $timestamp ?? now();

        DB::transaction(function () use ($order, $oldStatus, $newStatus, $trigger, $timestamp, $timestampField) {
            // Prepare update data
            $updateData = [
                'status' => $newStatus,
                'status_changed_at' => $timestamp,
            ];
            
            // Add timestamp field if provided
            if ($timestampField) {
                $updateData[$timestampField] = $timestamp;
            }
            
            // Update order status
            $order->update($updateData);

            // Log status change
            OrderStatusLog::create([
                'order_id' => $order->id,
                'old_status' => $oldStatus,
                'new_status' => $newStatus,
                'trigger' => $trigger,
                'notes' => "Status changed from {$oldStatus} to {$newStatus} via {$trigger}",
            ]);
        });
    }
}

