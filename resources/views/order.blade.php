@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@23.7.3/build/css/intlTelInput.css">
<link href="{{ asset('css/order.css') }}" rel="stylesheet">

<div class="order-page-wrapper">
    <div class="order-grid">
        
        <!-- LEFT COLUMN -->
        <div class="order-left-col">
            <div class="order-header">
                <div class="order-hero-badge">ORDER FORM</div>
                <h1 class="order-hero-title">Pesan <span>Pedasnya</span><br>Sekarang.</h1>
                <p class="order-hero-desc">Isi form di bawah untuk memesan Cilok Mak Pik yang legendaris langsung ke rumahmu.</p>
            </div>
            
            <div class="order-features">
                <div class="feature-card-blue">
                    <i class="fa-solid fa-truck feature-icon"></i>
                    <h3 class="feature-title">Pengiriman Cepat</h3>
                    <div class="feature-desc">Pesanan kamu akan dikirim dalam waktu 30-45 menit dalam kondisi masih hangat.</div>
                </div>
                
                <div class="feature-card-red">
                    <i class="fa-solid fa-medal feature-icon"></i>
                    <h3 class="feature-title">Bahan Premium</h3>
                    <div class="feature-desc">Hanya menggunakan tepung pilihan dan cabai segar asli pilihan Mak Pik.</div>
                </div>
                <!-- Removed #StreetHeatMakPik image card as requested -->
            </div>
        </div>
        
        <!-- RIGHT COLUMN -->
        <div class="order-right-col">
            <img src="{{ asset('images/Home_Wallpaper.png') }}" alt="Cilok Mak Pik" class="order-hero-img">
            
            <div class="order-form-container">
                <form id="orderForm">
                    @csrf
                    <div class="form-grid">
                        
                        <div class="form-group">
                            <label class="form-label"><i class="fa-regular fa-user"></i> Nama Lengkap</label>
                            <input type="text" name="customer_name" class="form-input" placeholder="Masukkan nama kamu" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label"><i class="fa-brands fa-whatsapp"></i> Nomor WhatsApp</label>
                            <input type="tel" id="whatsappInput" name="whatsapp" class="form-input" inputmode="numeric" required>
                            <span class="phone-error" id="phoneError" style="font-size: 11px; color: #ef4444; margin-top: 4px; display: none;">Nomor tidak valid.</span>
                        </div>
                        
                        <div class="form-group full-width">
                            <label class="form-label"><i class="fa-solid fa-location-dot"></i> Alamat Lengkap</label>
                            <input type="text" name="address" class="form-input" placeholder="Nama jalan, nomor rumah, RT/RW..." required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label"><i class="fa-solid fa-utensils"></i> Pilih Menu Tambahan</label>
                            <select id="menuSelect" class="form-input form-select">
                                <option value="" disabled selected>Pilih menu...</option>
                                @foreach($menus as $menu)
                                    <option value="{{ $menu->id }}" data-name="{{ $menu->name }}" data-price="{{ $menu->price_numeric }}">
                                        {{ $menu->name }} - {{ $menu->price }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label"><i class="fa-solid fa-list-ol"></i> Jumlah</label>
                            <input type="number" id="menuQty" class="form-input" value="1" min="1" placeholder="1">
                        </div>
                        
                        <div class="form-group full-width" style="margin-top: -10px;">
                            <button type="button" id="btnAddMenu" class="add-menu-btn">
                                <i class="fa-solid fa-plus"></i> Tambahkan Ke Pesanan
                            </button>
                        </div>

                        <!-- CART ITEMS DISPLAY -->
                        <div class="form-group full-width">
                            <label class="form-label"><i class="fa-solid fa-basket-shopping"></i> Daftar Pesanan</label>
                            <div class="cart-items-list" id="cartContainer">
                                <div style="padding: 15px; text-align: center; color: #94a3b8; font-size: 0.9rem;">Belum ada pesanan</div>
                            </div>
                            <div style="text-align: right; margin-top: 10px; font-weight: 800; font-size: 1.2rem; color: #1e293b;" id="cartTotalDisplay">Total: Rp 0</div>
                        </div>

                        <div class="form-group full-width">
                            <label class="form-label"><i class="fa-regular fa-clipboard"></i> Catatan Tambahan</label>
                            <textarea name="note" class="form-input form-textarea" placeholder="Contoh: Pisah sambalnya ya Mak, jangan pakai seledri..."></textarea>
                        </div>
                        
                    </div>
                    
                    <button type="submit" class="btn-submit-order">
                        Kirim Pesanan <i class="fa-solid fa-paper-plane"></i>
                    </button>
                    <div class="form-disclaimer">
                        Dengan menekan tombol di atas, pesanan kamu akan diteruskan langsung ke WhatsApp Mak Pik.
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Success Modal -->
<!-- Reusing the Modal styles briefly inline since order.css is mostly layout -->
<style>
    .modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); backdrop-filter: blur(5px); display: none; justify-content: center; align-items: center; z-index: 1000; }
    .success-modal { background: white; padding: 40px; border-radius: 30px; text-align: center; max-width: 400px; width: 90%; box-shadow: 0 20px 40px rgba(0,0,0,0.2); animation: slideIn 0.3s ease-out; }
    .modal-icon-success { font-size: 4rem; color: #10b981; margin-bottom: 20px; }
    .modal-title-success { font-size: 1.5rem; font-weight: 800; margin-bottom: 10px; color: #1e293b; }
    .modal-text-success { color: #64748b; margin-bottom: 20px; line-height: 1.4; }
    .btn-modal-ok { background: #10b981; color: white; padding: 12px 40px; border: none; border-radius: 50px; font-weight: 700; width: 100%; cursor: pointer; transition: 0.2s; }
    .btn-modal-ok:hover { background: #059669; }
    @keyframes slideIn { from { transform: translateY(20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
</style>

<div id="successModal" class="modal-overlay">
    <div class="success-modal">
        <div class="modal-icon-success" style="color: #25D366;"><i class="fab fa-whatsapp"></i></div>
        <h3 class="modal-title-success">Pesanan Berhasil Dicatat!</h3>
        <p class="modal-text-success"> Pesanan akan cepat diproses.</p>
        <div style="display: flex; gap: 10px;">
            <button class="btn-modal-ok" style="background: #e2e8f0; color: #475569;" onclick="window.location.href='{{ route('home') }}'">Tutup</button>
            <a id="waRedirectLink" href="#" target="_blank" style="text-decoration: none; width: 100%;">
                <button class="btn-modal-ok" style="background: #25D366; color: white;">Kirim Sekarang <i class="fa-solid fa-paper-plane" style="margin-left: 5px;"></i></button>
            </a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@23.7.3/build/js/intlTelInput.min.js"></script>
<script>
    // --- Cart System ---
    let cart = JSON.parse(localStorage.getItem('checkoutCart')) || [];
    
    function updateCartUI() {
        const container = $('#cartContainer');
        const totalDisplay = $('#cartTotalDisplay');
        
        if (cart.length === 0) {
            container.html('<div style="padding: 15px; text-align: center; color: #94a3b8; font-size: 0.9rem;">Belum ada pesanan yang dipilih</div>');
            totalDisplay.text('Total: Rp 0');
            return;
        }
        
        let html = '';
        let total = 0;
        
        cart.forEach((item, index) => {
            const subtotal = item.price * item.quantity;
            total += subtotal;
            
            html += `
                <div class="cart-item-row">
                    <div>
                        <div style="font-weight: 700; color: #1e293b; font-size: 0.95rem;">${item.name}</div>
                        <div style="color: #64748b; font-size: 0.85rem;">Rp ${item.price.toLocaleString('id-ID')} x ${item.quantity}</div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <div style="font-weight: 800; color: #c8102e;">Rp ${subtotal.toLocaleString('id-ID')}</div>
                        <button type="button" class="btn-remove-item" onclick="removeCartItem(${index})">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </div>
                </div>
            `;
        });
        
        container.html(html);
        const symbol = typeof iti !== 'undefined' && iti.getSelectedCountryData ? (CURRENCIES[iti.getSelectedCountryData().iso2] || 'Rp') : 'Rp';
        totalDisplay.text(`Total: ${symbol} ${total.toLocaleString('id-ID')}`);
        
        // sync with local storage 
        localStorage.setItem('checkoutCart', JSON.stringify(cart));
    }
    
    window.removeCartItem = function(index) {
        cart.splice(index, 1);
        updateCartUI();
    };
    
    $('#btnAddMenu').click(function() {
        const select = $('#menuSelect option:selected');
        if (!select.val()) return alert('Pilih menu terlebih dahulu!');
        
        const id = select.val();
        const name = select.data('name');
        const price = select.data('price');
        const qty = parseInt($('#menuQty').val());
        
        if (qty < 1 || isNaN(qty)) return alert('Jumlah harus minimal 1');
        
        const existing = cart.find(i => i.id == id);
        if (existing) {
            existing.quantity += qty;
        } else {
            cart.push({ id, name, price, quantity: qty });
        }
        
        // Reset form inputs gently
        $('#menuSelect').val('');
        $('#menuQty').val(1);
        
        updateCartUI();
    });

    // --- Phone Number Inputs ---
    const phoneInput  = document.getElementById('whatsappInput');
    const phoneError  = document.getElementById('phoneError');
    
    const DIGIT_LIMITS = { id: { min: 9,  max: 13 }, my: { min: 9,  max: 11 }, sg: { min: 8,  max: 8 } };
    const CURRENCIES = { id: 'Rp', my: 'RM', sg: 'S$', us: '$', gb: '£', au: 'A$', jp: '¥', kr: '₩', ae: 'AED', nl: '€', de: '€', fr: '€' };
    
    const iti = window.intlTelInput(phoneInput, {
        initialCountry: 'id',
        separateDialCode: true,
        loadUtils: () => import('https://cdn.jsdelivr.net/npm/intl-tel-input@23.7.3/build/js/utils.js'),
    });
    
    phoneInput.addEventListener('countrychange', () => {
        updateCartUI(); // Update currency symbol
    });
    
    iti.promise.then(() => updateCartUI());
    
    phoneInput.addEventListener('input', function () {
        const iso = iti.getSelectedCountryData().iso2;
        const limits = DIGIT_LIMITS[iso] || { min: 7, max: 15 };
        let val = this.value.replace(/[^0-9]/g, '').slice(0, limits.max);
        
        let formatted = "";
        for (let i = 0; i < val.length; i++) {
            if (i > 0 && i % 4 === 0) formatted += "-";
            formatted += val[i];
        }
        this.value = formatted;
        phoneError.style.display = 'none';
    });

    // --- Form Submission ---
    $('#orderForm').submit(function (e) {
        e.preventDefault();
        
        if (cart.length === 0) {
            alert('Belum ada pesanan di keranjang Anda!');
            $('#menuSelect').focus();
            return;
        }

        const digitsOnly = phoneInput.value.replace(/[^0-9]/g, '');
        if (digitsOnly.length < 7) {
            phoneError.style.display = 'block';
            phoneInput.focus();
            return;
        }

        const fullNumber = '+' + iti.getSelectedCountryData().dialCode + digitsOnly;
        const customer_name = $('input[name="customer_name"]').val();
        const address = $('input[name="address"]').val();
        const note = $('textarea[name="note"]').val();
        
        let items = cart.map(i => ({ menu_id: i.id, quantity: i.quantity }));
        
        const btn = $('.btn-submit-order');
        const originalText = btn.html();
        btn.html('<i class="fa-solid fa-spinner fa-spin"></i> Memproses...').prop('disabled', true);

        $.ajax({
            url   : '{{ route("order.store") }}',
            method: 'POST',
            data  : {
                _token       : '{{ csrf_token() }}',
                customer_name: customer_name,
                whatsapp     : fullNumber,
                address      : address,
                note         : note,
                items        : items,
            },
            success: function (res) {
                // Build WA Message
                let waText = `Permisi, Saya atas nama *${customer_name}*, memesan cilok melalui website dengan rincian pemesanan:\n\n`;
                waText += `📍 *Alamat Pengiriman*:\n${address}\n\n`;
                waText += `🛒 *Detail Pesanan*:\n`;
                
                let total = 0;
                cart.forEach(item => {
                    const subtotal = item.price * item.quantity;
                    total += subtotal;
                    waText += `- ${item.name} x${item.quantity} = Rp ${subtotal.toLocaleString('id-ID')}\n`;
                });
                
                waText += `\n*TOTAL: Rp ${total.toLocaleString('id-ID')}*\n`;
                if (note && note.trim() !== '') waText += `\n📝 *Catatan*:\n${note}\n`;
                
                const waNumber = '6285233159859'; // Target admin WhatsApp number
                const waUrl = `https://wa.me/${waNumber}?text=${encodeURIComponent(waText)}`;
                
                localStorage.removeItem('cart');
                localStorage.removeItem('checkoutCart');
                
                // Update Modal Content & Show
                $('#waRedirectLink').attr('href', waUrl);
                document.getElementById('successModal').style.display = 'flex';
                btn.html(originalText).prop('disabled', false);
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                alert('Gagal memesan: ' + (xhr.responseJSON ? xhr.responseJSON.message : 'Silakan coba lagi.'));
                btn.html(originalText).prop('disabled', false);
            },
        });
    });

    // Initial Render
    updateCartUI();
</script>
@endpush