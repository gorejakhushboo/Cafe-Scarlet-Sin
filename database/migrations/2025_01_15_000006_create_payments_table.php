<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: Create payments table
 * Purpose: Store payment information for orders
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->unique()->constrained()->onDelete('cascade');
            $table->string('payment_method')->default('cash'); // cash, card, online
            $table->string('payment_status')->default('pending'); // pending, paid, failed, refunded
            $table->decimal('amount', 10, 2);
            $table->string('transaction_id')->nullable(); // External payment gateway transaction ID
            $table->timestamp('paid_at')->nullable();
            $table->text('notes')->nullable(); // Additional payment notes
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};

