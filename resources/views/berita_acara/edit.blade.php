<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Berita Acara</title>
    <link rel="icon" type="image/png" href="{{ asset('storage/images/mgdt.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #0d6efd;
            --secondary-color: #6c757d;
            --success-color: #198754;
            --light-bg: #f8f9fa;
            --border-color: #dee2e6;
        }

        body {
            background-color: #f5f7fb;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .container {
            max-width: 1000px;
            background-color: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .page-header {
            color: var(--primary-color);
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid var(--border-color);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-section {
            background-color: var(--light-bg);
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 25px;
            border-left: 4px solid var(--primary-color);
        }

        .section-title {
            color: var(--primary-color);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 600;
        }

        .form-label {
            font-weight: 500;
            margin-bottom: 8px;
            color: #495057;
        }

        .form-control,
        .form-select {
            border-radius: 6px;
            padding: 10px 12px;
            border: 1px solid var(--border-color);
            transition: all 0.3s;
        }

        .form-control:focus,
        .form-select:focus {
            box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.15);
            border-color: var(--primary-color);
        }

        .signature-container {
            position: relative;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            background-color: white;
            touch-action: none;
            margin-bottom: 10px;
        }

        .signature-container canvas {
            width: 100%;
            height: 150px;
            border-radius: 6px;
        }

        .signature-clear-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 10;
        }

        .image-preview {
            max-height: 150px;
            border-radius: 6px;
            border: 1px solid var(--border-color);
            padding: 5px;
            background-color: white;
            margin-bottom: 10px;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: 500;
        }

        .btn-secondary {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: 500;
        }

        .btn-success {
            background-color: var(--success-color);
            border-color: var(--success-color);
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: 500;
        }

        .btn-danger {
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 0.875rem;
        }

        .optional-badge {
            background-color: #e9ecef;
            color: #6c757d;
            font-size: 0.75rem;
            padding: 2px 6px;
            border-radius: 4px;
            margin-left: 5px;
        }

        .file-upload-container {
            border: 2px dashed var(--border-color);
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            transition: all 0.3s;
            background-color: #fdfdfd;
        }

        .file-upload-container:hover {
            border-color: var(--primary-color);
            background-color: #f8fbff;
        }

        .photo-column {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .photo-documentation {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .photo-documentation .col-md-6 {
            max-width: 400px;
        }

        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }

            .signature-container canvas {
                height: 120px;
            }

            .image-preview {
                max-height: 120px;
            }

            .photo-documentation .col-md-6 {
                max-width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h2 class="page-header">
            <i class="fas fa-edit"></i> Edit Berita Acara
        </h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('berita_acara.update', $beritaAcara->id) }}" method="POST" enctype="multipart/form-data"
            id="editForm">
            @csrf
            @method('PUT')

            <!-- Data Pelanggan -->
            <div class="form-section">
                <h4 class="section-title">
                    <i class="fas fa-user"></i> Data Pelanggan
                </h4>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap"
                            value="{{ old('nama_lengkap', $beritaAcara->nama_lengkap) }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="no_ktp" class="form-label">No KTP</label>
                        <input type="text" class="form-control" id="no_ktp" name="no_ktp"
                            value="{{ old('no_ktp', $beritaAcara->no_ktp) }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email <span
                                class="optional-badge">opsional</span></label>
                        <input type="email" class="form-control" id="email" name="email"
                            value="{{ old('email', $beritaAcara->email) }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="no_hp" class="form-label">No HP</label>
                        <input type="text" class="form-control" id="no_hp" name="no_hp"
                            value="{{ old('no_hp', $beritaAcara->no_hp) }}" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="alamat_lengkap" class="form-label">Alamat Lengkap</label>
                    <textarea class="form-control" id="alamat_lengkap" name="alamat_lengkap" rows="3" required>{{ old('alamat_lengkap', $beritaAcara->alamat_lengkap) }}</textarea>
                </div>
            </div>

            <!-- Data Instalasi -->
            <div class="form-section">
                <h4 class="section-title">
                    <i class="fas fa-wifi"></i> Data Instalasi
                </h4>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="tanggal_registrasi" class="form-label">Tanggal Registrasi</label>
                        <input type="date" class="form-control" id="tanggal_registrasi" name="tanggal_registrasi"
                            value="{{ old('tanggal_registrasi', $beritaAcara->tanggal_registrasi) }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="jenis_perangkat" class="form-label">Jenis Perangkat</label>
                        <input type="text" class="form-control" id="jenis_perangkat" name="jenis_perangkat"
                            value="{{ old('jenis_perangkat', $beritaAcara->jenis_perangkat) }}" required>
                    </div>
                </div>

                <!-- QR Code Section -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="mac_address" class="form-label">MAC Address</label>
                        <input type="text" id="mac_address" name="mac_address" class="form-control"
                            value="{{ old('mac_address', $beritaAcara->mac_address) }}">
                        <button type="button" class="btn btn-outline-secondary mt-2"
                            onclick="startScan('mac_address')">
                            <i class="fas fa-qrcode"></i> Scan QR
                        </button>
                        <div id="camera-mac" class="mt-2" style="width:100%; height:300px; display:none;"></div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="serial_number" class="form-label">Serial Number</label>
                        <input type="text" id="serial_number" name="serial_number" class="form-control"
                            value="{{ old('serial_number', $beritaAcara->serial_number) }}">
                        <button type="button" class="btn btn-outline-secondary mt-2"
                            onclick="startScan('serial_number')">
                            <i class="fas fa-qrcode"></i> Scan QR
                        </button>
                        <div id="camera-serial" class="mt-2" style="width:100%; height:300px; display:none;"></div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nama_teknisi_1" class="form-label">Nama Teknisi 1</label>
                        <select name="nama_teknisi_1" class="form-select" required>
                            <option value="">Pilih Teknisi 1</option>
                            <option value="AMRULLOH SYDIK IBRAHIM"
                                {{ old('nama_teknisi_1', $beritaAcara->nama_teknisi_1) == 'AMRULLOH SYDIK IBRAHIM' ? 'selected' : '' }}>
                                AMRULLOH SYDIK IBRAHIM</option>
                            <option value="SUTIPYO"
                                {{ old('nama_teknisi_1', $beritaAcara->nama_teknisi_1) == 'SUTIPYO' ? 'selected' : '' }}>
                                SUTIPYO</option>
                            <option value="ABDUL WAHED A"
                                {{ old('nama_teknisi_1', $beritaAcara->nama_teknisi_1) == 'ABDUL WAHED A' ? 'selected' : '' }}>
                                ABDUL WAHED A</option>
                            <option value="MAHFUD BAWAFI"
                                {{ old('nama_teknisi_1', $beritaAcara->nama_teknisi_1) == 'MAHFUD BAWAFI' ? 'selected' : '' }}>
                                MAHFUD BAWAFI</option>
                            <option value="NOVI TRIWORO"
                                {{ old('nama_teknisi_1', $beritaAcara->nama_teknisi_1) == 'NOVI TRIWORO' ? 'selected' : '' }}>
                                NOVI TRIWORO</option>
                            <option value="FATHOR ROSYID"
                                {{ old('nama_teknisi_1', $beritaAcara->nama_teknisi_1) == 'FATHOR ROSYID' ? 'selected' : '' }}>
                                FATHOR ROSYID</option>
                            <option value="MOH. YUNUS"
                                {{ old('nama_teknisi_1', $beritaAcara->nama_teknisi_1) == 'MOH. YUNUS' ? 'selected' : '' }}>
                                MOH. YUNUS</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="nama_teknisi_2" class="form-label">Nama Teknisi 2 <span
                                class="optional-badge">opsional</span></label>
                        <select name="nama_teknisi_2" class="form-select">
                            <option value="">Pilih Teknisi 2 (Opsional)</option>
                            <option value="AMRULLOH SYDIK IBRAHIM"
                                {{ old('nama_teknisi_2', $beritaAcara->nama_teknisi_2) == 'AMRULLOH SYDIK IBRAHIM' ? 'selected' : '' }}>
                                AMRULLOH SYDIK IBRAHIM</option>
                            <option value="SUTIPYO"
                                {{ old('nama_teknisi_2', $beritaAcara->nama_teknisi_2) == 'SUTIPYO' ? 'selected' : '' }}>
                                SUTIPYO</option>
                            <option value="ABDUL WAHED A"
                                {{ old('nama_teknisi_2', $beritaAcara->nama_teknisi_2) == 'ABDUL WAHED A' ? 'selected' : '' }}>
                                ABDUL WAHED A</option>
                            <option value="MAHFUD BAWAFI"
                                {{ old('nama_teknisi_2', $beritaAcara->nama_teknisi_2) == 'MAHFUD BAWAFI' ? 'selected' : '' }}>
                                MAHFUD BAWAFI</option>
                            <option value="NOVI TRIWORO"
                                {{ old('nama_teknisi_2', $beritaAcara->nama_teknisi_2) == 'NOVI TRIWORO' ? 'selected' : '' }}>
                                NOVI TRIWORO</option>
                            <option value="FATHOR ROSYID"
                                {{ old('nama_teknisi_2', $beritaAcara->nama_teknisi_2) == 'FATHOR ROSYID' ? 'selected' : '' }}>
                                FATHOR ROSYID</option>
                            <option value="MOH. YUNUS"
                                {{ old('nama_teknisi_2', $beritaAcara->nama_teknisi_2) == 'MOH. YUNUS' ? 'selected' : '' }}>
                                MOH. YUNUS</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="paket_berlangganan" class="form-label">Paket Berlangganan</label>
                        <select class="form-select" id="paket_berlangganan" name="paket_berlangganan" required>
                            <option value="">Pilih Paket Berlangganan</option>
                            <option value="Rp. 125.000 (10 Mbps)"
                                {{ old('paket_berlangganan', $beritaAcara->paket_berlangganan) == 'Rp. 125.000 (10 Mbps)' ? 'selected' : '' }}>
                                Rp. 125.000 (10 Mbps)</option>
                            <option value="Rp. 166.500 (20 Mbps)"
                                {{ old('paket_berlangganan', $beritaAcara->paket_berlangganan) == 'Rp. 166.500 (20 Mbps)' ? 'selected' : '' }}>
                                Rp. 166.500 (20 Mbps)</option>
                            <option value="Rp. 175.000 (30 Mbps)"
                                {{ old('paket_berlangganan', $beritaAcara->paket_berlangganan) == 'Rp. 175.000 (30 Mbps)' ? 'selected' : '' }}>
                                Rp. 175.000 (30 Mbps)</option>
                            <option value="Rp. 200.000 (50 Mbps)"
                                {{ old('paket_berlangganan', $beritaAcara->paket_berlangganan) == 'Rp. 200.000 (50 Mbps)' ? 'selected' : '' }}>
                                Rp. 200.000 (50 Mbps)</option>
                            <option value="Rp. 250.000 (75 Mbps)"
                                {{ old('paket_berlangganan', $beritaAcara->paket_berlangganan) == 'Rp. 250.000 (75 Mbps)' ? 'selected' : '' }}>
                                Rp. 250.000 (75 Mbps)</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="biaya_registrasi" class="form-label">Biaya Registrasi</label>
                        <select class="form-select" id="biaya_registrasi" name="biaya_registrasi" required>
                            <option value="">Pilih Biaya Registrasi</option>
                            <option value="150000"
                                {{ old('biaya_registrasi', $beritaAcara->biaya_registrasi) == '150000' ? 'selected' : '' }}>
                                Rp. 150.000</option>
                            <option value="250000"
                                {{ old('biaya_registrasi', $beritaAcara->biaya_registrasi) == '250000' ? 'selected' : '' }}>
                                Rp. 250.000</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Catatan Instalasi -->
            <div class="form-section">
                <h4 class="section-title">
                    <i class="fas fa-clipboard-check"></i> Catatan Instalasi Pelanggan
                </h4>

                <div class="terms-box">
                    <ol>
                        <li>Pelanggan sudah melakukan instalasi kepada MEGADATA.ISP Besuki.</li>
                        <li>Perangkat digunakan adalah pinjaman dari PT. MEGA ARTHA LINTAS DATA.</li>
                        <li>Tidak melakukan downgrade layanan sebelum 6 bulan sejak berita acara ditandatangani.</li>
                        <li>Jika berhenti berlangganan, pihak MEGADATA ISP berhak menarik perangkat pinjaman.</li>
                    </ol>
                </div>
                <div class="form-check mt-2">
                    <input class="form-check-input" type="checkbox" name="accept_terms" value="1"
                        id="accept_terms" {{ old('accept_terms', $beritaAcara->accept_terms) ? 'checked' : '' }}
                        required>
                    <label class="form-check-label" for="accept_terms">
                        Saya telah membaca dan menyetujui <strong>syarat & ketentuan</strong>.
                    </label>
                </div>
            </div>

            <!-- Foto Dokumentasi -->
            <div class="form-section">
                <h4 class="section-title">
                    <i class="fas fa-camera"></i> Upload Foto
                </h4>

                <!-- Foto Rumah dan ODP bersebelahan -->
                <div class="row">
                    <div class="col-md-6 mb-4 photo-column">
                        <label class="form-label">Foto Rumah</label>
                        @if ($beritaAcara->foto_rumah && Storage::disk('public')->exists($beritaAcara->foto_rumah))
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $beritaAcara->foto_rumah) }}" alt="Foto Rumah"
                                    class="image-preview">
                                <div class="form-text">Foto saat ini</div>
                            </div>
                        @endif
                        <input type="file" class="form-control" name="foto_rumah" accept="image/*"
                            onchange="previewImage(this, 'preview_foto_rumah')">
                        <img id="preview_foto_rumah" src="#" alt="Pratinjau"
                            class="mt-2 img-fluid rounded d-none">
                    </div>

                    <div class="col-md-6 mb-4 photo-column">
                        <label class="form-label">Foto ODP</label>
                        @if ($beritaAcara->foto_odp && Storage::disk('public')->exists($beritaAcara->foto_odp))
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $beritaAcara->foto_odp) }}" alt="Foto ODP"
                                    class="image-preview">
                                <div class="form-text">Foto saat ini</div>
                            </div>
                        @endif
                        <input type="file" class="form-control" name="foto_odp" accept="image/*"
                            onchange="previewImage(this, 'preview_foto_odp')">
                        <img id="preview_foto_odp" src="#" alt="Pratinjau"
                            class="mt-2 img-fluid rounded d-none">
                    </div>
                </div>

                <!-- Foto Dokumentasi Pelanggan di bawah dan di tengah -->
                <div class="row photo-documentation">
                    <div class="col-md-6 mb-4 photo-column">
                        <label class="form-label">Foto Dokumentasi Pelanggan</label>
                        @if (
                            $beritaAcara->foto_dokumentasi_pelanggan &&
                                Storage::disk('public')->exists($beritaAcara->foto_dokumentasi_pelanggan))
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $beritaAcara->foto_dokumentasi_pelanggan) }}"
                                    alt="Foto Dokumentasi Pelanggan" class="image-preview">
                                <div class="form-text">Foto saat ini</div>
                            </div>
                        @endif
                        <input type="file" class="form-control" name="foto_dokumentasi_pelanggan"
                            accept="image/*" onchange="previewImage(this, 'preview_foto_dokumentasi_pelanggan')">
                        <img id="preview_foto_dokumentasi_pelanggan" src="#" alt="Pratinjau"
                            class="mt-2 img-fluid rounded d-none">
                    </div>
                </div>
            </div>

            <!-- Tanda Tangan -->
            <div class="form-section">
                <h4 class="section-title">
                    <i class="fas fa-signature"></i> Tanda Tangan
                </h4>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label class="form-label">Tanda Tangan Pelanggan</label>
                        @if ($beritaAcara->tanda_tangan_pelanggan)
                            <div class="mb-2">
                                <img src="{{ $beritaAcara->tanda_tangan_pelanggan }}" alt="Tanda Tangan Pelanggan"
                                    class="image-preview">
                                <div class="form-text">Tanda tangan saat ini</div>
                            </div>
                        @endif
                        <input type="hidden" name="tanda_tangan_pelanggan" id="signature_pelanggan"
                            value="{{ old('tanda_tangan_pelanggan', $beritaAcara->tanda_tangan_pelanggan) }}">
                        <div class="signature-container">
                            <canvas id="sig_pelanggan"></canvas>
                            <button type="button" class="btn btn-danger signature-clear-btn" id="clear_pelanggan">
                                <i class="fas fa-eraser"></i> Hapus
                            </button>
                        </div>
                        <div class="form-text">Gunakan mouse atau jari untuk menandatangani</div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label class="form-label">Tanda Tangan Petugas</label>
                        @if ($beritaAcara->tanda_tangan_petugas)
                            <div class="mb-2">
                                <img src="{{ $beritaAcara->tanda_tangan_petugas }}" alt="Tanda Tangan Petugas"
                                    class="image-preview">
                                <div class="form-text">Tanda tangan saat ini</div>
                            </div>
                        @endif
                        <input type="hidden" name="tanda_tangan_petugas" id="signature_petugas"
                            value="{{ old('tanda_tangan_petugas', $beritaAcara->tanda_tangan_petugas) }}">
                        <div class="signature-container">
                            <canvas id="sig_petugas"></canvas>
                            <button type="button" class="btn btn-danger signature-clear-btn" id="clear_petugas">
                                <i class="fas fa-eraser"></i> Hapus
                            </button>
                        </div>
                        <div class="form-text">Gunakan mouse atau jari untuk menandatangani</div>
                    </div>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="d-flex justify-content-end gap-3 mt-4">
                <a href="{{ route('berita_acara.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Update Berita Acara
                </button>
            </div>
        </form>
    </div>

    <!-- Script -->
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.5/dist/signature_pad.umd.min.js"></script>
    <script src="https://unpkg.com/html5-qrcode@2.3.7/minified/html5-qrcode.min.js"></script>

    <script>
        let sigPelanggan = null;
        let sigPetugas = null;
        let qrScanner = null;

        function initSignaturePads() {
            const canvasPelanggan = document.getElementById('sig_pelanggan');
            const canvasPetugas = document.getElementById('sig_petugas');

            if (!canvasPelanggan || !canvasPetugas) {
                console.warn("Canvas tanda tangan tidak ditemukan");
                return;
            }

            const ratio = Math.max(window.devicePixelRatio || 1, 1);

            function setupCanvas(canvas) {
                const width = canvas.offsetWidth * ratio;
                const height = 150 * ratio;
                canvas.width = width;
                canvas.height = height;
                canvas.getContext("2d").scale(ratio, ratio);
            }

            setupCanvas(canvasPelanggan);
            setupCanvas(canvasPetugas);

            sigPelanggan = new SignaturePad(canvasPelanggan, {
                backgroundColor: "#fff",
                penColor: "#000"
            });
            sigPetugas = new SignaturePad(canvasPetugas, {
                backgroundColor: "#fff",
                penColor: "#000"
            });

            if (document.getElementById('clear_pelanggan'))
                document.getElementById('clear_pelanggan').onclick = () => sigPelanggan.clear();

            if (document.getElementById('clear_petugas'))
                document.getElementById('clear_petugas').onclick = () => sigPetugas.clear();
        }

        function previewImage(input, previewId) {
            if (!input.files || !input.files[0]) return;
            const reader = new FileReader();
            reader.onload = e => {
                const img = document.getElementById(previewId);
                img.src = e.target.result;
                img.classList.remove("d-none");
            };
            reader.readAsDataURL(input.files[0]);
        }

        function validateForm() {
            const sigPelField = document.getElementById('signature_pelanggan');
            const sigPetField = document.getElementById('signature_petugas');

            if (sigPelanggan && !sigPelanggan.isEmpty()) {
                sigPelField.value = sigPelanggan.toDataURL();
            }

            if (sigPetugas && !sigPetugas.isEmpty()) {
                sigPetField.value = sigPetugas.toDataURL();
            }

            if (!document.getElementById("accept_terms").checked) {
                alert("Setujui syarat & ketentuan terlebih dahulu");
                return false;
            }

            return true;
        }

        function startScan(fieldId) {
            const cameraDiv = fieldId === 'mac_address' ? 'camera-mac' : 'camera-serial';
            const container = document.getElementById(cameraDiv);

            if (qrScanner) {
                qrScanner.stop().catch(() => {});
            }

            container.style.display = "block";
            qrScanner = new Html5Qrcode(cameraDiv);

            qrScanner.start({
                        facingMode: "environment"
                    }, {
                        fps: 10,
                        qrbox: 250
                    },
                    (decodedText) => {
                        document.getElementById(fieldId).value = decodedText;
                        qrScanner.stop().then(() => container.style.display = "none");
                    },
                    (err) => console.log("Scanning..."))
                .catch(() => alert("Kamera tidak dapat diakses. Pastikan izin kamera diizinkan."));
        }

        document.addEventListener('DOMContentLoaded', () => {
            initSignaturePads();

            const form = document.getElementById('editForm');
            if (form) form.onsubmit = () => validateForm();
            else console.warn("⚠️ Form dengan id='editForm' tidak ditemukan.");
        });
    </script>

</body>

</html>
