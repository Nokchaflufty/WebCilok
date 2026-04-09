@extends('layouts.app')

@section('content')
<style>
    .success-wrapper {
        min-height: 70vh;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
    }
    
    .success-card {
        background-color: var(--card-bg); /* Grey matching the figma screen */
        border-radius: 25px;
        padding: 40px 60px 50px 60px; /* Generous padding */
        text-align: center;
        max-width: 600px;
        width: 100%;
        position: relative;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        border: 1px solid var(--border-color);
        color: var(--text-color);
    }
    
    .success-text {
        font-size: 1.1rem;
        color: var(--text-color);
        line-height: 1.6;
        font-weight: 300;
        margin: 0;
    }
    
    .success-btn {
        position: absolute;
        bottom: -20px; /* Overlaps bottom edge exactly */
        left: 50%;
        transform: translateX(-50%);
        background-color: #a4232a; /* Deep Red */
        color: white;
        border: none;
        border-radius: 50px;
        padding: 10px 45px;
        font-weight: 800;
        font-size: 1.2rem;
        cursor: pointer;
        text-decoration: none;
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        transition: background-color 0.2s, transform 0.2s;
    }
    
    .success-btn:hover {
        background-color: #8c1e24;
        color: white;
    }
</style>

<div class="success-wrapper">
    <div class="success-card">
        <p class="success-text">
            Terima kasih!<br>
            Pesanan <strong>#[{{ $order->id ?? 'NomorPesanan' }}]</strong> sudah<br>
            masuk dalam sistem kami dan akan<br>
            segera dikirim. Jika ada pertanyaan,<br>
            hubungi nomor Whatsapp kami<br>
            [0896-1387-9206].
        </p>
        <a href="{{ route('home') }}" class="success-btn">OK!</a>
    </div>
</div>
@endsection