@extends('layouts.admin')

@section('page_title', 'Dashboard')

@section('content')
<style>
    .welcome-text {
        color: #888;
        font-weight: 600;
        margin-bottom: 25px;
    }
    .stats-container {
        display: flex;
        gap: 30px;
        margin-bottom: 40px;
    }
    .stat-card {
        background: var(--admin-card-bg);
        border-radius: 15px;
        padding: 12px 15px;
        flex: 1;
        display: flex;
        align-items: center;
        gap: 15px;
        box-shadow: var(--admin-shadow);
        border: 1px solid var(--admin-border);
    }
    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        justify-content: center;
        align-items: center;
        color: white;
        font-size: 1.5rem;
    }
    .icon-transaksi { background-color: #d32f2f; }
    .icon-menu { background-color: #fbc02d; }
    .icon-income { background-color: #e64a19; }
    
    .stat-info h4 {
        margin: 0;
        font-size: 0.85rem;
        font-weight: 800;
        color: var(--admin-text);
    }
    .stat-info .count {
        font-size: 1.2rem;
        font-weight: 900;
        color: var(--admin-text);
    }

    /* Table Styles */
    .transactions-section {
        margin-bottom: 60px;
    }
    .transactions-section h3 {
        font-size: 1.5rem;
        font-weight: 900;
        margin-bottom: 20px;
    }
    .transactions-table-card {
        background: var(--admin-card-bg);
        border-radius: 20px;
        padding: 15px 20px;
        box-shadow: var(--admin-shadow);
        min-height: 250px;
        position: relative;
        color: var(--admin-text);
    }
    .table-custom {
        width: 100%;
        border-collapse: collapse;
        color: var(--admin-text);
    }
    .table-custom th {
        text-align: center;
        padding: 10px;
        font-weight: 900;
        font-size: 1.1rem;
        border-bottom: 2px solid var(--admin-border);
        border-right: 1px solid var(--admin-border);
    }
    .table-custom th:last-child { border-right: none; }
    .table-custom td {
        padding: 12px 10px;
        text-align: center;
        font-size: 0.95rem;
        font-weight: 500;
        color: var(--admin-text);
        border-bottom: 1px solid var(--admin-border);
    }
    
    .status-badge {
        display: inline-block;
        padding: 8px 25px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.9rem;
    }
    .status-selesai { background-color: #b9f6ca; color: #2e7d32; }
    .status-proses { background-color: #fff9c4; color: #f9a825; }

    .btn-lihat-semua {
        position: absolute;
        bottom: -50px;
        right: 15px;
        background-color: #ff0000;
        color: white;
        border: none;
        border-radius: 12px;
        padding: 8px 30px;
        font-weight: 800;
        font-size: 1rem;
        box-shadow: 0 4px 15px rgba(255,0,0,0.3);
        text-decoration: none;
    }
    .btn-lihat-semua:hover {
        background-color: #d32f2f;
        color: white;
    }
</style>

<div class="dashboard-wrapper">
    <div class="welcome-section">
        <p class="welcome-text">Selamat datang di Admin Dashboard Warung Cilok Pedas</p>
    </div>

    <div class="stats-container">
        <div class="stat-card">
            <div class="stat-icon icon-transaksi"><i class="fas fa-chart-line"></i></div>
            <div class="stat-info">
                <h4>Total Transaksi</h4>
                <div class="count">{{ $totalTransaksi }}+</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon icon-menu"><i class="fas fa-book-open"></i></div>
            <div class="stat-info">
                <h4>Menu</h4>
                <div class="count">{{ $totalMenu }}+</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon icon-income"><i class="fas fa-dollar-sign"></i></div>
            <div class="stat-info">
                <h4>Pendapatan Hari ini</h4>
                <div class="count">{{ number_format($pendapatanHariIni, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>

    <div class="transactions-section">
        <h3>Transaksi Terbaru</h3>
        <div class="transactions-table-card">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th style="width: 30%;">Nama Pembeli</th>
                        <th style="width: 20%;">Total Pembelian</th>
                        <th style="width: 30%;">Hari, Jam</th>
                        <th style="width: 20%;">Status pembelian</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentTransactions as $tx)
                    <tr>
                        <td>{{ $tx['nama'] }}</td>
                        <td>{{ number_format($tx['total'], 0, ',', '.') }}</td>
                        <td>{{ $tx['waktu'] }}</td>
                        <td>
                            <span class="status-badge status-{{ $tx['status'] }}">
                                {{ $tx['status'] }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                    <!-- Fill with empty rows to match height -->
                    <tr><td>&nbsp;</td><td></td><td></td><td></td></tr>
                    <tr><td>&nbsp;</td><td></td><td></td><td></td></tr>
                </tbody>
            </table>
            
            <a href="{{ route('admin.transaksi') }}" class="btn-lihat-semua">Lihat Transaksi</a>
        </div>
    </div>
</div>
@endsection
