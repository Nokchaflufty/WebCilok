<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Warung Cilok Mak Pik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Poppins', sans-serif;
            overflow: hidden;
        }
        .login-wrapper {
            display: flex;
            height: 100vh;
        }
        .login-left {
            flex: 0 0 40%;
            background-color: #ff0000; /* Bright red from design */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
            padding: 40px;
        }
        .login-right {
            flex: 1;
            background-color: #ffcc00; /* Vibrant yellow from design */
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 0 10%;
        }
        .brand-logo-top {
            position: absolute;
            top: 20px;
            left: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .brand-logo-top img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
        }
        .brand-name-top {
            color: #8c1e24;
            font-weight: 900;
            font-size: 1rem;
            line-height: 1;
        }
        .illustration-circle {
            width: 450px;
            height: 450px;
            background-color: #e67e22; /* Inner circle orange */
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            border: 15px solid #8c1e24; /* Dark red border */
        }
        .illustration-circle img {
            width: 100%;
            height: auto;
            transform: scale(1.1);
        }
        .login-title {
            font-size: 4rem;
            font-weight: 900;
            color: white;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        .login-subtitle {
            font-size: 1.8rem;
            font-weight: 800;
            color: white;
            margin-bottom: 15px;
            text-transform: uppercase;
        }
        .login-desc {
            font-size: 1.2rem;
            color: white;
            margin-bottom: 40px;
            max-width: 500px;
            font-weight: 400;
            line-height: 1.4;
        }
        .form-input-container {
            position: relative;
            margin-bottom: 25px;
            max-width: 450px;
        }
        .form-input-container i {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #ccc;
            font-size: 1.2rem;
        }
        .login-input {
            width: 100%;
            background-color: #ffeaa7; /* Pale yellow */
            border: none;
            border-radius: 12px;
            padding: 15px 15px 15px 55px;
            font-size: 1rem;
            color: #333;
            outline: none;
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.05);
        }
        .login-input::placeholder {
            color: #bbb;
        }
        .remember-me {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 30px;
            color: #333;
            font-weight: 500;
        }
        .btn-login-submit {
            background-color: #a4232a;
            color: white;
            border: none;
            border-radius: 15px;
            padding: 15px;
            font-size: 2.2rem;
            font-weight: 900;
            width: 100%;
            max-width: 450px;
            text-transform: uppercase;
            box-shadow: 0 6px 15px rgba(0,0,0,0.2);
            transition: transform 0.2s, background-color 0.2s;
        }
        .btn-login-submit:hover {
            background-color: #8c1e24;
            transform: translateY(-3px);
            color: white;
        }

        @media (max-width: 1200px) {
            .illustration-circle { width: 350px; height: 350px; }
            .login-title { font-size: 3rem; }
        }
        @media (max-width: 992px) {
            .login-left { display: none; }
            .login-right { padding: 0 10%; }
        }
    </style>
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

                <div class="remember-me">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Ingat saya</label>
                </div>

                <button type="submit" class="btn-login-submit">LOGIN</button>
            </form>
        </div>
    </div>

</body>
</html>
