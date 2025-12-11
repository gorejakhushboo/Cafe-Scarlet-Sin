<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: Create orders table
 * Purpose: Store customer orders with status and timing information
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique(); // Human-readable order number (e.g., ORD-20250115-001)
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null'); // Optional: if user is logged in
            $table->string('session_id')->nullable(); // Session ID for guest orders
            
            // Customer information (denormalized for historical record)
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');
            $table->text('customer_address');
            $table->text('shipping_notes')->nullable(); // Special delivery instructions
            
            // Order status and timing
            $table->string('status')->default('new'); // new, accepted, on_the_way, delivered, cancelled, auto_cancelled
            $table->timestamp('status_changed_at')->nullable(); // When status last changed
            $table->timestamp('accepted_at')->nullable(); // When order was accepted
            $table->timestamp('shipped_at')->nullable(); // When order started delivery
            $table->timestamp('delivered_at')->nullable(); // When order was delivered
            $table->timestamp('cancelled_at')->nullable(); // When order was cancelled
            
            // Financial
            $table->decimal('subtotal', 10, 2);
            $table->decimal('tax', 10, 2)->default(0);
            $table->decimal('shipping', 10, 2)->default(0);
            $table->decimal('total', 10, 2);
            
            $table->timestamps();
            
            // Index for status queries
            $table->index('status');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

