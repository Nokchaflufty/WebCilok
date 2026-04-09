@extends('layouts.app')

@section('content')
<style>
    .about-wrapper {
        display: flex;
        justify-content: center;
        padding: 60px 20px;
    }
    .about-main-card {
        background-color: var(--bg-color); /* Very light grey outer canvas */
        border-radius: 40px; /* Extremely rounded */
        max-width: 950px;
        width: 100%;
        padding: 45px; /* Even padding all around */
        box-shadow: 0 8px 20px rgba(0,0,0,0.15); 
        display: flex;
        flex-direction: column;
        gap: 35px; /* Creates the space between the red box and the contact box natively */
        border: 1px solid var(--border-color);
    }
    .about-card-red {
        background-color: #a4232a;
        color: white;
        border-radius: 25px;
        padding: 35px 45px;
        font-size: 1.1rem;
        font-weight: 500;
        line-height: 1.6;
        text-align: justify;
        box-shadow: 0 8px 24px rgba(0,0,0,0.25);
    }
    .about-card-contact {
        background-color: var(--card-bg);
        border-radius: 35px;
        padding: 35px 50px;
        box-shadow: 0 8px 24px rgba(0,0,0,0.2);
        border: 1px solid var(--border-color);
    }
    .about-card-contact h3 {
        font-weight: 800;
        color: var(--text-color);
        margin-bottom: 20px;
        font-size: 1.4rem;
    }
    .contact-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 0;
        border-bottom: 2px solid var(--border-color); /* Distinct grey line separating entries */
        font-size: 1.25rem;
        color: var(--text-color);
        margin-bottom: 10px;
    }
    .contact-icon {
        font-size: 2rem;
    }
    .icon-wa {
        color: #25D366; 
    }
    .icon-ig {
        background: -webkit-linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    
    @media (max-width: 800px) {
        .about-main-card {
            padding: 25px;
        }
        .about-card-red, .about-card-contact {
            padding: 20px;
        }
    }
</style>

<div class="about-wrapper">
    <div class="about-main-card">
        <!-- TOP NESTED BLOCK (Red) -->
        <div class="about-card-red">
            Selamat datang di Warung Cilok Pedas Mak Pik! Kami memulai usaha ini dengan semangat menghadirkan jajanan sederhana yang penuh rasa dan kenangan, menyajikan cilok kenyal dari bahan pilihan dengan bumbu kacang khas serta sambal pedas yang menggugah selera. Kami berkomitmen menjaga kualitas dengan bahan yang fresh dan tanpa bahan berbahaya, sehingga setiap porsi dibuat dengan cinta dan menghadirkan sensasi pedas gurih yang bikin nagih—setiap gigitan adalah pengalaman nikmat yang siap memanjakan lidah Anda! 🌶️
        </div>
        
        <!-- BOTTOM NESTED BLOCK (Darker Grey) -->
        <div class="about-card-contact">
            <h3>CONTACT US</h3>
            <div class="contact-row">
                <span>0896-1387-9206</span>
                <i class="fab fa-whatsapp contact-icon icon-wa"></i>
            </div>
            <div class="contact-row">
                <span>@cilokpedaswarungmakpik</span>
                <i class="fab fa-instagram contact-icon icon-ig"></i>
            </div>
        </div>
    </div>
</div>
@endsection