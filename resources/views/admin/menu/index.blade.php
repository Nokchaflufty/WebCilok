@extends('layouts.admin')

@section('page_title', 'Menu')

@section('content')
<style>
    .welcome-text {
        color: #888;
        font-weight: 600;
        margin-bottom: 25px;
    }
    .menu-management-card {
        background: var(--admin-card-bg);
        border-radius: 20px;
        padding: 25px;
        box-shadow: var(--admin-shadow);
        min-height: 300px;
        color: var(--admin-text);
    }
    .menu-header-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 40px;
    }
    .search-container {
        position: relative;
        width: 350px;
    }
    .search-container i {
        position: absolute;
        left: 20px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 1.5rem;
        color: var(--admin-text);
    }
    .search-input {
        width: 100%;
        border: 2px solid var(--admin-text);
        background: var(--admin-card-bg);
        color: var(--admin-text);
        border-radius: 50px;
        padding: 8px 15px 8px 45px;
        font-size: 1rem;
        font-weight: 600;
        outline: none;
    }
    .btn-tambah-menu {
        background-color: #ff0000;
        color: white;
        border: none;
        border-radius: 12px;
        padding: 8px 20px;
        font-weight: 800;
        font-size: 1.1rem;
        box-shadow: 0 4px 15px rgba(255,0,0,0.3);
        text-decoration: none;
        transition: background-color 0.2s;
    }
    .btn-tambah-menu:hover {
        background-color: #d32f2f;
        color: white;
    }
    
    .menu-list {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }
    .menu-admin-item {
        border: 1px solid var(--admin-text);
        background: var(--admin-card-bg);
        border-radius: 20px;
        padding: 10px 20px;
        display: flex;
        align-items: center;
        gap: 15px;
        transition: transform 0.2s;
        color: var(--admin-text);
        box-shadow: var(--admin-shadow);
    }
    .menu-admin-item:hover {
        transform: scale(1.005);
    }
    .menu-admin-img {
        width: 80px;
        height: 65px;
        object-fit: cover;
        border: 1px solid var(--admin-text);
        border-radius: 8px;
    }
    .menu-admin-name {
        font-size: 1.2rem;
        font-weight: 800;
        margin: 0;
        text-transform: uppercase;
    }
    .menu-admin-price {
        font-size: 0.95rem;
        font-weight: 500;
        color: var(--admin-text);
        opacity: 0.7;
    }
    .menu-item-actions {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .action-btn {
        width: 35px;
        height: 35px;
        border-radius: 6px;
        display: flex;
        justify-content: center;
        align-items: center;
        border: none;
        cursor: pointer;
        color: white;
        font-size: 1rem;
    }
    .btn-edit { background-color: #9c92f8; }
    .btn-delete { background-color: #ffb4b4; }
</style>

<div class="menu-page-wrapper">
    <div class="welcome-section">
        <p class="welcome-text">Kelola menu makanan dan minuman</p>
    </div>

    <div class="menu-management-card">
        <div class="menu-header-actions">
            <div class="search-container">
                <i class="fas fa-search"></i>
                <input type="text" class="search-input" placeholder="Cari Menu">
            </div>
            <a href="{{ route('admin.menu.create') }}" class="btn-tambah-menu">Tambah Menu</a>
        </div>

        <div class="menu-list">
            @forelse($menus as $menu)
            <div class="menu-admin-item">
                <img src="{{ asset('images/logo.jpeg') }}" class="menu-admin-img" alt="Menu Image">
                <div class="menu-admin-info">
                    <h3 class="menu-admin-name">{{ $menu->name }}</h3>
                    <span class="menu-admin-price">{{ $menu->price }}</span>
                </div>
                <div class="menu-item-actions">
                    <button class="action-btn btn-edit"><i class="fas fa-pen"></i></button>
                    <button class="action-btn btn-delete"><i class="fas fa-trash-alt"></i></button>
                </div>
            </div>
            @empty
            <div class="menu-admin-item">
                <img src="{{ asset('images/logo.jpeg') }}" class="menu-admin-img" alt="Placeholder">
                <div class="menu-admin-info">
                    <h3 class="menu-admin-name">MENU 1</h3>
                    <span class="menu-admin-price">Rp. 1.000</span>
                </div>
                <div class="menu-item-actions">
                    <button class="action-btn btn-edit"><i class="fas fa-pen"></i></button>
                    <button class="action-btn btn-delete"><i class="fas fa-trash-alt"></i></button>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
