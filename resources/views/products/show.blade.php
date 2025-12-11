<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Café Scarlet Sin | {{ $product->name }}</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700&family=Bodoni+Moda+SC:wght@400;600;700&family=Great+Vibes&family=Raleway+Dots&family=Quintessential&display=swap" rel="stylesheet">
    
    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/dark-academia.css') }}">
    
    <style>
        .product-details-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 4rem 2rem;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
        }
        
        .product-image-container {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: var(--shadow-glow);
            border: 1px solid var(--antique-gold);
            aspect-ratio: 1/1;
        }
        
        .product-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        
        .product-image:hover {
            transform: scale(1.05);
        }
        
        .product-info {
            color: var(--parchment);
        }
        
        .product-title {
            font-family: var(--font-script);
            font-size: 3.5rem;
            color: var(--antique-gold);
            margin-bottom: 1rem;
            line-height: 1.2;
        }
        
        .product-subtitle {
            font-size: 1.5rem;
            color: var(--crimson-light);
            font-style: italic;
            margin-bottom: 2rem;
            font-family: var(--font-serif);
        }
        
        .product-description {
            font-size: 1.1rem;
            line-height: 1.8;
            margin-bottom: 2rem;
        }
        
        .details-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
            background: rgba(14, 13, 13, 0.4);
            padding: 2rem;
            border-radius: 15px;
            border: 1px solid rgba(184, 134, 11, 0.3);
        }
        
        .detail-item h3 {
            color: var(--antique-gold);
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
            font-family: var(--font-serif);
        }
        
        .price-tag {
            font-size: 2.5rem;
            color: var(--antique-gold);
            font-family: var(--font-serif);
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .original-price {
            text-decoration: line-through;
            color: rgba(245, 241, 232, 0.5);
            font-size: 1.5rem;
        }
        
        .add-to-cart-btn {
            background: linear-gradient(45deg, var(--burgundy-deep), var(--crimson-dark));
            color: var(--parchment);
            border: 1px solid var(--antique-gold);
            padding: 1rem 3rem;
            font-size: 1.2rem;
            border-radius: 30px;
            cursor: pointer;
            font-family: var(--font-serif);
            transition: var(--transition-smooth);
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        
        .add-to-cart-btn:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-glow);
        }
        
        .back-link {
            display: inline-block;
            margin-top: 2rem;
            color: var(--antique-gold);
            text-decoration: none;
            font-family: var(--font-serif);
            transition: var(--transition-smooth);
        }
        
        .back-link:hover {
            color: var(--parchment);
        }
        
        @media (max-width: 768px) {
            .product-details-container {
                grid-template-columns: 1fr;
                padding: 2rem;
            }
            
            .product-title {
                font-size: 2.5rem;
            }
        }
    </style>
</head>
<body>
    <header class="header" id="header">
        <nav class="nav-container">
            <a href="{{ route('home') }}" class="logo">Café Scarlet Sin</a>
            <ul class="nav-menu" style="text-transform:uppercase">
                <li><a href="{{ route('home') }}" class="nav-link">The Parlor</a></li>
                <li><a href="{{ route('page2') }}" class="nav-link active">The Indulgences</a></li>
                <li><a href="{{ route('page3') }}" class="nav-link">The Scarlet Society</a></li>
                <li><a href="{{ route('admin.form') }}" class="nav-link">Admin</a></li>
            </ul>
            <!-- Cart Link -->
            <div style="display: flex; gap: 1rem; align-items: center;">
                <a href="{{ route('cart.index') }}" class="cart-icon" style="position: relative; text-decoration: none;">
                    <span class="cart-count">{{ $cartCount ?? 0 }}</span>
                    🛒
                </a>
            </div>
        </nav>
    </header>

    <main class="main-content" style="padding-top: 80px;">
        <div class="product-details-container">
            <!-- Product Image -->
            <div class="product-image-container">
                @if($product->image_path)
                    <img src="{{ asset('images/' . $product->image_path) }}" alt="{{ $product->name }}" class="product-image">
                @else
                    <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; background: #1a0a0a; color: var(--antique-gold); font-size: 2rem; font-family: var(--font-script);">
                        {{ $product->name }}
                    </div>
                @endif
            </div>

            <!-- Product Info -->
            <div class="product-info">
                <h1 class="product-title">{{ $product->name }}</h1>
                @if($product->description)
                    <p class="product-subtitle">{{ $product->description }}</p>
                @endif

                <div class="details-grid">
                    @if($product->ingredients)
                        <div class="detail-item">
                            <h3>Ingredients</h3>
                            <p>{{ $product->ingredients }}</p>
                        </div>
                    @endif
                    
                    @if($product->flavor_notes)
                        <div class="detail-item">
                            <h3>Flavor Notes</h3>
                            <p>{{ $product->flavor_notes }}</p>
                        </div>
                    @endif
                </div>

                @if($product->origin_story)
                    <div class="product-description">
                        <h3 style="color: var(--antique-gold); margin-bottom: 0.5rem; font-family: var(--font-serif);">Origin Story</h3>
                        <p>{{ $product->origin_story }}</p>
                    </div>
                @endif

                <div class="price-tag">
                    @if($product->special_price)
                        <span class="original-price">${{ number_format($product->price, 2) }}</span>
                        <span>${{ number_format($product->special_price, 2) }}</span>
                    @else
                        <span>${{ number_format($product->price, 2) }}</span>
                    @endif
                </div>

                <form method="POST" action="{{ route('cart.add') }}">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" class="add-to-cart-btn">Claim This Indulgence</button>
                </form>

                <a href="{{ route('page2') }}" class="back-link">← Return to Menu</a>
            </div>
        </div>
    </main>

    <!-- Main JavaScript -->
    <script src="{{ asset('js/cafe-scarlet-sin.js') }}"></script>
</body>
</html>
