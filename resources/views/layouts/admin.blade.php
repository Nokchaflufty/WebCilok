<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Warung Cilok Mak Pik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="{{ asset('css/admin/layout.css') }}" rel="stylesheet">
</head>
<body>

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

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
            <header style="width: 100%; display: flex;">
                <button id="sidebarToggle" class="btn d-md-none" style="background: none; border: none; font-size: 1.5rem; color: var(--admin-text); padding: 0 15px 0 0; margin-right: auto;">
                    <i class="fas fa-bars"></i>
                </button>
                <button id="themeToggle" class="theme-toggle" aria-label="Toggle Theme" style="margin-left: auto;">
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
                <button id="cancelBtn" class="btn-modal btn-cancel" onclick="closeModal()">Batal</button>
                <button class="btn-modal btn-confirm" id="confirmBtn">Ya, Lanjutkan</button>
            </div>
        </div>
    </div>

    <script>
        // Modal Logic
        window.showConfirm = function(title, text, callback) {
            document.getElementById('modalTitle').innerText = title;
            document.getElementById('modalText').innerText = text;
            
            // UI Reset
            document.getElementById('cancelBtn').style.display = 'block';
            document.getElementById("confirmModal").querySelector('.modal-icon i').className = 'fas fa-exclamation-circle';
            document.getElementById("confirmModal").querySelector('.modal-icon').style.color = '#ff0000';
            
            document.getElementById('confirmModal').classList.add('active');
            
            document.getElementById('confirmBtn').onclick = function() {
                if (callback) callback();
                window.closeModal();
            };
        };

        window.showAlert = function(title, text) {
            document.getElementById('modalTitle').innerText = title;
            document.getElementById('modalText').innerText = text;
            document.getElementById('cancelBtn').style.display = 'none';
            document.getElementById("confirmModal").querySelector('.modal-icon i').className = 'fas fa-check-circle';
            document.getElementById("confirmModal").querySelector('.modal-icon').style.color = '#4CAF50';
            document.getElementById('confirmModal').classList.add('active');
            document.getElementById('confirmBtn').onclick = function() { window.closeModal(); };
        };

        window.closeModal = function() {
            document.getElementById('confirmModal').classList.remove('active');
        };

        document.getElementById('confirmModal').onclick = function(e) {
            if (e.target.id === 'confirmModal') window.closeModal();
        };

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

        // Sidebar Toggle Logic for Mobile
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.querySelector('.sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        if(sidebarToggle) {
            sidebarToggle.addEventListener('click', () => {
                sidebar.classList.add('show');
                sidebarOverlay.classList.add('show');
            });
        }
        if(sidebarOverlay) {
            sidebarOverlay.addEventListener('click', () => {
                sidebar.classList.remove('show');
                sidebarOverlay.classList.remove('show');
            });
        }
    </script>
</body>
</html>
