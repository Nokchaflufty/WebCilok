@extends('layouts.admin')

@section('page_title', 'Profile')

@section('content')
<style>
    .edit-profile-row {
        display: flex;
        gap: 30px;
        align-items: flex-start;
        padding-top: 10px;
    }
    
    /* Left Sidebar Styling */
    .edit-profile-left {
        width: 300px;
        background: var(--admin-card-bg);
        border-radius: 40px;
        padding: 40px 20px;
        box-shadow: var(--admin-shadow);
        display: flex;
        flex-direction: column;
        align-items: center;
        border: 1px solid var(--admin-border);
    }
    .avatar-wrapper {
        position: relative;
        margin-bottom: 40px;
    }
    .avatar-circle {
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
        box-shadow: 0 10px 20px rgba(211, 47, 47, 0.3);
        overflow: hidden;
    }
    .edit-icon-overlay {
        position: absolute;
        bottom: 5px;
        right: 5px;
        background: #fc0;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        color: #fff;
        font-size: 1.2rem;
        border: 4px solid var(--admin-card-bg);
        cursor: pointer;
    }
    
    .edit-menu {
        width: 100%;
        display: flex;
        flex-direction: column;
        gap: 15px;
    }
    .menu-item {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 10px 20px;
        border-radius: 10px;
        text-decoration: none;
        color: var(--admin-text);
        font-weight: 700;
        font-size: 0.95rem;
        transition: background 0.2s;
    }
    .menu-item i {
        font-size: 1.2rem;
    }
    .menu-item.active {
        background-color: #ff0000;
        color: white;
    }
    .menu-item.active i {
        color: white;
    }
    .menu-item.back-btn {
        margin-top: 10px;
        justify-content: center;
        opacity: 0.8;
    }

    /* Right Form Styling */
    .edit-profile-right {
        flex: 1;
        background: var(--admin-card-bg);
        border-radius: 40px;
        padding: 40px 50px;
        box-shadow: var(--admin-shadow);
        border: 1px solid var(--admin-border);
    }
    .edit-profile-right h3 {
        text-align: center;
        font-weight: 900;
        margin-bottom: 40px;
        font-size: 1.4rem;
        color: var(--admin-text);
    }
    .form-group-custom {
        margin-bottom: 25px;
    }
    .form-group-custom label {
        display: block;
        font-weight: 600;
        font-size: 1rem;
        margin-bottom: 10px;
        color: var(--admin-text);
        opacity: 0.7;
    }
    .form-input-custom {
        width: 100%;
        background: #e9e9e9;
        border: 1px solid #ddd;
        border-radius: 20px;
        padding: 12px 25px;
        font-size: 1.1rem;
        outline: none;
        color: #333;
    }
    [data-theme="dark"] .form-input-custom {
        background: #333;
        border-color: #444;
        color: white;
    }
    
    .form-actions {
        display: flex;
        align-items: center;
        gap: 40px;
        margin-top: 40px;
        justify-content: flex-start;
    }
    .btn-simpan {
        background-color: #ff0000;
        color: white;
        border: none;
        border-radius: 50px;
        padding: 8px 35px;
        font-weight: 800;
        font-size: 1.3rem;
        box-shadow: 0 4px 15px rgba(255,0,0,0.3);
        cursor: pointer;
    }
    .btn-batal {
        background: transparent;
        border: none;
        color: var(--admin-text);
        font-weight: 800;
        font-size: 1.3rem;
        text-decoration: none;
        cursor: pointer;
    }
</style>

<div class="edit-profile-row">
    <!-- Wrap everything in form to handle both image and text fields -->
    <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" style="display: contents;">
        @csrf
        <!-- Left Sidebar -->
        <div class="edit-profile-left">
            <div class="avatar-wrapper">
                <div class="avatar-circle" id="profile-preview" style="{{ $user->profile_image ? 'background-image: url(' . asset('uploads/profile/' . $user->profile_image) . '); background-size: cover; background-position: center;' : '' }}">
                    @if(!$user->profile_image)
                        {{ strtoupper(substr($user->username, 0, 1)) }}
                    @endif
                </div>
                <!-- Only this label triggers the file input -->
                <label for="profile_image_input" class="edit-icon-overlay">
                    <i class="fas fa-pencil"></i>
                </label>

                <input type="file" name="profile_image" id="profile_image_input" style="display: none;" onchange="previewImage(this)">
            </div>
            
            <div class="edit-menu">
                <a href="#" class="menu-item active">
                    <i class="fas fa-key"></i>
                    Password dan Username
                </a>
                <a href="{{ route('admin.profile') }}" class="menu-item back-btn">
                    Kembali
                </a>
            </div>
        </div>

        <!-- Right Form -->
        <div class="edit-profile-right">
            <h3>Password & Username</h3>
            
            @if(session('success'))
                <div style="background: rgba(76, 175, 80, 0.1); color: #2e7d32; padding: 15px 25px; border-radius: 15px; margin-bottom: 25px; border: 1px solid rgba(76, 175, 80, 0.2); font-weight: 700; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger" style="border-radius: 15px; margin-bottom: 20px;">
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="form-group-custom">
                <label>Email</label>
                <input type="email" name="email" class="form-input-custom" value="{{ old('email', $user->email) }}" required>
            </div>
            <div class="form-group-custom">
                <label>Username Baru</label>
                <input type="text" name="username" class="form-input-custom" value="{{ old('username', $user->username) }}" required>
            </div>
            <div class="form-group-custom">
                <label>Password baru</label>
                <input type="password" name="password" class="form-input-custom" style="width: 250px;">
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn-simpan">Simpan</button>
                <a href="{{ route('admin.profile') }}" class="btn-batal">Batal</a>
            </div>
        </div>
    </form>
</div>

<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('profile-preview');
            preview.style.backgroundImage = 'url(' + e.target.result + ')';
            preview.style.backgroundSize = 'cover';
            preview.style.backgroundPosition = 'center';
            preview.innerText = ''; // Clear the initial letter
        }
        reader.readAsDataURL(input.files[0]);
    }
}

</script>
@endsection
