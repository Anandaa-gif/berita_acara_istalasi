<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Berita Acara</title>
    <link rel="icon" type="image/png" href="{{ asset('storage/images/mgdt.png') }}">

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a2d9b6a64b.js" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/html5-qrcode@2.3.7/minified/html5-qrcode.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.5/dist/signature_pad.umd.min.js"></script>

    <style>
        body {
            background-color: #f1f3f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .container {
            max-width: 900px;
            background: #fff;
            padding: 2rem;
            border-radius: 16px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            margin: 2rem auto;
        }

        .page-header {
            background: linear-gradient(135deg, #4361ee, #3f37c9);
            color: white;
            padding: 1.5rem;
            border-radius: 12px;
            margin: -2rem -2rem 1.5rem -2rem;
            text-align: center;
            box-shadow: 0 4px 15px rgba(67, 97, 238, 0.3);
        }

        .page-header i {
            font-size: 2.2rem;
            margin-bottom: 0.5rem;
        }

        .page-header h2 {
            font-weight: 700;
            margin: 0;
            font-size: 1.6rem;
        }

        .form-section {
            background-color: #f8f9fa;
            padding: 1.5rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            border: 1px solid #e9ecef;
        }

        .form-section h4 {
            color: #4361ee;
            font-weight: 600;
            margin-bottom: 1rem;
            font-size: 1.1rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-label {
            font-weight: 500;
            color: #495057;
        }

        .form-control,
        .form-select {
            border-radius: 8px;
            padding: 0.55rem 0.9rem;
            font-size: 0.95rem;
            border: 1px solid #ced4da;
            transition: all 0.2s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #4361ee;
            box-shadow: 0 0 0 0.2rem rgba(67, 97, 238, 0.25);
        }

        .btn {
            border-radius: 8px;
            font-weight: 500;
            padding: 0.55rem 1.2rem;
            transition: all 0.2s ease;
            font-size: 0.95rem;
        }

        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .btn-primary {
            background: linear-gradient(135deg, #4361ee, #3f37c9);
            border: none;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
        }

        .btn-outline-secondary {
            border-color: #6c757d;
            color: #6c757d;
        }

        .btn-outline-secondary:hover {
            background-color: #6c757d;
            color: white;
        }

        .signature-container {
            position: relative;
            border: 2px dashed #ced4da;
            border-radius: 12px;
            background: #fff;
            overflow: hidden;
        }

        .signature-container canvas {
            width: 100%;
            height: 240px;
            display: block;
            cursor: crosshair;
        }

        .signature-clear-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 10;
            font-size: 0.8rem;
            padding: 0.35rem 0.6rem;
        }

        .terms-box {
            background: #ffffff;
            border: 1px solid #dee2e6;
            border-radius: 10px;
            padding: 1rem;
            max-height: 220px;
            overflow-y: auto;
            font-size: 0.9rem;
            line-height: 1.5;
        }

        .terms-box ol {
            margin: 0;
            padding-left: 1.2rem;
        }

        .qr-scan-btn {
            font-size: 0.85rem;
            padding: 0.4rem 0.7rem;
        }

        .camera-container {
            margin-top: 0.5rem;
            border-radius: 8px;
            overflow: hidden;
            display: none;
            background: #000;
        }

        .img-preview {
            max-height: 180px;
            object-fit: cover;
            border-radius: 8px;
            margin-top: 0.5rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        /* Responsif */
        @media (max-width: 768px) {
            .container {
                margin: 1rem;
                padding: 1.5rem;
            }

            .page-header {
                margin: -1.5rem -1.5rem 1.5rem -1.5rem;
                padding: 1.2rem;
            }

            .page-header h2 {
                font-size: 1.4rem;
            }

            .signature-container canvas {
                height: 180px;
            }

            .form-section {
                padding: 1.2rem;
            }

            .btn {
                font-size: 0.9rem;
                padding: 0.5rem 1rem;
            }

            .d-flex.gap-3 {
                flex-direction: column;
            }

            .d-flex.gap-3 .btn {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="page-header">
            <i class="fas fa-file-alt"></i>
            <h2>📂 Tambah Berita Acara</h2>
        </div>

        {{-- Alert --}}
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data"
            id="formBeritaAcara">
            @csrf

            <!-- ==================== DATA UMUM ==================== -->
            <div class="form-section">
                <h4>Data Umum</h4>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="nama_lengkap" class="form-control" value="{{ old('nama_lengkap') }}"
                            required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">No KTP <span class="text-danger">*</span></label>
                        <input type="text" name="no_ktp" class="form-control" value="{{ old('no_ktp') }}"
                            pattern="[0-9]{10,20}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">No HP <span class="text-danger">*</span></label>
                        <input type="tel" name="no_hp" class="form-control" value="{{ old('no_hp') }}"
                            pattern="[0-9+ ]{8,15}" required>
                    </div>
                </div>

                <div class="mt-3">
                    <label class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                    <textarea name="alamat_lengkap" class="form-control" rows="3" required>{{ old('alamat_lengkap') }}</textarea>
                </div>

                <div class="row g-3 mt-3">
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Registrasi <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_registrasi" class="form-control"
                            value="{{ old('tanggal_registrasi', now()->format('Y-m-d')) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Jenis Perangkat <span class="text-danger">*</span></label>
                        <input type="text" name="jenis_perangkat" class="form-control"
                            value="{{ old('jenis_perangkat') }}" required>
                    </div>
                </div>

                <!-- QR Scan -->
                <div class="row g-3 mt-3">
                    <div class="col-md-6">
                        <label class="form-label">MAC Address</label>
                        <div class="input-group">
                            <input type="text" id="mac_address" name="mac_address" class="form-control"
                                value="{{ old('mac_address') }}">
                            <button type="button" class="btn btn-outline-secondary qr-scan-btn"
                                onclick="startScan('mac_address')">
                                <i class="fas fa-qrcode"></i>
                            </button>
                        </div>
                        <div id="camera-mac" class="camera-container"></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Serial Number</label>
                        <div class="input-group">
                            <input type="text" id="serial_number" name="serial_number" class="form-control"
                                value="{{ old('serial_number') }}">
                            <button type="button" class="btn btn-outline-secondary qr-scan-btn"
                                onclick="startScan('serial_number')">
                                <i class="fas fa-qrcode"></i>
                            </button>
                        </div>
                        <div id="camera-serial" class="camera-container"></div>
                    </div>
                </div>

                <!-- Teknisi & Paket -->
                <div class="row g-3 mt-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama Teknisi 1 <span class="text-danger">*</span></label>
                        <select name="nama_teknisi_1" class="form-select" required>
                            <option value="">Pilih Teknisi</option>
                            @foreach (['AMRULLOH SYDIK IBRAHIM', 'SUTIPYO', 'ABDUL WAHED A', 'MAHFUD BAWAFI', 'NOVI TRIWORO', 'FATHOR ROSYID', 'MOH. YUNUS'] as $teknisi)
                                <option value="{{ $teknisi }}"
                                    {{ old('nama_teknisi_1') == $teknisi ? 'selected' : '' }}>{{ $teknisi }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nama Teknisi 2</label>
                        <select name="nama_teknisi_2" class="form-select">
                            <option value="">Opsional</option>
                            @foreach (['AMRULLOH SYDIK IBRAHIM', 'SUTIPYO', 'ABDUL WAHED A', 'MAHFUD BAWAFI', 'NOVI TRIWORO', 'FATHOR ROSYID', 'MOH. YUNUS'] as $teknisi)
                                <option value="{{ $teknisi }}"
                                    {{ old('nama_teknisi_2') == $teknisi ? 'selected' : '' }}>{{ $teknisi }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Paket Berlangganan <span class="text-danger">*</span></label>
                        <select name="paket_berlangganan" class="form-select" required>
                            <option value="">Pilih Paket</option>
                            @foreach (['Rp. 125.000 (10 Mbps)', 'Rp. 166.500 (20 Mbps)', 'Rp. 175.000 (30 Mbps)', 'Rp. 200.000 (50 Mbps)', 'Rp. 250.000 (75 Mbps)'] as $paket)
                                <option value="{{ $paket }}"
                                    {{ old('paket_berlangganan') == $paket ? 'selected' : '' }}>{{ $paket }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Biaya Registrasi <span class="text-danger">*</span></label>
                        <select name="biaya_registrasi" class="form-select" required>
                            <option value="">Pilih Biaya</option>
                            <option value="150000" {{ old('biaya_registrasi') == '150000' ? 'selected' : '' }}>Rp.
                                150.000</option>
                            <option value="250000" {{ old('biaya_registrasi') == '250000' ? 'selected' : '' }}>Rp.
                                250.000</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- ==================== SYARAT ==================== -->
            <div class="form-section">
                <h4>Catatan & Syarat</h4>
                <div class="terms-box">
                    <ol>
                        <li>Pelanggan sudah melakukan instalasi kepada MEGADATA.ISP Besuki.</li>
                        <li>Perangkat digunakan adalah pinjaman dari PT. MEGA ARTHA LINTAS DATA.</li>
                        <li>Tidak melakukan downgrade layanan sebelum 6 bulan sejak berita acara ditandatangani.</li>
                        <li>Jika berhenti berlangganan, pihak MEGADATA ISP berhak menarik perangkat pinjaman.</li>
                    </ol>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="accept_terms" id="accept_terms"
                        value="1" {{ old('accept_terms') ? 'checked' : '' }} required>
                    <label class="form-check-label" for="accept_terms">
                        Saya setuju dengan <strong>syarat & ketentuan</strong> di atas.
                    </label>
                </div>
            </div>

            <!-- ==================== FOTO ==================== -->
            <div class="form-section">
                <h4>Upload Foto</h4>
                <div class="row g-3">
                    @foreach ([
        'foto_rumah' => 'Foto Rumah',
        'foto_odp' => 'Foto ODP',
        'foto_dokumentasi_pelanggan' => 'Foto Dokumentasi Pelanggan',
    ] as $name => $label)
                        <div class="col-md-4">
                            <label class="form-label">{{ $label }}</label>
                            <input type="file" name="{{ $name }}" class="form-control" accept="image/*"
                                onchange="previewImage(this)">
                            <img id="preview_{{ $name }}" src="#" class="img-preview w-100 d-none"
                                alt="Pratinjau">
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- ==================== TANDA TANGAN ==================== -->
            <div class="form-section">
                <h4>Tanda Tangan Pelanggan <span class="text-danger">*</span></h4>
                <div class="signature-container">
                    <canvas id="signaturePelanggan"></canvas>
                    <button type="button" class="btn btn-sm btn-outline-secondary signature-clear-btn"
                        id="clearPelanggan">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
                </div>
                <input type="hidden" name="tanda_tangan_pelanggan" id="tanda_tangan_pelanggan">
            </div>

            <div class="form-section">
                <h4>Tanda Tangan Petugas <span class="text-danger">*</span></h4>
                <div class="signature-container">
                    <canvas id="signaturePetugas"></canvas>
                    <button type="button" class="btn btn-sm btn-outline-secondary signature-clear-btn"
                        id="clearPetugas">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
                </div>
                <input type="hidden" name="tanda_tangan_petugas" id="tanda_tangan_petugas">
            </div>

            <!-- ==================== AKSI ==================== -->
            <div class="d-flex justify-content-between gap-3 mt-4">
                <a href="{{ route('user.index') }}" class="btn btn-primary d-flex align-items-center gap-2">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <button type="submit" class="btn btn-success d-flex align-items-center gap-2">
                    <i class="fas fa-save"></i> Simpan Berita Acara
                </button>
            </div>
        </form>
    </div>

    <script>
        let sigPelanggan, sigPetugas, qrScanner;

        document.addEventListener('DOMContentLoaded', () => {
            const canvas1 = document.getElementById('signaturePelanggan');
            const canvas2 = document.getElementById('signaturePetugas');

            // WARNA HITAM untuk kedua tanda tangan
            sigPelanggan = new SignaturePad(canvas1, {
                penColor: '#000000' // Hitam
            });
            sigPetugas = new SignaturePad(canvas2, {
                penColor: '#000000' // Hitam
            });

            document.getElementById('clearPelanggan').onclick = () => sigPelanggan.clear();
            document.getElementById('clearPetugas').onclick = () => sigPetugas.clear();

            const resize = () => {
                [canvas1, canvas2].forEach((canvas, i) => {
                    const ratio = Math.max(window.devicePixelRatio || 1, 1);
                    const rect = canvas.getBoundingClientRect();
                    canvas.width = rect.width * ratio;
                    canvas.height = 240 * ratio;
                    canvas.getContext('2d').scale(ratio, ratio);
                    (i === 0 ? sigPelanggan : sigPetugas).clear();
                });
            };

            window.addEventListener('resize', resize);
            resize();

            document.getElementById('formBeritaAcara').onsubmit = function(e) {
                if (sigPelanggan.isEmpty()) {
                    alert('Tanda tangan pelanggan wajib diisi!');
                    e.preventDefault();
                    return false;
                }
                if (sigPetugas.isEmpty()) {
                    alert('Tanda tangan petugas wajib diisi!');
                    e.preventDefault();
                    return false;
                }
                document.getElementById('tanda_tangan_pelanggan').value = sigPelanggan.toDataURL();
                document.getElementById('tanda_tangan_petugas').value = sigPetugas.toDataURL();
                return true;
            };
        });

        function previewImage(input) {
            const file = input.files[0];
            if (!file) return;
            const reader = new FileReader();
            const img = document.getElementById('preview_' + input.name);
            reader.onload = e => {
                img.src = e.target.result;
                img.classList.remove('d-none');
            };
            reader.readAsDataURL(file);
        }

        function startScan(fieldId) {
            const cameraId = fieldId === 'mac_address' ? 'camera-mac' : 'camera-serial';
            const cameraDiv = document.getElementById(cameraId);
            cameraDiv.style.display = cameraDiv.style.display === 'block' ? 'none' : 'block';

            if (cameraDiv.style.display === 'block') {
                if (qrScanner) qrScanner.stop();
                qrScanner = new Html5Qrcode(cameraId);
                qrScanner.start({
                        facingMode: 'environment'
                    }, {
                        fps: 10,
                        qrbox: {
                            width: 250,
                            height: 250
                        }
                    },
                    (text) => {
                        document.getElementById(fieldId).value = text;
                        qrScanner.stop();
                        cameraDiv.style.display = 'none';
                    },
                    () => {}
                ).catch(err => {
                    alert('Gagal mengakses kamera: ' + err);
                    cameraDiv.style.display = 'none';
                });
            } else if (qrScanner) {
                qrScanner.stop();
            }
        }
    </script>
</body>

</html>
