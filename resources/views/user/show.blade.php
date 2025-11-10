<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Berita Acara</title>
    <link rel="icon" type="image/png" href="{{ asset('storage/images/mgdt.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #0d6efd;
            --secondary-color: #6c757d;
            --success-color: #198754;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
            --light-bg: #f8f9fa;
            --border-color: #dee2e6;
            --card-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
        }

        .detail-container {
            max-width: 1200px;
            margin: 30px auto;
        }

        .card-main {
            border: none;
            border-radius: 16px;
            box-shadow: var(--card-shadow);
            overflow: hidden;
            background: white;
        }

        .card-header-custom {
            background: linear-gradient(135deg, var(--primary-color), #0a58ca);
            color: white;
            padding: 25px 30px;
            border-bottom: none;
        }

        .page-title {
            font-size: 1.8rem;
            font-weight: 700;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .section-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
            margin-bottom: 24px;
            transition: transform 0.3s ease;
        }

        .section-card:hover {
            transform: translateY(-2px);
        }

        .section-header {
            background: var(--light-bg);
            border-bottom: 2px solid var(--primary-color);
            padding: 16px 20px;
            border-radius: 12px 12px 0 0;
        }

        .section-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--primary-color);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .info-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .info-table th {
            background-color: var(--light-bg);
            font-weight: 600;
            color: #495057;
            width: 35%;
            padding: 14px 20px;
            border-bottom: 1px solid var(--border-color);
        }

        .info-table td {
            padding: 14px 20px;
            border-bottom: 1px solid var(--border-color);
            color: #212529;
        }

        .info-table tr:last-child th,
        .info-table tr:last-child td {
            border-bottom: none;
        }

        .image-gallery {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            padding: 20px;
        }

        .image-item {
            text-align: center;
            padding: 15px;
            border-radius: 10px;
            background: var(--light-bg);
            transition: all 0.3s ease;
        }

        .image-item:hover {
            background: #e9ecef;
            transform: translateY(-3px);
        }

        .image-label {
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 12px;
            font-size: 1rem;
        }

        .image-preview {
            max-width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid var(--border-color);
            padding: 5px;
            background: white;
        }

        .no-image {
            height: 180px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8f9fa;
            border: 2px dashed var(--border-color);
            border-radius: 8px;
            color: var(--secondary-color);
        }

        .signature-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            padding: 20px;
        }

        .signature-item {
            text-align: center;
            padding: 20px;
            border-radius: 10px;
            background: var(--light-bg);
        }

        .signature-label {
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 15px;
            font-size: 1.1rem;
        }

        .signature-preview {
            max-width: 100%;
            height: 150px;
            object-fit: contain;
            border: 2px solid var(--border-color);
            border-radius: 8px;
            padding: 8px;
            background: white;
        }

        .action-buttons {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
            flex-wrap: wrap;
            padding: 25px 30px;
            background: var(--light-bg);
            border-radius: 0 0 12px 12px;
        }

        .btn-custom {
            padding: 10px 24px;
            border-radius: 8px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .btn-back {
            background: var(--secondary-color);
            border-color: var(--secondary-color);
        }

        .btn-edit {
            background: var(--warning-color);
            border-color: var(--warning-color);
            color: #212529;
        }

        .btn-delete {
            background: var(--danger-color);
            border-color: var(--danger-color);
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .badge-active {
            background: #d1e7dd;
            color: #0f5132;
        }

        @media (max-width: 768px) {
            .detail-container {
                margin: 15px;
            }

            .page-title {
                font-size: 1.5rem;
            }

            .image-gallery {
                grid-template-columns: 1fr;
            }

            .signature-container {
                grid-template-columns: 1fr;
            }

            .action-buttons {
                justify-content: center;
            }

            .info-table th {
                width: 40%;
            }
        }

        @media (max-width: 576px) {
            .card-header-custom {
                padding: 20px;
            }

            .section-header {
                padding: 14px 16px;
            }

            .info-table th,
            .info-table td {
                padding: 12px 16px;
            }

            .btn-custom {
                width: 100%;
                justify-content: center;
            }

            .action-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>
    <div class="detail-container">
        <div class="card-main">
            <!-- Header -->
            <div class="card-header-custom">
                <h1 class="page-title">
                    <i class="fas fa-file-contract"></i>
                    Detail Berita Acara
                </h1>
            </div>

            <div class="card-body p-0">
                <!-- Data Pelanggan -->
                <div class="section-card">
                    <div class="section-header">
                        <h3 class="section-title">
                            <i class="fas fa-user-circle"></i>
                            Data Pelanggan
                        </h3>
                    </div>
                    <div class="p-0">
                        <table class="info-table">
                            <tr>
                                <th>Nama Lengkap</th>
                                <td>{{ $beritaAcara->nama_lengkap ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>No KTP</th>
                                <td>{{ $beritaAcara->no_ktp ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>
                                    @if ($beritaAcara->email)
                                        <i class="fas fa-envelope me-2 text-muted"></i>{{ $beritaAcara->email }}
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>No HP</th>
                                <td>
                                    @if ($beritaAcara->no_hp)
                                        <i class="fas fa-phone me-2 text-muted"></i>{{ $beritaAcara->no_hp }}
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Alamat Lengkap</th>
                                <td>
                                    @if ($beritaAcara->alamat_lengkap)
                                        <i
                                            class="fas fa-map-marker-alt me-2 text-muted"></i>{{ $beritaAcara->alamat_lengkap }}
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Data Registrasi -->
                <div class="section-card">
                    <div class="section-header">
                        <h3 class="section-title">
                            <i class="fas fa-calendar-alt"></i>
                            Data Registrasi
                        </h3>
                    </div>
                    <div class="p-0">
                        <table class="info-table">
                            <tr>
                                <th>Tanggal Registrasi</th>
                                <td>
                                    @if ($beritaAcara->tanggal_registrasi)
                                        <i class="far fa-calendar me-2 text-muted"></i>
                                        {{ \Carbon\Carbon::parse($beritaAcara->tanggal_registrasi)->format('d F Y') }}
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Paket Berlangganan</th>
                                <td>
                                    @if ($beritaAcara->paket_berlangganan)
                                        <span class="status-badge badge-active">
                                            <i class="fas fa-wifi"></i>
                                            {{ $beritaAcara->paket_berlangganan }}
                                        </span>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Jenis Perangkat</th>
                                <td>{{ $beritaAcara->jenis_perangkat ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Biaya Registrasi</th>
                                <td>
                                    @if (isset($beritaAcara->biaya_registrasi))
                                        <strong class="text-success">Rp
                                            {{ number_format($beritaAcara->biaya_registrasi, 0, ',', '.') }}</strong>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Data Teknisi -->
                <div class="section-card">
                    <div class="section-header">
                        <h3 class="section-title">
                            <i class="fas fa-tools"></i>
                            Data Teknisi
                        </h3>
                    </div>
                    <div class="p-0">
                        <table class="info-table">
                            <tr>
                                <th>Nama Teknisi 1</th>
                                <td>
                                    @if ($beritaAcara->nama_teknisi_1)
                                        <i
                                            class="fas fa-user-cog me-2 text-muted"></i>{{ $beritaAcara->nama_teknisi_1 }}
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Nama Teknisi 2</th>
                                <td>
                                    @if ($beritaAcara->nama_teknisi_2)
                                        <i
                                            class="fas fa-user-cog me-2 text-muted"></i>{{ $beritaAcara->nama_teknisi_2 }}
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Foto Dokumentasi -->
                <!-- Foto Dokumentasi -->
                <div class="row text-center mt-4">
                    <h5 class="fw-bold mb-3">📸 Dokumentasi</h5>

                    <!-- Baris pertama: Foto Rumah dan Foto ODP -->
                    <div class="row justify-content-center mb-3">
                        @foreach (['foto_rumah' => 'Foto Rumah', 'foto_odp' => 'Foto ODP'] as $field => $label)
                            <div class="col-md-4 mb-3">
                                <div class="card">
                                    <div class="card-header bg-light fw-bold">{{ $label }}</div>
                                    <div class="card-body p-2">
                                        @if ($beritaAcara->$field)
                                            <img src="{{ asset('storage/' . $beritaAcara->$field) }}"
                                                class="img-fluid rounded shadow-sm" alt="{{ $label }}">
                                        @else
                                            <div class="text-muted fst-italic">Tidak ada foto</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Baris kedua: Foto Pelanggan (di tengah) -->
                    <div class="row justify-content-center">
                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <div class="card-header bg-light fw-bold">Foto Pelanggan</div>
                                <div class="card-body p-2">
                                    @if ($beritaAcara->foto_dokumentasi_pelanggan)
                                        <img src="{{ asset('storage/' . $beritaAcara->foto_dokumentasi_pelanggan) }}"
                                            class="img-fluid rounded shadow-sm" alt="Foto Pelanggan">
                                    @else
                                        <div class="text-muted fst-italic">Tidak ada foto</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tanda Tangan -->
                <div class="row text-center mt-4">
                    <div class="col-md-6">
                        <h6 class="fw-bold">Tanda Tangan Pelanggan</h6>
                        @if (Str::startsWith($beritaAcara->tanda_tangan_pelanggan, 'data:image'))
                            <img src="{{ $beritaAcara->tanda_tangan_pelanggan }}" class="img-fluid border rounded"
                                style="max-height: 180px;">
                        @elseif($beritaAcara->tanda_tangan_pelanggan)
                            <img src="{{ asset('storage/' . $beritaAcara->tanda_tangan_pelanggan) }}"
                                class="img-fluid border rounded" style="max-height: 180px;">
                        @else
                            <p class="text-muted fst-italic">Belum ada tanda tangan</p>
                        @endif
                    </div>

                    <div class="col-md-6">
                        <h6 class="fw-bold">Tanda Tangan Petugas</h6>
                        @if (Str::startsWith($beritaAcara->tanda_tangan_petugas, 'data:image'))
                            <img src="{{ $beritaAcara->tanda_tangan_petugas }}" class="img-fluid border rounded"
                                style="max-height: 180px;">
                        @elseif($beritaAcara->tanda_tangan_petugas)
                            <img src="{{ asset('storage/' . $beritaAcara->tanda_tangan_petugas) }}"
                                class="img-fluid border rounded" style="max-height: 180px;">
                        @else
                            <p class="text-muted fst-italic">Belum ada tanda tangan</p>
                        @endif
                    </div>
                </div>

                <hr>



                <!-- Tombol Aksi -->
                <div class="action-buttons">
                    <a href="{{ route('user.index') }}" class="btn btn-secondary btn-custom">
                        <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
