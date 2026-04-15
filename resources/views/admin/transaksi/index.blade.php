@extends('layouts.admin')

@section('page_title', 'Transaksi')

@section('content')
<style>
    .transaksi-card {
        background: var(--admin-card-bg);
        border-radius: 20px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: var(--admin-shadow);
        border: 1px solid var(--admin-border);
        color: var(--admin-text);
    }
    .table-transaksi {
        width: 100%;
        border-collapse: collapse;
    }
    .table-transaksi th {
        padding: 10px;
        font-weight: 800;
        text-align: center;
        border-bottom: 2px solid var(--admin-border);
        border-right: 1px solid var(--admin-border);
        color: var(--admin-text);
        font-size: 0.95rem;
    }
    .table-transaksi th:last-child { border-right: none; }
    .table-transaksi td {
        padding: 10px;
        text-align: center;
        border-bottom: 1px solid var(--admin-border);
        border-right: 1px solid var(--admin-border);
        min-height: 40px;
        color: var(--admin-text);
        font-size: 0.85rem;
    }
    .table-transaksi td:last-child { border-right: none; }
    
    .detail-section-title {
        font-size: 1.5rem;
        font-weight: 900;
        margin: 20px 0 10px 0;
        color: var(--admin-text);
    }

    .update-status-bar {
        display: flex;
        align-items: center;
        gap: 20px;
        margin-top: 40px;
    }
    .status-select {
        width: 200px;
        background: var(--admin-card-bg);
        color: var(--admin-text);
        border: 2px solid var(--admin-border);
        border-radius: 50px;
        padding: 8px 15px;
        font-size: 1rem;
        appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2224%22%20height%3D%2224%22%20viewBox%3D%220%200%2024%2024%20fill%3D%22none%22%20stroke%3D%22currentColor%22%20stroke-width%3D%222%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%3E%3Cpolyline%20points%3D%226%209%2012%2015%2018%209%22%3E%3C%2Fpolyline%3E%3C%2Fsvg%3E");
        background-repeat: no-repeat;
        background-position: right 20px center;
        background-size: 20px;
    }
    .btn-update-status {
        background-color: #ff0000;
        color: white;
        border: none;
        border-radius: 50px;
        padding: 8px 25px;
        font-weight: 800;
        font-size: 1.1rem;
        box-shadow: 0 4px 15px rgba(255,0,0,0.3);
    }
</style>

<div class="transaksi-wrapper">
    <h1 style="font-size: 2rem; font-weight: 900; margin-bottom: 20px;">Transaksi</h1>
    
    <div class="transaksi-card">
        <table class="table-transaksi">
            <thead>
                <tr>
                    <th style="width: 100px;">Kode Transaksi</th>
                    <th>Nama</th>
                    <th>Total Pesanan</th>
                    <th>Alamat</th>
                    <th>No Telp</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $tx)
                <tr onclick="showTransactionDetails('{{ $tx->id }}')" style="cursor: pointer;">
                    <td>{{ $tx->id }}</td>
                    <td>{{ $tx->customer_name }}</td>
                    <td id="total-cell-{{ $tx->id }}">{{ number_format($tx->total_price, 0, ',', '.') }}</td>
                    <td>{{ $tx->address }}</td>
                    <td>{{ $tx->whatsapp }}</td>
                    <td id="status-cell-{{ $tx->id }}">{{ $tx->status }}</td>
                </tr>
                @empty
                <tr><td colspan="6">Tidak ada transaksi.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Hidden form for deletion -->
    <form id="delete-form" method="POST" style="display:none;">
        @csrf
    </form>

    <h2 class="detail-section-title">Detail Transaksi</h2>
    
    <div class="transaksi-card">
        <table class="table-transaksi">
            <thead>
                <tr>
                    <th style="width: 100px;">Kode Transaksi</th>
                    <th>Nama Menu</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="detail-transaksi-body">
                <!-- Empty rows to match UI design -->
                <tr><td>&nbsp;</td><td></td><td></td><td></td><td></td></tr>
                <tr><td>&nbsp;</td><td></td><td></td><td></td><td></td></tr>
                <tr><td>&nbsp;</td><td></td><td></td><td></td><td></td></tr>
            </tbody>
        </table>
    </div>

    <form action="{{ route('admin.transaksi.update_status') }}" method="POST" class="update-status-bar">
        @csrf
        <input type="hidden" name="order_id" id="order_id_input">
        <span style="color: var(--admin-text); font-weight: 700;">Update Status untuk ID: <span id="selected_order_kode">-</span></span>
        <select name="status" id="status_select" class="status-select" required>
            <option value="">Pilih Status</option>
            <option value="pending">Pending</option>
            <option value="proses">Proses</option>
            <option value="selesai">Selesai</option>
            <option value="batal">Batal</option>
        </select>
        <button type="submit" class="btn-update-status">Update Status</button>
    </form>
</div>

<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
function showTransactionDetails(id) {
    // Update selected ID labels/inputs
    document.getElementById('order_id_input').value = id;
    document.getElementById('selected_order_kode').innerText = id;
    
    // Set current status in select
    const statusCell = document.getElementById('status-cell-' + id);
    if (statusCell) {
        const currentStatus = statusCell.innerText.trim().toLowerCase();
        const select = document.getElementById('status_select');
        for (let i = 0; i < select.options.length; i++) {
            if (select.options[i].value === currentStatus) {
                select.selectedIndex = i;
                break;
            }
        }
    }

    const tbody = document.getElementById('detail-transaksi-body');
    tbody.innerHTML = '<tr><td colspan="5" style="text-align:center; color:#888;">Memuat...</td></tr>';

    // Fetch details via AJAX — no-store to always get fresh data from server
    fetch(`/admin/transaksi/${id}/details`, { cache: 'no-store' })
        .then(response => {
            if (!response.ok) throw new Error('Server error: ' + response.status);
            return response.json();
        })
        .then(data => {
            let html = '';
            
            if (data.length === 0) {
                html = '<tr><td colspan="5" style="text-align:center;">Tidak ada item.</td></tr>';
            } else {
                data.forEach(item => {
                    html += `<tr>
                        <td>${item.order_id}</td>
                        <td>${item.nama_menu}</td>
                        <td>${item.quantity}</td>
                        <td>${item.subtotal}</td>
                        <td>
                            <button onclick="hideDetails()" style="background: none; border: none; color: #ff0000; cursor: pointer;" title="Tutup Detail">
                                <i class="fas fa-minus-circle"></i>
                            </button>
                        </td>
                    </tr>`;
                });
                
                // Add empty rows if needed to maintain design
                for (let i = data.length; i < 3; i++) {
                    html += '<tr><td>&nbsp;</td><td></td><td></td><td></td><td></td></tr>';
                }
            }

            tbody.innerHTML = html;
        })
        .catch(error => {
            console.error('Error fetching details:', error);
            tbody.innerHTML = '<tr><td colspan="5" style="text-align:center; color:red;">Gagal memuat detail.</td></tr>';
        });
}

function hideDetails() {
    document.getElementById('detail-transaksi-body').innerHTML = '<tr><td>&nbsp;</td><td></td><td></td><td></td><td></td></tr><tr><td>&nbsp;</td><td></td><td></td><td></td><td></td></tr><tr><td>&nbsp;</td><td></td><td></td><td></td><td></td></tr>';
    document.getElementById('selected_order_kode').innerText = '-';
    document.getElementById('order_id_input').value = '';
}
function confirmDelete(id) {
    showConfirm(
        'Hapus Transaksi',
        'Apakah Anda yakin ingin menghapus transaksi #' + id + '? Semua detail pesanan juga akan dihapus.',
        function() {
            const form = document.getElementById('delete-form');
            form.action = '/admin/transaksi/' + id + '/delete';
            form.submit();
        }
    );
}
</script>
@endsection
