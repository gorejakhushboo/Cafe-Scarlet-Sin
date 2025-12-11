<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Café Scarlet Sin | Admin Panel</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700&family=Bodoni+Moda+SC:wght@400;600;700&family=Great+Vibes&family=Raleway+Dots&family=Quintessential&display=swap" rel="stylesheet">
    
    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/dark-academia.css') }}">
    
    <div id="js-connection-status" style="background:red; color:white; text-align:center; padding:5px; width:100%; display:block;">
        JS NOT LOADED (If you see this, the script file is missing/blocked)
    </div>
    
    <style>
        .admin-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
        }
        
        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            border-bottom: 1px solid var(--antique-gold);
            padding-bottom: 1rem;
        }
        
        .admin-title {
            color: var(--antique-gold);
            font-family: var(--font-script);
            font-size: 2.5rem;
        }

        .action-btn {
            padding: 0.5rem 1rem;
            border-radius: 5px;
            cursor: pointer;
            font-family: var(--font-serif);
            border: none;
            transition: var(--transition-smooth);
            margin-right: 0.5rem;
            text-decoration: none;
            display: inline-block;
        }
        
        .edit-btn {
            background: var(--antique-gold);
            color: var(--ink-black);
        }
        
        .delete-btn {
            background: var(--crimson-dark);
            color: var(--parchment);
        }

        .btn-secondary {
            background: transparent;
            border: 1px solid var(--antique-gold);
            color: var(--antique-gold);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            color: var(--parchment);
            background: rgba(14, 13, 13, 0.6);
            border-radius: 15px;
            overflow: hidden;
        }
        
        th, td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid rgba(184, 134, 11, 0.2);
        }
        
        th {
            color: var(--antique-gold);
            font-family: var(--font-serif);
            font-weight: 600;
            background: rgba(14, 13, 13, 0.8);
        }

        .form-group {
            margin-bottom: 1rem;
        }
        
        .form-label {
            display: block;
            color: var(--antique-gold);
            margin-bottom: 0.5rem;
            font-family: var(--font-serif);
        }
        
        .form-input, .form-textarea, .form-select {
            width: 100%;
            padding: 0.8rem;
            background: rgba(245, 241, 232, 0.1);
            border: 1px solid var(--antique-gold);
            border-radius: 5px;
            color: var(--parchment);
            font-family: var(--font-serif);
        }

        .form-select option {
            background-color: #1a0a0a;
            color: var(--parchment);
        }
        
        .submit-btn {
            padding: 1rem 2rem;
            background: linear-gradient(45deg, var(--burgundy-deep), var(--crimson-dark));
            color: var(--parchment);
            border: 1px solid var(--antique-gold);
            border-radius: 5px;
            cursor: pointer;
            font-family: var(--font-serif);
            font-weight: bold;
            transition: var(--transition-smooth);
        }

        .alert {
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 5px;
            border: 1px solid var(--antique-gold);
        }
        
        .alert-success {
            background: rgba(0, 100, 0, 0.3);
            color: #90EE90;
        }
        
        .alert-error {
            background: rgba(139, 0, 0, 0.3);
            color: #FF6347;
        }
    </style>
    <!-- Admin JavaScript -->
    <script src="{{ asset('js/admin.js') }}?v={{ time() }}"></script>
</body>
</html>
