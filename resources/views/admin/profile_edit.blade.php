@extends('layouts.admin')

@section('page_title', 'Profile')

@section('content')
<link href="{{ asset('css/admin/profile_edit.css') }}" rel="stylesheet">

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
                    <i class="fas fa-user-edit"></i>
                    Edit Profile
                </a>
                <a href="{{ route('admin.profile') }}" class="menu-item back-btn">
                    Kembali
                </a>
            </div>
        </div>

        <!-- Right Form -->
        <div class="edit-profile-right">
            <h3>Edit Profile</h3>
            
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
