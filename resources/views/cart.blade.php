<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Café Scarlet Sin | Your Cart</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700&family=Bodoni+Moda+SC:wght@400;600;700&family=Great+Vibes&family=Raleway+Dots&family=Quintessential&display=swap" rel="stylesheet">
    
    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/dark-academia.css') }}">
    <link rel="stylesheet" href="{{ asset('css/cart-responsive.css') }}">
</head>
<body class="page2">
    <!-- Header -->
    <header class="header" id="header">
        <nav class="nav-container">
            <a href="{{ route('home') }}" class="logo">Café Scarlet Sin</a>
            <ul class="nav-menu" style="text-transform:uppercase">
                <li><a href="{{ route('home') }}" class="nav-link">The Parlor</a></li>
                <li><a href="{{ route('page2') }}" class="nav-link">The Indulgences</a></li>
                <li><a href="{{ route('page3') }}" class="nav-link">The Scarlet Society</a></li>
                <li><a href="{{ route('admin.form') }}" class="nav-link">Admin</a></li>

            </ul>
            <div style="display: flex; gap: 1rem; align-items: center;">
                <a href="{{ route('cart.index') }}" class="cart-icon" style="position: relative;">
                    <span class="cart-count">{{ $cart->total_quantity }}</span>
                    🛒
                </a>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <section class="cart-section">
            <div class="container">
                <h1 class="section-title">Your Indulgences</h1>
                
                <!-- Flash Messages -->
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-error">{{ session('error') }}</div>
                @endif

                @if($items->isEmpty())
                    <!-- Empty Cart State -->
                    <div class="empty-cart">
                        <p>Your cart is empty. <a href="{{ route('page2') }}">Browse our indulgences</a>.</p>
                    </div>
                @else
                    <!-- Cart Items Table -->
                    <div class="cart-table-wrapper">
                        <table class="cart-table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Subtotal</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($items as $item)
                                    <tr>
                                        <td class="product-info" data-label="Product">
                                            <strong>{{ $item->product->name }}</strong>
                                            <p class="product-description">{{ $item->product->description }}</p>
                                        </td>
                                        <td class="price" data-label="Price">${{ number_format($item->price_at_add, 2) }}</td>
                                        <td class="quantity" data-label="Quantity">
                                            <!-- Update Quantity Form -->
                                            <form method="POST" action="{{ route('cart.update', $item) }}" class="quantity-form">
                                                @csrf
                                                @method('POST')
                                                <input type="number" 
                                                       name="quantity" 
                                                       value="{{ $item->quantity }}" 
                                                       min="1" 
                                                       max="10" 
                                                       class="quantity-input">
                                                <button type="submit" class="btn-primary">Update</button>
                                            </form>
                                        </td>
                                        <td class="subtotal" data-label="Subtotal">${{ number_format($item->subtotal, 2) }}</td>
                                        <td class="actions" data-label="Actions">
                                            <!-- Delete Item Form (POST with method spoofing) -->
                                            <form method="POST" action="{{ route('cart.destroy', $item) }}" class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-primary" onclick="return confirm('Remove this item from cart?')">Remove</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="total-label"><strong>Total</strong></td>
                                    <td class="total-amount"><strong>${{ number_format($total, 2) }}</strong></td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>

                        <!-- Cart Actions -->
                        <div class="cart-actions">
                            <a href="{{ route('page2') }}" class="btn-primary">Continue Shopping</a>
                            <form method="POST" action="{{ route('cart.clear') }}" class="inline-form">
                                @csrf
                                <button type="submit" class="btn-primary" onclick="return confirm('Clear entire cart?')">Clear Cart</button>
                            </form>
                            <a href="{{ route('payment.create') }}" class="btn-primary">Proceed to Checkout</a>
                        </div>
                    </div>
                @endif
            </div>
        </section>
    </main>
</body>
</html>

