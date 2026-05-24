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
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            background: url('{{ asset('img/waseco.png') }}') center center / cover no-repeat fixed;
            position: relative;
            overflow-x: hidden;
        }

        body::before {
            content: "";
            position: fixed;
            inset: 0;
            background:
                linear-gradient(135deg, rgba(5, 26, 58, 0.78), rgba(13, 110, 253, 0.45)),
                rgba(0, 0, 0, 0.35);
            z-index: 0;
        }

        body::after {
            content: "";
            position: fixed;
            inset: 0;
            background:
                radial-gradient(circle at 15% 20%, rgba(255, 255, 255, 0.14), transparent 28%),
                radial-gradient(circle at 85% 80%, rgba(13, 110, 253, 0.22), transparent 30%);
            z-index: 1;
            pointer-events: none;
        }

        .login-page {
            position: relative;
            z-index: 2;
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 30px;
        }

        .login-wrapper {
            width: 100%;
            max-width: 1120px;
            margin: 0 auto;
        }

        .brand-panel {
            color: #fff;
            padding: 35px;
        }

        .brand-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.16);
            border: 1px solid rgba(255, 255, 255, 0.22);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            margin-bottom: 24px;
            font-size: 14px;
            font-weight: 600;
        }

        .brand-title {
            font-size: 42px;
            font-weight: 900;
            line-height: 1.15;
            margin-bottom: 16px;
            letter-spacing: -0.8px;
        }

        .brand-description {
            font-size: 16px;
            line-height: 1.7;
            color: rgba(255, 255, 255, 0.86);
            max-width: 560px;
            margin-bottom: 28px;
        }

        .feature-list {
            display: grid;
            gap: 14px;
            max-width: 520px;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 16px;
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.16);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        .feature-icon {
            width: 38px;
            height: 38px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.18);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }

        .feature-text {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.92);
            margin: 0;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            border-radius: 28px;
            padding: 34px;
            border: 1px solid rgba(255, 255, 255, 0.55);
            box-shadow: 0 25px 70px rgba(0, 0, 0, 0.28);
            animation: fadeUp .55s ease;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(24px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .logo-area {
            text-align: center;
            margin-bottom: 28px;
        }

        .logo-icon {
            width: 78px;
            height: 78px;
            background: linear-gradient(135deg, #0d6efd, #4dabf7);
            border-radius: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
            font-size: 38px;
            color: #fff;
            box-shadow: 0 12px 28px rgba(13, 110, 253, 0.32);
        }

        .logo-area h3 {
            color: #152238;
            font-size: 22px;
            font-weight: 900;
            margin-bottom: 6px;
        }

        .logo-area p {
            color: #6c757d;
            font-size: 14px;
            margin: 0;
        }

        .form-label {
            font-size: 14px;
            color: #343a40;
            margin-bottom: 8px;
            font-weight: 700;
        }

        .input-wrapper {
            position: relative;
            margin-bottom: 18px;
        }

        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #0d6efd;
            font-size: 17px;
        }

        .form-control {
            background: #f8f9fb;
            border: 1px solid #e5e7eb;
            color: #212529;
            border-radius: 14px;
            padding: 13px 45px;
            font-size: 14px;
            font-weight: 500;
        }

        .form-control::placeholder {
            color: #9ca3af;
        }

        .form-control:focus {
            background: #fff;
            border-color: #0d6efd;
            box-shadow: 0 0 0 .20rem rgba(13, 110, 253, .14);
            outline: none;
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #6c757d;
            font-size: 17px;
        }

        .password-toggle:hover {
            color: #0d6efd;
        }

        .form-check-label {
            color: #495057;
            font-size: 14px;
            font-weight: 500;
        }

        .form-check-input {
            border-radius: 5px;
        }

        .btn-login {
            width: 100%;
            padding: 13px;
            background: linear-gradient(135deg, #0d6efd, #0b5ed7);
            border: none;
            border-radius: 14px;
            color: white;
            font-weight: 800;
            font-size: 15px;
            margin-top: 12px;
            box-shadow: 0 12px 26px rgba(13, 110, 253, 0.28);
            transition: .25s ease;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 16px 32px rgba(13, 110, 253, 0.34);
            color: #fff;
        }

        .login-footer {
            text-align: center;
            margin-top: 22px;
            font-size: 13px;
            color: #6c757d;
            font-weight: 600;
        }

        .alert {
            border: none;
            border-radius: 14px;
            font-size: 14px;
            padding: 12px 14px;
        }

        .copyright {
            text-align: center;
            color: rgba(255, 255, 255, 0.72);
            font-size: 12px;
            margin-top: 22px;
        }

        @media (max-width: 991px) {
            .login-page {
                padding: 20px;
            }

            .brand-panel {
                text-align: center;
                padding: 20px 10px 30px;
            }

            .brand-title {
                font-size: 30px;
            }

            .brand-description {
                margin-left: auto;
                margin-right: auto;
            }

            .feature-list {
                display: none;
            }

            .login-card {
                padding: 28px 24px;
            }
        }

        @media (max-width: 480px) {
            .login-page {
                padding: 16px;
            }

            .brand-title {
                font-size: 25px;
            }

            .login-card {
                border-radius: 22px;
                padding: 26px 20px;
            }

            .logo-icon {
                width: 68px;
                height: 68px;
                font-size: 32px;
                border-radius: 20px;
            }
        }
    </style>
</head>

<body>

    <div class="login-page">
        <div class="login-wrapper">
            <div class="row align-items-center g-4">

                <div class="col-lg-7">
                    <div class="brand-panel">
                        <div class="brand-badge">
                            <i class="bi bi-shield-check"></i>
                            Sistem Pendukung Keputusan
                        </div>

                        <h1 class="brand-title">
                            Sistem Penilaian Karyawan PT Waseco Tirta
                        </h1>

                        <p class="brand-description">
                            Aplikasi berbasis website untuk membantu proses penilaian karyawan terbaik
                            menggunakan metode Profile Matching secara lebih cepat, terstruktur, dan objektif.
                        </p>

                        <div class="feature-list">
                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="bi bi-bar-chart-line-fill"></i>
                                </div>
                                <p class="feature-text">
                                    Perhitungan otomatis berdasarkan GAP, Core Factor, dan Secondary Factor.
                                </p>
                            </div>

                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="bi bi-trophy-fill"></i>
                                </div>
                                <p class="feature-text">
                                    Menampilkan ranking karyawan terbaik berdasarkan nilai akhir.
                                </p>
                            </div>

                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="bi bi-file-earmark-pdf-fill"></i>
                                </div>
                                <p class="feature-text">
                                    Mendukung pembuatan laporan hasil penilaian secara praktis.
                                </p>
                            </div>
                        </div>

                        <div class="copyright">
                            © {{ date('Y') }} PT Waseco Tirta. All rights reserved.
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="login-card">

                        <div class="logo-area">
                            <div class="logo-icon">
                                <i class="bi bi-droplet-fill"></i>
                            </div>

                            <h3>Masuk Sistem</h3>
                            <p>Gunakan akun yang telah terdaftar</p>
                        </div>

                        @if($errors->any())
                            <div class="alert alert-danger">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                {{ $errors->first() }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <label class="form-label">Email</label>
                            <div class="input-wrapper">
                                <i class="bi bi-envelope-fill input-icon"></i>
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}"
                                    placeholder="Masukkan email Anda" required autofocus>
                            </div>

                            <label class="form-label">Password</label>
                            <div class="input-wrapper">
                                <i class="bi bi-lock-fill input-icon"></i>
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="Masukkan password Anda" required>

                                <button type="button" class="password-toggle" onclick="togglePassword()">
                                    <i class="bi bi-eye-fill" id="toggleIcon"></i>
                                </button>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                    <label class="form-check-label" for="remember">
                                        Ingat saya
                                    </label>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-login">
                                <i class="bi bi-box-arrow-in-right me-1"></i>
                                MASUK
                            </button>
                        </form>

                        <div class="login-footer">
                            <i class="bi bi-lock-fill me-1"></i>
                            Akses sistem hanya untuk pengguna berwenang
                        </div>

                    </div>
                </div>

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