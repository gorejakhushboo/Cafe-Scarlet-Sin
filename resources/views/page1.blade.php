<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Café Scarlet Sin | The Parlor</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700&family=Bodoni+Moda+SC:wght@400;600;700&family=Great+Vibes&family=Raleway+Dots&family=Quintessential&display=swap" rel="stylesheet">
    
    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/dark-academia.css') }}">
    
</head>
<body>
    <!-- Header -->
    <header class="header" id="header">
        <nav class="nav-container">
            <a href="{{ route('home') }}" class="logo">Café Scarlet Sin</a>
            <ul class="nav-menu" style="text-transform:uppercase">
                <li><a href="{{ route('home') }}" class="nav-link active">The Parlor</a></li>
                <li><a href="{{ route('page2') }}" class="nav-link">The Indulgences</a></li>
                <li><a href="{{ route('page3') }}" class="nav-link">The Scarlet Society</a></li>
                <li><a href="{{ route('admin.form') }}" class="nav-link">Admin</a></li>
            </ul>
            <!-- Cart  -->
            <div style="display: flex; gap: 1rem; align-items: center;">
                <div class="cart-icon" id="cartIcon">
                    <span class="cart-count" id="cartCount">0</span>
                    🛒
                </div>
                <div class="status-display" style="position:static; background:rgba(14,13,13,.6); border:none; padding:.5rem 1rem; border-radius:12px;">
                    <span class="status-indicator" id="statusIndicator"></span>
                    <span class="status-text" id="statusText">Now Open</span>
                </div>
            </div>
        </nav>
    </header>



    <!-- Main Content -->
    <main class="main-content">
        <!-- Hero Section -->
        <section class="hero">
            
            <div class="hero-content">
                <h1 class="hero-title">Welcome to the Parlor</h1>
                <p class="hero-subtitle">Where shadows dance with golden whispers</p>
                <p class="hero-description">
                    Step into a realm where every sip tells a story, where the aroma of roasted dreams 
                    mingles with the poetry of midnight desires. Here, in our crimson-lit sanctuary, 
                    time slows and souls awaken.
                </p>
            </div>
        </section>

        <!-- About Section -->
        <section class="about-section scroll-reveal">
            <div class="container">
                <h2 class="section-title">A Sanctuary for the Soul</h2>
                <div class="about-grid">
                    <div class="about-card scroll-reveal">
                        <div class="card-icon">☕</div>
                        <h3>Artisanal Craftsmanship</h3>
                        <p>Each brew is a carefully orchestrated symphony of flavors, crafted by masters who understand the poetry of coffee.</p>
                    </div>
                    <div class="about-card scroll-reveal">
                        <div class="card-icon">📜</div>
                        <h3>Poetic Experience</h3>
                        <p>Our menu reads like verses from forbidden letters, each drink a stanza in the epic of indulgence.</p>
                    </div>
                    <div class="about-card scroll-reveal">
                        <div class="card-icon">🕯️</div>
                        <h3>Ambient Atmosphere</h3>
                        <p>Soft jazz melodies and candlelit corners create the perfect backdrop for your moments of reflection.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Featured Indulgences -->
        <section class="featured-section scroll-reveal">
            <div class="container">
                <h2 class="section-title">Society's Favourite Indulgences</h2>
                <div class="featured-grid">
                    <div class="featured-card scroll-reveal">
                        <div class="card-image" style="height: 500px;">
                            <img src="{{ asset('images/lemonade.jpg') }}" alt="Lover's lemonade" style="width:100%;height:100%;object-fit:cover;">
                        </div>
                        <div class="card-content">
                            <h3>Lover's Lemonade</h3>
                            <p class="card-tagline">Sparkling lemonade with strawberry syrup</p>
                            <p class="card-description">A fruity twist on classic refreshment, perfect for summer days.</p>
                        </div>
                    </div>

                    <div class="featured-card scroll-reveal">
                        <div class="card-image" style="height:500px;">
                            <img src="{{ asset('images/burnt sugar bliss.jpg') }}" alt="Burnt Sugar Bliss" style="width:100%;height:100%;object-fit:cover;">
                        </div>
                        <div class="card-content">
                            <h3>Burnt Sugar Bliss</h3>
                            <p class="card-tagline">Espresso caramelized with raw sugar and sea salt</p>
                            <p class="card-description">Intense yet balanced, like the perfect storm of sweetness and salt.</p>
                        </div>
                    </div>

                    <div class="featured-card scroll-reveal">
                        <div class="card-image" style="height: 500px;">
                            <img src="{{ asset('images/Autum Ember Latte.jpg') }}" alt="Autumn Ember Latte" style="width:100%;height:100%;object-fit:cover;">
                        </div>
                        <div class="card-content">
                            <h3>Autumn Ember Latte</h3>
                            <p class="card-tagline">Pumpkin spice latte with cinnamon dust</p>
                            <p class="card-description">Warm and cozy like autumn evenings by the fireplace.</p>
                        </div>
                    </div>
                </div>
            </div>
    </section>
    </main>

    <!-- Main JavaScript -->
    <script src="{{ asset('js/cafe-scarlet-sin.js') }}"></script>
    
    <!-- Page-specific JavaScript -->
    <script>
        // Status Display
        function updateStatus() {
            const now = new Date();
            const hour = now.getHours();
            const statusIndicator = document.getElementById('statusIndicator');
            const statusText = document.getElementById('statusText');
            
            if (hour >= 6 && hour < 22) {
                statusIndicator.className = 'status-indicator open';
                statusText.textContent = 'Now Open';
            } else {
                statusIndicator.className = 'status-indicator closed';
                statusText.textContent = 'Closed';
            }
        }
        updateStatus();
        setInterval(updateStatus, 60000); // Update every minute

    </script>

    <!-- Additional Styles for New Elements -->
    <style>
        .cart-icon {
            position: relative;
            font-size: 1.5rem;
            cursor: pointer;
            transition: var(--transition-smooth);
            color: var(--antique-gold);
        }

        .cart-icon:hover {
            transform: scale(1.1);
        }

        .cart-count {
            position: absolute;
            top: -8px;
            right: -8px;
            background: var(--crimson-dark);
            color: var(--parchment);
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            font-weight: 600;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .about-section {
            padding: 6rem 0;
            background: rgba(14, 13, 13, 0.3);
        }

        .about-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .about-card {
            background: rgba(75, 30, 30, 0.3);
            padding: 2rem;
            border-radius: 15px;
            border: 1px solid var(--antique-gold);
            text-align: center;
            transition: var(--transition-smooth);
        }

        .about-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-glow);
        }

        .card-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .about-card h3 {
            color: var(--antique-gold);
            margin-bottom: 1rem;
            font-size: 1.3rem;
        }

        .featured-section {
            padding: 6rem 0;
        }

        .featured-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
        }

        .featured-card {
            background: rgba(14, 13, 13, 0.5);
            border-radius: 20px;
            overflow: hidden;
            border: 1px solid var(--antique-gold);
            transition: var(--transition-smooth);
        }

        .featured-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-glow);
        }

        .card-image {
            height: 200px;
            background: linear-gradient(45deg, var(--burgundy-deep), var(--crimson-dark));
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .image-placeholder {
            color: var(--antique-gold);
            font-family: var(--font-script);
            font-size: 1.5rem;
            text-shadow: var(--shadow-glow);
        }

        .card-content {
            padding: 2rem;
        }

        .card-content h3 {
            color: var(--antique-gold);
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .card-tagline {
            color: var(--antique-gold-light);
            font-style: italic;
            margin-bottom: 1rem;
        }

        .card-description {
            color: var(--parchment);
            line-height: 1.6;
        }

        .section-title {
            color: var(--antique-gold-light)
        }

        @media (max-width: 768px) {
            .section-title {
                font-size: 2rem;
            }
            
            .about-grid,
            .featured-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</body>
</html>