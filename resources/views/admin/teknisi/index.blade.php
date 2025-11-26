@extends('layout.index')

@section('title', 'Daftar Teknisi')

@section('content')
    <div class="container mt-5">
        <!-- FAVICON -->
        <link rel="icon" type="image/png" href="{{ asset('storage/images/mgdt.png') }}">

        <!-- DROPDOWN AKUN - POJOK KANAN ATAS -->
        <div class="position-fixed top-0 end-0 p-3" style="z-index: 1050;">
            <div class="dropdown">
                <button
                    class="btn btn-outline-primary dropdown-toggle d-flex align-items-center gap-2 shadow-sm rounded-pill px-3 py-2"
                    type="button" id="dropdownAccount" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-user-circle fa-lg"></i>
                    <span class="d-none d-sm-inline fw-medium">{{ Auth::user()->name ?? 'User' }}</span>
                </button>

                <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 mt-2 rounded-3"
                    aria-labelledby="dropdownAccount">
                    <!-- Profil Admin -->
                    <li>
                        <button type="button" class="dropdown-item d-flex align-items-center gap-2 text-primary px-3 py-2"
                            data-bs-toggle="modal" data-bs-target="#profileModal">
                            <i class="fas fa-user-shield"></i> Profil Admin
                        </button>
                    </li>
                    <li><hr class="dropdown-divider mx-3"></li>
                    <!-- Logout -->
                    <li>
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit"
                                class="dropdown-item d-flex align-items-center gap-2 text-danger px-3 py-2"
                                onclick="return confirm('Yakin ingin keluar?')">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Card Utama -->
        <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
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

                <!-- Tombol Aksi: Tambah Data (Kanan) -->
                <div class="d-flex justify-content-end align-items-center mb-4">
                    <a href="{{ route('admin.teknisi.create') }}"
                        class="btn btn-success d-flex align-items-center gap-2 px-4 py-2 fw-medium shadow-sm rounded-pill">
                        <i class="fas fa-user-plus"></i>
                        Tambah Teknisi
                    </a>
                </div>

                <!-- Tabel -->
                <div class="table-responsive rounded-3">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-primary text-dark">
                            <tr>
                                <th class="text-center" style="width: 50px;">No</th>
                                <th>Nama Lengkap</th>
                                <th>Email</th>
                                <th>No HP</th>
                                <th>Alamat</th>
                                <th class="text-center" style="width: 100px;">Aksi</th>
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
                                            onsubmit="return confirm('Yakin ingin menghapus teknisi ini?')"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="btn btn-sm btn-dark d-flex align-items-center gap-1 rounded-pill"
                                                title="Hapus Teknisi">
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

        <!-- MODAL PROFIL ADMIN -->
        <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content border-0 shadow-lg rounded-3 overflow-hidden">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title fw-bold" id="profileModalLabel">
                            <i class="fas fa-user-shield me-2"></i> Profil Admin
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-5">
                        <div class="text-center mb-4">
                            <div class="initial-avatar mx-auto d-flex align-items-center justify-content-center text-white shadow-lg rounded-circle"
                                style="width: 110px; height: 110px; font-size: 3rem; font-weight: 700;">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <p class="mt-2 text-muted small">Admin Megadata</p>
                        </div>

                        <div class="bg-light rounded-3 p-4 border-start border-primary border-4">
                            <div class="row g-3">
                                <div class="col-sm-4 fw-bold text-muted">Nama</div>
                                <div class="col-sm-8 fw-medium">{{ Auth::user()->name }}</div>

                                <div class="col-sm-4 fw-bold text-muted">Email</div>
                                <div class="col-sm-8">{{ Auth::user()->email }}</div>

                                <div class="col-sm-4 fw-bold text-muted">Role</div>
                                <div class="col-sm-8">
                                    <span class="badge bg-primary px-3 py-2">Administrator</span>
                                </div>

                                <div class="col-sm-4 fw-bold text-muted">Status</div>
                                <div class="col-sm-8">
                                    <span class="badge bg-success px-3 py-2">Aktif</span>
                                </div>

                                <div class="col-sm-4 fw-bold text-muted">Bergabung</div>
                                <div class="col-sm-8">
                                    {{ \Carbon\Carbon::parse(Auth::user()->created_at)->format('d F Y') }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 justify-content-center pb-4">
                        <button type="button" class="btn btn-outline-secondary rounded-pill px-4"
                            data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i> Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Card & Header */
        .card {
            border-radius: 16px;
            overflow: hidden;
        }

        .card-header {
            background: linear-gradient(135deg, #4361ee, #3f37c9);
            border-bottom: none;
        }

        /* Tombol Standar & Rapi */
        .btn {
            border-radius: 12px;
            font-weight: 500;
            padding: 0.5rem 1rem;
            transition: all 0.2s ease;
            font-size: 0.95rem;
        }

        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .btn-sm {
            font-size: 0.8rem;
            padding: 0.35rem 0.6rem;
        }

        /* Dropdown Akun - Pojok Kanan Atas */
        .dropdown-toggle::after {
            margin-left: 0.5rem;
            font-size: 0.8rem;
        }

        .dropdown-menu {
            border-radius: 16px;
            padding: 0.5rem 0;
            min-width: 190px;
            font-size: 0.9rem;
            border: 1px solid #e9ecef;
        }

        .dropdown-item {
            padding: 0.5rem 1.2rem;
            border-radius: 10px;
            margin: 0 0.5rem;
            transition: all 0.2s ease;
        }

        .dropdown-item:hover {
            background-color: #4361ee;
            color: white !important;
        }

        .dropdown-item.text-danger:hover {
            background-color: #dc3545;
            color: white !important;
        }

        .dropdown-item i {
            width: 18px;
            text-align: center;
        }

        /* Tabel */
        .table th {
            font-weight: 600;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table tbody tr:hover {
            background-color: #f8f9fa;
        }

        /* Ikon di Tabel */
        .table i {
            font-size: 0.9rem;
        }

        /* Empty State */
        .text-center.py-5 i {
            color: #adb5bd;
        }

        /* Responsif */
        @media (max-width: 768px) {
            .btn {
                font-size: 0.875rem;
                padding: 0.5rem 0.8rem;
                width: 100%;
                justify-content: center;
            }

            .btn-sm {
                padding: 0.35rem 0.5rem;
                font-size: 0.8rem;
            }

            .table {
                font-size: 0.875rem;
            }
        }

        @media (max-width: 576px) {
            .dropdown-toggle .d-none {
                display: none !important;
            }

            .dropdown-toggle {
                padding: 0.5rem 0.75rem !important;
            }

            .table th,
            .table td {
                font-size: 0.8rem;
                padding: 0.5rem;
            }
        }

        /* Modal Profil */
        #profileModal .modal-content {
            border-radius: 16px;
        }

        .initial-avatar {
            background: linear-gradient(135deg, #4361ee, #3f37c9);
            text-transform: uppercase;
            transition: all 0.3s ease;
        }

        .initial-avatar:hover {
            transform: scale(1.08);
            box-shadow: 0 12px 30px rgba(67, 97, 238, 0.4) !important;
        }

        .border-start {
            border-left-width: 5px !important;
        }

        .badge {
            font-size: 0.85rem;
        }
    </style>
@endsection