<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: Create products table
 * Purpose: Store menu items (coffee drinks) with pricing and category information
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., "Crimson Mocha"
            $table->text('description')->nullable(); // Tagline/description
            $table->text('ingredients')->nullable(); // Ingredients list
            $table->text('flavor_notes')->nullable(); // Flavor description
            $table->text('origin_story')->nullable(); // Poetic description
            $table->string('category'); // hot, cold, non-coffee, seasonal
            $table->decimal('price', 8, 2); // Price in USD
            $table->decimal('special_price', 8, 2)->nullable(); // Discounted price if on sale
            $table->boolean('is_special')->default(false); // Mark as special/featured
            $table->string('image_path')->nullable(); // Path to product image
            $table->integer('display_order')->default(0); // For sorting
            $table->boolean('is_active')->default(true); // Show/hide product
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

