<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Warung Cilok Mak Pik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="{{ asset('css/admin/login.css') }}" rel="stylesheet">
</head>
<body>

    <div class="login-wrapper">
        <div class="login-left">
            <div class="brand-logo-top">
                <img src="{{ asset('images/logo.jpeg') }}" alt="Logo">
                <div class="brand-name-top">
                    WARUNG CILOK PEDAS<br>MAK PIK
                </div>
            </div>
            <div class="illustration-circle">
                <!-- Using logo as fallback illustration if specific cartoon image is missing -->
                <img src="{{ asset('images/logo.jpeg') }}" alt="Illustration">
            </div>
        </div>
        
        <div class="login-right">
            <h1 class="login-title">LOGIN</h1>
            <h2 class="login-subtitle">SANTAI DULU, PANTAU CILOK MAK PIK HARI INI!</h2>
            <p class="login-desc">
                Cek pesanan masuk, atau update menu pedas baru. Semuanya beres dalam hitungan detik.
            </p>

            <form action="{{ route('admin.login.submit') }}" method="POST">
                @csrf
                <div class="form-input-container">
                    <i class="fas fa-user-circle"></i>
                    <input type="text" name="username" class="login-input" placeholder="masukan username" required>
                </div>
                
                <div class="form-input-container">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" class="login-input" placeholder="masukan password" required>
                </div>

                <label class="remember-me">
                    <input type="checkbox" name="remember">
                    <span class="custom-checkbox"></span>
                    Ingat saya
                </label>

                @if(session('error'))
                    <div class="alert-error">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ session('error') }}
                    </div>
                @endif

                <button type="submit" class="btn-login-submit">LOGIN</button>
            </form>
        </div>
    </div>

</body>
</html>
