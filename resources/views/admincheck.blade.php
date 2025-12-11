<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>

        <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700&family=Bodoni+Moda+SC:wght@400;600;700&family=Great+Vibes&family=Raleway+Dots&family=Quintessential&display=swap" rel="stylesheet">
    
    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/dark-academia.css') }}">

    <style>
        body {
            background-color: #4A0000; /* deep dark scarlet */
            color: ##B8860B;; /* gold text */
            font-family: Arial, sans-serif;
            text-align: center;
            padding-top: 80px;
            margin: 0;
        }

        h2 {
    font-size: 32px;
    margin-bottom: 30px;
    margin-top: 40px; /* <-- added space from header */
    color: #B8860B;
    text-transform: uppercase;
    letter-spacing: 2px;
     }


        form {
            display: inline-block;
            background: rgba(0, 0, 0, 0.3);
            padding: 30px 40px;
            border-radius: 12px;
            border: 2px solid #B8860B;;
            width: 350px;
            max-width: 90%;
            box-sizing: border-box;
        }

        label {
            font-size: 18px;
            color: #B8860B;;
        }

        input {
            padding: 12px;
            width: 100%;
            margin-top: 5px;
            margin-bottom: 20px;
            border: 2px solid #B8860B;;
            border-radius: 5px;
            background-color: transparent;
            color: ##B8860B;;
            box-sizing: border-box;
            font-size: 16px;
        }

        button {
            padding: 12px;
            width: 100%;
            background-color: ##B8860B;;
            border: none;
            border-radius: 6px;
            color: #4A0000;
            cursor: pointer;
            font-size: 18px;
            font-weight: bold;
            text-transform: uppercase;
        }

        button:hover {
            background-color: ##B8860B;;
        }

        p {
            color: #ff5555;
            font-weight: bold;
        }

        /* ----------------------- RESPONSIVE DESIGN ----------------------- */

        /* Tablet screens */
        @media (max-width: 768px) {
            body {
                padding-top: 60px;
            }

            h2 {
                font-size: 28px;
            }

            form {
                width: 300px;
                padding: 25px;
            }

            input, button {
                font-size: 15px;
                padding: 10px;
            }
        }

        /* Mobile screens */
        @media (max-width: 480px) {
            body {
                padding-top: 40px;
            }

            h2 {
                font-size: 24px;
            }

            form {
                width: 90%;
                padding: 20px;
                border-width: 1.5px;
            }

            input, button {
                padding: 10px;
                font-size: 14px;
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
                <li><a href="{{ route('page2') }}" class="nav-link">The Indulgences</a></li>
                <li><a href="{{ route('page3') }}" class="nav-link ">The Scarlet Society</a></li>
                <li><a href="{{ route('admin.form') }}" class="nav-link active">Admin</a></li>
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


    <h2>Admin Login</h2>

    @if(session('error'))
        <p>{{ session('error') }}</p>
    @endif

    <form action="{{ route('admin.login') }}" method="POST">
        @csrf

        <label>Username:</label><br>
        <input type="text" name="username" required><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br>

        <button type="submit" class="btn btn-primary">Login</button>
    </form>

</body>
</html>
