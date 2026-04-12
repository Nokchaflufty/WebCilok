<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Warung Cilok Pedas Mak Pik</title>
    <!-- Bootstrap CSS (lightweight, hanya untuk grid dan reset) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome (opsional untuk ikon kontak) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Custom CSS sesuai desain -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>

    <!-- NAVIGASI: HOME | ABOUT US | MENU | PEMESANAN -->
    <style>
        body {
            background-color: var(--bg-color) !important;
            color: var(--text-color) !important;
        }
        .navbar-custom {
            padding: 0; 
            background-color: var(--navbar-bg) !important; 
            border-bottom: 1px solid var(--border-color); 
            text-align: left;
            box-shadow: 0 4px 6px rgba(0,0,0,0.02);
            display: flex;
            align-items: center; 
            height: 70px; 
            overflow: visible;
        }
        .navbar-custom .container {
            display: flex;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            position: relative; 
            width: 100%;
            height: 100%;
        }
        .navbar-logo-container {
            flex: 0 0 auto;
            display: flex;
            align-items: center;
        }
        .navbar-logo {
            width: 60px;
            height: 60px; 
            border-radius: 50%;
            object-fit: cover;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            background-color: #f15a24;
        }
        .nav-links {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            align-items: center;
            gap: 4rem; /* Tightened gap to fit 5 buttons comfortably */
            white-space: nowrap;
        }
        
        .nav-links a {
            text-decoration: none;
            color: var(--text-color);
            font-size: 1.1rem; /* Reverted back to original size */
            font-weight: 800; /* Thick bold font */
            text-transform: uppercase;
        }

        /* Theme Toggle Styling */
        .theme-toggle {
            cursor: pointer;
            border: none;
            background: none;
            font-size: 1.5rem;
            color: var(--text-color);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 5px;
            transition: transform 0.3s ease;
            position: absolute;
            right: 15px;
        }
        .theme-toggle:hover {
            transform: scale(1.1);
        }
        [data-theme="dark"] .fa-sun { display: block; }
        [data-theme="dark"] .fa-moon { display: none; }
        .fa-sun { display: none; color: #f39c12; }
        .fa-moon { display: block; color: #2c3e50; }
        
        .nav-links a.active {
            color: #a4232a !important; /* Deep red for active link */
            text-decoration: none !important;
            font-weight: 800 !important;
        }
        
        .nav-links a:hover {
            color: #a4232a;
        }
        
        @media (max-width: 900px) {
            .nav-links {
                position: static;
                transform: none;
                flex: 1;
                justify-content: flex-end;
                gap: 2rem;
            }
        }
        
        .nav-links {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            align-items: center;
            gap: 3.5rem; /* Slightly reduced gap to accommodate the button padding */
            white-space: nowrap;
        }
        
        .nav-links a {
            text-decoration: none;
            color: var(--text-color);
            font-size: 1.1rem; 
            font-weight: 800; 
            text-transform: uppercase;
        }

        .btn-login {
            background-color: #a4232a;
            color: white !important;
            padding: 8px 25px;
            border-radius: 50px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
            transition: transform 0.2s, background-color 0.2s;
        }

        .btn-login:hover {
            background-color: #8c1e24;
            transform: translateY(-2px);
            color: white !important;
        }
    </style>
    
    <nav class="navbar-custom">
        <div class="container">
            <div class="navbar-logo-container">
                <!-- Fallback to a placeholder if the actual logo image is not in public/images yet -->
                <img src="{{ asset('images/logo.jpeg') }}" alt="Logo" class="navbar-logo" onerror="this.onerror=null; this.src='https://placehold.co/100x100/f15a24/white?text=Mak+Pik';">
            </div>
            <div class="nav-links">
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">HOME</a>
                <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">ABOUT US</a>
                <a href="{{ route('menu') }}" class="{{ request()->routeIs('menu') ? 'active' : '' }}">MENU</a>

                <a href="{{ route('admin.login') }}" class="btn-login">LOGIN</a>
            </div>
            <button id="themeToggle" class="theme-toggle" aria-label="Toggle Theme">
                <i class="fas fa-moon"></i>
                <i class="fas fa-sun"></i>
            </button>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    <script>
        // Theme Toggle Logic
        const themeToggle = document.getElementById('themeToggle');
        const htmlElement = document.documentElement;

        const savedTheme = localStorage.getItem('theme') || 'light';
        htmlElement.setAttribute('data-theme', savedTheme);

        themeToggle.addEventListener('click', () => {
            const currentTheme = htmlElement.getAttribute('data-theme');
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';
            htmlElement.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
        });
    </script>
    @stack('scripts')
</body>
</html>