<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard' }}</title>
    <link rel="icon" type="image/png" href="{{ asset('storage/images/mgdt.png') }}">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        :root {
            --blue: #0d6efd;
            --green: #20c997;
            --red: #dc3545;
            --white: #ffffff;
            --light: #f8f9fa;
            --dark: #212529;
            --gray: #6c757d;
            --sidebar-bg: linear-gradient(180deg, #1e3a8a, #166534);
            --glass: rgba(255, 255, 255, 0.12);
            --hover: rgba(255, 255, 255, 0.2);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to bottom right, #eef2f3, #f8f9fa);
            color: var(--dark);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* === SIDEBAR === */
        .sidebar {
            width: 260px;
            background: var(--sidebar-bg);
            color: white;
            padding: 1.5rem 0;
            backdrop-filter: blur(12px);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 8px 0 30px rgba(0, 0, 0, 0.15);
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            z-index: 1000;
            transition: all 0.3s ease;
            overflow-y: auto;
        }

        .sidebar h4 {
            text-align: center;
            font-weight: 800;
            font-size: 1.4rem;
            margin-bottom: 2rem;
            background: linear-gradient(135deg, white, #a0e7c8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 0.9rem 1.5rem;
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
            border-left: 4px solid transparent;
        }

        .nav-link i {
            width: 24px;
            font-size: 1.1rem;
            margin-right: 12px;
            text-align: center;
        }

        .nav-link:hover {
            background: var(--hover);
            color: white;
            border-left-color: var(--green);
            transform: translateX(4px);
        }

        .nav-link.active {
            background: var(--hover);
            color: white;
            border-left: 4px solid var(--green);
            font-weight: 600;
        }

        .nav-link.active::after {
            content: '';
            position: absolute;
            right: 1rem;
            width: 8px;
            height: 8px;
            background: var(--green);
            border-radius: 50%;
            box-shadow: 0 0 10px var(--green);
        }

        /* Logout Button */
        .logout-form {
            margin: 2rem 1.5rem 1rem;
        }

        .btn-logout {
            background: var(--red);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            font-size: 0.9rem;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
        }

        .btn-logout:hover {
            background: #c82333;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(220, 53, 69, 0.4);
        }

        /* === CONTENT === */
        .content {
            margin-left: 260px;
            flex: 1;
            padding: 2rem;
            transition: all 0.3s ease;
            min-height: 100vh;
        }

        /* === RESPONSIVE === */

        /* Tablet: Sidebar jadi ikon only */
        @media (max-width: 992px) {
            .sidebar {
                width: 80px;
                padding: 1rem 0;
            }

            .sidebar h4,
            .nav-link span,
            .logout-form {
                display: none;
            }

            .nav-link {
                justify-content: center;
                padding: 1rem;
            }

            .nav-link i {
                margin: 0;
                font-size: 1.3rem;
            }

            .content {
                margin-left: 80px;
                padding: 1.5rem;
            }
        }

        /* Mobile: Bottom Navbar */
        @media (max-width: 576px) {
            .sidebar {
                width: 100%;
                height: 70px;
                position: fixed;
                bottom: 0;
                top: auto;
                align-items: center;
                display: flex;
                justify-content: space-around;
                padding: 0;
                flex-direction: row;
                border-top: 1px solid rgba(255, 255, 255, 0.2);
                box-shadow: 0 -8px 30px rgba(0, 0, 0, 0.15);
            }

            .sidebar h4,
            .nav-link span,
            .btn-logout span {
                display: none !important;
            }

            .nav-link {
                padding: 0.7rem;
                border-left: none;
                border-bottom: 3px solid transparent;
                justify-content: center;
                font-size: 1.3rem;
            }

            .nav-link.active {
                border-bottom: 3px solid var(--green);
            }

            .nav-link.active::after {
                display: none;
            }

            /* Logout Button di Mobile */
            .logout-form {
                display: block !important;
                margin: 0;
                padding: 0;
                height: 100%;
                width: 20%;
            }

            .btn-logout {
                background: none !important;
                color: white !important;
                box-shadow: none !important;
                padding: 0 !important;
                border-radius: 0 !important;
                width: 100% !important;
                height: 100% !important;
                display: flex !important;
                align-items: center;
                justify-content: center;
                font-size: 1.4rem;
                transition: color 0.3s ease;
            }

            .btn-logout i {
                display: block !important;
            }

            .btn-logout:hover {
                color: var(--red) !important;
            }

            .content {
                margin-left: 0;
                padding: 1rem;
                padding-bottom: 80px;
            }
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h4 class="text-center mb-4">INSTALASI</h4>

        <div class="nav-container">
            <a href="{{ route('dashboard.index') }}"
                class="nav-link {{ request()->routeIs('dashboard.index') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('berita_acara.index') }}"
                class="nav-link {{ request()->routeIs('berita_acara.*') ? 'active' : '' }}">
                <i class="fas fa-file-alt"></i>
                <span>Data Berita Acara</span>
            </a>

            <a href="{{ route('admin.teknisi.index') }}"
                class="nav-link {{ request()->routeIs('admin.teknisi.*') ? 'active' : '' }}">
                <i class="fas fa-users-cog"></i>
                <span>Daftar Teknisi</span>
            </a>
        </div>


    </div>

    <!-- Content -->
    <div class="content">
        @yield('content')
    </div>

    <!-- Bootstrap JS (opsional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
+