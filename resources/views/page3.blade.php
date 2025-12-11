<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Café Scarlet Sin | The Scarlet Society</title>
    
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
                <li><a href="{{ route('home') }}" class="nav-link">The Parlor</a></li>
                <li><a href="{{ route('page2') }}" class="nav-link">The Indulgences</a></li>
                <li><a href="{{ route('page3') }}" class="nav-link active">The Scarlet Society</a></li>
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
        <section class="society-hero">
            <div class="society-background">
                <img src="{{ asset('images/scarlet society background.jpg') }}" alt="Scarlet Society Background" style="width: 100%; height: 100%; object-fit: cover; opacity: 0.6;">
            </div>
            <div class="container">
                <h1 class="society-title" style="color: #B8860B;">The Scarlet Society</h1>
                <p class="society-subtitle" style="color:   #f5f1e8;">Where whispers become legends</p>
                <p class="society-description" style="color:  #f5f1e8;">
                    Step into our secret sanctuary where anonymous souls share their deepest coffee confessions. 
                    Here, in the flickering candlelight of shared experiences, every sip tells a story.
                </p>
            </div>
        </section>

        <!-- Comments Section -->
        <section class="comments-section">
            <div class="container">
                
                @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="add-comment-section">
    <h3>Leave a whisper of your indulgence...</h3>
    <form class="comment-form" method="POST" action="{{ route('addComment') }}">
        @csrf
        <div class="comment-box">
        <label for="com">Share your experience with our indulgences...</label><br>
        <input type="text" id="com" name="com" required>
        </div>

        <select id="coffeeSelect" name="drink" required>
            <option value="">Select your indulgence...</option>
            <option value="Crimson Mocha">Crimson Mocha</option>
            <option value="Velvet Sin Latte">Velvet Sin Latte</option>
            <option value="Midnight Brew">Midnight Brew</option>
            <option value="Whispered Desire">Whispered Desire</option>
            <option value="Amber Macchiato">Amber Macchiato</option>
            <option value="Burnt Sugar Bliss">Burnt Sugar Bliss</option>
            <option value="Blush Cold Brew">Blush Cold Brew</option>
            <option value="Scarlet Frost">Scarlet Frost</option>
            <option value="Honey Bloom Latte">Honey Bloom Latte</option>
            <option value="Moonlight Iced Latte">Moonlight Iced Latte</option>
            <option value="Berry Temptation">Berry Temptation</option>
            <option value="Sinful Caramel Chill">Sinful Caramel Chill</option>
            <option value="Crimson Bloom Tea">Crimson Bloom Tea</option>
            <option value="Golden Chai">Golden Chai</option>
            <option value="Sinful Matcha">Sinful Matcha</option>
            <option value="Lover's Lemonade">Lover's Lemonade</option>
            <option value="Autumn Ember Latte">Autumn Ember Latte</option>
            <option value="Winter Cocoa">Winter Cocoa</option>
            <option value="Summer Sin Spritz">Summer Sin Spritz</option>
            <option value="Spring Blush Brew">Spring Blush Brew</option>
        </select>

        <button type="submit" class="submit-comment-btn">Whisper to the Society</button>
    </form>
</div>
            </div>
        </section>

          <!-- Find Us Section -->
        <section class="find-us-section">
            <div class="container">
                <h2 class="section-title">Find Us</h2>
                <p class="section-subtitle">We'd love to welcome you in person — come taste sin in a cup.</p>
                <div class="map-container">
                    <div class="map-wrapper">
                        <!-- Google Maps Embed -->
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3022.2153310123456!2d-74.005941!3d40.712776!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNDDCsDQyJzQ2LjAiTiA3NMKwMDAnMjEuNCJX!5e0!3m2!1sen!2sus!4v1234567890123!5m2!1sen!2sus"
                            width="100%" 
                            height="400" 
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
            </div>
        </section>

        <!-- Café Gallery Section -->
        <section class="gallery-section">
            <div class="container">
                <h2 class="section-title">Our Sanctuary</h2>
                <p class="section-subtitle">Step into our world of dark elegance and whispered secrets</p>
                <div class="gallery-grid">
                    <div class="gallery-card">
                        <div class="gallery-image">
                            <img src="{{ asset('images/lounge area.jpg') }}" alt="Lounge Area" style="width: 100%; height: 100%; object-fit: cover;">
                            <div class="gallery-overlay">
                                <h3>Lounge Area</h3>
                            </div>
                        </div>
                        <div class="gallery-caption">
                            <p>Where shadows dance and conversations flow like wine</p>
                        </div>
                    </div>

                    <div class="gallery-card">
                        <div class="gallery-image">
                            <img src="{{ asset('images/coffee bar.jpg') }}" alt="Coffee Bar" style="width: 100%; height: 100%; object-fit: cover;">
                            <div class="gallery-overlay">
                                <h3>Coffee Bar</h3>
                            </div>
                        </div>
                        <div class="gallery-caption">
                            <p>Our alchemists craft your perfect indulgence</p>
                        </div>
                    </div>

                    <div class="gallery-card">
                        <div class="gallery-image">
                            <img src="{{ asset('images/readnook.jpg') }}" alt="Reading Nook" style="width: 100%; height: 100%; object-fit: cover;">
                            <div class="gallery-overlay">
                                <h3>Reading Nook</h3>
                            </div>
                        </div>
                        <div class="gallery-caption">
                            <p>A quiet corner for whispered thoughts and stolen moments</p>
                        </div>
                    </div>

                    <div class="gallery-card">
                        <div class="gallery-image">
                            <img src="{{ asset('images/mainhall.jpg') }}" alt="Main Hall" style="width: 100%; height: 100%; object-fit: cover;">
                            <div class="gallery-overlay">
                                <h3>Main Hall</h3>
                            </div>
                        </div>
                        <div class="gallery-caption">
                            <p>The heart of our sanctuary, where every story begins</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    <!-- Main JavaScript -->
    <script src="{{ asset('js/cafe-scarlet-sin.js') }}"></script>
    <script>
    
    </script>

    <!-- Additional Styles -->
    <style>
        /* Page 3 specific background */
        body {
            background: url('../images/scarlet society background.jpg') center/cover no-repeat fixed;
            background-attachment: fixed;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .society-background {
            position: absolute;
            top: 50;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
        }

        .society-title {
            font-family: var(--font-script);
            font-size: 3.5rem;
            color: var(--antique-gold);
            max-width: 800px;
            margin: 0 auto;
            line-height: 1.8;
            text-shadow: var(--shadow-glow);
            position: relative;
            z-index: 2;
        }

        .society-subtitle {
            font-size: 1.1rem;
            color: var(--parchment);
            max-width: 800px;
            margin: 0 auto;
            line-height: 1.8;
            position: relative;
            z-index: 2;
        }

        .society-description {
            font-size: 1.1rem;
            color: var(--parchment);
            max-width: 800px;
            margin: 0 auto;
            line-height: 1.8;
            position: relative;
            z-index: 2;
        }

        .comments-section {
            padding: 4rem 0;
            background: rgba(14, 13, 13, 0.3);
            position: relative;
        }

        .comments-container {
            min-height: 400px;
            position: relative;
            margin-bottom: 3rem;
        }

        .comment-content {
            text-align: center;
        }

        .comment-text {
            color: var(--parchment);
            font-style: italic;
            margin-bottom: 0.5rem;
            font-size: 1rem;
        }

        .comment-coffee {
            color: var(--antiquegold);
            font-weight: 600;
            font-size: 0.9rem;
        }

        .add-comment-section {
            background: rgba(14, 13, 13, 0.6);
            padding: 3rem;
            border-radius: 20px;
            border: 1px solid var(--antique-gold);
            text-align: center;
        }

        .add-comment-section h3 {
            color: var(--antique-gold);
            font-family: var(--font-script);
            font-size: 1.8rem;
            margin-bottom: 2rem;
        }

        .comment-form {
            max-width: 600px;
            margin: 0 auto;
        }

        .comment-form textarea {
            width: 100%;
            height: 120px;
            background: rgba(245, 241, 232, 0.9);
            border: 1px solid var(--antique-gold);
            border-radius: 10px;
            padding: 1rem;
            font-family: var(--font-serif);
            font-size: 1rem;
            color: var(--ink-black);
            resize: vertical;
            margin-bottom: 1rem;
        }

        .comment-form input {
            width: 100%;
            background: rgba(245, 241, 232, 0.9);
            border: 1px solid var(--antique-gold);
            border-radius: 10px;
            padding: 1rem;
            font-family: var(--font-serif);
            font-size: 1rem;
            color: var(--ink-black);
            margin-bottom: 1.5rem;
        }

        .comment-form select {
            width: 100%;
            background: rgba(245, 241, 232, 0.9);
            border: 1px solid var(--antique-gold);
            border-radius: 10px;
            padding: 1rem;
            font-family: var(--font-serif);
            font-size: 1rem;
            color: var(--ink-black);
            margin-bottom: 1.5rem;
        }

        .submit-comment-btn {
            background: linear-gradient(45deg, var(--burgundy-deep), var(--crimson-dark));
            color: var(--parchment);
            border: none;
            padding: 1rem 2rem;
            border-radius: 25px;
            cursor: pointer;
            transition: var(--transition-smooth);
            font-family: var(--font-serif);
            font-weight: 600;
            font-size: 1.1rem;
        }

        .submit-comment-btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-glow);
        }

    
         /* Find Us Section Styles */
        .find-us-section {
            padding: 80px 0;
            background: linear-gradient(135deg, #1a0a0a 0%, #2d1b1b 50%, #1a0a0a 100%);
            position: relative;
        }

        .map-container {
            margin-top: 40px;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.6);
            border: 1px solid rgba(139, 69, 19, 0.3);
        }

        .map-wrapper {
            position: relative;
            background: #1a0a0a;
        }

        .map-wrapper iframe {
            border-radius: 15px;
        }

        /* Gallery Section Styles */
        .gallery-section {
            padding: 80px 0;
            background: linear-gradient(135deg, #1a0a0a 0%, #2d1b1b 50%, #1a0a0a 100%);
            position: relative;
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-top: 50px;
        }

        .gallery-card {
            background: linear-gradient(145deg, #2a1a1a, #1f0f0f);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.6);
            transition: all 0.4s ease;
            border: 1px solid rgba(139, 69, 19, 0.3);
        }

        .gallery-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.8);
        }

        .gallery-image {
            height: 250px;
            position: relative;
            overflow: hidden;
        }

        .gallery-image img {
            transition: all 0.4s ease;
        }

        .gallery-card:hover .gallery-image img {
            transform: scale(1.1);
            filter: brightness(0.7);
        }

        .gallery-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(139, 69, 19, 0.8), rgba(212, 175, 55, 0.8));
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: all 0.4s ease;
        }

        .gallery-card:hover .gallery-overlay {
            opacity: 1;
        }

        .gallery-overlay h3 {
            color: #1a0a0a;
            font-size: 1.8rem;
            font-weight: bold;
            text-align: center;
            margin: 0;
        }

        .gallery-caption {
            padding: 20px;
            text-align: center;
        }

        .gallery-caption p {
            color: #ccc;
            font-style: italic;
            margin: 0;
            line-height: 1.4;
        }

        @media (max-width: 768px) {
            .society-title {
                font-size: 2.5rem;
            }
            
            .add-comment-section {
                padding: 2rem;
            }
        }
    </style>
</body>
</html>