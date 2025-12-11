<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: Create order_status_logs table
 * Purpose: Audit trail of order status changes with timestamps
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_status_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->string('old_status')->nullable(); // Previous status
            $table->string('new_status'); // New status
            $table->string('trigger')->default('manual'); // manual, automatic, system
            $table->text('notes')->nullable(); // Optional notes about the change
            $table->timestamps();
            
            // Index for order history queries
            $table->index('order_id');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_status_logs');
    }
};

