@extends('layouts.admin')

@section('page_title', 'Dashboard')

@section('content')
<link href="{{ asset('css/admin/dashboard.css') }}" rel="stylesheet">

<div class="dashboard-wrapper">
    <div class="welcome-section">
        <p class="welcome-text">Selamat datang di Admin Dashboard Warung Cilok Pedas</p>
    </div>

    <div class="stats-container">
        <div class="stat-card">
            <div class="stat-icon icon-transaksi"><i class="fas fa-chart-line"></i></div>
            <div class="stat-info">
                <h4>Total Transaksi</h4>
                <div class="count">+{{ $totalTransaksi }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon icon-menu"><i class="fas fa-book-open"></i></div>
            <div class="stat-info">
                <h4>Menu</h4>
                <div class="count">{{ $totalMenu }}</div>
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
        <h3>Statistik Penjualan (7 Hari Terakhir)</h3>
        <div class="transactions-table-card chart-card">
            <div class="chart-wrapper">
                <canvas id="salesChart"></canvas>
            </div>
            
            <a href="{{ route('admin.transaksi') }}" class="btn-lihat-semua">Lihat Transaksi</a>
        </div>
    </div>

    <!-- Chart.js and Custom Line Chart Initialization -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const chartLabels = @json($chartLabels);
            const chartData = @json($chartData);

            const ctx = document.getElementById('salesChart').getContext('2d');

            // Create gradient
            let gradient = ctx.createLinearGradient(0, 0, 0, 350);
            gradient.addColorStop(0, 'rgba(255, 0, 0, 0.35)');
            gradient.addColorStop(1, 'rgba(255, 0, 0, 0)');

            function getThemeColor(variableName) {
                return getComputedStyle(document.documentElement).getPropertyValue(variableName).trim();
            }

            function getThemeColors() {
                const textColor = getThemeColor('--admin-text') || '#111111';
                const borderColor = getThemeColor('--admin-border') || '#eeeeee';
                const cardBgColor = getThemeColor('--admin-card-bg') || '#ffffff';
                return { textColor, borderColor, cardBgColor };
            }

            let colors = getThemeColors();

            const salesChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: chartLabels,
                    datasets: [{
                        label: 'Pendapatan',
                        data: chartData,
                        borderColor: '#ff0000',
                        borderWidth: 3,
                        backgroundColor: gradient,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#ff0000',
                        pointBorderColor: colors.cardBgColor,
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7,
                        pointHoverBorderWidth: 3,
                        pointHoverBackgroundColor: colors.cardBgColor,
                        pointHoverBorderColor: '#ff0000'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: colors.cardBgColor === '#ffffff' ? 'rgba(255, 255, 255, 0.95)' : 'rgba(42, 42, 42, 0.95)',
                            titleColor: colors.textColor,
                            bodyColor: colors.textColor,
                            borderColor: '#ff0000',
                            borderWidth: 1,
                            padding: 12,
                            cornerRadius: 10,
                            boxPadding: 6,
                            titleFont: {
                                family: "'Inter', sans-serif",
                                size: 13,
                                weight: 'bold'
                            },
                            bodyFont: {
                                family: "'Inter', sans-serif",
                                size: 14,
                                weight: '600'
                            },
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed.y !== null) {
                                        label += new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(context.parsed.y);
                                    }
                                    return label;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                color: colors.borderColor,
                                drawBorder: false
                            },
                            ticks: {
                                color: colors.textColor,
                                font: {
                                    family: "'Inter', sans-serif",
                                    weight: '600',
                                    size: 11
                                }
                            }
                        },
                        y: {
                            grid: {
                                color: colors.borderColor,
                                drawBorder: false
                            },
                            ticks: {
                                color: colors.textColor,
                                font: {
                                    family: "'Inter', sans-serif",
                                    weight: '600',
                                    size: 11
                                },
                                callback: function(value) {
                                    if (value >= 1000) {
                                        return 'Rp ' + new Intl.NumberFormat('id-ID', { notation: 'compact', compactDisplay: 'short' }).format(value);
                                    }
                                    return 'Rp ' + value;
                                }
                            }
                        }
                    }
                }
            });

            function updateChartTheme() {
                const newColors = getThemeColors();
                
                // Update dataset styles
                salesChart.data.datasets[0].pointBorderColor = newColors.cardBgColor;
                salesChart.data.datasets[0].pointHoverBackgroundColor = newColors.cardBgColor;
                
                // Update tooltip styles
                salesChart.options.plugins.tooltip.backgroundColor = newColors.cardBgColor === '#ffffff' ? 'rgba(255, 255, 255, 0.95)' : 'rgba(42, 42, 42, 0.95)';
                salesChart.options.plugins.tooltip.titleColor = newColors.textColor;
                salesChart.options.plugins.tooltip.bodyColor = newColors.textColor;
                
                // Update axes styles
                salesChart.options.scales.x.grid.color = newColors.borderColor;
                salesChart.options.scales.x.ticks.color = newColors.textColor;
                salesChart.options.scales.y.grid.color = newColors.borderColor;
                salesChart.options.scales.y.ticks.color = newColors.textColor;
                
                salesChart.update();
            }

            // MutationObserver to detect html[data-theme] changes
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.attributeName === 'data-theme') {
                        updateChartTheme();
                    }
                });
            });
            observer.observe(document.documentElement, { attributes: true });
        });
    </script>
</div>
@endsection
