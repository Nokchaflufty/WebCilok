@extends('layouts.admin')

@section('page_title', 'Riwayat')

@section('content')
<style>
    .riwayat-container {
        padding-top: 20px;
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
    
    <div class="riwayat-table-card">
        <table class="table-riwayat">
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
                <tr>
                    <td>{{ $item->order->customer_name ?? 'N/A' }}</td>
                    <td>{{ $item->menu->name ?? 'Unknown' }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->order->whatsapp ?? 'N/A' }}</td>
                    <td>{{ $item->order->address ?? 'N/A' }}</td>
                </tr>
                @empty
                <tr><td colspan="5">Belum ada riwayat transaksi.</td></tr>
                @endforelse
                
                <!-- Extra empty rows for design fidelity if list is short -->
                @if(count($history) < 5)
                    @for($i = 0; $i < (5 - count($history)); $i++)
                    <tr><td>&nbsp;</td><td></td><td></td><td></td><td></td></tr>
                    @endfor
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
