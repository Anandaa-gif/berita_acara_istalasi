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
        /* Card & Header */
        .card-header {
            background: linear-gradient(135deg, #4361ee, #3f37c9);
        }

        /* Scroll Horizontal (PERBAIKAN UTAMA) */
        .teknisi-scroll {
            overflow-x: auto !important;
            -webkit-overflow-scrolling: touch;
        }

        .teknisi-scroll::-webkit-scrollbar {
            height: 6px;
        }

        .teknisi-scroll::-webkit-scrollbar-thumb {
            background: #c2c7d0;
            border-radius: 10px;
        }

        .teknisi-scroll::-webkit-scrollbar-track {
            background: #f1f1f1;
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

        /* Responsif */
        @media (max-width: 768px) {
            .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
@endsection
