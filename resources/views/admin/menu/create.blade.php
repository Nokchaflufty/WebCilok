@extends('layouts.admin')

@section('page_title', 'Tambah Menu')

@section('content')
<link href="{{ asset('css/admin/menu_create.css') }}" rel="stylesheet">

<div class="create-menu-wrapper">
    <div class="photo-upload-container" onclick="document.getElementById('imageInput').click()" style="position: relative; overflow: hidden;">
        <i class="fas fa-camera"></i>
        <span>Tambah Foto</span>
        <img id="previewImg" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; display: none;">
    </div>

    <div class="form-container-card">
        <h3>Tambah Menu</h3>
        <form action="{{ route('admin.menu.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group-sm" style="display: none;">
                <input type="file" name="image" id="imageInput" accept="image/*">
            </div>
            <div class="form-group-sm">
                <label>Nama</label>
                <input type="text" name="name" class="form-input-sm" required>
            </div>
            <div class="form-group-sm">
                <label>Deskripsi</label>
                <textarea name="description" class="form-input-sm form-textarea-sm" rows="3" placeholder="Tuliskan deskripsi menu..." required></textarea>
            </div>
            <div class="form-row-sm">
                <div class="form-group-sm">
                    <label>Harga</label>
                    <div style="position: relative;">
                        <span style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); font-weight: 800; color: var(--admin-text); opacity: 0.6;">Rp</span>
                        <input type="text" id="price_display" class="form-input-sm" style="padding-left: 45px;" placeholder="0" required>
                        <input type="hidden" name="price" id="price_real">
                    </div>
                </div>
                <div class="form-group-sm">
                    <label>Kategori</label>
                    <select name="category" class="form-input-sm" required>
                        <option value="" disabled selected>Pilih kategori</option>
                        <option value="makanan">Makanan</option>
                        <option value="minuman">Minuman</option>
                    </select>
                </div>
            </div>
            <div class="form-group-sm">
                <label>Status</label>
                <select name="status" class="form-input-sm" required>
                    <option value="" disabled selected>Pilih status</option>
                    <option value="tersedia">Tersedia</option>
                    <option value="habis">Habis</option>
                </select>
            </div>
            <div class="form-actions-sm">
                <button type="submit" class="btn-simpan-sm">Simpan</button>
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
