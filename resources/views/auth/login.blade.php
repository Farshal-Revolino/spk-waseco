<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SISTEM PENILAIAN KARYAWAN PT.WASECO TIRTA</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            background: url('{{ asset('img/waseco.png') }}') center center/cover no-repeat fixed;
        }

        .background-layer {
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: 0;
        }

        .background-layer::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg,
                    rgba(255, 255, 255, 0.25),
                    rgba(26, 86, 160, 0.25),
                    rgba(30, 107, 191, 0.25));
        }

        /* Floating Shapes */
        .floating-shapes {
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: 1;
        }

        .shape {
            position: absolute;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            animation: float 20s infinite ease-in-out;
        }

        .shape1 {
            width: 250px;
            height: 250px;
            top: -80px;
            left: -80px;
        }

        .shape2 {
            width: 180px;
            height: 180px;
            bottom: -50px;
            right: -50px;
        }

        .shape3 {
            width: 120px;
            height: 120px;
            top: 50%;
            left: 10%;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(180deg);
            }
        }

        .login-container {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 400px;
            padding: 15px;
        }

        /* Compact Glass Card */
        .login-card {
            background: rgba(0, 0, 0, 0.35);
            backdrop-filter: blur(15px);
            border-radius: 20px;
            padding: 35px 30px;
            border: 1px solid rgba(255, 255, 255, 0.15);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
            animation: slideUp 0.6s ease;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Logo */
        .logo-area {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #1a56a0, #00aaff);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            font-size: 2rem;
            color: white;
        }

        .logo-area h3 {
            color: white;
            font-size: 1.3rem;
            margin-bottom: 4px;
        }

        .logo-area p {
            color: #cbd5e1;
            font-size: 0.85rem;
            margin: 0;
        }

        /* Form */
        .form-label {
            font-size: 0.85rem;
            color: #e2e8f0;
            margin-bottom: 6px;
        }

        .input-wrapper {
            position: relative;
            margin-bottom: 15px;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.25);
            color: #fff;
            border-radius: 10px;
            padding: 10px 14px 10px 40px;
            font-size: 0.9rem;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: #00c6ff;
            box-shadow: 0 0 10px rgba(0, 198, 255, 0.5);
            outline: none;
        }

        .password-toggle {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #94a3b8;
        }

        .btn-login {
            width: 100%;
            padding: 11px;
            background: linear-gradient(135deg, #1a56a0, #2d7dd2);
            border: none;
            border-radius: 10px;
            color: white;
            font-weight: 600;
            font-size: 0.9rem;
            margin-top: 10px;
        }

        .btn-login:hover {
            transform: translateY(-2px);
        }

        .login-footer {
            text-align: center;
            margin-top: 18px;
            font-size: 0.8rem;
            color: #cbd5e1;
        }

        @media (max-width: 480px) {
            .login-card {
                padding: 30px 22px;
            }
        }
    </style>
</head>

<body>

    <div class="background-layer"></div>

    <div class="floating-shapes">
        <div class="shape shape1"></div>
        <div class="shape shape2"></div>
        <div class="shape shape3"></div>
    </div>

    <div class="login-container">
        <div class="login-card">

            <div class="logo-area">
                <div class="logo-icon">
                    <i class="bi bi-droplet-fill"></i>
                </div>
                <h3>PT. WASECO TIRTA</h3>
                <p>Sistem Penilaian Karyawan Terbaik</p>
            </div>

            @if($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <label class="form-label">Email</label>
                <div class="input-wrapper">
                    <input type="email" class="form-control" name="email" placeholder="Masukkan email Anda" required>
                    <i class="bi bi-envelope-fill input-icon"></i>
                </div>

                <label class="form-label">Password</label>
                <div class="input-wrapper">
                    <input type="password" class="form-control" id="password" name="password"
                        placeholder="Masukkan password Anda" required>
                    <i class="bi bi-lock-fill input-icon"></i>
                    <button type="button" class="password-toggle" onclick="togglePassword()">
                        <i class="bi bi-eye-fill" id="toggleIcon"></i>
                    </button>
                </div>

                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" name="remember">
                    <label class="form-check-label text-light">
                        Ingat saya
                    </label>
                </div>

                <button type="submit" class="btn btn-login">
                    <i class="bi bi-box-arrow-in-right"></i> MASUK
                </button>
            </form>

            <div class="login-footer">
                <i class="bi bi-shield-check-fill"></i>
                Sistem Aman & Terenkripsi
            </div>

        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.replace('bi-eye-fill', 'bi-eye-slash-fill');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.replace('bi-eye-slash-fill', 'bi-eye-fill');
            }
        }
    </script>

</body>

</html>