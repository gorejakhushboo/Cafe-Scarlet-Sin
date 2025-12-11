/* ===== CAFÉ SCARLET SIN - INTERACTIVE FEATURES ===== */
/* 
 * Note: Cart functionality has been moved to server-side form submissions.
 * This file now only contains UI enhancements (audio, status display).
 */

// Global variables (non-cart related)
let comments = JSON.parse(localStorage.getItem('societyComments')) || [];
// ===== LOADING SCREEN =====
function initializeLoadingScreen() {
    window.addEventListener('load', function () {
        setTimeout(() => {
            const loadingScreen = document.getElementById('loadingScreen');
            if (loadingScreen) {
                loadingScreen.classList.add('fade-out');
                setTimeout(() => {
                    loadingScreen.style.display = 'none';
                }, 1000);
            }
        }, 2000);
    });
}

// ===== HEADER SCROLL EFFECT =====
function initializeHeaderScroll() {
    window.addEventListener('scroll', function () {
        const header = document.getElementById('header');
        if (header) {
            if (window.scrollY > 100) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        }
    });
}

// ===== STATUS DISPLAY =====
function initializeStatusDisplay() {
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
}

// ===== QUOTE SYSTEM =====
function initializeQuoteSystem() {
    const quotes = [
        { text: "I have measured out my life with coffee spoons.", author: "T.S. Eliot" },
        { text: "Coffee is a language in itself.", author: "Jackie Chan" },
        { text: "The morning cup of coffee has an exhilaration about it which the cheering influence of the afternoon or evening cup of tea cannot be expected to reproduce.", author: "Oliver Wendell Holmes Sr." },
        { text: "Coffee should be black as hell, strong as death, and sweet as love.", author: "Turkish Proverb" },
        { text: "I orchestrate my mornings to the tune of coffee.", author: "Terri Guillemets" },
        { text: "Coffee is the best thing to douse the sunrise with.", author: "Drew Sirtors" },
        { text: "Behind every successful person is a substantial amount of coffee.", author: "Unknown" },
        { text: "Coffee is a way of stealing time that should by rights belong to your older self.", author: "Terry Pratchett" },
        { text: "Coffee: because adulting is hard.", author: "Unknown" },
        { text: "Life happens, coffee helps.", author: "Unknown" }
    ];

    function showRandomQuote() {
        const quoteOverlay = document.getElementById('quoteOverlay');
        const quoteText = document.getElementById('quoteText');
        const quoteAuthor = document.getElementById('quoteAuthor');

        if (quoteOverlay && quoteText && quoteAuthor) {
            const randomQuote = quotes[Math.floor(Math.random() * quotes.length)];
            quoteText.textContent = randomQuote.text;
            quoteAuthor.textContent = `— ${randomQuote.author}`;
            quoteOverlay.classList.add('show');
        }
    }

    // Show quote on page load
    setTimeout(showRandomQuote, 3000);

    // Close quote overlay
    const quoteClose = document.getElementById('quoteClose');
    if (quoteClose) {
        quoteClose.addEventListener('click', function () {
            const quoteOverlay = document.getElementById('quoteOverlay');
            if (quoteOverlay) {
                quoteOverlay.classList.remove('show');
            }
        });
    }
}

// ===== MENU CARD HOVER EFFECTS =====
function initializeMenuCardHover() {
    const menuCards = document.querySelectorAll('.menu-card');

    menuCards.forEach(card => {
        card.addEventListener('mouseenter', function () {
            this.classList.add('hovered');
        });

        card.addEventListener('mouseleave', function () {
            this.classList.remove('hovered');
        });
    });
}

// ===== COMMENTS SYSTEM =====
function initializeCommentsSystem() {
    // Sample comments for initial display (if using localStorage for page3)
    const sampleComments = [
        { text: "Felt like midnight in Venice", coffee: "Velvet Sin Latte", timestamp: Date.now() - 3600000 },
        { text: "This drink awakened something in me", coffee: "Crimson Mocha", timestamp: Date.now() - 7200000 },
        { text: "Pure poetry in a cup", coffee: "Whispered Desire", timestamp: Date.now() - 10800000 },
        { text: "Like dancing with shadows", coffee: "Midnight Brew", timestamp: Date.now() - 14400000 },
    ];

    // Initialize comments if empty (for page3 if still using localStorage)
    if (comments.length === 0) {
        comments = sampleComments;
        localStorage.setItem('societyComments', JSON.stringify(comments));
    }

    // Display comments (if comments container exists on page)
    function displayComments() {
        const container = document.getElementById('commentsContainer');
        if (!container) return;

        container.innerHTML = '';

        // Sort comments by timestamp (newest first)
        const sortedComments = [...comments].sort((a, b) => b.timestamp - a.timestamp);

        sortedComments.forEach(comment => {
            const commentElement = document.createElement('div');
            commentElement.className = 'floating-comment';
            commentElement.innerHTML = `
                <div class="comment-content">
                    <p class="comment-text">"${comment.text}"</p>
                    <p class="comment-coffee">— ${comment.coffee}</p>
                </div>
            `;
            container.appendChild(commentElement);
        });
    }

    // Initialize comments display
    displayComments();
}

// ===== SCROLL REVEAL ANIMATION =====
function initializeScrollReveal() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function (entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('revealed');
            }
        });
    }, observerOptions);

    document.querySelectorAll('.scroll-reveal').forEach(el => {
        observer.observe(el);
    });
}

// ===== SMOOTH SCROLLING =====
function initializeSmoothScrolling() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
}

// ===== INITIALIZATION =====
document.addEventListener('DOMContentLoaded', function () {
    // Initialize all features (cart-related removed)
    initializeLoadingScreen();
    initializeHeaderScroll();
    initializeStatusDisplay();
    initializeQuoteSystem();
    initializeMenuCardHover();
    initializeCommentsSystem();
    initializeScrollReveal();
    initializeSmoothScrolling();

    console.log('Café Scarlet Sin - UI features initialized');
});

// Export functions for global access
window.CafeScarletSin = {
    // No global functions needed currently
};

