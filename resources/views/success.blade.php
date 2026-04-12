@extends('layouts.app')

@section('content')
<style>
    .success-wrapper {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        min-height: 80vh;
        text-align: center;
        padding: 20px;
    }
    .success-icon {
        font-size: 5rem;
        color: #4CAF50;
        margin-bottom: 20px;
        animation: scaleUp 0.5s ease-out;
    }
    .success-title {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--text-color);
        margin-bottom: 15px;
    }
    .success-text {
        font-size: 1.1rem;
        color: var(--text-color);
        opacity: 0.8;
        max-width: 500px;
        margin-bottom: 40px;
    }
    .btn-back-home {
        background-color: #a3222a;
        color: white;
        text-decoration: none;
        padding: 15px 40px;
        border-radius: 50px;
        font-weight: 700;
        box-shadow: 0 4px 15px rgba(163,34,42,0.3);
        transition: transform 0.2s;
    }
    .btn-back-home:hover {
        transform: translateY(-3px);
        color: white;
    }
    @keyframes scaleUp {
        0% { transform: scale(0); }
        100% { transform: scale(1); }
    }
</style>

<div class="container success-wrapper">
    <div class="success-icon">
        <i class="fas fa-check-circle"></i>
    </div>
    <h1 class="success-title">PESANAN TERKIRIM!</h1>
    <p class="success-text">
        Terima kasih <strong>{{ $order->customer_name }}</strong>, pesanan Anda telah kami terima dan sedang diproses. 
        Admin akan segera menghubungi Anda melalui WhatsApp. Jika ada pertanyaan, silakan hubungi kami di <strong>0815-1387-9206</strong>.
    </p>
    <a href="{{ route('home') }}" class="btn-back-home">KEMBALI KE BERANDA</a>
</div>
@endsection
