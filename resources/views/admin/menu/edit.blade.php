@extends('layouts.admin')

@section('page_title', 'Edit Menu')

@section('content')
<style>
    .create-menu-wrapper {
        display: flex;
        gap: 30px;
        align-items: flex-start;
        padding-top: 20px;
    }
    .photo-upload-container {
        width: 180px;
        height: 180px;
        background: var(--admin-card-bg);
        border: 2px solid var(--admin-text);
        border-radius: 25px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        flex-shrink: 0;
        box-shadow: var(--admin-shadow);
    }
    .photo-upload-container i {
        font-size: 2.5rem;
        margin-bottom: 10px;
        color: var(--admin-text);
    }
    .photo-upload-container span {
        font-weight: 800;
        font-size: 0.9rem;
        color: var(--admin-text);
    }
    
    .form-container-card {
        background: var(--admin-card-bg);
        border-radius: 25px;
        padding: 25px 35px;
        flex: 1;
        box-shadow: var(--admin-shadow);
        border: 1px solid var(--admin-border);
    }
    .form-container-card h3 {
        text-align: center;
        font-weight: 900;
        margin-bottom: 25px;
        font-size: 1.2rem;
        color: var(--admin-text);
    }
    .form-group-sm {
        margin-bottom: 15px;
    }
    .form-group-sm label {
        display: block;
        font-weight: 500;
        font-size: 0.85rem;
        margin-bottom: 5px;
        color: var(--admin-text);
        opacity: 0.8;
    }
    .form-input-sm {
        width: 100%;
        background: #e9e9e9;
        border: 1px solid #ddd;
        border-radius: 12px;
        padding: 8px 15px;
        font-size: 0.9rem;
        outline: none;
        color: #333;
    }
    [data-theme="dark"] .form-input-sm {
        background: #333;
        border-color: #444;
        color: white;
    }
    
    .form-actions-sm {
        display: flex;
        align-items: center;
        gap: 20px;
        margin-top: 20px;
    }
    .btn-simpan-sm {
        background-color: #ff0000;
        color: white;
        border: none;
        border-radius: 12px;
        padding: 8px 30px;
        font-weight: 900;
        font-size: 1.1rem;
        box-shadow: 0 4px 10px rgba(255,0,0,0.2);
    }
    .btn-batal-sm {
        background: transparent;
        border: none;
        color: var(--admin-text);
        font-weight: 800;
        font-size: 1.1rem;
        text-decoration: none;
    }
</style>

<div class="create-menu-wrapper">
    <div class="photo-upload-container" onclick="document.getElementById('imageInput').click()" style="position: relative; overflow: hidden;">
        <i class="fas fa-camera"></i>
        <span>Ubah Foto</span>
        <img id="previewImg" src="{{ $menu->image ? asset('images/' . $menu->image) : '' }}" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; {{ $menu->image ? '' : 'display: none;' }}">
    </div>

    <div class="form-container-card">
        <h3>Edit Menu</h3>
        <form action="{{ route('admin.menu.update', $menu->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group-sm" style="display: none;">
                <input type="file" name="image" id="imageInput" accept="image/*">
            </div>
            <div class="form-group-sm">
                <label>Nama</label>
                <input type="text" name="name" class="form-input-sm" value="{{ $menu->name }}" required>
            </div>
            <div class="form-group-sm">
                <label>Harga</label>
                <div style="position: relative;">
                    <span style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); font-weight: 800; color: var(--admin-text); opacity: 0.6;">Rp</span>
                    <input type="text" id="price_display" class="form-input-sm" style="padding-left: 45px;" value="{{ number_format($menu->price_numeric, 0, ',', '.') }}" required>
                    <input type="hidden" name="price" id="price_real" value="{{ $menu->price_numeric }}">
                </div>
            </div>
            <div class="form-actions-sm">
                <button type="submit" class="btn-simpan-sm">Update</button>
                <a href="{{ route('admin.menu') }}" class="btn-batal-sm">Batal</a>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('imageInput').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('previewImg');
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(file);
        }
    });

    const priceDisplay = document.getElementById('price_display');
    const priceReal = document.getElementById('price_real');

    priceDisplay.addEventListener('input', function(e) {
        // Remove non-digits
        let value = this.value.replace(/[^0-9]/g, '');
        
        // Save raw value
        priceReal.value = value;
        
        // Format with dots
        if (value) {
            this.value = parseInt(value).toLocaleString('id-ID');
        } else {
            this.value = '';
        }
    });
</script>
@endsection
