@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@23.7.3/build/css/intlTelInput.css">
<style>
    /* Styling to match Figma Design */
    .pemesanan-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 50px 15px;
        background-color: transparent;
    }
    .pemesanan-card {
        background-color: var(--card-bg); /* Use theme variable */
        border-radius: 20px;
        padding: 40px 40px 60px 40px; /* extra padding at bottom for button overlap */
        width: 100%;
        max-width: 600px;
        position: relative;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        border: 1px solid var(--border-color);
        color: var(--text-color);
    }
    .form-group-custom {
        margin-bottom: 20px;
    }
    .form-group-custom label {
        display: block;
        font-size: 12px;
        color: var(--text-color);
        margin-bottom: 6px;
        margin-left: 15px;
        font-weight: 500;
        font-family: inherit;
    }
    .form-group-custom .form-control-custom {
        width: 100%;
        border: none;
        border-radius: 50px;
        padding: 12px 20px;
        font-size: 14px;
        background-color: var(--input-bg);
        color: var(--text-color);
        outline: none;
        box-sizing: border-box;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        transition: box-shadow 0.3s ease, border 0.3s ease;
        border: 1px solid var(--border-color);
    }
    .form-group-custom .form-control-custom:focus {
        box-shadow: 0 4px 12px rgba(0,0,0,0.12);
    }
    .pemesanan-btn {
        background-color: #a3222a; /* Red color matching the screenshot */
        color: white;
        border: none;
        border-radius: 50px;
        padding: 10px 45px;
        font-size: 16px;
        font-weight: 600;
        position: absolute;
        bottom: -20px;
        right: 40px;
        cursor: pointer;
        box-shadow: 2px 4px 8px rgba(0,0,0,0.2);
        transition: transform 0.2s, background-color 0.2s;
    }
    .pemesanan-btn:hover {
        background-color: #8f1d24;
        transform: translateY(-2px);
    }
    #orderSummary {
        font-size: 13px;
        color: var(--text-color);
        margin-top: 15px;
        padding: 15px;
        border-radius: 15px;
        background-color: var(--input-bg);
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        display: none; /* Shown via JS */
        border: 1px solid var(--border-color);
    }

    /* Custom Styling for intl-tel-input to keep the PILL design */
    .iti {
        width: 100%;
        display: block;
    }
    .iti__tel-input {
        border-radius: 50px !important; /* Force pill shape */
        padding-left: 95px !important; /* Make room for flag */
    }
    .iti__selected-flag {
        border-radius: 50px 0 0 50px !important;
        padding-left: 20px !important;
        background-color: transparent !important;
    }
    .iti__country-list {
        border-radius: 15px !important;
        overflow-y: auto !important; /* Enable scrolling */
        max-height: 250px !important; /* Set a comfortable height */
        box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important;
        background-color: var(--card-bg) !important;
        color: var(--text-color) !important;
        border: 1px solid var(--border-color) !important;
    }
    .iti__country {
        padding: 10px 15px !important;
    }
    .iti__country:hover {
        background-color: rgba(0,0,0,0.05) !important;
    }
    /* select dropdown styled to match pill inputs */
    .form-group-custom .select-custom {
        width: 100%;
        border: none;
        border-radius: 50px;
        padding: 12px 20px;
        font-size: 14px;
        background-color: var(--input-bg);
        color: var(--text-color);
        outline: none;
        box-sizing: border-box;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        transition: box-shadow 0.3s ease;
        appearance: none;
        border: 1px solid var(--border-color);
        -webkit-appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%23888' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 18px center;
        cursor: pointer;
    }
    .form-group-custom .select-custom:focus {
        box-shadow: 0 4px 12px rgba(163,34,42,0.15);
        outline: none;
    }

    /* Success Modal Styling */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.7);
        backdrop-filter: blur(5px);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }
    .success-modal {
        background: white;
        padding: 40px;
        border-radius: 30px;
        text-align: center;
        max-width: 400px;
        width: 90%;
        box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        animation: slideIn 0.3s ease-out;
    }
    .modal-icon-success {
        font-size: 4rem;
        color: #4CAF50;
        margin-bottom: 20px;
    }
    .modal-title-success {
        font-size: 1.5rem;
        font-weight: 800;
        margin-bottom: 10px;
        color: #333;
    }
    .modal-text-success {
        color: #666;
        margin-bottom: 20px;
        line-height: 1.4;
    }
    @keyframes slideIn {
        from { transform: translateY(20px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
</style>

<div class="container pemesanan-wrapper">
    <div class="pemesanan-card">
        <form id="orderForm">
            @csrf
            <div class="form-group-custom">
                <label>Nama</label>
                <input type="text" name="customer_name" class="form-control-custom" required>
            </div>
            <div class="form-group-custom">
                <label>No. Whatsapp</label>
                <input type="tel" id="whatsappInput" name="whatsapp" class="form-control-custom" placeholder="081234567890" inputmode="numeric" required>
                <span id="phoneHint" style="font-size: 10px; opacity: 0.6; margin-left: 15px; display: block; margin-top: 5px;"></span>
                <span class="phone-error" id="phoneError" style="font-size: 11px; color: #a3222a; margin: 4px 0 0 15px; display: none;">Nomor tidak valid.</span>
            </div>
            <div class="form-group-custom">
                <label>Alamat</label>
                <input type="text" name="address" class="form-control-custom" required>
            </div>
            <div class="form-group-custom">
                <label>Pilihan Kuah</label>
                <select name="note" class="select-custom">
                    <option value="">-- Pilih Level Pedas --</option>
                    <option value="Level 0 (Tidak Pedas)">Level 0 — Tidak Pedas</option>
                    <option value="Level 1 (Sedikit Pedas)">Level 1 — Sedikit Pedas</option>
                    <option value="Level 2 (Pedas)">Level 2 — Pedas</option>
                    <option value="Level 3 (Sangat Pedas)">Level 3 — Sangat Pedas</option>
                    <option value="Level 4 (Extra Pedas)">Level 4 — Extra Pedas</option>
                    <option value="Level 5 (Maut)">Level 5 — Maut 🔥</option>
                </select>
            </div>
            
            <div id="orderSummary">
                <strong>Pesanan Anda:</strong><br>
                <span id="summaryDetail">Memuat...</span>
            </div>

            <button type="submit" class="pemesanan-btn">Pesan</button>
        </form>
    </div>
</div>

<!-- Success Modal -->
<div id="successModal" class="modal-overlay">
    <div class="success-modal">
        <div class="modal-icon-success"><i class="fas fa-check-circle"></i></div>
        <h3 class="modal-title-success">Pesanan Sudah Masuk!</h3>
        <p class="modal-text-success">Pesanan Anda telah kami terima dan sedang diproses oleh admin Warung Cilok Mak Pik. Jika ada pertanyaan, hubungi nomor WhatsApp kami di <strong>0815-1387-9206</strong>.</p>
        <button class="pemesanan-btn" style="position: static; margin-top: 10px;" onclick="window.location.href='{{ route('home') }}'">OK</button>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@23.7.3/build/js/intlTelInput.min.js"></script>
<script>
    // ── Cart summary ──────────────────────────────────────────────────────────
    let cart = JSON.parse(localStorage.getItem('checkoutCart')) || [];
    if (cart.length === 0) {
        $('#orderSummary').html('<p style="margin:0;">Tidak ada pesanan. <a href="{{ route('menu') }}">Kembali ke menu</a></p>').show();
    } else {
        let total = 0, html = '';
        cart.forEach(item => {
            let subtotal = item.price * item.quantity;
            total += subtotal;
            html += `<div>${item.name} x ${item.quantity} = Rp ${subtotal.toLocaleString('id-ID')}</div>`;
        });
        html += `<hr style="margin:10px 0; border-top:1px solid #ccc;"><strong>Total: Rp ${total.toLocaleString('id-ID')}</strong>`;
        $('#summaryDetail').html(html);
        $('#orderSummary').show();
    }

    const phoneInput  = document.getElementById('whatsappInput');
    const phoneError  = document.getElementById('phoneError');
    const phoneHint  = document.getElementById('phoneHint');

    const DIGIT_LIMITS = {
        id: { min: 9,  max: 13, name: 'Indonesia' },
        my: { min: 9,  max: 11, name: 'Malaysia' },
        sg: { min: 8,  max: 8,  name: 'Singapore' },
    };
    const DEFAULT_LIMIT = { min: 7, max: 15 };

    const CURRENCIES = {
        id: 'Rp',
        my: 'RM',
        sg: 'S$',
        us: '$',
        gb: '£',
        au: 'A$',
        jp: '¥',
        kr: '₩',
        cn: '¥',
        ae: 'AED',
        nl: '€',
        de: '€',
        fr: '€'
    };

    function updateSummary() {
        if (cart.length === 0) return;
        const country = iti.getSelectedCountryData().iso2;
        const symbol = CURRENCIES[country] || 'Rp'; 
        
        let total = 0, html = '';
        cart.forEach(item => {
            let subtotal = item.price * item.quantity;
            total += subtotal;
            // Note: We're not doing real conversion rates yet, just changing the symbol/label
            html += `<div>${item.name} x ${item.quantity} = ${symbol} ${subtotal.toLocaleString('id-ID')}</div>`;
        });
        html += `<hr style="margin:10px 0; border-top:1px solid #ccc;"><strong>Total: ${symbol} ${total.toLocaleString('id-ID')}</strong>`;
        $('#summaryDetail').html(html);
    }

    const iti = window.intlTelInput(phoneInput, {
        initialCountry: 'id',
        separateDialCode: true,
        loadUtils: () => import('https://cdn.jsdelivr.net/npm/intl-tel-input@23.7.3/build/js/utils.js'),
    });

    function getLimits() {
        const iso = iti.getSelectedCountryData().iso2;
        return DIGIT_LIMITS[iso] || DEFAULT_LIMIT;
    }

    function updateHint() {
        const country = iti.getSelectedCountryData();
        const limits = getLimits();
        phoneHint.textContent = `Negara: ${country.name} (+${country.dialCode})`;
    }

    phoneInput.addEventListener('countrychange', () => {
        updateHint();
        updateSummary();
    });
    iti.promise.then(() => {
        updateHint();
        updateSummary();
    });

    // Strip non-digits and add dashes for "real phone" feel
    phoneInput.addEventListener('input', function () {
        const limits = getLimits();
        let val = this.value.replace(/[^0-9]/g, '').slice(0, limits.max);
        
        let formatted = "";
        for (let i = 0; i < val.length; i++) {
            if (i > 0 && i % 4 === 0) {
                formatted += "-";
            }
            formatted += val[i];
        }
        
        this.value = formatted;
        phoneError.style.display = 'none';
    });

    // ── Form submission ───────────────────────────────────────────────────────
    $('#orderForm').submit(function (e) {
        e.preventDefault();

        const digitsOnly = phoneInput.value.replace(/[^0-9]/g, '');
        const limits = getLimits();

        if (digitsOnly.length < 7) {
            phoneError.textContent = `Nomor terlalu pendek.`;
            phoneError.style.display = 'block';
            phoneInput.focus();
            return;
        }

        const fullNumber = '+' + iti.getSelectedCountryData().dialCode + digitsOnly;

        let items = cart.map(i => ({ menu_id: i.id, quantity: i.quantity }));
        $.ajax({
            url   : '{{ route("order.store") }}',
            method: 'POST',
            data  : {
                _token       : '{{ csrf_token() }}',
                customer_name: $('input[name="customer_name"]').val(),
                whatsapp     : fullNumber,
                address      : $('input[name="address"]').val(),
                note         : $('select[name="note"]').val(),
                items        : items,
            },
            success: function (res) {
                localStorage.removeItem('cart');
                localStorage.removeItem('checkoutCart');
                // Show Popup instead of immediate redirect
                document.getElementById('successModal').style.display = 'flex';
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                alert('Gagal memesan: ' + (xhr.responseJSON ? xhr.responseJSON.message : 'Silakan coba lagi.'));
            },
        });
    });
</script>
@endpush