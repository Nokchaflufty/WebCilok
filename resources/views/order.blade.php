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

    /* ── intl-tel-input: country dial-code selector ── */
    .iti { width: 100%; display: block; }
    .iti__tel-input {
        width: 100%;
        border: none;
        border-radius: 50px;
        padding: 12px 20px 12px 110px; /* left room for flag + dial code */
        font-size: 14px;
        background-color: var(--input-bg);
        color: var(--text-color);
        outline: none;
        box-sizing: border-box;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        transition: box-shadow 0.3s ease;
        border: 1px solid var(--border-color);
    }
    .iti__tel-input:focus {
        box-shadow: 0 4px 12px rgba(0,0,0,0.12);
    }
    .iti--separate-dial-code .iti__flag-container {
        border-radius: 50px 0 0 50px;
    }
    .iti--separate-dial-code .iti__selected-flag {
        border-radius: 50px 0 0 50px;
        background-color: #f0f0f0;
        padding: 0 8px 0 14px;
    }
    .iti__country-list { border-radius: 12px; box-shadow: 0 8px 24px rgba(0,0,0,0.12); }
    /* digit hint / error messages */
    .phone-hint {
        font-size: 11px;
        color: #888;
        margin: 4px 0 0 15px;
        display: block;
    }
    .phone-error {
        font-size: 11px;
        color: #a3222a;
        margin: 4px 0 0 15px;
        display: none;
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
                <input type="tel" id="whatsappInput" name="whatsapp" inputmode="numeric" required>
                <span class="phone-hint" id="phoneHint">Memuat info negara…</span>
                <span class="phone-error" id="phoneError">Nomor tidak valid untuk negara yang dipilih.</span>
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

    // ── intl-tel-input: country selector + digit limits ──────────────────────
    // Per-country digit limits (subscriber digits, excluding country code).
    // Falls back to { min:7, max:15 } for unlisted countries.
    const DIGIT_LIMITS = {
        id: { min: 9,  max: 13, name: 'Indonesia'    },
        my: { min: 9,  max: 11, name: 'Malaysia'     },
        sg: { min: 8,  max: 8,  name: 'Singapura'    },
        us: { min: 10, max: 10, name: 'Amerika Serikat' },
        gb: { min: 10, max: 10, name: 'Inggris'      },
        au: { min: 9,  max: 9,  name: 'Australia'    },
        jp: { min: 10, max: 11, name: 'Jepang'       },
        kr: { min: 9,  max: 11, name: 'Korea Selatan'},
        cn: { min: 11, max: 11, name: 'China'        },
        in: { min: 10, max: 10, name: 'India'        },
        sa: { min: 9,  max: 9,  name: 'Arab Saudi'   },
        ae: { min: 9,  max: 9,  name: 'UAE'          },
        nl: { min: 9,  max: 9,  name: 'Belanda'      },
        de: { min: 10, max: 11, name: 'Jerman'       },
        fr: { min: 9,  max: 9,  name: 'Prancis'      },
    };
    const DEFAULT_LIMIT = { min: 7, max: 15 };

    const phoneInput  = document.getElementById('whatsappInput');
    const phoneHint   = document.getElementById('phoneHint');
    const phoneError  = document.getElementById('phoneError');

    const iti = window.intlTelInput(phoneInput, {
        initialCountry    : 'id',
        preferredCountries: ['id', 'my', 'sg'],
        separateDialCode  : true,
        loadUtils         : () => import('https://cdn.jsdelivr.net/npm/intl-tel-input@23.7.3/build/js/utils.js'),
    });

    function getLimits() {
        const iso = iti.getSelectedCountryData().iso2;
        return DIGIT_LIMITS[iso] || DEFAULT_LIMIT;
    }

    function updateHint() {
        const country = iti.getSelectedCountryData();
        const iso     = country.iso2;
        const limits  = DIGIT_LIMITS[iso] || DEFAULT_LIMIT;
        const label   = limits.name || country.name || iso.toUpperCase();
        const range   = limits.min === limits.max
            ? `${limits.min} digit`
            : `${limits.min}–${limits.max} digit`;
        phoneHint.textContent = `+${country.dialCode} · ${label} · ${range}`;
        // enforce maxlength dynamically
        phoneInput.setAttribute('maxlength', limits.max);
        phoneInput.setAttribute('minlength', limits.min);
    }

    // Strip non-digits and clamp to current country max on every keystroke
    phoneInput.addEventListener('input', function () {
        const max = getLimits().max;
        this.value = this.value.replace(/[^0-9]/g, '').slice(0, max);
        phoneError.style.display = 'none';
    });

    phoneInput.addEventListener('countrychange', updateHint);

    // Run once after utils load so we get accurate label
    iti.promise.then(updateHint);

    // ── Form submission ───────────────────────────────────────────────────────
    $('#orderForm').submit(function (e) {
        e.preventDefault();

        // Validate phone number length manually to avoid strict library issues
        const digitsOnly = phoneInput.value.replace(/[^0-9]/g, '');
        const limits = getLimits();

        if (digitsOnly.length < limits.min || digitsOnly.length > limits.max) {
            phoneError.textContent = `Nomor tidak valid. Masukkan ${limits.min === limits.max ? limits.min : limits.min + '–' + limits.max} digit untuk negara yang dipilih.`;
            phoneError.style.display = 'block';
            phoneInput.focus();
            return;
        }
        phoneError.style.display = 'none';

        const fullNumber = iti.getNumber(); // e.g. "+6281234567890"

        let items = cart.map(i => ({ menu_id: i.id, quantity: i.quantity }));
        $.ajax({
            url   : '{{ route("order.store") }}',
            method: 'POST',
            data  : {
                _token       : '{{ csrf_token() }}',
                customer_name: $('input[name="customer_name"]').val(),
                whatsapp     : fullNumber,
                address      : $('input[name="address"]').val(),
                note         : $('input[name="note"]').val(),
                items        : items,
            },
            success: function (res) {
                localStorage.removeItem('cart');
                localStorage.removeItem('checkoutCart');
                window.location.href = res.redirect_url;
            },
            error: function () { alert('Gagal memesan, coba lagi.'); },
        });
    });
</script>
@endpush