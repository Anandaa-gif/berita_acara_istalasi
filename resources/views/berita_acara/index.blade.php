@extends('layout.index')

@section('title', 'Data Berita Acara')

@section('content')
    <div class="container mt-5">
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
                    <li>
                        <button type="button" class="dropdown-item d-flex align-items-center gap-2 text-primary px-3 py-2"
                            data-bs-toggle="modal" data-bs-target="#profileModal">
                            <i class="fas fa-user-shield"></i> Profil Admin
                        </button>
                    </li>
                    <li>
                        <hr class="dropdown-divider mx-3">
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit"
                                class="dropdown-item d-flex align-items-center gap-2 text-danger px-3 py-2">
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
                    <i class="fas fa-file-alt me-2"></i> Data Berita Acara
                </h1>
                <small class="opacity-75">Kelola data registrasi pelanggan</small>
            </div>

            <div class="card-body p-4">

                <!-- Alert -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show rounded-3" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Tombol Aksi: Export (Kiri) | Tambah Data (Kanan) -->
                <div class="d-flex justify-content-between align-items-center mb-4">

                    <!-- Kiri: Form Export Excel -->
                    <form action="{{ route('berita_acara.export.excel') }}" method="GET"
                        class="d-flex flex-column flex-md-row gap-2 align-items-center">

                        <select name="bulan" required class="form-select form-select-sm shadow-sm rounded-pill"
                            style="min-width: 130px;">
                            <option value="" hidden>Pilih Bulan</option>
                            @for ($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}">
                                    {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                                </option>
                            @endfor
                        </select>

                        <select name="tahun" required class="form-select form-select-sm shadow-sm rounded-pill"
                            style="min-width: 110px;">
                            <option value="" hidden>Pilih Tahun</option>
                            @for ($y = 2023; $y <= date('Y'); $y++)
                                <option value="{{ $y }}">{{ $y }}</option>
                            @endfor
                        </select>

                        <button type="submit"
                            class="btn btn-outline-success d-flex align-items-center gap-2 px-4 py-2 fw-medium shadow-sm rounded-pill">
                            <i class="fas fa-file-excel"></i>
                            Export Excel
                        </button>
                    </form>

                    <!-- Kanan: Tambah Data -->
                    <a href="{{ url('/berita-acara/create') }}"
                        class="btn btn-success d-flex align-items-center gap-2 px-4 py-2 fw-medium shadow-sm rounded-pill">
                        <i class="fas fa-plus"></i>
                        Tambah Data
                    </a>

                </div>

                <!-- Tabel -->
                <div class="table-responsive rounded-3">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-primary text-dark">
                            <tr>
                                <th class="text-center" style="width: 50px;">No</th>
                                <th>Nama Lengkap</th>
                                <th>No KTP</th>
                                <th>Perangkat</th>
                                <th>Paket</th>
                                <th>Teknisi</th>
                                <th>Tanggal</th>
                                <th class="text-center" style="width: 180px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($beritaAcaras as $acara)
                                <tr>
                                    <td class="text-center fw-bold">{{ $loop->iteration }}</td>
                                    <td>{{ $acara->nama_lengkap }}</td>
                                    <td>{{ $acara->no_ktp }}</td>
                                    <td>
                                        <span class="badge bg-info text-dark">{{ $acara->jenis_perangkat }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-success">{{ $acara->paket_berlangganan }}</span>
                                    </td>
                                    <td>
                                        <div>
                                            <div class="fw-medium">{{ $acara->nama_teknisi_1 }}</div>
                                            <div class="fw-medium">{{ $acara->nama_teknisi_2 }}</div>
                                        </div>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($acara->tanggal_registrasi)->format('d/m/Y') }}</td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-1 flex-wrap">
                                            <!-- Detail -->
                                            <a href="{{ route('berita_acara.show', $acara->id) }}"
                                                class="btn btn-sm btn-primary d-flex align-items-center gap-1 rounded-pill"
                                                title="Lihat Detail">
                                                <i class="fas fa-eye"></i> <span class="d-none d-sm-inline">Detail</span>
                                            </a>

                                            <!-- Edit -->
                                            <a href="{{ route('berita_acara.edit', $acara->id) }}"
                                                class="btn btn-sm btn-warning d-flex align-items-center gap-1 rounded-pill"
                                                title="Edit Data">
                                                <i class="fas fa-edit"></i> <span class="d-none d-sm-inline">Edit</span>
                                            </a>

                                            <!-- PDF -->
                                            <a href="{{ route('berita_acara.pdf', $acara->id) }}"
                                                class="btn btn-sm btn-danger d-flex align-items-center gap-1 rounded-pill"
                                                title="Download PDF">
                                                <i class="fas fa-file-pdf"></i> <span class="d-none d-sm-inline">PDF</span>
                                            </a>

                                            <!-- Chat (WhatsApp) -->
                                            <a href="{{ route('berita_acara.sendWhatsapp', $acara->id) }}"
                                                class="btn btn-sm btn-success text-white d-flex align-items-center gap-1 rounded-pill"
                                                title="Kirim via WhatsApp" target="_blank">
                                                <i class="fab fa-whatsapp"></i> <span
                                                    class="d-none d-sm-inline">Chat</span>
                                            </a>

                                            <!-- Hapus -->
                                            <form action="{{ route('berita_acara.destroy', $acara->id) }}" method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus data ini?')"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="btn btn-sm btn-dark d-flex align-items-center gap-1 rounded-pill"
                                                    title="Hapus Data">
                                                    <i class="fas fa-trash"></i> <span
                                                        class="d-none d-sm-inline">Hapus</span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5 text-muted">
                                        <i class="fas fa-folder-open fa-3x mb-3 opacity-50"></i>
                                        <p class="mb-0">Belum ada data berita acara</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if (method_exists($beritaAcaras, 'links'))
                    <div class="mt-4 d-flex justify-content-center">
                        {{ $beritaAcaras->links() }}
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

    <!-- Auto Open WhatsApp -->
    @if (session('whatsapp_url'))
        <script>
            setTimeout(() => {
                window.open('{{ session('whatsapp_url') }}', '_blank');
            }, 600);
        </script>
    @endif

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

        /* Form Export Rapi */
        .form-select-sm {
            min-width: 130px;
            font-size: 0.875rem;
            padding: 0.375rem 0.75rem;
            height: calc(1.5em + 0.75rem + 2px);
            border-radius: 12px;
            border: 1px solid #ced4da;
            transition: border-color 0.2s ease;
        }

        .form-select-sm:focus {
            border-color: #4361ee;
            box-shadow: 0 0 0 0.2rem rgba(67, 97, 238, 0.25);
        }

        /* Tabel */
        .table th {
            font-weight: 600;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge {
            font-size: 0.75rem;
            padding: 0.4em 0.8em;
        }

        .table tbody tr:hover {
            background-color: #f8f9fa;
        }

        /* Responsif */
        @media (max-width: 768px) {
            .d-flex.gap-2 {
                flex-direction: column;
            }

            .form-select-sm {
                width: 100% !important;
                min-width: auto !important;
                font-size: 0.85rem;
                padding: 0.4rem 0.6rem;
            }

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

        /* Responsif Modal */
        @media (max-width: 576px) {
            #profileModal .modal-dialog {
                margin: 1rem;
            }

            .initial-avatar {
                width: 90px !important;
                height: 90px !important;
                font-size: 2.5rem !important;
            }
        }
    </style>
@endsection
