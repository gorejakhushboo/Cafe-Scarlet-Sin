<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Café Scarlet Sin | The Indulgences</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700&family=Bodoni+Moda+SC:wght@400;600;700&family=Great+Vibes&family=Raleway+Dots&family=Quintessential&display=swap" rel="stylesheet">
    
    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/dark-academia.css') }}">

</head>
<body class="page2">
    <!-- Header -->
    <header class="header" id="header">
        <nav class="nav-container">
            <a href="{{ route('home') }}" class="logo">Café Scarlet Sin</a>
            <ul class="nav-menu" style="text-transform:uppercase">
                <li><a href="{{ route('home') }}" class="nav-link">The Parlor</a></li>
                <li><a href="{{ route('page2') }}" class="nav-link active">The Indulgences</a></li>
                <li><a href="{{ route('page3') }}" class="nav-link">The Scarlet Society</a></li>
                <li><a href="{{ route('admin.form') }}" class="nav-link">Admin</a></li>
            </ul>
            <!-- Cart Link (shows count) -->
            <div style="display: flex; gap: 1rem; align-items: center;">
                <a href="{{ route('cart.index') }}" class="cart-icon" style="position: relative; text-decoration: none;">
                    <span class="cart-count">{{ $cartCount ?? 0 }}</span>
                    🛒
                </a>
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
        <section class="menu-hero">
            <div class="container">
                <h1 class="menu-title">The Indulgences</h1>
                <p class="menu-subtitle">Where every sip tells a story of desire</p>
                
                <!-- Search Bar -->
                <div class="search-wrapper" style="position: relative; max-width: 600px; margin: 2rem auto;">
                    <input type="text" id="productSearch" placeholder="Search specific desires..." 
                           style="width: 100%; padding: 1rem 1.5rem; border-radius: 30px; border: 1px solid var(--antique-gold); 
                                  background: rgba(0,0,0,0.6); color: var(--parchment); font-family: var(--font-serif); font-size: 1rem;">
                    <div id="searchResults" class="search-dropdown" 
                         style="display: none; position: absolute; top: 100%; left: 0; right: 0; 
                                background: #1a1a1a; border: 1px solid var(--antique-gold); border-radius: 10px; 
                                margin-top: 0.5rem; z-index: 9999; max-height: 400px; overflow-y: auto; box-shadow: 0 10px 30px rgba(0,0,0,0.8);">
                    </div>
                </div>

                <!-- Category Filters -->
                <div class="menu-filters">
                    <a href="{{ route('page2', ['filter' => 'all']) }}" 
                       class="filter-btn {{ $filter === 'all' ? 'active' : '' }}">All Indulgences</a>
                    @foreach($allCategories as $cat)
                        <a href="{{ route('page2', ['filter' => $cat->slug]) }}" 
                           class="filter-btn {{ $filter === $cat->slug ? 'active' : '' }}">{{ $cat->name }}</a>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="alert alert-success" style="max-width: 1200px; margin: 2rem auto; padding: 1rem; background: rgba(139, 0, 0, 0.3); border: 1px solid var(--antique-gold); border-radius: 10px; color: var(--antique-gold);">
                {{ session('success') }}
            </div>
        @endif

        <!-- Menu Grid - Loop through products from database -->
        <section class="menu-section">
            <div class="container">
                @foreach($categories as $category)
                    @if($category->products->isNotEmpty())
                        <!-- Display category section -->
                        <div class="menu-category" data-category="{{ $category->slug }}">
                            <h2 class="category-title">{{ $category->name }}</h2>
                            @if($category->description)
                                <p class="category-description" style="text-align:center; color:var(--parchment); margin-bottom:2rem; font-style:italic;">{{ $category->description }}</p>
                            @endif
                            <div class="menu-grid">
                                @foreach($category->products as $product)
                                    <!-- Product Card -->
                                    <div class="menu-card" data-category="{{ $category->slug }}">
                                        <!-- Product Image -->
                                        <div class="card-image">
                                            <a href="{{ route('products.show', $product) }}" style="display:block; width:100%; height:100%; text-decoration:none;">
                                                @if($product->image_path)
                                                    <img src="{{ asset('images/' . $product->image_path) }}" 
                                                         alt="{{ $product->name }}" 
                                                         style="width: 100%; height: 100%; object-fit: cover;">
                                                @else
                                                    <div class="image-placeholder" style="width:100%; height:100%; display:flex; align-items:center; justify-content:center;">{{ $product->name }}</div>
                                                @endif
                                            </a>
                                        </div>
                                        
                                        <!-- Product Details -->
                                        <div class="card-content">
                                            <h3>{{ $product->name }}</h3>
                                            @if($product->description)
                                                <p class="card-tagline">{{ $product->description }}</p>
                                            @endif
                                            
                                            <!-- Hidden Details (shown on hover) -->
                                            <div class="card-details">
                                                @if($product->ingredients)
                                                    <p class="ingredients">Ingredients: {{ $product->ingredients }}</p>
                                                @endif
                                                @if($product->flavor_notes)
                                                    <p class="flavor-notes">Flavor Notes: {{ $product->flavor_notes }}</p>
                                                @endif
                                                @if($product->origin_story)
                                                    <p class="origin-story">{{ $product->origin_story }}</p>
                                                @endif
                                            </div>
                                            
                                            <!-- Price Display -->
                                            <div class="card-price">
                                                @if($product->special_price)
                                                    <span class="was-special-price">Was: ${{ number_format($product->price, 2) }}</span>
                                                    <span class="special-price">Now: ${{ number_format($product->special_price, 2) }}</span>
                                                @else
                                                    ${{ number_format($product->price, 2) }}
                                                @endif
                                            </div>
                                            
                                            <!-- Add to Cart Form (NO JavaScript) -->
                                            <form method="POST" action="{{ route('cart.add') }}" class="add-to-cart-form">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                <input type="hidden" name="quantity" value="1">
                                                <button type="submit" class="claim-btn">
                                                    Claim This Indulgence
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach

                @if($categories->isEmpty())
                    <!-- No Products Found -->
                    <div class="no-products" style="text-align: center; padding: 4rem 2rem; color: var(--parchment);">
                        <p style="font-size: 1.2rem;">No indulgences found in this category.</p>
                        <a href="{{ route('page2') }}" class="btn-primary" style="margin-top: 1rem; display: inline-block;">View All</a>
                    </div>
                @endif
            </div>
        </section>
    </main>

    <!-- Main JavaScript (for audio controls only, NO cart JS) -->
    <script src="{{ asset('js/cafe-scarlet-sin.js') }}"></script>
    
    <!-- Page-specific JavaScript (Status and Search only) -->
    <script>
        // Status Display
        function updateStatus() {
            const now = new Date();
            const hour = now.getHours();
            const statusIndicator = document.getElementById('statusIndicator');
            const statusText = document.getElementById('statusText');
            
            if (statusIndicator && statusText) {
                if (hour >= 6 && hour < 22) {
                    statusIndicator.className = 'status-indicator open';
                    statusText.textContent = 'Now Open';
                } else {
                    statusIndicator.className = 'status-indicator closed';
                    statusText.textContent = 'Closed';
                }
            }
        }
        updateStatus();
        setInterval(updateStatus, 60000); // Update every minute

        // Search Functionality
        const searchInput = document.getElementById('productSearch');
        const searchResults = document.getElementById('searchResults');
        let debounceTimer;

        if (searchInput && searchResults) {
            searchInput.addEventListener('input', function() { // Changed to input event for better handling
                clearTimeout(debounceTimer);
                const query = this.value.trim();

                if (query.length < 2) {
                    searchResults.style.display = 'none';
                    searchResults.innerHTML = '';
                    return;
                }

                debounceTimer = setTimeout(() => {
                    fetch(`{{ route('products.search') }}?query=${encodeURIComponent(query)}`)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            searchResults.innerHTML = '';
                            if (data.length > 0) {
                                data.forEach(product => {
                                    const item = document.createElement('a');
                                    // Use explicit ID in URL
                                    item.href = `/products/${product.id}`; 
                                    
                                    item.style.cssText = 'display: block; padding: 1rem; border-bottom: 1px solid rgba(197, 160, 89, 0.2); text-decoration: none; color: var(--parchment); transition: background 0.2s; cursor: pointer;';
                                    
                                    // Handle image path correctly
                                    const imagePath = product.image_path ? `/images/${product.image_path}` : '';
                                    const imageHtml = imagePath ? 
                                        `<img src="${imagePath}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">` :
                                        `<div style="width: 50px; height: 50px; background: #333; display: flex; align-items: center; justify-content: center; border-radius: 5px; font-size: 0.8rem;">No Img</div>`;

                                    item.innerHTML = `
                                        <div style="display: flex; align-items: center; gap: 1rem;">
                                            ${imageHtml}
                                            <div>
                                                <div style="color: var(--antique-gold); font-weight: bold;">${product.name}</div>
                                                <div style="font-size: 0.8rem; color: #888;">${product.category ? product.category.name : ''}</div>
                                            </div>
                                            <div style="margin-left: auto; color: var(--antique-gold);">$${parseFloat(product.price).toFixed(2)}</div>
                                        </div>
                                    `;
                                    
                                    item.addEventListener('mouseenter', () => item.style.background = 'rgba(197, 160, 89, 0.1)');
                                    item.addEventListener('mouseleave', () => item.style.background = 'transparent');
                                    
                                    searchResults.appendChild(item);
                                });
                                searchResults.style.display = 'block';
                            } else {
                                searchResults.innerHTML = '<div style="padding: 1rem; color: #888; text-align: center;">No indulgences found</div>';
                                searchResults.style.display = 'block';
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching search results:', error);
                            searchResults.innerHTML = '<div style="padding: 1rem; color: crimson; text-align: center;">Error loading results</div>';
                            searchResults.style.display = 'block';
                        });
                }, 300); // 300ms debounce
            });

            // Close search results when clicking outside
            document.addEventListener('click', function(e) {
                if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                    searchResults.style.display = 'none';
                }
            });
        }
    </script>

    <!-- Additional Styles for Filter Buttons as Links -->
    <style>
        /* Ensure filter-btn works as both buttons and links */
        .menu-filters .filter-btn {
            text-decoration: none;
            display: inline-block;
        }
        
        .menu-filters .filter-btn:hover {
            text-decoration: none;
        }
        
        /* Menu filters styling (if not already in CSS) */
        .menu-filters {
            display: flex;
            justify-content: center;
            gap: 1rem;
            flex-wrap: wrap;
            margin-top: 2rem;
        }
        
        .filter-btn {
            background: transparent;
            color: var(--parchment);
            border: 1px solid var(--antique-gold);
            padding: 0.8rem 1.5rem;
            border-radius: 25px;
            cursor: pointer;
            transition: var(--transition-smooth);
            font-family: var(--font-serif);
            text-decoration: none;
            display: inline-block;
        }
        
        .filter-btn:hover,
        .filter-btn.active {
            background: var(--antique-gold);
            color: var(--ink-black);
            text-decoration: none;
        }

        /* Add spacing for desktop screens */
        @media (min-width: 1200px) {
            .container {
                padding: 0 4rem;
            }
        }
    </style>
</body>
</html>
