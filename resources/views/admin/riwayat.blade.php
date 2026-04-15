@extends('layouts.admin')

@section('page_title', 'Riwayat')

@section('content')
<style>
    .riwayat-container {
        padding-top: 20px;
    }
    .search-wrapper {
        margin-bottom: 25px;
        display: flex;
        justify-content: flex-end;
    }
    .search-box {
        position: relative;
        width: 300px;
        max-width: 100%;
    }
    .search-box input {
        width: 100%;
        background: var(--admin-card-bg);
        border: 2px solid var(--admin-border);
        border-radius: 50px;
        padding: 10px 20px 10px 45px;
        color: var(--admin-text);
        font-size: 0.95rem;
        outline: none;
        transition: all 0.3s ease;
        box-shadow: var(--admin-shadow);
    }
    .search-box input:focus {
        border-color: #ff0000;
        box-shadow: 0 0 15px rgba(255,0,0,0.1);
    }
    .search-box i {
        position: absolute;
        left: 20px;
        top: 50%;
        transform: translateY(-50%);
        color: #888;
        font-size: 1rem;
    }
    .riwayat-table-card {
        background: var(--admin-card-bg);
        border-radius: 20px;
        padding: 10px;
        box-shadow: var(--admin-shadow);
        overflow: hidden;
        color: var(--admin-text);
        border: 1px solid var(--admin-border);
    }
    .table-riwayat {
        width: 100%;
        border-collapse: collapse;
    }
    .table-riwayat th {
        padding: 15px 10px;
        font-weight: 900;
        font-size: 1.1rem;
        text-align: center;
        border-bottom: 2px solid var(--admin-border);
        border-right: 1px solid var(--admin-border);
        color: var(--admin-text);
    }
    .table-riwayat th:last-child { border-right: none; }
    .table-riwayat td {
        padding: 12px 10px;
        text-align: center;
        font-size: 0.95rem;
        font-weight: 500;
        border-bottom: 1px solid var(--admin-border);
        border-right: 1px solid var(--admin-border);
        color: var(--admin-text);
    }
    .table-riwayat td:last-child { border-right: none; }
    .table-riwayat tr:last-child td { border-bottom: none; }
    
    .page-main-title {
        font-size: 2.5rem;
        font-weight: 900;
        margin-bottom: 20px;
        color: var(--admin-text);
    }
</style>

<div class="riwayat-container">
    <h1 class="page-main-title">Riwayat</h1>

    <div class="search-wrapper">
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
                    <th>No Telp</th>
                    <th>Alamat</th>
                </tr>
            </thead>
            <tbody>
                @forelse($history as $item)
                <tr class="riwayat-row">
                    <td class="searchable">{{ $item->order->customer_name ?? 'N/A' }}</td>
                    <td class="searchable">{{ $item->menu->name ?? 'Unknown' }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td class="searchable">{{ $item->order->whatsapp ?? 'N/A' }}</td>
                    <td class="searchable">{{ $item->order->address ?? 'N/A' }}</td>
                </tr>
                @empty
                <tr><td colspan="5">Belum ada riwayat transaksi.</td></tr>
                @endforelse
                
                <!-- Placeholder for when no results are found -->
                <tr id="noResultsRow" style="display: none;">
                    <td colspan="5" style="padding: 30px; color: #888;">Data tidak ditemukan.</td>
                </tr>

                <!-- Extra empty rows for design fidelity if list is short -->
                @if(count($history) < 5)
                    @for($i = 0; $i < (5 - count($history)); $i++)
                    <tr class="empty-row"><td>&nbsp;</td><td></td><td></td><td></td><td></td></tr>
                    @endfor
                @endif
            </tbody>
        </table>
    </div>
</div>

<script>
function filterTable() {
    const input = document.getElementById('searchInput');
    const filter = input.value.toLowerCase();
    const table = document.getElementById('riwayatTable');
    const rows = table.getElementsByClassName('riwayat-row');
    const emptyRows = table.getElementsByClassName('empty-row');
    const noResultsRow = document.getElementById('noResultsRow');
    let hasResults = false;

    // Filter main data rows
    for (let i = 0; i < rows.length; i++) {
        const row = rows[i];
        const cells = row.getElementsByClassName('searchable');
        let textContent = '';
        
        for (let j = 0; j < cells.length; j++) {
            textContent += cells[j].textContent.toLowerCase() + ' ';
        }

        if (textContent.indexOf(filter) > -1) {
            row.style.display = "";
            hasResults = true;
        } else {
            row.style.display = "none";
        }
    }

    // Show/hide "No Results" message
    if (noResultsRow) {
        if (!hasResults && filter !== '') {
            noResultsRow.style.display = '';
        } else {
            noResultsRow.style.display = 'none';
        }
    }

    // Hide empty/design rows when searching
    for (let i = 0; i < emptyRows.length; i++) {
        emptyRows[i].style.display = filter === '' ? '' : 'none';
    }
}
</script>
@endsection
