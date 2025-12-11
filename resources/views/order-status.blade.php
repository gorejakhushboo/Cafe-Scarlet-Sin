<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Café Scarlet Sin | Order Status</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700&family=Bodoni+Moda+SC:wght@400;600;700&family=Great+Vibes&family=Raleway+Dots&family=Quintessential&display=swap" rel="stylesheet">
    
    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/dark-academia.css') }}">
    <link rel="stylesheet" href="{{ asset('css/cart-responsive.css') }}">
    <meta http-equiv="refresh" content="30"> <!-- Auto-refresh every 30 seconds for status updates -->
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
        </nav>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <section class="order-status-section">
            <div class="container">
                <!-- Order Header -->
                <div class="order-header">
                    <h1 class="section-title">Order #{{ $order->order_number }}</h1>
                    <p class="order-date">Placed on {{ $order->created_at->format('F j, Y \a\t g:i A') }}</p>
                </div>

                <!-- Flash Messages -->
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-error">{{ session('error') }}</div>
                @endif

                <!-- Current Status Display -->
                <div class="status-display-box">
                    <div class="status-badge status-{{ $order->status }}">
                        {{ $order->status_label }}
                    </div>
                    
                

                <!-- Status Timeline -->
                <div class="status-timeline">
                    <h3>Order Timeline</h3>
                    <div class="timeline">
                        @php
                            $statuses = [
                                'new' => ['label' => 'Order Placed', 'icon' => '📝', 'date' => $order->created_at],
                                'accepted' => ['label' => 'Accepted', 'icon' => '✓', 'date' => $order->accepted_at],
                                'on_the_way' => ['label' => 'On The Way', 'icon' => '🚗', 'date' => $order->shipped_at],
                                'delivered' => ['label' => 'Delivered', 'icon' => '🎉', 'date' => $order->delivered_at],
                            ];
                            $statusOrder = ['new', 'accepted', 'on_the_way', 'delivered'];
                            $currentStatusIndex = array_search($order->status, $statusOrder);
                        @endphp

                        @foreach($statusOrder as $index => $statusKey)
                            @php
                                $statusInfo = $statuses[$statusKey] ?? null;
                                $isCompleted = $currentStatusIndex !== false && $index <= $currentStatusIndex;
                                $isCurrent = $index === $currentStatusIndex;
                            @endphp
                            
                            @if($statusInfo)
                                <div class="timeline-item {{ $isCompleted ? 'completed' : '' }} {{ $isCurrent ? 'current' : '' }}">
                                    <div class="timeline-icon">{{ $statusInfo['icon'] }}</div>
                                    <div class="timeline-content">
                                        <h4>{{ $statusInfo['label'] }}</h4>
                                        @if($statusInfo['date'])
                                            <p>{{ $statusInfo['date']->format('M j, Y g:i A') }}</p>
                                        @elseif($isCurrent)
                                            <p class="pending">Pending...</p>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        @endforeach

                        @if(in_array($order->status, ['cancelled', 'auto_cancelled']))
                            <div class="timeline-item cancelled">
                                <div class="timeline-icon">✕</div>
                                <div class="timeline-content">
                                    <h4>Order {{ $order->status === 'auto_cancelled' ? 'Auto-Cancelled' : 'Cancelled' }}</h4>
                                    <p>{{ ($order->cancelled_at ?? $order->updated_at)->format('M j, Y g:i A') }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Status Actions (if applicable) -->
                <div class="status-actions">

                    @if(!in_array($order->status, ['delivered', 'cancelled', 'auto_cancelled']))
                        <!-- Cancel Order -->
                        <form method="POST" action="{{ route('orders.cancel', $order) }}" class="inline-form">
                            @csrf
                            <button type="submit" class="btn-primary" onclick="return confirm('Are you sure you want to cancel this order?')">Cancel Order</button>
                        </form>
                    @endif
                </div>

                <!-- Order Details -->
                <div class="order-details">
                    <h3>Order Details</h3>
                    
                    <!-- Customer Information -->
                    <div class="detail-section">
                        <h4>Customer Information</h4>
                        <p><strong>Name:</strong> {{ $order->customer_name }}</p>
                        <p><strong>Email:</strong> {{ $order->customer_email }}</p>
                        <p><strong>Phone:</strong> {{ $order->customer_phone }}</p>
                        <p><strong>Address:</strong> {{ $order->customer_address }}</p>
                        @if($order->shipping_notes)
                            <p><strong>Delivery Notes:</strong> {{ $order->shipping_notes }}</p>
                        @endif
                    </div>

                    <!-- Order Items -->
                    <div class="detail-section">
                        <h4>Items</h4>
                        <table class="order-items-table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($items as $item)
                                    <tr>
                                        <td>{{ $item->product_name }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>${{ number_format($item->unit_price, 2) }}</td>
                                        <td>${{ number_format($item->total_price, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3"><strong>Subtotal:</strong></td>
                                    <td><strong>${{ number_format($order->subtotal, 2) }}</strong></td>
                                </tr>
                                <tr>
                                    <td colspan="3"><strong>Tax:</strong></td>
                                    <td><strong>${{ number_format($order->tax, 2) }}</strong></td>
                                </tr>
                                <tr>
                                    <td colspan="3"><strong>Shipping:</strong></td>
                                    <td><strong>${{ number_format($order->shipping, 2) }}</strong></td>
                                </tr>
                                <tr>
                                    <td colspan="3"><strong>Total:</strong></td>
                                    <td><strong>${{ number_format($order->total, 2) }}</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <!-- Payment Information -->
                    @if($payment)
                        <div class="detail-section">
                            <h4>Payment Information</h4>
                            <p><strong>Status:</strong> {{ ucfirst($payment->payment_status) }}</p>
                            <p><strong>Method:</strong> {{ ucfirst($payment->payment_method) }}</p>
                            <p><strong>Amount:</strong> ${{ number_format($payment->amount, 2) }}</p>
                            @if($payment->paid_at)
                                <p><strong>Paid At:</strong> {{ $payment->paid_at->format('M j, Y g:i A') }}</p>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Navigation -->
                <div class="order-navigation">
                    <a href="{{ route('page2') }}" class="btn-primary">Browse More</a>
                </div>
            </div>
        </section>
    </main>
</body>
</html>

