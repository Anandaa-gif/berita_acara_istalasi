@extends('user.layout')

@section('title', 'Data Berita Acara')

@section('content')
    <div class="container mt-5 position-relative">

        <!-- DROPDOWN AKUN TEKNISI -->
        <div class="position-fixed top-0 end-0 p-3" style="z-index: 1050;">
            <div class="dropdown">
                <button class="btn btn-success dropdown-toggle d-flex align-items-center gap-2 shadow-sm rounded-pill px-3 py-2 text-white"
                    type="button" data-bs-toggle="dropdown">
                    <i class="fas fa-user-circle fa-lg"></i>
                    <span class="d-none d-sm-inline fw-medium">{{ Auth::user()->name ?? 'Teknisi' }}</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 mt-2 rounded-3" style="min-width: 220px;">
                    <li>
                        <button type="button" class="dropdown-item d-flex align-items-center gap-2 px-3 py-2 text-success fw-medium"
                            data-bs-toggle="modal" data-bs-target="#profileTeknisiModal">
                            <i class="fas fa-hard-hat"></i> Profil Teknisi
                        </button>
                    </li>
                    <li><hr class="dropdown-divider mx-3"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="dropdown-item d-flex align-items-center gap-2 px-3 py-2 text-danger fw-medium">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>

        <!-- CARD UTAMA -->
        <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
            <div class="card-header text-white text-center py-4"
                style="background: linear-gradient(135deg, #16a34a, #15803d);">
                <h1 class="h4 fw-bold mb-1">
                    <i class="fas fa-file-alt me-2"></i> Data Berita Acara
                </h1>
                <small class="opacity-90">Kelola data registrasi pelanggan</small>
            </div>

            <div class="card-body p-4">

                <!-- ALERT -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show rounded-3 border-0" role="alert">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show rounded-3 border-0" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- TOMBOL TAMBAH -->
                <div class="d-flex justify-content-end mb-4">
                    <a href="{{ route('user.berita_acara.create') }}"
                        class="btn btn-success d-flex align-items-center gap-2 px-4 py-2 fw-medium rounded-pill shadow-sm">
                        <i class="fas fa-plus"></i> Tambah Data
                    </a>
                </div>

                <!-- TABEL -->
                <div class="table-responsive rounded-3 overflow-hidden">
                    <table class="table table-hover align-middle mb-0">
                        <thead style="background: #dcfce7; color: #166534;">
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
                            @forelse($acaras as $acara)
                                <tr class="border-bottom">
                                    <td class="text-center fw-bold">{{ $loop->iteration }}</td>
                                    <td class="fw-medium">{{ $acara->nama_lengkap }}</td>
                                    <td>{{ $acara->no_ktp }}</td>
                                    <td><span class="badge bg-teal text-white">{{ $acara->jenis_perangkat }}</span></td>
                                    <td><span class="badge bg-success text-white">{{ $acara->paket_berlangganan }}</span></td>
                                    <td>
                                        <div class="fw-medium text-success">{{ $acara->nama_teknisi_1 }}</div>
                                        @if ($acara->nama_teknisi_2)
                                            <div class="fw-medium text-success">{{ $acara->nama_teknisi_2 }}</div>
                                        @endif
                                    </td>
                                    <td class="text-muted">
                                        {{ \Carbon\Carbon::parse($acara->tanggal_registrasi)->format('d/m/Y') }}
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-1 flex-wrap">
                                            <a href="{{ route('user.show', $acara->id) }}"
                                                class="btn btn-sm btn-primary d-flex align-items-center gap-1 rounded-pill"
                                                title="Detail">
                                                <i class="fas fa-eye"></i>
                                                <span class="d-none d-sm-inline">Detail</span>
                                            </a>
                                            <a href="{{ route('user.pdf', $acara->id) }}"
                                                class="btn btn-sm btn-danger d-flex align-items-center gap-1 rounded-pill"
                                                title="PDF">
                                                <i class="fas fa-file-pdf"></i>
                                                <span class="d-none d-sm-inline">PDF</span>
                                            </a>
                                            <!-- TOMBOL WA DIPERBAIKI -->
                                            <a href="javascript:void(0)"
                                                class="btn btn-sm btn-success d-flex align-items-center gap-1 rounded-pill"
                                                onclick="openWhatsApp({{ $acara->id }})"
                                                title="Kirim via WhatsApp">
                                                <i class="fab fa-whatsapp"></i>
                                                <span class="d-none d-sm-inline">WA</span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        <div class="bg-light rounded-3 p-3 border border-dashed border-success">
                                            <i class="fas fa-info-circle text-success me-2"></i>
                                            <small class="text-success fw-medium">
                                                Belum ada data. Tambahkan data baru.
                                            </small>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- PAGINATION -->
                @if (method_exists($acaras, 'links'))
                    <div class="mt-4 d-flex justify-content-center">
                        {{ $acaras->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            </div>
        </div>

        <!-- MODAL PROFIL TEKNISI -->
        <div class="modal fade" id="profileTeknisiModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content border-0 shadow-lg rounded-3 overflow-hidden">
                    <div class="modal-header text-white" style="background: linear-gradient(135deg, #16a34a, #15803d);">
                        <h5 class="modal-title fw-bold d-flex align-items-center gap-2">
                            <i class="fas fa-hard-hat"></i> Profil Teknisi
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-5" style="background: linear-gradient(to bottom, #f0fdf4, #dcfce7);">
                        <div class="text-center mb-5">
                            <div class="initial-avatar mx-auto d-flex align-items-center justify-content-center text-white rounded-circle shadow-lg"
                                style="width: 120px; height: 120px; font-size: 3.5rem; font-weight: 800; background: linear-gradient(135deg, #16a34a, #15803d);">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <p class="mt-3 text-success fw-bold fs-5">Teknisi Lapangan</p>
                        </div>
                        <div class="bg-white rounded-3 p-4 shadow-sm border-start border-5" style="border-color: #16a34a !important;">
                            <div class="row g-3">
                                <div class="col-sm-4 fw-bold text-success">Nama</div>
                                <div class="col-sm-8 fw-medium">{{ Auth::user()->name }}</div>
                                <div class="col-sm-4 fw-bold text-success">Email</div>
                                <div class="col-sm-8">{{ Auth::user()->email }}</div>
                                <div class="col-sm-4 fw-bold text-success">Role</div>
                                <div class="col-sm-8"><span class="badge bg-success text-white px-3 py-2 fw-bold">TEKNISI</span></div>
                                <div class="col-sm-4 fw-bold text-success">Status</div>
                                <div class="col-sm-8"><span class="badge bg-emerald text-white px-3 py-2 fw-bold">AKTIF</span></div>
                                <div class="col-sm-4 fw-bold text-success">Bergabung</div>
                                <div class="col-sm-8">{{ \Carbon\Carbon::parse(Auth::user()->created_at)->format('d F Y') }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 justify-content-center pb-4 bg-light">
                        <button type="button" class="btn btn-success rounded-pill px-5 py-2 fw-medium" data-bs-dismiss="modal">
                            <i class="fas fa-check me-2"></i> OK
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JAVASCRIPT WHATSAPP -->
    <script>
    function openWhatsApp(id) {
        fetch(`/user/berita-acara/${id}/send-whatsapp`)
            .then(response => {
                if (!response.ok) throw new Error('Gagal terhubung ke server');
                return response.json();
            })
            .then(data => {
                window.open(data.wa_url, '_blank');
            })
            .catch(err => {
                alert('Gagal membuka WhatsApp: ' + err.message);
                console.error(err);
            });
    }
    </script>

    <!-- CSS -->
    <style>
        :root { --teknisi-green: #16a34a; --teknisi-dark: #15803d; --teknisi-light: #f0fdf4; }
        .card { border-radius: 18px; overflow: hidden; }
        .btn { border-radius: 12px; font-weight: 600; transition: all .25s ease; }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(22, 163, 74, 0.3); }
        .dropdown-toggle { background: var(--teknisi-green) !important; border: none; }
        .dropdown-menu { border-radius: 16px; padding: .75rem 0; }
        .dropdown-item { border-radius: 10px; margin: 0 .5rem; font-weight: 500; }
        .dropdown-item:hover { background: var(--teknisi-green); color: white !important; }
        .dropdown-item.text-danger:hover { background: #dc3545; }
        .initial-avatar { background: linear-gradient(135deg, var(--teknisi-green), var(--teknisi-dark)); transition: .3s ease; }
        .initial-avatar:hover { transform: scale(1.1); box-shadow: 0 15px 35px rgba(22, 163, 74, 0.4); }
        .badge.bg-teal { background: #0d9488 !important; }
        .badge.bg-emerald { background: #10b981 !important; }
        .table thead { background: #dcfce7; color: #166534; }
        .table tbody tr:hover { background: #f0fdf4; }
        .border-dashed { border-style: dashed !important; border-color: #16a34a !important; }
        @media (max-width: 768px) {
            .btn, .btn-sm { width: 100%; justify-content: center; font-size: .9rem; padding: .6rem; }
            .table { font-size: .85rem; }
            .dropdown-toggle .d-none { display: none !important; }
        }
    </style>
@endsection