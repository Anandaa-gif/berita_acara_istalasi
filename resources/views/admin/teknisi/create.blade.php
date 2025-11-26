@extends('layout.index')

@section('content')
<style>
    :root {
        --blue: #0d6efd;
        --green: #20c997;
        --red: #dc3545;
        --white: #ffffff;
        --light: #f8f9fa;
        --dark: #212529;
        --gray: #6c757d;
        --shadow: 0 15px 50px rgba(13, 110, 253, 0.2);
        --glass: rgba(255, 255, 255, 0.96);
        --border: #ced4da;
    }

    .form-container {
        max-width: 1000px;
        margin: 3rem auto;
        padding: 0 2rem;
    }

    .form-card {
        background: var(--glass);
        backdrop-filter: blur(18px);
        border-radius: 24px;
        border: 1px solid rgba(255, 255, 255, 0.4);
        box-shadow: var(--shadow);
        overflow: hidden;
        transition: all 0.4s ease;
    }

    .form-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 25px 60px rgba(13, 110, 253, 0.28);
    }

    .form-header {
        background: linear-gradient(135deg, var(--blue), var(--green));
        color: white;
        padding: 2.5rem 3rem;
        text-align: center;
        font-weight: 800;
        font-size: 1.8rem;
        letter-spacing: 1px;
        position: relative;
    }

    .form-header i {
        font-size: 2rem;
        margin-right: 12px;
    }

    .form-header::after {
        content: '';
        position: absolute;
        bottom: 0; left: 0; right: 0;
        height: 6px;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.6), transparent);
    }

    .form-body {
        padding: 3rem 4rem;
    }

    .form-label {
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 1.15rem;
    }

    .form-label i {
        color: var(--blue);
        font-size: 1.3rem;
    }

    .input-group {
        position: relative;
    }

    .input-group i {
        position: absolute;
        left: 22px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--blue);
        font-size: 1.4rem;
        z-index: 10;
    }

    .form-control-custom {
        border: 2.5px solid var(--border);
        border-radius: 16px;
        padding: 1.2rem 1.2rem 1.2rem 3.8rem;
        font-size: 1.1rem;
        height: 64px;
        transition: all 0.3s ease;
        background: rgba(255, 255, 255, 0.95);
        width: 100%;
        box-shadow: inset 0 2px 8px rgba(0,0,0,0.03);
        font-style: normal !important;
    }

    .form-control-custom:focus {
        border-color: var(--blue);
        box-shadow: 0 0 0 6px rgba(13, 110, 253, 0.22);
        background: white;
        outline: none;
    }

    .form-control-custom::placeholder {
        color: #adb5bd;
        font-style: normal;
        font-weight: 400;
        opacity: 0.8;
    }

    .btn-action {
        border-radius: 16px;
        padding: 1rem 2.8rem;
        font-weight: 700;
        font-size: 1.1rem;
        display: inline-flex;
        align-items: center;
        gap: 12px;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 1px;
        min-width: 180px;
        justify-content: center;
        margin: 0 0.5rem;
    }

    .btn-save {
        background: var(--green);
        color: white;
        border: none;
        box-shadow: 0 8px 25px rgba(32, 201, 151, 0.4);
    }

    .btn-save:hover {
        background: #1baa80;
        transform: translateY(-4px);
        box-shadow: 0 12px 35px rgba(32, 201, 151, 0.5);
    }

    .btn-back {
        background: var(--blue);
        color: white;
        text-decoration: none;
        box-shadow: 0 8px 25px rgba(13, 110, 253, 0.4);
    }

    .btn-back:hover {
        background: #0b5ed7;
        transform: translateY(-4px);
        box-shadow: 0 12px 35px rgba(13, 110, 253, 0.5);
        color: white;
    }

    .error-message {
        color: var(--red);
        font-size: 0.95rem;
        margin-top: 0.6rem;
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: 500;
        font-style: normal;
    }

    .error-message i {
        font-size: 1.2rem;
    }

    @media (max-width: 992px) {
        .form-container { max-width: 800px; padding: 0 1.5rem; }
        .form-body { padding: 2.5rem 3rem; }
        .form-control-custom { height: 60px; font-size: 1rem; }
    }

    @media (max-width: 768px) {
        .form-header { font-size: 1.5rem; padding: 2rem; }
        .form-body { padding: 2rem; }
        .btn-action { width: 100%; margin: 0.5rem 0; }
    }

    @media (max-width: 576px) {
        .form-container { margin: 1.5rem auto; padding: 0 1rem; }
        .form-header { font-size: 1.3rem; padding: 1.5rem; }
        .form-body { padding: 1.5rem; }
        .form-control-custom { height: 56px; font-size: 0.95rem; padding-left: 3.5rem; }
        .input-group i { left: 18px; font-size: 1.2rem; }
    }
</style>

<div class="form-container">
    <div class="form-card position-relative">
        <!-- Header -->
        <div class="form-header position-relative">
            <i class="fas fa-user-plus"></i>
            Tambah Teknisi Baru
        </div>

        <!-- Body -->
        <div class="form-body">
            <form action="{{ route('admin.teknisi.store') }}" method="POST">
                @csrf

                <!-- NAMA LENGKAP -->
                <div class="mb-5">
                    <label class="form-label">
                        <i class="fas fa-user"></i> Nama Lengkap
                    </label>
                    <div class="input-group">
                        <i class="fas fa-user"></i>
                        <input type="text" name="name" class="form-control-custom @error('name') is-invalid @enderror"
                               value="{{ old('name') }}" required placeholder="Masukkan nama lengkap teknisi">
                    </div>
                    @error('name')
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- ALAMAT -->
                <div class="mb-5">
                    <label class="form-label">
                        <i class="fas fa-map-marker-alt"></i> Alamat
                    </label>
                    <div class="input-group">
                        <i class="fas fa-map-marker-alt"></i>
                        <input type="text" name="alamat" class="form-control-custom @error('alamat') is-invalid @enderror"
                               value="{{ old('alamat') }}" required placeholder="Masukkan alamat lengkap">
                    </div>
                    @error('alamat')
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- NOMOR TELEPON -->
                <div class="mb-5">
                    <label class="form-label">
                        <i class="fas fa-phone"></i> Nomor Telepon
                    </label>
                    <div class="input-group">
                        <i class="fas fa-phone"></i>
                        <input type="text" name="no_hp" class="form-control-custom @error('no_hp') is-invalid @enderror"
                               value="{{ old('no_hp') }}" required placeholder="Contoh: 081234567890">
                    </div>
                    @error('no_hp')
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- EMAIL -->
                <div class="mb-5">
                    <label class="form-label">
                        <i class="fas fa-envelope"></i> Email (Akun Login)
                    </label>
                    <div class="input-group">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="email" class="form-control-custom @error('email') is-invalid @enderror"
                               value="{{ old('email') }}" required placeholder="contoh@perusahaan.co.id">
                    </div>
                    @error('email')
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- PASSWORD -->
                <div class="mb-5">
                    <label class="form-label">
                        <i class="fas fa-lock"></i> Password
                    </label>
                    <div class="input-group">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" class="form-control-custom @error('password') is-invalid @enderror"
                               required placeholder="Minimal 8 karakter">
                    </div>
                    @error('password')
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- KONFIRMASI PASSWORD -->
                <div class="mb-5">
                    <label class="form-label">
                        <i class="fas fa-lock"></i> Konfirmasi Password
                    </label>
                    <div class="input-group">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password_confirmation" class="form-control-custom" 
                               required placeholder="Ulangi password">
                    </div>
                </div>

                <!-- Tombol -->
                <div class="d-flex flex-column flex-sm-row justify-content-center gap-4 mt-5">
                    <button type="submit" class="btn-action btn-save">
                        <i class="fas fa-save"></i> Simpan Data
                    </button>
                    <a href="{{ route('admin.teknisi.index') }}" class="btn-action btn-back">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection