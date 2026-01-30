<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard Admin' }}</title>
    <link rel="icon" type="image/png" href="{{ asset('storage/images/mgdt.png') }}">

    <!-- Bootstrap 5.3.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
          rel="stylesheet" 
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
          crossorigin="anonymous">

    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" 
          integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" 
          crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        :root {
            --sidebar-bg: linear-gradient(180deg, #1e3a8a, #166534);
            --hover: rgba(255, 255, 255, 0.2);
            --primary: #1e3a8a;
            --light-blue: #e3f2fd;
        }

        body {
            background: #f6f8fa;
            min-height: 100vh;
            padding-top: 0;
        }

        /* SIDEBAR */
        .sidebar {
            width: 260px;
            background: var(--sidebar-bg);
            color: white;
            padding: 1.4rem 0;
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            overflow-y: auto;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.85);
            padding: 12px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .nav-link:hover,
        .nav-link.active {
            background: var(--hover);
            color: #fff !important;
        }

        .content {
            margin-left: 260px;
            padding: 2rem;
            transition: margin-left 0.3s ease;
        }

        /* RESPONSIVE */
        @media (max-width: 992px) {
            .sidebar {
                width: 80px;
            }

            .sidebar h4,
            .sidebar .nav-link span {
                display: none;
            }

            .sidebar .nav-link {
                justify-content: center;
                padding: 15px 0;
            }

            .sidebar .nav-link i {
                font-size: 1.4rem;
            }

            .content {
                margin-left: 80px;
            }
        }

        @media (max-width: 576px) {
            .sidebar {
                width: 0;
                padding: 0;
                overflow: hidden;
            }

            .content {
                margin-left: 0 !important;
            }
        }

        /* Profil & Logout style */
        .profile-menu-item {
            color: #212529 !important;
            background-color: transparent !important;
            transition: all 0.25s ease;
            border-radius: 0.375rem;
            margin: 4px 0;
        }

        .profile-menu-item:hover,
        .profile-menu-item:focus,
        .profile-menu-item:active {
            background-color: var(--primary) !important;
            color: white !important;
        }

        .logout-item {
            color: #dc3545 !important;
            font-weight: 500;
            transition: all 0.25s ease;
            border-radius: 0.375rem;
            margin: 4px 0;
        }

        .logout-item:hover {
            background-color: #dc3545 !important;
            color: white !important;
        }

        .logout-item:hover i {
            color: white !important;
        }
    </style>
</head>

<body>

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h4 class="text-center fw-bold text-white mb-4">INSTALASI</h4>
        <a href="{{ route('dashboard.index') }}"
           class="nav-link {{ request()->routeIs('dashboard.index') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt"></i> <span>Dashboard</span>
        </a>
        <a href="{{ route('berita_acara.index') }}"
           class="nav-link {{ request()->routeIs('berita_acra.*') ? 'active' : '' }}">
            <i class="fas fa-file-alt"></i> <span>Data Berita Acara</span>
        </a>
        <a href="{{ route('admin.teknisi.index') }}"
           class="nav-link {{ request()->routeIs('admin.teknisi.*') ? 'active' : '' }}">
            <i class="fas fa-users-cog"></i> <span>Daftar Teknisi</span>
        </a>
    </div>

    <!-- TOMBOL ADMINISTRATOR (di kanan atas) -->
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 2000;">
        <button class="btn text-white shadow dropdown-toggle fw-medium" 
                style="background-color: var(--primary);"
                type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-user-shield me-2"></i> {{ Auth::user()->name ?? 'Admin' }}
        </button>

        <ul class="dropdown-menu dropdown-menu-end shadow border-0">
            <li>
                <button type="button" class="dropdown-item d-flex align-items-center gap-2 profile-menu-item"
                        data-bs-toggle="modal" data-bs-target="#profileModal">
                    <i class="fas fa-user-cog"></i> Profil & Edit
                </button>
            </li>
            <li><hr class="dropdown-divider my-1"></li>
            <li>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="dropdown-item logout-item d-flex align-items-center gap-2">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </li>
        </ul>
    </div>

    <!-- KONTEN UTAMA -->
    <div class="content">
        @yield('content')
    </div>

    <!-- MODAL PROFIL & EDIT -->
    <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content rounded-4 overflow-hidden" style="background-color: var(--light-blue);">
                <div class="modal-header text-white" style="background-color: var(--primary);">
                    <h5 class="modal-title fw-bold" id="profileModalLabel">
                        <i class="fas fa-user-cog me-2"></i> Profil & Edit Akun
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-5">
                    <div class="text-center mb-5">
                        <div class="mx-auto d-flex align-items-center justify-content-center text-white rounded-circle shadow-lg"
                             style="background-color: var(--primary); width:110px; height:110px; font-size:3.5rem;">
                            {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                        </div>
                        <h5 class="mt-3 mb-0">Admin Megadata</h5>
                    </div>

                    <div class="bg-white p-4 rounded shadow-sm mb-4">
                        <div class="row g-3">
                            <div class="col-sm-4 fw-bold text-muted">Nama</div>
                            <div class="col-sm-8">{{ Auth::user()->name ?? '-' }}</div>

                            <div class="col-sm-4 fw-bold text-muted">Email</div>
                            <div class="col-sm-8">{{ Auth::user()->email ?? '-' }}</div>

                            <div class="col-sm-4 fw-bold text-muted">Role</div>
                            <div class="col-sm-8">
                                <span class="badge bg-success px-3 py-2">Administrator</span>
                            </div>

                            <div class="col-sm-4 fw-bold text-muted">Status</div>
                            <div class="col-sm-8"><span class="badge bg-success">Aktif</span></div>

                            <div class="col-sm-4 fw-bold text-muted">Bergabung</div>
                            <div class="col-sm-8">
                                {{ Auth::user() ? \Carbon\Carbon::parse(Auth::user()->created_at)->format('d F Y') : '-' }}
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf @method('PUT')
                        <hr class="my-4">
                        <h6 class="mb-3">Edit Akun</h6>
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label">Email Baru</label>
                                <input type="email" name="email" value="{{ old('email', Auth::user()->email ?? '') }}"
                                       class="form-control" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Password Baru <small class="text-muted">(kosongkan jika tidak diganti)</small></label>
                                <input type="password" name="password" class="form-control" minlength="8">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" class="form-control">
                            </div>
                        </div>

                        <div class="d-flex gap-2 justify-content-end mt-4">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn text-white px-4" style="background-color: var(--primary);">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5.3.3 JS Bundle (harus di akhir body) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" 
            crossorigin="anonymous"></script>

    <!-- Optional: tambahkan script debug kecil -->
    <script>
        // Cek apakah Bootstrap berhasil load (buka F12 → Console)
        if (typeof bootstrap !== 'undefined') {
            console.log('Bootstrap 5.3.3 berhasil di-load ✓');
        } else {
            console.error('Bootstrap JS gagal load! Cek koneksi / CDN');
        }
    </script>

    @yield('scripts')

</body>
</html>