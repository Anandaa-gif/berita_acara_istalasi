<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Megadata - Sistem Berita Acara Instalasi</title>
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- Google Font: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #1e40af;
            --primary-light: #3b82f6;
            --success: #10b981;
            --success-light: #34d399;
            --dark: #1f2937;
            --gray: #6b7280;
            --light: #f9fafb;
            --border: #e5e7eb;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            color: var(--dark);
            line-height: 1.6;
            min-height: 100vh;
            padding: 2rem 1rem;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            position: relative;
        }

        /* TOMBOL LOGIN - POJOK KANAN ATAS */
        .login-btn {
            position: fixed;
            top: 1.5rem;
            right: 1.5rem;
            z-index: 1000;
            background: white;
            color: var(--primary);
            padding: 0.75rem 1.25rem;
            border-radius: 14px;
            font-weight: 600;
            font-size: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: 0 8px 25px rgba(30, 64, 175, 0.2);
            border: 2px solid var(--primary);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .login-btn:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(30, 64, 175, 0.3);
        }

        .login-btn i {
            font-size: 1.1rem;
        }

        @media (max-width: 768px) {
            .login-btn {
                top: 1rem;
                right: 1rem;
                padding: 0.65rem 1rem;
                font-size: 0.95rem;
            }
        }

        /* Header */
        .header {
            text-align: center;
            margin-bottom: 3.5rem;
        }

        .header h1 {
            font-size: 2.8rem;
            font-weight: 800;
            background: linear-gradient(90deg, var(--primary), var(--primary-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.75rem;
        }

        .header p {
            font-size: 1.1rem;
            color: var(--gray);
            max-width: 700px;
            margin: 0 auto;
            font-weight: 500;
        }

        /* Features Grid */
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(270px, 1fr));
            gap: 1.75rem;
            margin-bottom: 4rem;
        }

        .feature-card {
            background: white;
            border-radius: 20px;
            padding: 2.25rem;
            box-shadow: 0 12px 30px rgba(30, 64, 175, 0.1);
            border: 1px solid var(--border);
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 5px;
            background: linear-gradient(90deg, var(--primary), var(--primary-light));
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.4s ease;
        }

        .feature-card:hover::before {
            transform: scaleX(1);
        }

        .feature-card:hover {
            transform: translateY(-12px);
            box-shadow: 0 25px 50px rgba(30, 64, 175, 0.18);
        }

        /* IKON BESAR - WARNA BIRU (Default) */
        .icon-wrapper {
            width: 90px;
            height: 90px;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            border-radius: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            color: white;
            font-size: 2.2rem;
            box-shadow: 0 12px 28px rgba(30, 64, 175, 0.3);
            transition: all 0.4s ease;
        }

        /* IKON HIJAU untuk Data Pelanggan & Laporan */
        .icon-wrapper.green {
            background: linear-gradient(135deg, var(--success), var(--success-light));
            box-shadow: 0 12px 28px rgba(16, 185, 129, 0.3);
        }

        .feature-card:hover .icon-wrapper {
            transform: scale(1.1) rotate(5deg);
            box-shadow: 0 18px 38px rgba(30, 64, 175, 0.4);
        }

        .feature-card:hover .icon-wrapper.green {
            box-shadow: 0 18px 38px rgba(16, 185, 129, 0.4);
        }

        .feature-title {
            font-weight: 700;
            font-size: 1.25rem;
            color: var(--dark);
            margin-bottom: 0.75rem;
        }

        .feature-desc {
            color: var(--gray);
            font-size: 0.95rem;
            line-height: 1.65;
        }

        /* Visi & Misi */
        .vision-mission {
            margin: 5rem 0;
            padding: 3rem 0;
            position: relative;
        }

        .vision-mission::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 5px;
            background: linear-gradient(90deg, var(--primary), var(--primary-light));
            border-radius: 3px;
        }

        .section-title {
            text-align: center;
            margin-bottom: 3rem;
        }

        .section-title h2 {
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 0.75rem;
        }

        .section-title .subtitle {
            color: var(--gray);
            font-size: 1.05rem;
            max-width: 650px;
            margin: 0 auto;
            font-weight: 500;
        }

        .vm-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 2.5rem;
        }

        .vm-card {
            background: white;
            border-radius: 22px;
            padding: 2.25rem;
            box-shadow: 0 15px 35px rgba(30, 64, 175, 0.12);
            border: 1px solid var(--border);
            position: relative;
            overflow: hidden;
            transition: all 0.4s ease;
        }

        .vm-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 6px;
            background: linear-gradient(90deg, var(--primary), var(--primary-light));
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.5s ease;
        }

        .vm-card:hover::before {
            transform: scaleX(1);
        }

        .vm-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 28px 55px rgba(30, 64, 175, 0.2);
        }

        .vm-icon {
            width: 100px;
            height: 100px;
            border-radius: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2.5rem;
            margin-bottom: 1.75rem;
            box-shadow: 0 14px 32px rgba(0,0,0,0.22);
            transition: all 0.4s ease;
        }

        .vm-card:hover .vm-icon {
            transform: scale(1.12) translateY(-4px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.28);
        }

        .visi .vm-icon {
            background: linear-gradient(135deg, #1e40af, #3b82f6);
        }

        .misi .vm-icon,
        .pelanggan .icon-wrapper,
        .laporan .icon-wrapper {
            background: linear-gradient(135deg, var(--success), var(--success-light));
            box-shadow: 0 14px 32px rgba(16, 185, 129, 0.3);
        }

        .vm-card h3 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 1.25rem;
            position: relative;
        }

        .vm-card h3::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 50px;
            height: 4px;
            background: var(--primary-light);
            border-radius: 2px;
        }

        .misi h3::after {
            background: var(--success);
        }

        .vm-list {
            list-style: none;
            padding-left: 0;
            color: var(--gray);
            font-size: 0.98rem;
            line-height: 1.8;
        }

        .vm-list li {
            position: relative;
            padding-left: 2rem;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }

        .vm-list li::before {
            content: '✓';
            position: absolute;
            left: 0;
            color: var(--success);
            font-weight: bold;
            font-size: 1.2rem;
            top: -1px;
        }

        .vm-list li:hover {
            color: var(--dark);
            padding-left: 2.2rem;
        }

        /* Action Buttons */
        .actions {
            display: flex;
            gap: 1.5rem;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 2.5rem;
        }

        .btn {
            padding: 0.9rem 2rem;
            border-radius: 14px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            font-size: 1.05rem;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            min-width: 200px;
            justify-content: center;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: white;
            box-shadow: 0 6px 20px rgba(30, 64, 175, 0.35);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(30, 64, 175, 0.45);
        }

        .btn-secondary {
            background: white;
            color: var(--primary);
            border: 2.5px solid var(--primary);
            font-weight: 600;
        }

        .btn-secondary:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-3px);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .header h1 { font-size: 2.2rem; }
            .section-title h2 { font-size: 1.9rem; }
            .actions { flex-direction: column; align-items: center; }
            .btn { width: 100%; max-width: 320px; }
            .vm-grid, .features-grid { grid-template-columns: 1fr; }
            .feature-card, .vm-card { padding: 1.75rem; }
            .icon-wrapper { width: 75px; height: 75px; font-size: 1.9rem; }
            .vm-icon { width: 85px; height: 85px; font-size: 2.1rem; }
        }

        @media (max-width: 480px) {
            .header h1 { font-size: 1.9rem; }
            .btn { font-size: 1rem; padding: 0.8rem 1.5rem; }
        }
    </style>
</head>
<body>

    <!-- TOMBOL LOGIN -->
    <a href="{{ route('login') }}" class="login-btn">
        <i class="fas fa-sign-in-alt"></i> Login
    </a>

    <div class="container">

        <!-- Header -->
        <div class="header">
            <h1>Selamat Datang</h1>
            <p><strong>Sistem Berita Acara Instalasi Megadata</strong><br>
            Kelola data registrasi, teknisi, dan pelanggan dengan lebih mudah dan efisien.</p>
        </div>

        <!-- Features Grid -->
        <div class="features-grid">

            <!-- Berita Acara (BIRU) -->
            <div class="feature-card">
                <div class="icon-wrapper">
                    <i class="fas fa-file-contract"></i>
                </div>
                <div class="feature-title">Berita Acara</div>
                <div class="feature-desc">Kelola dokumen instalasi dengan sistem digital terintegrasi, tanda tangan elektronik, dan arsip otomatis.</div>
            </div>

            <!-- Manajemen Teknisi (BIRU) -->
            <div class="feature-card">
                <div class="icon-wrapper">
                    <i class="fas fa-hard-hat"></i>
                </div>
                <div class="feature-title">Manajemen Teknisi</div>
                <div class="feature-desc">Atur tim teknisi dengan mudah: jadwal, lokasi, performa, dan sertifikasi dalam satu dashboard.</div>
            </div>

            <!-- Data Pelanggan (HIJAU) -->
            <div class="feature-card pelanggan">
                <div class="icon-wrapper green">
                    <i class="fas fa-address-book"></i>
                </div>
                <div class="feature-title">Data Pelanggan</div>
                <div class="feature-desc">Kelola informasi pelanggan secara terpusat: riwayat instalasi, kontrak, dan komunikasi terintegrasi.</div>
            </div>

            <!-- Laporan (HIJAU) -->
            <div class="feature-card laporan">
                <div class="icon-wrapper green">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="feature-title">Laporan</div>
                <div class="feature-desc">Analisis data instalasi secara real-time: grafik performa, tren, dan laporan eksekutif otomatis.</div>
            </div>

        </div>

        <!-- Visi & Misi -->
        <div class="vision-mission">
            <div class="section-title">
                <h2>Visi & Misi Megadata</h2>
                <p class="subtitle">Komitmen kami untuk masa depan digital yang lebih baik</p>
            </div>

            <div class="vm-grid">

                <!-- Visi (BIRU) -->
                <div class="vm-card visi">
                    <div class="vm-icon">
                        <i class="fas fa-binoculars"></i>
                    </div>
                    <h3>Visi</h3>
                    <ul class="vm-list">
                        <li>Menjadi penyedia layanan profesional yang meningkatkan produktivitas dan efisiensi perusahaan melalui teknologi terkini dan sumber daya manusia yang berkualitas.</li>
                        <li>Menjadi penyedia layanan internet dan solusi teknologi terintegrasi yang andal.</li>
                    </ul>
                </div>

                <!-- Misi (HIJAU) -->
                <div class="vm-card misi">
                    <div class="vm-icon">
                        <i class="fas fa-compass"></i>
                    </div>
                    <h3>Misi</h3>
                    <ul class="vm-list">
                        <li>Membangun infrastruktur dan solusi digital yang andal untuk pemerintah, bisnis, dan masyarakat.</li>
                        <li>Memberikan layanan yang aman, cepat, dan dapat diandalkan.</li>
                        <li>Menerapkan integritas, kolaborasi, dan inovasi berkelanjutan dalam setiap aspek layanan.</li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
</body>
</html>