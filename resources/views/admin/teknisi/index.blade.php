@extends('layout.index')

@section('title', 'Daftar Teknisi')

@section('content')
<div class="container mt-4">

    <!-- Alert -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-header bg-primary text-white text-center py-4">
            <h1 class="h5 fw-bold mb-1">
                <i class="fas fa-users me-2"></i> Daftar Teknisi
            </h1>
            <small class="opacity-75">Kelola akun teknisi terdaftar</small>
        </div>

        <div class="card-body p-4">

            <!-- Tombol Tambah -->
            <div class="d-flex justify-content-end mb-4">
                <a href="{{ route('admin.teknisi.create') }}"
                    class="btn btn-success d-flex align-items-center gap-2 px-4 py-2 fw-medium shadow-sm rounded-pill">
                    <i class="fas fa-user-plus"></i> Tambah Teknisi
                </a>
            </div>

            <!-- Tabel -->
            <div class="table-responsive rounded-3">
                <table class="table table-hover align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th class="text-center">No</th>
                            <th>Nama Lengkap</th>
                            <th>Email</th>
                            <th>No HP</th>
                            <th>Alamat</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($teknisi as $t)
                        <tr>
                            <td class="text-center fw-bold">{{ $loop->iteration }}</td>
                            <td>{{ $t->name }}</td>
                            <td><i class="fas fa-envelope text-success me-1"></i><small>{{ $t->email }}</small></td>
                            <td><i class="fas fa-phone text-primary me-1"></i><small>{{ $t->no_hp ?? '-' }}</small></td>
                            <td>
                                <i class="fas fa-map-marker-alt text-warning me-1"></i>
                                <small>{{ $t->alamat ? Str::limit($t->alamat, 30) : '-' }}</small>
                            </td>
                            <td class="text-center">
                                <form action="{{ route('admin.teknisi.destroy', $t->id) }}" method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus teknisi ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-dark rounded-pill d-flex align-items-center gap-1">
                                        <i class="fas fa-trash"></i> <span class="d-none d-sm-inline">Hapus</span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fas fa-users-slash fa-3x opacity-50 mb-3"></i>
                                <p>Belum ada data teknisi</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if(method_exists($teknisi, 'links'))
                <div class="mt-4 d-flex justify-content-center">
                    {{ $teknisi->links() }}
                </div>
            @endif

        </div>
    </div>
</div>
@endsection
