@extends('layout.index')

@section('title', 'Daftar Teknisi')

@section('content')
    <div class="container mt-5">
        <!-- FAVICON -->
        <link rel="icon" type="image/png" href="{{ asset('storage/images/mgdt.png') }}">

        <!-- Card Utama -->
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header bg-primary text-white text-center py-4">
                <h1 class="h4 fw-bold mb-1">
                    <i class="fas fa-users me-2"></i> Daftar Teknisi
                </h1>
                <small class="opacity-75">Kelola akun teknisi terdaftar</small>
            </div>

            <div class="card-body p-4">

                <!-- Alert -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Tombol Tambah Teknisi -->
                <div class="d-flex justify-content-end align-items-center mb-4">
                    <a href="{{ route('admin.teknisi.create') }}"
                        class="btn btn-success d-flex align-items-center gap-2 px-4 py-2 fw-medium shadow-sm rounded-pill">
                        <i class="fas fa-user-plus"></i>
                        Tambah Teknisi
                    </a>
                </div>

                <!-- Tabel -->
                <div class="table-responsive teknisi-scroll rounded-3">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-primary text-dark">
                            <tr>
                                <th class="text-center" style="min-width: 60px;">No</th>
                                <th style="min-width: 180px;">Nama Lengkap</th>
                                <th style="min-width: 200px;">Email</th>
                                <th style="min-width: 140px;">No HP</th>
                                <th style="min-width: 240px;">Alamat</th>
                                <th class="text-center" style="min-width: 120px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($teknisi as $t)
                                <tr>
                                    <td class="text-center fw-bold">{{ $loop->iteration }}</td>
                                    <td class="fw-medium">{{ $t->name }}</td>
                                    <td>
                                        <i class="fas fa-envelope text-success me-1"></i>
                                        <small class="text-muted">{{ $t->email }}</small>
                                    </td>
                                    <td>
                                        <i class="fas fa-phone text-primary me-1"></i>
                                        <small>{{ $t->no_hp ?? '-' }}</small>
                                    </td>
                                    <td>
                                        <i class="fas fa-map-marker-alt text-warning me-1"></i>
                                        <small title="{{ $t->alamat }}">
                                            {{ $t->alamat ? Str::limit($t->alamat, 30) : '-' }}
                                        </small>
                                    </td>
                                    <td class="text-center">
                                        <form action="{{ route('admin.teknisi.destroy', $t->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus teknisi ini?')" style="display:inline;">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                class="btn btn-sm btn-dark d-flex align-items-center gap-1 rounded-pill">
                                                <i class="fas fa-trash"></i>
                                                <span class="d-none d-sm-inline">Hapus</span>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="fas fa-users-slash fa-3x mb-3 opacity-50"></i>
                                        <p class="mb-0">Belum ada data teknisi</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if (method_exists($teknisi, 'links'))
                    <div class="mt-4 d-flex justify-content-center">
                        {{ $teknisi->links() }}
                    </div>
                @endif

            </div>
        </div>
    </div>

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
        padding-top: 0px;

        /* FIX TERPENTING */
        overflow-x: auto !important;
        -webkit-overflow-scrolling: touch !important;
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
        width: 100%;
        overflow-x: auto !important;
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
            width: 0 !important;
            padding: 0 !important;
            overflow: hidden !important;

            /* FIX UTAMA AGAR HP BISA SCROLL */
            position: static !important;
            height: auto !important;
        }

        .content {
            margin-left: 0 !important;
            width: 100% !important;
            overflow-x: auto !important;
        }

        body {
            overflow-x: auto !important;
        }
    }

    /* PROFIL MENU */
    .profile-menu-item {
        color: #212529 !important;
        background-color: transparent !important;
        transition: all 0.25s ease;
        border-radius: 0.375rem;
        margin: 4px 0px;
    }

    .profile-menu-item:hover,
    .profile-menu-item:focus,
    .profile-menu-item:active {
        background-color: var(--primary) !important;
        color: white !important;
    }

    /* LOGOUT */
    .logout-item {
        color: #dc3545 !important;
        font-weight: 500;
        border-radius: 0.375rem;
        margin: 4px 0px;
        transition: all 0.25s ease;
        background-color: transparent !important;
    }

    .logout-item i {
        color: #dc3545 !important;
    }

    .logout-item:hover {
        background-color: #dc3545 !important;
        color: #ffffff !important;
    }

    .logout-item:hover i {
        color: #ffffff !important;
    }
</style>

@endsection
