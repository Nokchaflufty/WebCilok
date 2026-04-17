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
            <p class="hero-desc">Lebih dari sekadar jajanan kaki lima, Cilok Pedas Mak Pik adalah resep legendaris yang diwariskan turun-temurun.</p>
        </div>
        <div class="hero-right">
            <div class="hero-img-box">
                <img src="https://images.unsplash.com/photo-1563514253100-348638bd1b49?auto=format&fit=crop&w=400&q=80" alt="Cilok Pedas Artisan" onerror="this.style.display='none'" style="border-radius: 20px; box-shadow: 0 10px 20px rgba(0,0,0,0.5);">
            </div>
            <div class="hero-quote-card">
                <div class="hero-quote-text">"Sekali nyoba, susah berhenti."</div>
                <div class="hero-quote-author">— Mak Pik sendiri</div>
            </div>
        </div>
    </section>

    <!-- Our Journey (Professional) -->
    <section class="journey-section">
        <div class="section-header">
            <h2>Perjalanan Kami</h2>
            <p>Dari gerobak kecil sederhana hingga menjadi destinasi pedas favorit di kota, kami tetap setia pada akar kami.</p>
        </div>
        <div class="journey-grid">
            <!-- 1. Visi Kita -->
            <div class="j-card card-vision">
                <div class="card-vision-content">
                    <div class="j-icon">
                        <i class="fa-solid fa-eye"></i>
                    </div>
                    <h3 class="j-title">Visi Kita</h3>
                    <p class="j-desc">Resep lama tetap jadi dasar, tapi dibawa dengan gaya yang lebih modern.
Harapannya? Mak Pik bisa dikenal lebih jauh, bahkan sampai luar sana.</div>
                <div class="card-vision-img">
                    <span>Nuansa Pedas</span>
                </div>
            </div>

            <!-- 2. Misi Kita -->
            <div class="j-card card-mission">
                <div class="j-icon">
                    <i class="fa-solid fa-rocket"></i>
                </div>
                <h3 class="j-title" style="color: white;">Misi Kita</h3>
                <p class="j-desc">Membuat amilan pedas yang enak, aman, dan selalu bikin pengen nambah.</p>
            </div>

            <!-- 3. Pesan Owner -->
            <div class="j-card card-origin">
                <div class="j-icon">
                    <i class="fa-solid fa-arrow-up-right-dots"></i>
                </div>
                <h3 class="j-title">Pesan Owner</h3>
                <p class="j-desc">Sejak 2012, Mak Pik udah ngeracik sausnya sendiri dan lama-lama jadi favorit di sekitar.
Menurut dia, pedas itu bukan soal kuat-kuatan tapi soal rasa yang bikin nagih.</p>
                <div class="founder-box">
                    <div class="founder-avatar" style="background-image: url('https://randomuser.me/api/portraits/women/68.jpg');"></div>
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
                    <p class="j-desc">Cilok kami diuleni setiap hari menggunakan tepung tapioka premium dan dikukus hingga mencapai konsistensi 'kenyal' sempurna yang dicintai masyarakat lokal.</p>
                </div>
                <div class="card-craft-img" style="background-image: url('https://images.unsplash.com/photo-1615486511484-92e172fc34ea?auto=format&fit=crop&w=500&q=80');"></div>
            </div>
        </div>
    </section>

    <!-- Our Spicy Values (Professional) -->
    <section class="values-section">
        <div class="values-left">
            <h2>Cara Kami Ngebikin<br>Pedas</h2>
            <p>Awalnya cuma karena doyan pedas. Lama-lama, ketemu orang-orang yang sama-sama suka</p>
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

    <!-- Footer Area -->
    <footer class="footer-custom">
        <h3 class="footer-title">Cilok Mak Pik</h3>
        <div class="footer-links" style="margin-bottom: 2rem; margin-top: 2rem;">
            <a href="#">Instagram</a>
            <a href="#">TikTok</a>
            <a href="#">WhatsApp</a>
            <a href="#">Kebijakan Privasi</a>
            <a href="#">Kontak</a>
        </div>
        <div class="footer-bottom">
            &copy; 2024 Cilok Pedas Mak Pik.
        </div>
    </footer>
</div>
@endsection