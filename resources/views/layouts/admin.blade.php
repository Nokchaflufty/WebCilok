<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Warung Cilok Mak Pik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --admin-red: #ff0000;
            --admin-sidebar-bg: #ffffff;
            --admin-content-bg: #e9e9e9;
            --admin-text: #111111;
            --admin-card-bg: #ffffff;
            --admin-border: #eeeeee;
            --admin-shadow: 0 10px 40px rgba(0,0,0,0.08);
        }

        [data-theme="dark"] {
            --admin-sidebar-bg: #1a1a1a;
            --admin-content-bg: #111111;
            --admin-text: #ffffff;
            --admin-card-bg: #2a2a2a;
            --admin-border: #333333;
            --admin-shadow: 0 10px 40px rgba(0,0,0,0.3);
        }

        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Inter', sans-serif;
            background-color: var(--admin-content-bg);
            color: var(--admin-text);
            transition: background-color 0.3s, color 0.3s;
        }
        .admin-wrapper {
            display: flex;
            min-height: 100vh;
        }
        /* Sidebar */
        .sidebar {
            width: 250px;
            background-color: var(--admin-sidebar-bg);
            display: flex;
            flex-direction: column;
            padding: 30px 0;
            flex-shrink: 0;
            box-shadow: 2px 0 10px rgba(0,0,0,0.05);
            transition: background-color 0.3s;
        }
        .sidebar-brand {
            padding: 0 25px 40px 25px;
            color: #a4232a;
            font-weight: 900;
            font-size: 1.2rem;
            line-height: 1.2;
            text-transform: uppercase;
        }
        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .sidebar-link {
            display: block;
            padding: 12px 25px;
            text-decoration: none;
            color: var(--admin-text);
            font-weight: 700;
            font-size: 0.9rem;
            transition: all 0.2s;
            margin-bottom: 5px;
        }
        .sidebar-link.active {
            background-color: var(--admin-red);
            color: white !important;
        }
        .sidebar-link:hover:not(.active) {
            background-color: rgba(255,0,0,0.1);
            color: var(--admin-red);
        }
        /* Main Content */
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        header {
            background-color: var(--admin-content-bg);
            padding: 20px 40px;
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }

        /* Theme Toggle Styling */
        .theme-toggle {
            cursor: pointer;
            border: none;
            background: none;
            font-size: 1.5rem;
            color: var(--admin-text);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 5px;
            transition: transform 0.3s ease;
        }
        .theme-toggle:hover {
            transform: scale(1.1);
        }
        [data-theme="dark"] .fa-sun { display: block; }
        [data-theme="dark"] .fa-moon { display: none; }
        .fa-sun { display: none; color: #f39c12; }
        .fa-moon { display: block; color: #2c3e50; }

        .content-body {
            padding: 0 40px 40px 40px;
            flex: 1;
        }
    </style>
</head>
<body>

    <div class="admin-wrapper">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-brand">
                WARUNG CILOK<br>PEDAS MAK PIK
            </div>
            <ul class="sidebar-menu">
                <li><a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a></li>
                <li><a href="{{ route('admin.profile') }}" class="sidebar-link {{ request()->routeIs('admin.profile') ? 'active' : '' }}">Profile</a></li>
                <li><a href="{{ route('admin.menu') }}" class="sidebar-link {{ request()->routeIs('admin.menu') ? 'active' : '' }}">Daftar Menu</a></li>
                <li><a href="{{ route('admin.transaksi') }}" class="sidebar-link {{ request()->routeIs('admin.transaksi') ? 'active' : '' }}">Transaksi</a></li>
                <li><a href="{{ route('admin.riwayat') }}" class="sidebar-link {{ request()->routeIs('admin.riwayat') ? 'active' : '' }}">Riwayat Transaksi</a></li>
                <li><a href="{{ route('admin.logout') }}" class="sidebar-link">Keluar</a></li>
            </ul>
        </aside>

        <!-- Main -->
        <main class="main-content">
            <header>
                <button id="themeToggle" class="theme-toggle" aria-label="Toggle Theme">
                    <i class="fas fa-moon"></i>
                    <i class="fas fa-sun"></i>
                </button>
            </header>
            
            <div class="content-body">
                @yield('content')
            </div>
        </main>
    </div>

    <script>
        // Theme Toggle Logic
        const themeToggle = document.getElementById('themeToggle');
        const htmlElement = document.documentElement;

        const savedTheme = localStorage.getItem('admin_theme') || 'light';
        htmlElement.setAttribute('data-theme', savedTheme);

        themeToggle.addEventListener('click', () => {
            const currentTheme = htmlElement.getAttribute('data-theme');
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';
            htmlElement.setAttribute('data-theme', newTheme);
            localStorage.setItem('admin_theme', newTheme);
        });
    </script>
</body>
</html>
