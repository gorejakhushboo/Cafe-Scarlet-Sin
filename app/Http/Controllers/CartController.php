<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

/**
 * CartController
 * Handles all cart operations: add, update quantity, delete items
 * All operations use form POST requests (no JavaScript required)
 */
class CartController extends Controller
{
    /**
     * Display the cart page with all items
     */
    public function index()
    {
        $cart = $this->getOrCreateCart();
        $items = $cart->items()->with('product')->get();
        $total = $cart->total;
        
        return view('cart', compact('cart', 'items', 'total'));
    }

    /**
     * Add a product to the cart (POST from product card form)
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1|max:10',
        ]);

        $product = Product::findOrFail($request->product_id);
        $quantity = $request->quantity ?? 1;
        
        $cart = $this->getOrCreateCart();
        
        // Check if product already exists in cart
        $existingItem = $cart->items()->where('product_id', $product->id)->first();
        
        if ($existingItem) {
            // Update quantity if item already exists
            $existingItem->quantity += $quantity;
            $existingItem->save();
        } else {
            // Add new item to cart
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price_at_add' => $product->effective_price,
            ]);
        }

        return redirect()->route('cart.index')
            ->with('success', "{$product->name} added to cart!");
    }

    /**
     * Update quantity of a cart item (POST from quantity update form)
     */
    public function update(Request $request, CartItem $cartItem)
    {
        // Verify cart item belongs to current session's cart
        $cart = $this->getOrCreateCart();
        if ($cartItem->cart_id !== $cart->id) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'quantity' => 'required|integer|min:1|max:10',
        ]);

        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        return redirect()->route('cart.index')
            ->with('success', 'Cart updated!');
    }

    /**
     * Remove an item from cart (POST/DELETE from remove form)
     */
    public function destroy(CartItem $cartItem)
    {
        // Verify cart item belongs to current session's cart
        $cart = $this->getOrCreateCart();
        if ($cartItem->cart_id !== $cart->id) {
            abort(403, 'Unauthorized');
        }

        $productName = $cartItem->product->name;
        $cartItem->delete();

        return redirect()->route('cart.index')
            ->with('success', "{$productName} removed from cart!");
    }

    /**
     * Clear entire cart
     */
    public function clear()
    {
        $cart = $this->getOrCreateCart();
        $cart->items()->delete();

        return redirect()->route('cart.index')
            ->with('success', 'Cart cleared!');
    }

    /**
     * Get or create cart for current session
     */
    private function getOrCreateCart(): Cart
    {
        $sessionId = Session::getId();
        $userId = auth()->id(); // null if guest

        return Cart::getOrCreateCart($sessionId, $userId);
    }
}

