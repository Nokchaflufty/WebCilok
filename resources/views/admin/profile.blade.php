@extends('layouts.admin')

@section('page_title', 'Profile')

@section('content')
<style>
    .welcome-text {
        color: #888;
        font-weight: 600;
        margin-bottom: 25px;
    }
    .profile-card-container {
        position: relative;
        padding-top: 60px; /* Space for absolute avatar */
    }
    .profile-card {
        background: var(--admin-card-bg);
        border-radius: 40px;
        padding: 80px 60px 50px 60px;
        box-shadow: var(--admin-shadow);
        display: flex;
        gap: 50px;
        min-height: 400px;
        color: var(--admin-text);
    }
    .profile-avatar-large {
        position: absolute;
        top: 0;
        left: 60px;
        width: 150px;
        height: 150px;
        background: linear-gradient(135deg, #ff0000 0%, #d32f2f 100%);
        color: white;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        font-weight: 900;
        font-size: 5.5rem;
        border: 10px solid var(--admin-content-bg);
        box-shadow: 0 10px 20px rgba(211, 47, 47, 0.4);
        overflow: hidden;
        z-index: 10;
        background-size: cover;
        background-position: center;
    }
    .profile-info-left {
        flex: 1;
    }
    .profile-name {
        font-size: 2.2rem;
        font-weight: 900;
        margin: 0 0 20px 0;
        color: var(--admin-text);
    }
    .profile-about h4 {
        font-weight: 800;
        margin-bottom: 10px;
        font-size: 1.1rem;
        color: var(--admin-text);
    }
    .profile-about p {
        color: var(--admin-text);
        opacity: 0.8;
        line-height: 1.6;
        font-size: 0.9rem;
        text-align: justify;
    }
    
    .profile-details-right {
        width: 400px;
        display: flex;
        flex-direction: column;
        gap: 20px;
    }
    .detail-box {
        background-color: var(--admin-content-bg);
        border-radius: 20px;
        padding: 15px 25px;
        display: flex;
        align-items: center;
        gap: 20px;
        color: var(--admin-text);
        box-shadow: var(--admin-shadow);
    }
    .detail-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        justify-content: center;
        align-items: center;
        color: white;
        font-size: 1.5rem;
    }
    .icon-email { background-color: #ffeb3b; color: white; }
    .icon-user { background-color: #ff0000; color: white; }
    .icon-pass { background-color: #ffee58; color: white; }
    
    .detail-content label {
        display: block;
        font-size: 0.8rem;
        color: #888;
        margin-bottom: 2px;
        font-weight: 600;
    }
    .detail-content span {
        font-weight: 700;
        color: var(--admin-text);
        font-size: 1rem;
    }
    
    .btn-edit-profile {
        display: inline-block;
        background-color: #ff0000;
        color: white;
        border: none;
        border-radius: 12px;
        padding: 12px 30px;
        font-weight: 900;
        font-size: 1.4rem;
        margin-top: 30px;
        box-shadow: 0 4px 15px rgba(255,0,0,0.3);
        text-decoration: none;
    }
    .btn-edit-profile:hover {
        background-color: #d32f2f;
        color: white;
    }
</style>

<div class="profile-page-wrapper">
    <div class="welcome-section">
        <p class="welcome-text">Kelola informasi profil Anda</p>
    </div>

    <div class="profile-card-container">
        <div class="profile-avatar-large" style="{{ $user->profile_image ? 'background-image: url(' . asset('uploads/profile/' . $user->profile_image) . ');' : '' }}">
            @if(!$user->profile_image)
                {{ strtoupper(substr($user->username, 0, 1)) }}
            @endif
        </div>
        <div class="profile-card">
            <div class="profile-info-left">
                <h2 class="profile-name">{{ $user->name }}</h2>
                <div class="profile-about">
                    <h4>Tentang</h4>
                    <p>
                        Administrator Warung Cilok Mak Pik. Bertanggung jawab penuh atas pengelolaan menu dan monitoring pesanan masuk secara real-time.
                    </p>
                </div>
            </div>
            
            <div class="profile-details-right">
                <div class="detail-box">
                    <div class="detail-icon icon-email"><i class="fas fa-envelope"></i></div>
                    <div class="detail-content">
                        <label>Email</label>
                        <span>{{ $user->email }}</span>
                    </div>
                </div>
                
                <div class="detail-box">
                    <div class="detail-icon icon-user"><i class="fas fa-user-alt"></i></div>
                    <div class="detail-content">
                        <label>Username</label>
                        <span>{{ $user->username }}</span>
                    </div>
                </div>
                
                <div class="detail-box">
                    <div class="detail-icon icon-pass"><i class="fas fa-lock"></i></div>
                    <div class="detail-content">
                        <label>Password</label>
                        <span>********</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <a href="{{ route('admin.profile.edit') }}" class="btn-edit-profile">Edit Profile</a>
</div>

@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        showAlert('Berhasil!', "{{ session('success') }}");
    });
</script>
@endif
@endsection
