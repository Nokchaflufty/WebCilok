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

        /* Custom Modal Styles */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(8px);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            transition: all 0.3s ease;
        }
        .custom-modal {
            background: var(--admin-card-bg);
            border-radius: 25px;
            padding: 40px;
            width: 400px;
            text-align: center;
            box-shadow: 0 20px 60px rgba(0,0,0,0.5);
            border: 1px solid var(--admin-border);
            transform: scale(0.9);
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .modal-overlay.active {
            display: flex;
        }
        .modal-overlay.active .custom-modal {
            transform: scale(1);
        }
        .modal-icon {
            font-size: 4rem;
            color: #ff0000;
            margin-bottom: 20px;
            filter: drop-shadow(0 10px 15px rgba(255, 0, 0, 0.4));
        }
        .modal-title {
            font-size: 1.5rem;
            font-weight: 900;
            margin-bottom: 10px;
            color: var(--admin-text);
        }
        .modal-text {
            font-size: 1rem;
            color: var(--admin-text);
            opacity: 0.8;
            margin-bottom: 30px;
        }
        .modal-actions {
            display: flex;
            gap: 15px;
            justify-content: center;
        }
        .btn-modal {
            padding: 10px 30px;
            border-radius: 12px;
            font-weight: 800;
            cursor: pointer;
            border: none;
            transition: all 0.2s;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .btn-confirm {
            background: #ff0000;
            color: white;
            box-shadow: 0 8px 20px rgba(255,0,0,0.3);
        }
        .btn-cancel {
            background: #eee;
            color: #333;
        }
        [data-theme="dark"] .btn-cancel {
            background: #333;
            color: white;
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
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

    <!-- Custom Reusable Modal -->
    <div id="confirmModal" class="modal-overlay">
        <div class="custom-modal">
            <div class="modal-icon"><i class="fas fa-exclamation-circle"></i></div>
            <h3 class="modal-title" id="modalTitle">Konfirmasi</h3>
            <p class="modal-text" id="modalText">Apakah Anda yakin ingin melakukan ini?</p>
            <div class="modal-actions">
                <button class="btn-modal btn-cancel" onclick="closeModal()">Batal</button>
                <button class="btn-modal btn-confirm" id="confirmBtn">Ya, Lanjutkan</button>
            </div>
        </div>
    </div>

    <script>
        // Modal Logic
        let currentCallback = null;

        function showConfirm(title, text, callback) {
            document.getElementById('modalTitle').innerText = title;
            document.getElementById('modalText').innerText = text;
            document.getElementById('confirmModal').classList.add('active');
            currentCallback = callback;
        }

        function closeModal() {
            document.getElementById('confirmModal').classList.remove('active');
        }

        document.getElementById('confirmBtn').addEventListener('click', () => {
            if (currentCallback) currentCallback();
            closeModal();
        });

        // Close on overlay click
        document.getElementById('confirmModal').addEventListener('click', (e) => {
            if (e.target.id === 'confirmModal') closeModal();
        });

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
