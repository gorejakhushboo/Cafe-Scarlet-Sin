<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Café Scarlet Sin | Payment Details</title>
    
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
                <li><a href="{{ route('admin.form') }}" class="nav-link active">Admin</a></li>

            </ul>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <section class="payment-section">
            <div class="container">
                <h1 class="section-title">Complete Your Order</h1>
                <p class="section-subtitle">We'll have your indulgence ready in no time.</p>

                <!-- Flash Messages -->
                @if(session('error'))
                    <div class="alert alert-error">{{ session('error') }}</div>
                @endif

                <!-- Order Summary -->
                <div class="order-summary-box">
                    <h3>Order Summary</h3>
                    <div class="summary-items">
                        @foreach($items as $item)
                            <div class="summary-item">
                                <span>{{ $item->product->name }} × {{ $item->quantity }}</span>
                                <span>${{ number_format($item->subtotal, 2) }}</span>
                            </div>
                        @endforeach
                    </div>
                    <div class="summary-totals">
                        <div class="summary-row">
                            <span>Subtotal:</span>
                            <span>${{ number_format($subtotal, 2) }}</span>
                        </div>
                        <div class="summary-row">
                            <span>Tax:</span>
                            <span>${{ number_format($tax, 2) }}</span>
                        </div>
                        <div class="summary-row">
                            <span>Shipping:</span>
                            <span>${{ number_format($shipping, 2) }}</span>
                        </div>
                        <div class="summary-row total-row">
                            <span><strong>Total:</strong></span>
                            <span><strong>${{ number_format($total, 2) }}</strong></span>
                        </div>
                    </div>
                </div>

                <!-- Payment Details Form -->
                <form method="POST" action="{{ route('payment.store') }}" class="payment-form">
                    @csrf

                    <!-- Customer Name -->
                    <div class="form-group">
                        <label for="customer_name">Full Name *</label>
                        <input type="text" 
                               id="customer_name" 
                               name="customer_name" 
                               value="{{ old('customer_name') }}" 
                               required 
                               class="@error('customer_name') error @enderror">
                        @error('customer_name')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Customer Email -->
                    <div class="form-group">
                        <label for="customer_email">Email *</label>
                        <input type="email" 
                               id="customer_email" 
                               name="customer_email" 
                               value="{{ old('customer_email') }}" 
                               required 
                               class="@error('customer_email') error @enderror">
                        @error('customer_email')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Customer Phone -->
                    <div class="form-group">
                        <label for="customer_phone">Phone Number *</label>
                        <input type="tel" 
                               id="customer_phone" 
                               name="customer_phone" 
                               value="{{ old('customer_phone') }}" 
                               required 
                               class="@error('customer_phone') error @enderror">
                        @error('customer_phone')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Customer Address -->
                    <div class="form-group">
                        <label for="customer_address">Delivery Address *</label>
                        <textarea id="customer_address" 
                                  name="customer_address" 
                                  rows="3" 
                                  required 
                                  class="@error('customer_address') error @enderror">{{ old('customer_address') }}</textarea>
                        @error('customer_address')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Shipping Notes -->
                    <div class="form-group">
                        <label for="shipping_notes">Delivery Notes (Optional)</label>
                        <textarea id="shipping_notes" 
                                  name="shipping_notes" 
                                  rows="2" 
                                  class="@error('shipping_notes') error @enderror">{{ old('shipping_notes') }}</textarea>
                        <small>Special delivery instructions, building codes, etc.</small>
                        @error('shipping_notes')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Form Actions -->
                    <div class="form-actions">
                        <a href="{{ route('cart.index') }}" class="btn-primary">Back to Cart</a>
                        <button type="submit" class="btn-primary">Place Order</button>
                    </div>
                </form>
            </div>
        </section>
    </main>
</body>
</html>

