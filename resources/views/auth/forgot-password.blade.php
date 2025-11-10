<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - Berita Acara</title>
    <link rel="icon" type="image/png" href="{{ asset('storage/images/mgdt.png') }}">
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/a2e0e6ad74.js" crossorigin="anonymous"></script>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #6366f1;
            --primary-glow: #818cf8;
            --secondary: #f59e0b;
            --bg-start: #0f0f23;
            --bg-end: #1a1a2e;
            --card-bg: rgba(255, 255, 255, 0.08);
            --text: #e2e8f0;
            --text-light: #94a3b8;
            --border: rgba(255, 255, 255, 0.15);
            --success: #10b981;
            --error: #ef4444;
            --transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.1);
            --glow: 0 0 20px rgba(99, 102, 241, 0.4);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            height: 100%;
            overflow: hidden;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, var(--bg-start) 0%, var(--bg-end) 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            color: var(--text);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
        }

        /* Animated Background */
        .bg-gradient {
            position: fixed;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: conic-gradient(from 0deg at 50% 50%,
                    #6366f1, #8b5cf6, #ec4899, #f59e0b, #10b981, #06b6d4, #6366f1);
            animation: rotate 20s linear infinite;
            opacity: 0.15;
            z-index: -2;
        }

        @keyframes rotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .bg-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at center, transparent 0%, var(--bg-end) 70%);
            z-index: -1;
        }

        .orb {
            position: fixed;
            border-radius: 50%;
            background: radial-gradient(circle at 30% 30%, rgba(99, 102, 241, 0.3), transparent);
            filter: blur(40px);
            animation: floatOrb 12s infinite ease-in-out;
        }

        .orb:nth-child(1) { width: 300px; height: 300px; top: 10%; left: 10%; animation-delay: 0s; }
        .orb:nth-child(2) { width: 400px; height: 400px; top: 60%; left: 70%; animation-delay: 3s; }
        .orb:nth-child(3) { width: 250px; height: 250px; top: 40%; left: 5%; animation-delay: 6s; }

        @keyframes floatOrb {
            0%, 100% { transform: translateY(0) translateX(0) scale(1); }
            50% { transform: translateY(-30px) translateX(20px) scale(1.1); }
        }

        .login-container {
            width: 100%;
            max-width: 440px;
            min-width: 320px;
            perspective: 1500px;
            z-index: 10;
            max-height: 100vh;
            overflow-y: auto;
            padding: 10px 0;
        }

        .login-container::-webkit-scrollbar {
            width: 0;
            background: transparent;
        }

        .login-card {
            background: var(--card-bg);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-radius: 24px;
            border: 1px solid var(--border);
            padding: 44px 36px;
            box-shadow: var(--glow), 0 20px 40px rgba(0, 0, 0, 0.3);
            animation: cardEnter 1s ease-out forwards;
            opacity: 0;
            transform: translateY(30px) scale(0.95);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        @keyframes cardEnter {
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1), transparent);
            opacity: 0;
            transition: opacity 0.4s;
            pointer-events: none;
        }

        .login-card:hover::before { opacity: 1; }

        /* LOGO - KOTAK PANJANG */
        .brand-logo {
            text-align: center;
            margin-bottom: 32px;
        }

        .logo-container {
            width: 140px;
            height: 110px;
            margin: 0 auto 16px;
            background: linear-gradient(135deg, var(--primary), #8b5cf6);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: var(--glow), 0 0 0 8px rgba(99, 102, 241, 0.2);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
            padding: 8px;
        }

        .logo-img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            border-radius: 12px;
            transition: transform 0.4s ease;
            z-index: 2;
            background: white;
            padding: 4px;
        }

        .logo-container:hover .logo-img {
            transform: scale(1.06);
        }

        .logo-container::before {
            content: 'BA';
            position: absolute;
            font-weight: 800;
            font-size: 36px;
            color: white;
            z-index: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
            border-radius: 12px;
            background: rgba(99, 102, 241, 0.9);
        }

        .logo-img[src=""],
        .logo-img:not([src]) { opacity: 0; }

        .login-card h3 {
            text-align: center;
            font-weight: 700;
            font-size: 1.75rem;
            background: linear-gradient(90deg, #e0e7ff, #c7d2fe);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 12px;
        }

        .login-card p.subtitle {
            text-align: center;
            color: #cbd5e1;
            font-size: 0.95rem;
            margin-bottom: 28px;
        }

        .form-group {
            margin-bottom: 24px;
            position: relative;
        }

        .form-label {
            font-weight: 500;
            color: #cbd5e1;
            font-size: 0.9rem;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.08);
            border: 1.5px solid var(--border);
            border-radius: 16px;
            padding: 14px 18px;
            color: #ffffff;
            font-size: 1rem;
            transition: var(--transition);
            backdrop-filter: blur(4px);
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .form-control:focus {
            border-color: var(--primary-glow);
            box-shadow: var(--glow);
            background: rgba(255, 255, 255, 0.12);
            outline: none;
        }

        .btn-login {
            background: linear-gradient(135deg, var(--primary), #8b5cf6);
            border: none;
            border-radius: 16px;
            color: white;
            width: 100%;
            padding: 16px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: var(--transition);
            box-shadow: var(--glow);
            position: relative;
            overflow: hidden;
            cursor: pointer;
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: 0.6s;
        }

        .btn-login:hover::before { left: 100%; }
        .btn-login:hover {
            transform: translateY(-4px);
            box-shadow: 0 0 30px rgba(99, 102, 241, 0.6);
        }

        .status-message {
            padding: 14px 18px;
            border-radius: 14px;
            margin-bottom: 24px;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 10px;
            opacity: 0;
            transform: translateY(-10px);
            transition: var(--transition);
        }

        .status-success {
            background: rgba(16, 185, 129, 0.15);
            color: #86efac;
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        .status-message.status-error {
            background: rgba(239, 68, 68, 0.15);
            color: #fca5a5;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .status-message.show {
            opacity: 1;
            transform: translateY(0);
        }

        .status-message i {
            font-size: 1.1rem;
        }

        .footer-text {
            text-align: center;
            margin-top: 32px;
            font-size: 0.85rem;
            color: #94a3b8;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .login-card { padding: 36px 28px; border-radius: 20px; margin: 0 10px; }
            .logo-container { width: 120px; height: 96px; }
            .login-card h3 { font-size: 1.5rem; }
            .orb { display: none; }
        }

        @media (max-width: 480px) {
            body { padding: 15px; }
            .login-card { padding: 30px 20px; border-radius: 18px; }
            .logo-container { width: 110px; height: 88px; }
            .login-card h3 { font-size: 1.4rem; }
            .form-control { padding: 12px 16px; font-size: 0.95rem; }
            .btn-login { padding: 14px; font-size: 1rem; }
            .footer-text { font-size: 0.8rem; }
        }
    </style>
</head>

<body>
    <div class="bg-gradient"></div>
    <div class="bg-overlay"></div>
    <div class="orb"></div>
    <div class="orb"></div>
    <div class="orb"></div>

    <div class="login-container">
        <div class="login-card" id="loginCard">
            <div class="brand-logo">
                <div class="logo-container">
                    <img src="{{ asset('storage/images/mgdt.png') }}" alt="Logo Berita Acara" class="logo-img">
                </div>
            </div>

            <h3>Lupa Password</h3>
            <p class="subtitle">Masukkan email Anda untuk reset password</p>

            <!-- Session Status -->
            @if (session('status'))
                <div class="status-message status-success show">
                    <i class="fas fa-check-circle"></i>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            <!-- Error Message -->
            @if ($errors->any())
                <div class="status-message status-error show">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" id="forgotForm">
                @csrf

                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-envelope"></i> Email
                    </label>
                    <input type="email" name="email" class="form-control" placeholder="you@gmail.com" required
                        value="{{ old('email') }}" autofocus>
                </div>

                <button type="submit" class="btn-login">
                    Kirim Link Reset Password
                </button>
            </form>

            <p class="footer-text">
                <a href="{{ route('login') }}" style="color: #cbd5e1; text-decoration: none;">
                    ← Kembali ke Login
                </a>
            </p>
        </div>
    </div>

    <script>
        // 3D Tilt
        const card = document.getElementById('loginCard');
        let isTouchDevice = 'ontouchstart' in window || navigator.maxTouchPoints > 0;

        if (!isTouchDevice) {
            card.addEventListener('mousemove', (e) => {
                const rect = card.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                const centerX = rect.width / 2;
                const centerY = rect.height / 2;
                const rotateX = (y - centerY) / 10;
                const rotateY = (centerX - x) / 10;
                card.style.transform = `rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateZ(10px)`;
            });

            card.addEventListener('mouseleave', () => {
                card.style.transform = 'rotateX(0) rotateY(0) translateZ(0)';
            });
        }

        // Form submit dengan loading
        document.getElementById('forgotForm').addEventListener('submit', function(e) {
            const btn = this.querySelector('.btn-login');
            btn.disabled = true;
            btn.innerHTML = 'Mengirim...';
        });

        // Show status otomatis
        setTimeout(() => {
            document.querySelectorAll('.status-message').forEach(el => {
                if (!el.classList.contains('show')) {
                    el.classList.add('show');
                }
            });
        }, 300);
    </script>
</body>

</html>