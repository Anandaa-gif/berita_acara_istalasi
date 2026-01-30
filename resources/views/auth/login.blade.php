<!DOCTYPE html>
<html lang="id" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Berita Acara</title>
    <link rel="icon" type="image/png" href="{{ asset('storage/images/mgdt.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #3b82f6;
            --primary-dark: #2563eb;
            --primary-glow: #60a5fa;
            --card-bg: rgba(255, 255, 255, 0.92);
            --text: #1e293b;
            --text-secondary: #64748b;
            --border: #e2e8f0;
            --input-bg: #f8fafc;
            --glow: 0 0 20px rgba(59, 130, 246, 0.25);
            --error: #dc3545;
            --bg-light: url('https://img.freepik.com/free-vector/gradient-particle-wave-background_23-2150521671.jpg') center/cover no-repeat fixed;
            --bg-dark: url('https://thumbs.dreamstime.com/b/glowing-blue-lines-dots-abstract-digital-network-illustration-dark-background-futuristic-futuristic-blue-abstract-technology-410632239.jpg') center/cover no-repeat fixed;
        }

        [data-bs-theme="dark"] {
            --primary: #60a5fa;
            --primary-dark: #3b82f6;
            --primary-glow: rgba(96, 165, 250, 0.4);
            --card-bg: rgba(30, 41, 59, 0.92);
            --text: #f1f5f9;
            --text-secondary: #94a3b8;
            --border: #334155;
            --input-bg: #1e293b;
            --glow: 0 0 20px rgba(96, 165, 250, 0.35);
            --error: #ff6b6b;
        }

        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background: var(--bg-light);
            min-height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            color: var(--text);
            padding: 20px;
            transition: background 0.6s ease;
        }

        [data-bs-theme="dark"] body {
            background: var(--bg-dark);
        }

        .login-card {
            background: var(--card-bg);
            border-radius: 20px;
            border: 1px solid var(--border);
            padding: 48px 36px;
            width: 100%;
            max-width: 440px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15), var(--glow);
            text-align: center;
            backdrop-filter: blur(8px); /* efek kaca buram biar lebih premium */
            transition: all 0.4s ease;
        }

        .logo-container {
            width: 110px;
            height: 110px;
            margin: 0 auto 28px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 0 25px var(--primary-glow);
        }

        .logo-img {
            width: 82%;
            height: 82%;
            object-fit: contain;
            filter: brightness(1.1);
        }

        h3 {
            margin: 0 0 8px 0;
            font-weight: 700;
            font-size: 1.85rem;
            color: var(--primary-dark);
        }

        .subtitle {
            color: var(--text-secondary);
            margin: 0 0 36px 0;
            font-size: 0.95rem;
        }

        .form-group {
            margin-bottom: 24px;
            text-align: left;
        }

        .form-label {
            color: var(--text);
            margin-bottom: 8px;
            font-weight: 500;
            font-size: 0.95rem;
        }

        .form-control {
            background: var(--input-bg);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 14px 52px 14px 18px;
            color: var(--text);
            font-size: 1rem;
            transition: all 0.2s ease;
        }

        .form-control.is-invalid {
            border-color: var(--error);
            box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25);
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px var(--primary-glow);
            background: var(--card-bg);
        }

        .form-control::placeholder {
            color: var(--text-secondary);
        }

        .input-with-icon i {
            position: absolute;
            right: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-secondary);
            font-size: 1.25rem;
            cursor: pointer;
            transition: color 0.25s;
        }

        .input-with-icon i:hover {
            color: var(--primary);
        }

        .btn-login {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border: none;
            border-radius: 12px;
            color: white;
            padding: 15px;
            width: 100%;
            font-weight: 600;
            font-size: 1.05rem;
            margin-top: 12px;
            transition: all 0.25s ease;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 30px var(--primary-glow);
            opacity: 0.97;
        }

        .btn-login:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }

        .theme-toggle {
            position: absolute;
            top: 20px;
            right: 20px;
            background: rgba(0,0,0,0.1);
            border: none;
            font-size: 1.6rem;
            color: var(--text-secondary);
            cursor: pointer;
            border-radius: 50%;
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
            backdrop-filter: blur(10px);
        }

        .theme-toggle:hover {
            color: white;
            background: var(--primary);
            transform: scale(1.1);
        }

        .footer-text {
            margin-top: 32px;
            font-size: 0.82rem;
            color: var(--text-secondary);
        }

        @media (max-width: 480px) {
            .login-card {
                padding: 36px 24px;
            }
        }
    </style>
</head>

<body>

    <button class="theme-toggle" id="themeToggle" title="Ganti tema">
        <i class="fas fa-moon"></i>
    </button>

    <div class="login-card">
        <div class="logo-container">
            <img src="{{ asset('storage/images/mgdt.png') }}" alt="Logo" class="logo-img">
        </div>

        <h3>Berita Acara</h3>
        <p class="subtitle">Sistem Instalasi Pemasangan Wifi</p>

        @if ($errors->any() || session('error'))
            <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                <strong>Gagal masuk!</strong>
                <ul class="mb-0 mt-2" style="text-align: left; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                    @if (session('error'))
                        <li>{{ session('error') }}</li>
                    @endif
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" id="loginForm">
            @csrf

            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                       placeholder="you@gmail.com" required autofocus value="{{ old('email') }}">
            </div>

            <div class="form-group">
                <label class="form-label">Password</label>
                <div class="input-with-icon position-relative">
                    <input type="password" name="password" id="password" 
                           class="form-control @error('password') is-invalid @enderror" 
                           placeholder="••••••••" required>
                    <i class="fas fa-eye" id="togglePassword"></i>
                </div>
            </div>

            <button type="submit" class="btn-login" id="btnLogin">
                <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true" id="loginSpinner"></span>
                Masuk Sekarang
            </button>
        </form>

        <p class="footer-text">© 2025 Berita Acara Instalasi • All rights reserved</p>
    </div>

    <script>
        // Toggle Password
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        if (togglePassword && passwordInput) {
            togglePassword.addEventListener('click', function () {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });
        }

        // Dark/Light Mode
        const html = document.documentElement;
        const themeToggle = document.getElementById('themeToggle');
        const icon = themeToggle.querySelector('i');

        function setTheme(theme) {
            html.setAttribute('data-bs-theme', theme);
            localStorage.setItem('theme', theme);
            icon.classList.toggle('fa-sun', theme === 'dark');
            icon.classList.toggle('fa-moon', theme === 'light');
        }

        function loadTheme() {
            let saved = localStorage.getItem('theme');
            if (!saved) {
                saved = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            }
            setTheme(saved);
        }

        themeToggle.addEventListener('click', () => {
            const current = html.getAttribute('data-bs-theme') || 'light';
            setTheme(current === 'light' ? 'dark' : 'light');
        });

        loadTheme();

        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
            if (!localStorage.getItem('theme')) {
                setTheme(e.matches ? 'dark' : 'light');
            }
        });

        // Loading spinner saat submit
        const form = document.getElementById('loginForm');
        const btnLogin = document.getElementById('btnLogin');
        const spinner = document.getElementById('loginSpinner');

        if (form && btnLogin) {
            form.addEventListener('submit', () => {
                btnLogin.disabled = true;
                spinner.classList.remove('d-none');
                btnLogin.innerHTML = '<span class="spinner-border spinner-border-sm" role="status"></span> Memproses...';
            });
        }
    </script>
</body>
</html>