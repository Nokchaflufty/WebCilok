@extends('layouts.app')

@section('content')
<style>
    .menu-carousel-wrapper {
        position: relative;
        max-width: 1100px;
        margin: 40px auto;
        padding: 0 50px 80px 50px; /* Increased bottom padding to fit the staggered drop */
    }
    .carousel-container {
        overflow: hidden;
        padding-bottom: 50px; /* Safely contain absolute buttons of staggered elements */
        margin: 0 auto;
    }
    .carousel-track {
        display: flex;
        transition: transform 0.4s ease-in-out;
    }
    .carousel-slide {
        flex: 0 0 100%;
    }
    .menu-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 40px;
        padding: 10px 5px; 
        align-items: start; /* Allows items to have different vertical alignments natively */
    }
    .menu-item:nth-child(2) {
        margin-top: 30px; /* Raised the center card a bit higher */
    }
    .menu-item {
        background-color: var(--card-bg);
        border-radius: 20px;
        padding: 15px 15px 40px 15px; /* Heavy bottom padding to make space for overlapping button */
        text-align: center;
        position: relative;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        border: 1px solid var(--border-color);
    }
    .menu-img {
        width: 100%;
        height: 160px;
        object-fit: cover;
        background-color: white; 
        border-radius: 12px;
        border: 1px solid #111; /* Dark border from Figma screenshot */
        margin-bottom: 12px;
    }
    .menu-name {
        font-size: 1.4rem;
        color: var(--text-color);
        font-weight: 300; /* Specifically a lighter font in the design */
    }
    .menu-price {
        font-size: 1.1rem;
        color: var(--text-color);
        margin-bottom: 5px;
    }
    .btn-tambah {
        position: absolute;
        bottom: -20px; /* Overlapping the bottom boundary securely */
        left: 50%;
        transform: translateX(-50%);
        background-color: #a4232a;
        color: white;
        border: none;
        border-radius: 50px;
        padding: 10px 35px;
        font-weight: 800; /* Bold chunky to match previous designs */
        font-size: 1.1rem;
        cursor: pointer;
        box-shadow: 0 4px 6px rgba(0,0,0,0.2);
        white-space: nowrap;
        transition: background-color 0.2s, transform 0.2s;
    }
    .btn-tambah:hover {
        background-color: #8c1e24;
    }
    
    .carousel-arrow {
        position: absolute;
        top: 40%;
        transform: translateY(-50%);
        background-color: #a4232a;
        color: white;
        border: none;
        width: 45px;
        height: 45px;
        border-radius: 50%;
        font-size: 1.5rem;
        font-weight: bold;
        cursor: pointer;
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 10;
        box-shadow: 0 4px 6px rgba(0,0,0,0.2);
    }
    .prev { left: 0px; }
    .next { right: 0px; }
    
    .carousel-dots {
        position: absolute;
        bottom: 0px;
        left: 55px; /* Aligned roughly under first card */
        display: flex;
        gap: 15px;
    }
    .dot {
        width: 16px;
        height: 16px;
        background-color: #aaaaaa;
        border-radius: 50%;
        cursor: pointer;
        transition: background-color 0.3s;
    }
    .dot.active {
        background-color: #a4232a;
    }
    
    /* Cart Button Styles */
    .cart-btn-qty, .cart-btn-remove {
        background-color: #a4232a;
        color: white;
        border: none;
        border-radius: 50px;
        font-weight: 800;
        cursor: pointer;
        box-shadow: 0 2px 5px rgba(0,0,0,0.15);
        transition: transform 0.1s, background-color 0.2s;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .cart-btn-qty {
        width: 28px;
        height: 28px;
        font-size: 1.2rem;
        margin-right: 5px;
    }
    .cart-btn-remove {
        padding: 5px 15px;
        font-size: 0.85rem;
        margin-left: 10px;
        text-transform: uppercase;
    }
    .cart-btn-qty:hover, .cart-btn-remove:hover {
        background-color: #8c1e24;
        transform: scale(1.05);
    }
    .cart-btn-qty:active, .cart-btn-remove:active {
        transform: scale(0.95);
    }

    /* Rounder Pesan Sekarang Button with Shadow */
    .btn-order {
        border-radius: 50px !important;
        box-shadow: 0 4px 12px rgba(0,0,0,0.18);
        font-weight: 800;
        text-transform: uppercase;
        transition: transform 0.2s, background-color 0.2s, box-shadow 0.2s;
    }
    .btn-order:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(0,0,0,0.22);
    }

    @media (max-width: 800px) {
        .menu-grid {
            grid-template-columns: 1fr;
        }
        .carousel-dots {
            left: 50%;
            transform: translateX(-50%);
        }
    }
</style>

<div class="container">
    <div class="menu-carousel-wrapper">
        <div class="carousel-container" id="carouselContainer">
            <div class="carousel-track" id="carouselTrack">
                @php
                    $chunks = $menus->chunk(3);
                @endphp
                @foreach($chunks as $chunk)
                <div class="carousel-slide">
                    <div class="menu-grid">
                        @foreach($chunk as $menu)
                        <div class="menu-item" data-id="{{ $menu->id }}" data-name="{{ $menu->name }}" data-price="{{ $menu->price_numeric }}">
                            <!-- Image fallback that pulls from existing assets nicely -->
                            <img src="{{ asset('images/Home_Wallpaper.png') }}" class="menu-img" alt="Menu Image">
                            <div class="menu-name">{{ $menu->name }}</div>
                            <div class="menu-price">{{ $menu->price }}</div>
                            <button class="btn-tambah">Tambahkan</button>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <button class="carousel-arrow prev" id="prevBtn">&#10094;</button>
        <button class="carousel-arrow next" id="nextBtn">&#10095;</button>

        <div class="carousel-dots">
            @for($i = 0; $i < $chunks->count(); $i++)
                <span class="dot {{ $i == 0 ? 'active' : '' }}" data-index="{{ $i }}"></span>
            @endfor
        </div>
    </div>
</div>

<!-- Cart Sidebar -->
<div id="cartSidebar" class="cart-sidebar">
    <div class="cart-header" style="color: var(--text-color);">
        <strong>Pesanan Anda</strong>
        <button id="closeCart" style="background:none; border:none; font-size:1.2rem; color: var(--text-color);">&times;</button>
    </div>
    <div id="cartItems" class="cart-items">
        <p style="text-align:center;">Belum ada pesanan</p>
    </div>
    <div class="cart-footer">
        <div><strong>Total: </strong><span id="cartTotal">Rp 0</span></div>
        <button id="checkoutBtn" class="btn-order" style="width:100%; margin-top:10px;">Pesan Sekarang</button>
    </div>
</div>
<button id="cartToggle" class="cart-toggle">🛒</button>
@endsection

@push('scripts')
<script>
    // Carousel logic
    const track = document.getElementById('carouselTrack');
    const slides = document.querySelectorAll('.carousel-slide');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const dots = document.querySelectorAll('.dot');
    let currentIndex = 0;
    
    function updateCarousel() {
        if (!slides.length) return;
        const slideWidth = slides[0].clientWidth;
        track.style.transform = `translateX(-${currentIndex * slideWidth}px)`;
        dots.forEach((dot, i) => {
            dot.classList.toggle('active', i === currentIndex);
        });
        prevBtn.style.display = currentIndex === 0 ? 'none' : 'flex';
        nextBtn.style.display = currentIndex === slides.length - 1 ? 'none' : 'flex';
    }

    function nextSlide() {
        if (currentIndex < slides.length - 1) {
            currentIndex++;
            updateCarousel();
        }
    }

    function prevSlide() {
        if (currentIndex > 0) {
            currentIndex--;
            updateCarousel();
        }
    }

    prevBtn.addEventListener('click', prevSlide);
    nextBtn.addEventListener('click', nextSlide);

    dots.forEach(dot => {
        dot.addEventListener('click', () => {
            currentIndex = parseInt(dot.dataset.index);
            updateCarousel();
        });
    });

    window.addEventListener('resize', updateCarousel);
    updateCarousel();

    // Cart logic
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    function updateCartUI() {
        const container = $('#cartItems');
        const totalSpan = $('#cartTotal');
        let total = 0;
        if (cart.length === 0) {
            container.html('<p style="text-align:center;">Belum ada pesanan</p>');
            totalSpan.text('Rp 0');
            return;
        }
        let html = '';
        cart.forEach((item, idx) => {
            const itemTotal = item.price * item.quantity;
            total += itemTotal;
            html += `<div style="margin-bottom:15px; border-bottom:1px solid #eee; padding-bottom:8px; display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <strong>${item.name}</strong> x ${item.quantity}<br>
                            <span style="font-size: 0.9rem; color: var(--text-secondary);">Rp ${itemTotal.toLocaleString('id-ID')}</span>
                        </div>
                        <div style="display: flex; align-items: center;">
                            <button class="cart-btn-qty dec-qty" data-idx="${idx}">-</button>
                            <button class="cart-btn-qty inc-qty" data-idx="${idx}">+</button>
                            <button class="cart-btn-remove remove-item" data-idx="${idx}">Hapus</button>
                        </div>
                    </div>`;
        });
        container.html(html);
        totalSpan.text(`Rp ${total.toLocaleString('id-ID')}`);
    }
    $('.btn-tambah').click(function() {
        const parent = $(this).closest('.menu-item');
        const id = parent.data('id');
        const name = parent.data('name');
        const price = parent.data('price');
        const existing = cart.find(i => i.id == id);
        if (existing) existing.quantity++;
        else cart.push({ id, name, price, quantity: 1 });
        localStorage.setItem('cart', JSON.stringify(cart));
        updateCartUI();
    });
    $(document).on('click', '.inc-qty', function() {
        let idx = $(this).data('idx');
        cart[idx].quantity++;
        localStorage.setItem('cart', JSON.stringify(cart));
        updateCartUI();
    });
    $(document).on('click', '.dec-qty', function() {
        let idx = $(this).data('idx');
        if (cart[idx].quantity > 1) cart[idx].quantity--;
        else cart.splice(idx,1);
        localStorage.setItem('cart', JSON.stringify(cart));
        updateCartUI();
    });
    $(document).on('click', '.remove-item', function() {
        let idx = $(this).data('idx');
        cart.splice(idx,1);
        localStorage.setItem('cart', JSON.stringify(cart));
        updateCartUI();
    });
    $('#cartToggle').click(() => $('#cartSidebar').addClass('active'));
    $('#closeCart').click(() => $('#cartSidebar').removeClass('active'));
    $('#checkoutBtn').click(() => {
        if (cart.length === 0) return alert('Belum ada pesanan');
        localStorage.setItem('checkoutCart', JSON.stringify(cart));
        window.location.href = "{{ route('order') }}";
    });
    updateCartUI();
</script>
@endpush