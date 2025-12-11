<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: Create carts table
 * Purpose: Store shopping cart sessions for users (session-based cart identification)
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->string('session_id')->unique(); // Laravel session ID
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade'); // Optional: for logged-in users
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};

