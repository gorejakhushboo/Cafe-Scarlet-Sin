# Cart & Order Implementation Documentation

## Overview

This document describes the database-driven cart and order workflow implementation for Café Scarlet Sin. All cart interactions are now handled via server-side form submissions (no JavaScript required).

## Database Schema

### Tables Created

1. **products** - Menu items (coffee drinks) with pricing and category information
2. **carts** - Shopping cart sessions (session-based identification)
3. **cart_items** - Individual items in a cart (product + quantity)
4. **orders** - Customer orders with status tracking
5. **order_items** - Items in an order (product snapshot)
6. **payments** - Payment information for orders
7. **order_status_logs** - Audit trail of order status changes

### Migration Files

- `2025_01_15_000001_create_products_table.php`
- `2025_01_15_000002_create_carts_table.php`
- `2025_01_15_000003_create_cart_items_table.php`
- `2025_01_15_000004_create_orders_table.php`
- `2025_01_15_000005_create_order_items_table.php`
- `2025_01_15_000006_create_payments_table.php`
- `2025_01_15_000007_create_order_status_logs_table.php`

## Routes

### Cart Routes
- `GET /cart` - View cart (`cart.index`)
- `POST /cart/add` - Add product to cart (`cart.add`)
- `POST /cart/{cartItem}/update` - Update item quantity (`cart.update`)
- `DELETE /cart/{cartItem}` - Remove item from cart (`cart.destroy`)
- `POST /cart/clear` - Clear entire cart (`cart.clear`)

### Payment Routes
- `GET /payment/checkout` - Show payment details form (`payment.create`)
- `POST /payment/process` - Process payment and create order (`payment.store`)

### Order Routes
- `GET /orders/{order}` - View order status (`orders.show`)
- `POST /orders/{order}/accept` - Accept order (`orders.accept`)
- `POST /orders/{order}/ship` - Mark as shipped (`orders.ship`)
- `POST /orders/{order}/deliver` - Mark as delivered (`orders.deliver`)
- `POST /orders/{order}/cancel` - Cancel order (`orders.cancel`)

## Configuration

### Order Status Time Windows

Edit `config/order_status.php` or set environment variables:

```php
// For quick testing (15 seconds)
ORDER_ACCEPT_WINDOW=15
ORDER_PROCESSING_TIME=15
ORDER_DELIVERY_TIME=30

// For production (default values)
ORDER_ACCEPT_WINDOW=900  // 15 minutes
ORDER_PROCESSING_TIME=900 // 15 minutes
ORDER_DELIVERY_TIME=1800  // 30 minutes
```

## Order Status Flow

The order status follows a time-responsive state machine:

1. **new** - Order created, waiting for acceptance
   - Auto-cancels if not accepted within `accept_window` (default: 15 minutes)
   
2. **accepted** - Order accepted by staff/system
   - Auto-advances to `on_the_way` after `processing_time` (default: 15 minutes)
   
3. **on_the_way** - Order shipped/in transit
   - Auto-advances to `delivered` after `delivery_time` (default: 30 minutes)
   
4. **delivered** - Order completed (final state)

5. **cancelled** - Order manually cancelled (final state)

6. **auto_cancelled** - Order auto-cancelled due to timeout (final state)

## Setup Instructions

1. **Run Migrations**
   ```bash
   php artisan migrate
   ```

2. **Seed Products**
   ```bash
   php artisan db:seed --class=ProductSeeder
   ```

3. **Configure Time Windows (Optional)**
   
   For testing with 15-second windows, add to `.env`:
   ```env
   ORDER_ACCEPT_WINDOW=15
   ORDER_PROCESSING_TIME=15
   ORDER_DELIVERY_TIME=30
   ```

4. **Clear Cache**
   ```bash
   php artisan config:clear
   ```

## Manual Test Checklist

### Cart Operations

- [ ] **Add to Cart**: Click "Claim This Indulgence" button on a product card
  - Expected: Redirects to cart page with success message
  - Verify: Item appears in cart with correct quantity (1)
  - Verify: Database has cart and cart_item records

- [ ] **Update Quantity**: Change quantity in cart and click "Update"
  - Expected: Quantity updates in database and cart display
  - Verify: Total recalculates correctly

- [ ] **Delete Item**: Click "Remove" button on cart item
  - Expected: Item removed from cart
  - Verify: Item deleted from database
  - Verify: Cart total recalculates

- [ ] **Clear Cart**: Click "Clear Cart" button
  - Expected: All items removed
  - Verify: All cart_items deleted from database

### Payment & Order Creation

- [ ] **Checkout Flow**: Add items to cart, click "Proceed to Checkout"
  - Expected: Redirects to payment details form
  - Verify: Order summary shows correct items and totals

- [ ] **Payment Form Validation**: Submit form with invalid data
  - Expected: Validation errors displayed
  - Verify: Required fields enforced (name, email, phone, address)

- [ ] **Order Creation**: Submit valid payment form
  - Expected: Order created with status "new"
  - Verify: `orders` table has new record
  - Verify: `order_items` created for each cart item
  - Verify: `payments` record created
  - Verify: `order_status_logs` has initial entry
  - Verify: Cart is cleared

- [ ] **Order Number**: Verify order number format
  - Expected: Format `ORD-YYYYMMDD-###` (e.g., ORD-20250115-001)

### Order Status Transitions

- [ ] **View Order Status**: Navigate to order status page
  - Expected: Shows current status, timeline, order details
  - Verify: Time remaining displayed (if applicable)

- [ ] **Accept Order** (within accept window):
  - Expected: Status changes to "accepted"
  - Verify: `accepted_at` timestamp set
  - Verify: Status log entry created
  - Verify: Time remaining updates for next phase

- [ ] **Auto-Cancellation** (test with 15-second window):
  - Wait 15+ seconds after order creation
  - Refresh order status page
  - Expected: Status auto-changes to "auto_cancelled"
  - Verify: Status log shows automatic trigger

- [ ] **Auto-Progression to On The Way** (test with 15-second processing):
  - Accept order
  - Wait 15+ seconds
  - Refresh order status page
  - Expected: Status auto-changes to "on_the_way"
  - Verify: `shipped_at` timestamp set

- [ ] **Auto-Progression to Delivered** (test with 30-second delivery):
  - Wait for order to be "on_the_way"
  - Wait 30+ seconds
  - Refresh order status page
  - Expected: Status auto-changes to "delivered"
  - Verify: `delivered_at` timestamp set
  - Verify: Payment status updates to "paid"

- [ ] **Manual Status Actions**:
  - Verify "Accept Order" button only shows for "new" status
  - Verify "Mark as On The Way" only shows for "accepted" status
  - Verify "Mark as Delivered" only shows for "on_the_way" status
  - Verify "Cancel Order" available until final states

### Time Windows Testing (Quick Test Mode)

1. Set `.env`:
   ```env
   ORDER_ACCEPT_WINDOW=15
   ORDER_PROCESSING_TIME=15
   ORDER_DELIVERY_TIME=30
   ```

2. Clear config cache: `php artisan config:clear`

3. Create an order and observe:
   - Order created at time T
   - At T+15s: Auto-cancelled (if not accepted)
   - If accepted at T+5s: At T+20s (T+5+15): Auto-ships
   - If shipped at T+20s: At T+50s (T+20+30): Auto-delivered

## Files Changed/Created

### New Files
- Controllers: `CartController.php`, `PaymentController.php`, `OrderController.php`, `MenuController.php`
- Models: `Product.php`, `Cart.php`, `CartItem.php`, `Order.php`, `OrderItem.php`, `Payment.php`, `OrderStatusLog.php`
- Views: `cart.blade.php`, `payment-details.blade.php`, `order-status.blade.php`
- Migrations: 7 migration files
- Seeders: `ProductSeeder.php`
- Config: `config/order_status.php`
- CSS: `public/css/cart-responsive.css`

### Modified Files
- `routes/web.php` - Added new routes
- `resources/views/page2.blade.php` - Converted to database-driven with form submissions
- `public/js/cafe-scarlet-sin.js` - Removed cart-related JavaScript
- `database/seeders/DatabaseSeeder.php` - Added ProductSeeder call

### Removed Features
- JavaScript-based cart operations (localStorage)
- Cart modal JavaScript
- Client-side cart calculations
- JavaScript menu filtering (now uses URL parameters)

## Key Implementation Details

1. **Session-Based Cart Identification**: Carts are identified by Laravel session ID, allowing guest checkout

2. **Price Snapshot**: Cart items store `price_at_add` to protect against price changes during checkout

3. **Order Status Calculation**: Status is recalculated on each page view based on timestamps and configurable time windows

4. **Automatic Status Progression**: Orders automatically advance through states based on time elapsed

5. **Audit Trail**: All status changes are logged in `order_status_logs` with trigger type (manual/automatic/system)

6. **Form-Based Operations**: All cart interactions use HTML forms with CSRF protection - no JavaScript required

## Notes

- For testing auto-cancellation quickly, set `ORDER_ACCEPT_WINDOW=15` in `.env`
- The order status page auto-refreshes every 30 seconds for status updates
- All forms include CSRF tokens for security
- Cart persists across page refreshes via database (not localStorage)
- Products can be marked as active/inactive, special/regular price
- Order totals include subtotal, tax (10%), and shipping (currently $0)

