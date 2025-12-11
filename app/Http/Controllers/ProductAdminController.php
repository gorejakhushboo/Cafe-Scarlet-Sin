<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductAdminController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('category')->orderBy('name')->get();
        $categories = \App\Models\Category::orderBy('display_order')->get();
        return view('admin.dashboard', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = \App\Models\Category::where('is_active', true)->orderBy('display_order')->get();
        // Using versioned view to bypass cache
        return view('admin.products.create_v2', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'category' => 'nullable|string|max:50', // Legacy
            'description' => 'nullable|string',
            'ingredients' => 'nullable|string',
            'flavor_notes' => 'nullable|string',
            'origin_story' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'special_price' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|max:2048', // Max 2MB
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);
            $validated['image_path'] = $filename;
        }

        Product::create($validated);

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $categories = \App\Models\Category::where('is_active', true)->orderBy('display_order')->get();
        // Using versioned view to bypass cache
        return view('admin.products.edit_v2', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'category' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'ingredients' => 'nullable|string',
            'flavor_notes' => 'nullable|string',
            'origin_story' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'special_price' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image_path && file_exists(public_path('images/' . $product->image_path))) {
                unlink(public_path('images/' . $product->image_path));
            }
            
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);
            $validated['image_path'] = $filename;
        }

        // Handle checkbox unchecked (boolean false)
        $validated['is_active'] = $request->has('is_active');

        $product->update($validated);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        if ($product->image_path && file_exists(public_path('images/' . $product->image_path))) {
            unlink(public_path('images/' . $product->image_path));
        }
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }
}
