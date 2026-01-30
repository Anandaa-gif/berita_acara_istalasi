@extends('layout.index')

@section('content')
    <div class="container mt-5">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header bg-primary text-white text-center py-4">
                <h1 class="h4 fw-bold mb-1">
                    <i class="fas fa-users me-2"></i> Daftar Pengguna
                </h1>
                <small class="opacity-75">Kelola akun Administrator & Teknisi</small>
            </div>

            <div class="card-body p-4">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
                    <form method="GET" action="{{ route('admin.teknisi.index') }}" class="d-flex align-items-center gap-3">
                        <label class="form-label mb-0 fw-bold">Filter Role:</label>
                        <select name="role" class="form-select w-auto" onchange="this.form.submit()">
                            <option value="">Semua</option>
                            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Administrator</option>
                            <option value="teknisi" {{ request('role') == 'teknisi' ? 'selected' : '' }}>Teknisi</option>
                        </select>
                    </form>

                    <button type="button" class="btn btn-success d-flex align-items-center gap-2 px-4 py-2 fw-medium shadow-sm rounded-pill" id="btnTambah">
                        <i class="fas fa-user-plus"></i> Tambah Pengguna
                    </button>
                </div>

                <div class="table-responsive rounded-3">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-primary text-dark">
                            <tr>
                                <th class="text-center" style="min-width: 60px;">No</th>
                                <th style="min-width: 180px;">Nama Lengkap</th>
                                <th style="min-width: 200px;">Email</th>
                                <th style="min-width: 140px;">No HP</th>
                                <th style="min-width: 120px;">Role</th>
                                <th style="min-width: 240px;">Alamat</th>
                                <th class="text-center" style="min-width: 140px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $u)
                                <tr>
                                    <td class="text-center fw-bold">{{ $loop->iteration }}</td>
                                    <td class="fw-medium">{{ $u->name }}</td>
                                    <td><i class="fas fa-envelope text-success me-1"></i><small class="text-muted">{{ $u->email }}</small></td>
                                    <td><i class="fas fa-phone text-primary me-1"></i><small>{{ $u->no_hp ?? '-' }}</small></td>
                                    <td>
                                        <span class="badge {{ $u->role == 'admin' ? 'bg-danger' : 'bg-info' }} text-white">
                                            {{ ucfirst($u->role) }}
                                        </span>
                                    </td>
                                    <td>
                                        <i class="fas fa-map-marker-alt text-warning me-1"></i>
                                        <small title="{{ $u->alamat ?? '' }}">{{ $u->alamat ? Str::limit($u->alamat, 30) : '-' }}</small>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-primary d-flex align-items-center gap-1 rounded-pill mb-1 mx-auto btn-edit"
                                            data-id="{{ $u->id }}"
                                            data-name="{{ $u->name }}"
                                            data-email="{{ $u->email }}"
                                            data-nohp="{{ $u->no_hp ?? '' }}"
                                            data-alamat="{{ addslashes($u->alamat ?? '') }}"
                                            data-role="{{ $u->role }}">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>

                                        @if (auth()->id() !== $u->id)
                                            <form action="{{ route('admin.teknisi.destroy', $u->id) }}" method="POST" class="d-inline"
                                                  onsubmit="return confirm('Yakin ingin menghapus pengguna ini?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-dark d-flex align-items-center gap-1 rounded-pill mx-auto">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <i class="fas fa-users-slash fa-3x mb-3 opacity-50"></i>
                                        <p class="mb-0">Belum ada data pengguna</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($users instanceof \Illuminate\Pagination\LengthAwarePaginator)
                    <div class="mt-4 d-flex justify-content-center">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>
        </div>

        <!-- MODAL (satu untuk tambah & edit) -->
        <div class="modal fade" id="modalPengguna" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header text-white" id="modalHeader">
                        <h5 class="modal-title" id="modalLabel">Edit Data Pengguna</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form id="formPengguna" method="POST">
                        @csrf
                        <input type="hidden" name="_method" id="formMethod" value="PUT">
                        <input type="hidden" name="id" id="inputId">

                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="inputName" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" id="inputEmail" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">No HP</label>
                                    <input type="text" name="no_hp" id="inputNoHp" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Role <span class="text-danger">*</span></label>
                                    <select name="role" id="inputRole" class="form-select" required>
                                        <option value="teknisi">Teknisi</option>
                                        <option value="admin">Administrator</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-bold">Alamat</label>
                                    <textarea name="alamat" id="inputAlamat" class="form-control" rows="2"></textarea>
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="border rounded p-3 bg-light">
                                <h6 class="mb-3 text-warning fw-bold">
                                    <i class="fas fa-key me-2"></i>
                                    <span id="passwordTitle">Ubah Password</span> (kosongkan jika tidak ingin mengganti)
                                </h6>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Password Baru</label>
                                        <input type="password" name="password" id="inputPassword" class="form-control" minlength="8">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Konfirmasi Password</label>
                                        <input type="password" name="password_confirmation" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn px-4" id="btnSubmit">
                                <i class="fas fa-save me-2"></i>Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            console.log('Script modal pengguna dimuat');

            // Pengecekan Bootstrap JS
            if (typeof bootstrap === 'undefined') {
                console.error('Bootstrap JS tidak terdeteksi! Pastikan bootstrap.bundle.min.js sudah di-load di layout utama.');
                alert('Error: Bootstrap JavaScript tidak ter-load. Modal tidak bisa dibuka. Cek layout anda.');
                return;
            }

            const modalEl = document.getElementById('modalPengguna');
            if (!modalEl) {
                console.error('Modal #modalPengguna tidak ditemukan');
                return;
            }

            const modal = new bootstrap.Modal(modalEl);
            const form = document.getElementById('formPengguna');
            const header = document.getElementById('modalHeader');
            const title = document.getElementById('modalLabel');
            const submitBtn = document.getElementById('btnSubmit');
            const passwordTitle = document.getElementById('passwordTitle');

            // Fungsi reset form ke mode Tambah
            function resetToAddMode() {
                form.reset();
                document.getElementById('inputId').value = '';
                document.getElementById('formMethod').value = 'POST';
                form.action = "{{ route('admin.teknisi.store') }}";

                title.textContent = 'Tambah Pengguna Baru';
                header.classList.remove('bg-primary');
                header.classList.add('bg-success');
                submitBtn.classList.remove('btn-primary');
                submitBtn.classList.add('btn-success');
                submitBtn.innerHTML = '<i class="fas fa-save me-2"></i>Simpan Pengguna Baru';

                document.getElementById('inputPassword').required = true;
                passwordTitle.textContent = 'Password (wajib diisi)';
            }

            // Fungsi isi form untuk Edit
            function fillEditForm(data) {
                document.getElementById('inputId').value = data.id;
                document.getElementById('inputName').value = data.name;
                document.getElementById('inputEmail').value = data.email;
                document.getElementById('inputNoHp').value = data.nohp;
                document.getElementById('inputAlamat').value = data.alamat;
                document.getElementById('inputRole').value = data.role;

                document.getElementById('formMethod').value = 'PUT';
                form.action = "{{ url('/admin/teknisi') }}/" + data.id;

                title.textContent = 'Edit ' + (data.role === 'admin' ? 'Administrator' : 'Teknisi');
                header.classList.remove('bg-success');
                header.classList.add('bg-primary');
                submitBtn.classList.remove('btn-success');
                submitBtn.classList.add('btn-primary');
                submitBtn.innerHTML = '<i class="fas fa-save me-2"></i>Simpan Perubahan';

                document.getElementById('inputPassword').required = false;
                passwordTitle.textContent = 'Ubah Password (kosongkan jika tidak ingin mengganti)';
            }

            // Event Tombol Tambah
            document.getElementById('btnTambah')?.addEventListener('click', () => {
                console.log('Tombol Tambah diklik');
                resetToAddMode();
                modal.show();
            });

            // Event semua tombol Edit (delegasi event karena row bisa bertambah)
            document.addEventListener('click', function(e) {
                if (e.target.closest('.btn-edit')) {
                    const btn = e.target.closest('.btn-edit');
                    console.log('Tombol Edit diklik untuk ID:', btn.dataset.id);

                    const data = {
                        id: btn.dataset.id,
                        name: btn.dataset.name,
                        email: btn.dataset.email,
                        nohp: btn.dataset.nohp,
                        alamat: btn.dataset.alamat,
                        role: btn.dataset.role
                    };

                    fillEditForm(data);
                    modal.show();
                }
            });
        });
    </script>
@endsection