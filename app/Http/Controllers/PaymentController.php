<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

/**
 * PaymentController
 * Handles payment details collection and order creation
 */
class PaymentController extends Controller
{
    /**
     * Show payment details form (checkout step)
     */
    public function create()
    {
        $cart = $this->getOrCreateCart();
        $items = $cart->items()->with('product')->get();
        
        if ($items->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty!');
        }

        $subtotal = $cart->total;
        $tax = $subtotal * 0.1; // 10% tax (configurable)
        $shipping = 0; // Free shipping
        $total = $subtotal + $tax + $shipping;

        return view('payment-details', compact('items', 'subtotal', 'tax', 'shipping', 'total'));
    }

    /**
     * Process payment and create order (POST from payment form)
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'required|string|max:500',
            'shipping_notes' => 'nullable|string|max:500',
        ]);

        $cart = $this->getOrCreateCart();
        $items = $cart->items()->with('product')->get();

        if ($items->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty!');
        }

        // Calculate totals
        $subtotal = $cart->total;
        $tax = $subtotal * 0.1;
        $shipping = 0;
        $total = $subtotal + $tax + $shipping;

        // Create order within transaction
        DB::beginTransaction();
        try {
            // Create order
            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'user_id' => auth()->id(),
                'session_id' => Session::getId(),
                'customer_name' => $request->customer_name,
                'customer_email' => $request->customer_email,
                'customer_phone' => $request->customer_phone,
                'customer_address' => $request->customer_address,
                'shipping_notes' => $request->shipping_notes,
                'status' => 'new',
                'status_changed_at' => now(),
                'subtotal' => $subtotal,
                'tax' => $tax,
                'shipping' => $shipping,
                'total' => $total,
            ]);

            // Create order items
            foreach ($items as $cartItem) {
                $product = $cartItem->product;
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'quantity' => $cartItem->quantity,
                    'unit_price' => $cartItem->price_at_add,
                    'total_price' => $cartItem->quantity * $cartItem->price_at_add,
                ]);
            }

            // Create payment record
            Payment::create([
                'order_id' => $order->id,
                'payment_method' => 'cash', // Default for now
                'payment_status' => 'pending', // Or 'paid' if payment gateway integrated
                'amount' => $total,
            ]);

            // Log initial status
            $order->statusLogs()->create([
                'old_status' => null,
                'new_status' => 'new',
                'trigger' => 'system',
                'notes' => 'Order created',
            ]);

            // Clear cart
            $cart->items()->delete();

            DB::commit();

            return redirect()->route('orders.show', $order)
                ->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('payment.create')
                ->with('error', 'Failed to place order. Please try again.');
        }
    }

    /**
     * Get or create cart for current session
     */
    private function getOrCreateCart(): Cart
    {
        $sessionId = Session::getId();
        $userId = auth()->id();

        return Cart::getOrCreateCart($sessionId, $userId);
    }
}

