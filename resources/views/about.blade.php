@extends('layouts.app')

@section('content')
<link href="{{ asset('css/about.css') }}" rel="stylesheet">

<div class="about-page-wrapper">
    <!-- Hero Section (Professional) -->
    <section class="about-hero">
        <div class="hero-left">
            <div class="hero-badge">
                <i class="fa-solid fa-fire"></i> WARISAN PEDAS
            </div>
            <h1 class="hero-title">Di Balik Pedasnya Cilok <span class="text-red">Pedas</span></h1>
            <p class="hero-desc">Lebih dari sekadar jajanan kaki lima, Cilok Mak Pik adalah warung pedas yang menyajikan cita rasa khas, hangat, dan bikin nagih dari awal sampai akhir.</p>
        </div>
        <div class="hero-right">
            <div class="hero-img-box">
            </div>
            <div class="hero-quote-card">
                <div class="hero-quote-text">"Sekali nyoba, susah berhenti."</div>
                <div class="hero-quote-author">— Owner</div>
            </div>
        </div>
    </section>

    <!-- Our Journey (Professional) -->
    <section class="journey-section">
        <div class="section-header">
            <h2>Perjalanan Kami</h2>
            <p>Dari gerobak kecil sederhana hingga dikenal banyak pelanggan, kisah Mak Pik selalu berangkat dari rasa yang konsisten, bumbu yang khas, dan semangat untuk terus berkembang.</p>
        </div>
        <div class="journey-grid">
            <!-- 1. Visi Kita -->
            <div class="j-card card-vision">
                <div class="card-vision-content">
                    <div class="j-icon">
                        <i class="fa-solid fa-eye"></i>
                    </div>
                    <h3 class="j-title">Visi Kita</h3>
                    <p class="j-desc">Resep lama tetap jadi dasar, tapi dibawa dengan gaya yang lebih modern. Harapannya, Mak Pik bisa dikenal lebih jauh, bahkan sampai luar sana.</p>
                </div>
                <div class="card-vision-img" style="background-image: url('{{ asset('images/orgjualan.jpg') }}'); background-size: cover; background-position: center;"></div>
            </div>

            <!-- 2. Misi Kita -->
            <div class="j-card card-mission">
                <div class="j-icon">
                    <i class="fa-solid fa-rocket"></i>
                </div>
                <h3 class="j-title" style="color: white;">Misi Kita</h3>
                <p class="j-desc">Membuat cilok pedas yang enak, aman, dan selalu bikin pengen nambah.</p>
            </div>

            <!-- 3. Pesan Owner -->
            <div class="j-card card-origin">
                <div class="j-icon">
                    <i class="fa-solid fa-arrow-up-right-dots"></i>
                </div>
                <h3 class="j-title">Pesan Owner</h3>
                <p class="j-desc">Sejak 2020, Mak Pik udah ngeracik sausnya sendiri dan lama-lama jadi favorit di sekitar. Menurut dia, pedas itu bukan soal kuat-kuatan tapi soal rasa yang bikin nagih.</p>
                <div class="founder-box">
                    <div class="founder-avatar" style="background-image: url('{{ asset('images/logo.jpeg') }}');"></div>
                    <div class="founder-name">Didirikan oleh Mak Pik -</div>
                </div>
            </div>

            <!-- 4. Bumbu Rahasia -->
            <div class="j-card card-craft">
                <div class="card-craft-content">
                    <div class="craft-tags">
                        <span>100% BUATAN TANGAN</span>
                        <span class="tag-red">SKALA PEDAS 10+</span>
                    </div>
                    <h3 class="j-title">Bumbu Rahasia</h3>
                    <p class="j-desc">Cilok kami diuleni setiap hari dengan tepung tapioka pilihan dan dikukus sampai kenyal sempurna. Bumbunya yang khas bikin rasanya susah dilupakan.</p>
                </div>
                <div class="card-craft-img" style="background-image: url('{{ asset('images/foto1.jpg') }}');"></div>
            </div>
        </div>
    </section>

    <!-- Our Spicy Values (Professional) -->
    <section class="values-section">
        <div class="values-left">
            <h2>Cara Kami Ngebikin<br>Pedas</h2>
            <p>Awalnya karena kami memang suka pedas. Lama-kelamaan, kami bertemu banyak orang yang punya selera yang sama.</p>
        </div>
        <div class="values-right">
            <div class="val-card">
                <div class="val-icon">
                    <i class="fa-solid fa-heart"></i>
                </div>
                <h3>Mulai Dari Yang Kita Suka</h3>
                <p>Setiap mangkuk disajikan dengan keramah-tamahan khas Indonesia yang tulus.</p>
            </div>
            <div class="val-card">
                <div class="val-icon">
                    <i class="fa-solid fa-leaf"></i>
                </div>
                <h3>Kualitas Murni</h3>
                <p>Kami hanya menggunakan cabai rawit tersegar dari petani lokal.</p>
            </div>
            <div class="val-card">
                <div class="val-icon">
                    <i class="fa-solid fa-users"></i>
                </div>
                <h3>Inklusi</h3>
                <p>Jajanan kaki lima untuk semua orang, dari remaja hingga veteran pecinta pedas.</p>
            </div>
        </div>
    </section>

    <!-- Dark CTA (Professional) -->
    <section class="dark-cta-section">
        <div class="dark-cta">
            <h2>Siap menguji batasmu?</h2>
            <p>Bergabunglah dengan ribuan pencari sensasi pedas yang telah menemukan cita rasa legendaris Mak Pik.</p>
            <div class="dark-cta-buttons">
                <a href="{{ route('menu') }}" class="btn-cta-red">Jelajahi Menu</a>
            </div>
        </div>
    </section>

    <!-- Footer removed, now in app.blade.php -->
</div>
@endsection