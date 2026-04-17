@extends('layouts.admin')

@section('page_title', 'Riwayat')

@section('content')
<link href="{{ asset('css/admin/riwayat.css') }}" rel="stylesheet">

<div class="riwayat-container">
    <h1 class="page-main-title">Riwayat</h1>

    <div class="search-wrapper">
        <div class="filter-group">
            <select id="filterTanggal" onchange="filterTable()">
                <option value="">Tanggal</option>
                @for($i=1; $i<=31; $i++)
                    <option value="{{ $i }}">{{ $i }}</option>
                @endfor
            </select>
            <select id="filterBulan" onchange="filterTable()">
                <option value="">Bulan</option>
                @foreach(['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] as $idx => $month)
                    <option value="{{ $idx + 1 }}">{{ $month }}</option>
                @endforeach
            </select>
            <select id="filterTahun" onchange="filterTable()">
                <option value="">Tahun</option>
                @for($year = 2026; $year >= 1970; $year--)
                    <option value="{{ $year }}">{{ $year }}</option>
                @endfor
            </select>
        </div>
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" id="searchInput" placeholder="Cari data riwayat..." onkeyup="filterTable()">
        </div>
    </div>
    
    <div class="riwayat-table-card">
        <table class="table-riwayat" id="riwayatTable">
            <thead>
                <tr>
                    <th>Nama Pembeli</th>
                    <th>Nama Menu</th>
                    <th>Jumlah</th>
                    <th>Tanggal</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody id="riwayatTableBody">
                @foreach($history as $item)
                <tr>
                    <td>{{ $item->order->customer_name ?? 'N/A' }}</td>
                    <td>{{ $item->menu->name ?? 'Unknown' }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td data-day="{{ $item->order?->created_at?->format('j') }}" 
                        data-month="{{ $item->order?->created_at?->format('n') }}" 
                        data-year="{{ $item->order?->created_at?->format('Y') }}">
                        {{ $item->order?->created_at?->isoFormat('dddd, D MMMM YYYY') ?? 'N/A' }}
                    </td>
                    <td class="subtotal-cell" data-value="{{ $item->quantity * $item->price }}">
                        Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr style="background: rgba(255, 0, 0, 0.05); font-weight: 900;">
                    <td colspan="4" style="text-align: right; padding-right: 30px;">TOTAL KESELURUHAN</td>
                    <td id="grandTotalDisplay">Rp 0</td>
                </tr>
            </tfoot>
        </table>
    </div>
    
    <div class="table-footer">
        <a href="{{ route('admin.transaksi.create') }}" class="btn-manual-order">
            <i class="fas fa-plus-circle"></i> Input Pesanan Manual
        </a>
    </div>
</div>

<script>
    function filterTable() {
        const searchText = document.getElementById('searchInput').value.toLowerCase();
        const selectedDay = document.getElementById('filterTanggal').value;
        const selectedMonth = document.getElementById('filterBulan').value;
        const selectedYear = document.getElementById('filterTahun').value;
        
        const rows = document.querySelectorAll('#riwayatTableBody tr');
        let grandTotal = 0;

        rows.forEach(row => {
            const customerName = row.cells[0].innerText.toLowerCase();
            const menuName = row.cells[1].innerText.toLowerCase();
            const dateCell = row.cells[3];
            const subtotalCell = row.querySelector('.subtotal-cell');
            
            const day = dateCell.getAttribute('data-day');
            const month = dateCell.getAttribute('data-month');
            const year = dateCell.getAttribute('data-year');
            const subtotal = parseInt(subtotalCell.getAttribute('data-value')) || 0;

            const matchesSearch = customerName.includes(searchText) || menuName.includes(searchText);
            const matchesDay = selectedDay === "" || day === selectedDay;
            const matchesMonth = selectedMonth === "" || month === selectedMonth;
            const matchesYear = selectedYear === "" || year === selectedYear;

            if (matchesSearch && matchesDay && matchesMonth && matchesYear) {
                row.style.display = "";
                grandTotal += subtotal;
            } else {
                row.style.display = "none";
            }
        });

        document.getElementById('grandTotalDisplay').innerText = 'Rp ' + grandTotal.toLocaleString('id-ID');
    }

    // Call on load to set initial total
    document.addEventListener('DOMContentLoaded', filterTable);
</script>
@endsection
