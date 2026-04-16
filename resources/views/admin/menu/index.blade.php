@extends('layouts.admin')

@section('page_title', 'Menu')

@section('content')
<link href="{{ asset('css/admin/menu.css') }}" rel="stylesheet">

<div class="menu-page-wrapper">
    <div class="welcome-section">
        <p class="welcome-text">Kelola menu makanan dan minuman</p>
    </div>

    <div class="menu-management-card">
        <div class="menu-header-actions">
            <div class="search-container">
                <i class="fas fa-search"></i>
                <input type="text" id="menuSearchInput" class="search-input" placeholder="Cari Menu" oninput="filterMenu(this.value)">
            </div>
            <a href="{{ route('admin.menu.create') }}" class="btn-tambah-menu">Tambah Menu</a>
        </div>

        <div class="menu-list">
            @forelse($menus as $menu)
            <div class="menu-admin-item">
                <img src="{{ $menu->image ? asset('images/' . $menu->image) : asset('images/logo.jpeg') }}" class="menu-admin-img" alt="Menu Image">
                <div class="menu-admin-info">
                    <h3 class="menu-admin-name">{{ $menu->name }}</h3>
                    <span class="menu-admin-price">{{ $menu->price }}</span>
                </div>
                <div class="menu-item-actions">
                    <a href="{{ route('admin.menu.edit', $menu->id) }}" class="action-btn btn-edit"><i class="fas fa-pen"></i></a>
                    <form id="delete-form-{{ $menu->id }}" action="{{ route('admin.menu.delete', $menu->id) }}" method="POST" style="display:none;">
                        @csrf
                    </form>
                    <button type="button" class="action-btn btn-delete" onclick="showConfirm('Hapus Menu', 'Yakin ingin menghapus menu ini?', () => document.getElementById('delete-form-{{ $menu->id }}').submit())">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
            </div>
            @empty
            <div style="text-align: center; padding: 40px; color: var(--admin-text); opacity: 0.5;">
                <i class="fas fa-utensils" style="font-size: 2rem; margin-bottom: 10px; display: block;"></i>
                <p style="font-weight: 600;">Belum ada menu. Klik <strong>Tambah Menu</strong> untuk mulai.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

<script>
function filterMenu(query) {
    const q = query.toLowerCase().trim();
    const items = document.querySelectorAll('.menu-admin-item');
    let found = 0;

    items.forEach(item => {
        const name = item.querySelector('.menu-admin-name').textContent.toLowerCase();
        const match = name.includes(q);
        item.style.display = match ? '' : 'none';
        if (match) found++;
    });

    // Show/hide no-result message
    let noResult = document.getElementById('no-search-result');
    if (!noResult) {
        noResult = document.createElement('div');
        noResult.id = 'no-search-result';
        noResult.style.cssText = 'text-align:center;padding:30px;color:var(--admin-text);opacity:0.5;font-weight:600;';
        noResult.innerHTML = '<i class="fas fa-search" style="font-size:1.5rem;display:block;margin-bottom:8px;"></i>Menu tidak ditemukan.';
        document.querySelector('.menu-list').appendChild(noResult);
    }
    noResult.style.display = (found === 0 && q.length > 0) ? '' : 'none';
}
</script>
@endsection
