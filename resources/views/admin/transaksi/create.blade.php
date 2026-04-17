@extends('layouts.admin')

@section('page_title', 'Input Pesanan Manual')

@section('content')
<link href="{{ asset('css/admin/transaksi_create.css') }}" rel="stylesheet">

<div class="create-transaksi-container">
    <div class="header-section">
        <a href="{{ route('admin.riwayat') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Kembali ke Riwayat
        </a>
        <h1 class="page-main-title">Input Pesanan Manual</h1>
    </div>

    @if(session('error'))
        <div class="alert alert-danger mb-4" style="border-radius: 12px;">{{ session('error') }}</div>
    @endif

    <form action="{{ route('admin.transaksi.store') }}" method="POST" class="transaksi-form">
        @csrf
        <div class="form-grid">
            <!-- Left Side: Customer Info -->
            <div class="form-card">
                <h2 class="card-title"><i class="fas fa-user-circle"></i> Informasi Pelanggan</h2>
                <div class="form-group">
                    <label>Nama Pembeli</label>
                    <input type="text" name="customer_name" placeholder="Nama lengkap pembeli" required value="{{ old('customer_name') }}">
                </div>
                <div class="form-group">
                    <label>No. WhatsApp</label>
                    <input type="text" name="whatsapp" placeholder="08XXXXXXXXXX" required value="{{ old('whatsapp', '-') }}">
                </div>
                <div class="form-group">
                    <label>Alamat (Opsional)</label>
                    <textarea name="address" rows="3" placeholder="Alamat pengiriman..." required>{{ old('address', '-') }}</textarea>
                </div>
                <div class="form-group">
                    <label>Tanggal Transaksi</label>
                    <input type="date" name="order_date" value="{{ date('Y-m-d') }}" required>
                </div>
            </div>

            <!-- Right Side: Order Items -->
            <div class="form-card">
                <h2 class="card-title"><i class="fas fa-shopping-basket"></i> Daftar Menu</h2>
                <div id="items-container">
                    <div class="order-item-row" data-index="0">
                        <div class="item-select">
                            <label>Menu</label>
                            <select name="items[0][menu_id]" class="menu-select" required onchange="calculateTotal()">
                                <option value="" data-price="0">Pilih Menu</option>
                                @foreach($menus as $menu)
                                    <option value="{{ $menu->id }}" data-price="{{ $menu->price_numeric }}">
                                        {{ $menu->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="item-qty">
                            <label>Jumlah</label>
                            <input type="number" name="items[0][quantity]" value="1" min="1" required onchange="calculateTotal()">
                        </div>
                        <div class="item-sub">
                            <label>Subtotal</label>
                            <div class="row-subtotal">Rp 0</div>
                        </div>
                        <div class="item-action">
                            <button type="button" class="btn-remove-item" onclick="removeItem(this)">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>
                
                <button type="button" class="btn-add-item" onclick="addItem()">
                    <i class="fas fa-plus"></i> Tambah Menu Lain
                </button>

                <div class="total-section-card">
                    <div class="total-label">Total Akhir</div>
                    <div class="total-amount" id="grand-total">Rp 0</div>
                </div>

                <button type="submit" class="btn-submit-order">
                    <i class="fas fa-save"></i> Simpan Pesanan Manual
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    let itemIndex = 1;

    function addItem() {
        const container = document.getElementById('items-container');
        const div = document.createElement('div');
        div.className = 'order-item-row';
        div.dataset.index = itemIndex;
        div.innerHTML = `
            <div class="item-select">
                <label>Menu</label>
                <select name="items[${itemIndex}][menu_id]" class="menu-select" required onchange="calculateTotal()">
                    <option value="" data-price="0">Pilih Menu</option>
                    @foreach($menus as $menu)
                        <option value="{{ $menu->id }}" data-price="{{ $menu->price_numeric }}">
                            {{ $menu->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="item-qty">
                <label>Jumlah</label>
                <input type="number" name="items[${itemIndex}][quantity]" value="1" min="1" required onchange="calculateTotal()">
            </div>
            <div class="item-sub">
                <label>Subtotal</label>
                <div class="row-subtotal">Rp 0</div>
            </div>
            <div class="item-action">
                <button type="button" class="btn-remove-item" onclick="removeItem(this)">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;
        container.appendChild(div);
        itemIndex++;
        calculateTotal();
    }

    function removeItem(btn) {
        const rows = document.querySelectorAll('.order-item-row');
        if (rows.length > 1) {
            btn.closest('.order-item-row').remove();
            calculateTotal();
        } else {
            alert('Harus ada minimal 1 item pesanan.');
        }
    }

    function calculateTotal() {
        let grandTotal = 0;
        const rows = document.querySelectorAll('.order-item-row');
        
        rows.forEach(row => {
            const select = row.querySelector('.menu-select');
            const qtyInput = row.querySelector('input[type="number"]');
            const subtotalDiv = row.querySelector('.row-subtotal');
            
            if (select && qtyInput) {
                const price = parseFloat(select.options[select.selectedIndex].dataset.price || 0);
                const qty = parseInt(qtyInput.value || 0);
                const subtotal = price * qty;
                
                subtotalDiv.innerText = 'Rp ' + subtotal.toLocaleString('id-ID');
                grandTotal += subtotal;
            }
        });

        document.getElementById('grand-total').innerText = 'Rp ' + grandTotal.toLocaleString('id-ID');
    }

    // Initialize display
    calculateTotal();
</script>
@endsection


