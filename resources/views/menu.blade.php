@extends('layouts.app')

@section('content')
<link href="{{ asset('css/menu.css') }}" rel="stylesheet">

<div class="menu-page-wrapper">
    <div class="menu-hero-section">
        <div class="menu-hero-left">
            <span class="badge-yellow">STREET FOOD REVOLUTION</span>
            <h1 class="menu-hero-title">Level Pedas,<br>Selera Berkelas.</h1>
            <p class="menu-hero-desc">Nikmati sensasi pedas nampol dari bumbu rahasia Mak Pik yang dipadukan dengan tekstur cilok kenyal premium.</p>
            <a href="{{ route('order') }}" style="display: inline-block; margin-top: 25px; background: #c8102e; color: white; text-decoration: none; font-weight: bold; padding: 12px 35px; border-radius: 50px; font-size: 1.1rem; box-shadow: 0 4px 15px rgba(200, 16, 46, 0.3); transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='translateY(0)'">Order Sekarang</a>
        </div>
        <div class="menu-hero-right">
            <img src="https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=400&h=400&fit=crop" alt="Food" class="hero-img-circle img-1">
            <img src="https://images.unsplash.com/photo-1555939594-58d7cb561ad1?w=400&h=400&fit=crop" alt="Street" class="hero-img-circle img-2">
        </div>
    </div>

    <div class="menu-filters">
        <button class="filter-btn active" data-category="semua">Semua Menu</button>
        <button class="filter-btn" data-category="makanan">Makanan</button>
        <button class="filter-btn" data-category="minuman">Minuman</button>
    </div>

    <div class="menu-grid-container">
        @foreach($menus as $menu)
        <div class="menu-item-card" data-id="{{ $menu->id }}" data-name="{{ $menu->name }}" data-price="{{ $menu->price_numeric }}" data-category="{{ $menu->category }}">
            <div class="menu-img-wrapper">
                <img src="{{ $menu->image ? asset('images/' . $menu->image) : asset('images/logo.jpeg') }}" class="menu-img" alt="{{ $menu->name }}" onerror="this.src='{{ asset('images/Home_Wallpaper.png') }}'">
            </div>
            <div class="menu-info">
                <div class="menu-name">{{ $menu->name }}</div>
                <div class="menu-price">{{ $menu->price }}</div>
            </div>
            <button class="btn-tambah">
                <i class="fa-solid fa-plus"></i> Tambahkan
            </button>
        </div>
        @endforeach
    </div>
</div>

<!-- Cart Sidebar -->
<div id="cartSidebar" class="cart-sidebar">
    <div class="cart-header">
        <strong>Keranjang Anda</strong>
        <button id="closeCart" style="background:none; border:none; font-size:1.5rem; color: var(--text-secondary); cursor: pointer;">&times;</button>
    </div>
    
    <div id="cartItems" class="cart-items">
        <div style="text-align:center; color: var(--text-secondary); margin-top: 2rem;">
            <i class="fa-solid fa-basket-shopping" style="font-size: 3rem; opacity: 0.2; margin-bottom: 1rem; display: block;"></i>
            Belum ada pesanan
        </div>
    </div>
    
    <div class="cart-footer">
        <div class="cart-total-row">
            <span class="cart-total-label">Total Pembayaran</span>
            <span class="cart-total-value" id="cartTotal">Rp 0</span>
        </div>
        <button id="checkoutBtn" class="btn-order-now">Order Sekarang</button>
    </div>
</div>

<button id="cartToggle" class="cart-toggle">
    <i class="fa-solid fa-cart-shopping"></i>
</button>
@endsection

@push('scripts')
<script>
    // Cart logic
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    
    function updateCartUI() {
        const container = $('#cartItems');
        const totalSpan = $('#cartTotal');
        let total = 0;
        
        if (cart.length === 0) {
            container.html(`
                <div style="text-align:center; color: var(--text-secondary); margin-top: 2rem;">
                    <i class="fa-solid fa-basket-shopping" style="font-size: 3rem; opacity: 0.2; margin-bottom: 1rem; display: block;"></i>
                    Belum ada pesanan
                </div>
            `);
            totalSpan.text('Rp 0');
            return;
        }
        
        let html = '';
        cart.forEach((item, idx) => {
            const itemTotal = item.price * item.quantity;
            total += itemTotal;
            html += `
                <div class="cart-item-row">
                    <div class="cart-item-details">
                        <div class="cart-item-name">${item.name}</div>
                        <div class="cart-item-price">Rp ${itemTotal.toLocaleString('id-ID')}</div>
                    </div>
                    <div class="cart-item-controls">
                        <div class="cart-qty-controls">
                            <button class="cart-btn-qty dec-qty" data-idx="${idx}">-</button>
                            <span class="cart-qty-value">${item.quantity}</span>
                            <button class="cart-btn-qty inc-qty" data-idx="${idx}">+</button>
                        </div>
                        <button class="cart-btn-remove remove-item" data-idx="${idx}">Hapus</button>
                    </div>
                </div>
            `;
        });
        
        container.html(html);
        totalSpan.text(`Rp ${total.toLocaleString('id-ID')}`);
    }

    $('.btn-tambah').click(function() {
        const parent = $(this).closest('.menu-item-card');
        const id = parent.data('id');
        const name = parent.data('name');
        const price = parent.data('price');
        const existing = cart.find(i => i.id == id);
        
        if (existing) {
            existing.quantity++;
        } else {
            cart.push({ id, name, price, quantity: 1 });
        }
        
        localStorage.setItem('cart', JSON.stringify(cart));
        updateCartUI();
        
        // Auto open sidebar when adding an item
        $('#cartSidebar').addClass('active');
    });

    $(document).on('click', '.inc-qty', function() {
        let idx = $(this).data('idx');
        cart[idx].quantity++;
        localStorage.setItem('cart', JSON.stringify(cart));
        updateCartUI();
    });

    $(document).on('click', '.dec-qty', function() {
        let idx = $(this).data('idx');
        if (cart[idx].quantity > 1) {
            cart[idx].quantity--;
        } else {
            cart.splice(idx, 1);
        }
        localStorage.setItem('cart', JSON.stringify(cart));
        updateCartUI();
    });

    $(document).on('click', '.remove-item', function() {
        let idx = $(this).data('idx');
        cart.splice(idx, 1);
        localStorage.setItem('cart', JSON.stringify(cart));
        updateCartUI();
    });

    $('#cartToggle').click(() => $('#cartSidebar').addClass('active'));
    $('#closeCart').click(() => $('#cartSidebar').removeClass('active'));

    $('#checkoutBtn').click(() => {
        if (cart.length === 0) {
            return alert('Keranjang Anda masih kosong. Silakan tambahkan menu terlebih dahulu.');
        }
        localStorage.setItem('checkoutCart', JSON.stringify(cart));
        // Redirects to order form as requested
        window.location.href = "{{ route('order') }}";
    });

    // Filter logic
    $('.filter-btn').click(function() {
        $('.filter-btn').removeClass('active');
        $(this).addClass('active');

        const category = $(this).data('category');

        $('.menu-item-card').each(function() {
            const cardCat = $(this).data('category');
            if (category === 'semua' || cardCat === category) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });

    // Initialize UI on load
    updateCartUI();
</script>
@endpush
