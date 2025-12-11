<?php

/**
 * Order Status Configuration
 * 
 * Time windows for order status transitions (in seconds).
 * These can be adjusted for testing or production needs.
 * 
 * For testing: Set accept_window to 15 seconds to see auto-cancellation quickly.
 */

return [
    // Time window for order acceptance (default 15 minutes = 900 seconds)
    // Set to 15 for quick testing of auto-cancellation
    'accept_window' => env('ORDER_ACCEPT_WINDOW', 900),
    
    // Time between acceptance and shipping (default 15 minutes)
    'processing_time' => env('ORDER_PROCESSING_TIME', 900),
    
    // Time for delivery after shipping (default 30 minutes)
    'delivery_time' => env('ORDER_DELIVERY_TIME', 1800),
    
    // Enable automatic status progression (for testing, can disable)
    'auto_progression_enabled' => env('ORDER_AUTO_PROGRESSION', true),
];

