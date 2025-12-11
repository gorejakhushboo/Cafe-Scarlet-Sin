<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Cart;
use Illuminate\Http\Request;

/**
 * MenuController
 * Displays the menu page (page2) with products from database
 */
class MenuController extends Controller
{
    /**
     * Display menu page with all products grouped by category
     */
    public function index(Request $request)
    {
        // Get filter from request, default to 'all'
        $filter = $request->query('filter', 'all');
        
        // Fetch active categories with their active products
        $categoriesQuery = \App\Models\Category::with(['products' => function ($query) {
            $query->where('is_active', true)->orderBy('display_order');
        }])->where('is_active', true)->orderBy('display_order');

        if ($filter !== 'all') {
            $categoriesQuery->where('slug', $filter);
        }

        $categories = $categoriesQuery->get();
        
        // Get cart count for the header
        $cartCount = 0;
        $sessionId = session()->getId();
        $cart = Cart::where('session_id', $sessionId)->first();
        if ($cart) {
            $cartCount = $cart->items()->sum('quantity');
        }

        // Pass all categories for the filter buttons
        $allCategories = \App\Models\Category::where('is_active', true)->orderBy('display_order')->get();

        return view('page2', compact('categories', 'filter', 'cartCount', 'allCategories'));
    }

    public function show(Product $product)
    {
        if (!$product->is_active) {
            abort(404);
        }

        // Get cart count for the header
        $cartCount = 0;
        $sessionId = session()->getId();
        $cart = Cart::where('session_id', $sessionId)->first();
        if ($cart) {
            $cartCount = $cart->items()->sum('quantity');
        }

        return view('products.show', compact('product', 'cartCount'));
    }

    /**
     * Ajax Search for products
     */
    public function search(Request $request)
    {
        $query = $request->get('query');
        
        if (empty($query)) {
            return response()->json([]);
        }

        $products = Product::with('category')
            ->where('is_active', true)
            ->where(function($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhereHas('category', function($q) use ($query) {
                      $q->where('name', 'like', "%{$query}%");
                  });
            })
            ->limit(10) // Limit results for performance
            ->get();
            
        return response()->json($products);
    }
}
