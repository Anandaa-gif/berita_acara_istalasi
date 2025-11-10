<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Berita Acara - Pelanggan</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-light">

    <div class="container my-5">

        <!-- Header -->
        <div class="text-center mb-4">
            <h2 class="fw-bold">Berita Acara Instalasi</h2>
            <p class="text-muted">Informasi pelanggan dan teknisi telah tercatat</p>
        </div>

        <!-- Card Informasi -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h5 class="card-title mb-3">Detail Pelanggan</h5>

                <div class="row mb-2">
                    <div class="col-md-6"><strong>Nama Pelanggan:</strong> {{ $beritaAcara->nama_lengkap }}</div>
                    <div class="col-md-6"><strong>No HP:</strong> {{ $beritaAcara->no_hp }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6"><strong>No KTP:</strong> {{ $beritaAcara->no_ktp }}</div>
                    <div class="col-md-6"><strong>Alamat:</strong> {{ $beritaAcara->alamat_lengkap }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6"><strong>Jenis Perangkat:</strong> {{ $beritaAcara->jenis_perangkat }}</div>
                    <div class="col-md-6"><strong>Paket Berlangganan:</strong> {{ $beritaAcara->paket_berlangganan }}
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6"><strong>Teknisi 1:</strong> {{ $beritaAcara->nama_teknisi_1 }}</div>
                    <div class="col-md-6"><strong>Teknisi 2:</strong> {{ $beritaAcara->nama_teknisi_2 ?? '-' }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6"><strong>Tanggal Registrasi:</strong>
                        {{ \Carbon\Carbon::parse($beritaAcara->tanggal_registrasi)->format('d/m/Y') }}</div>
                </div>
            </div>
        </div>

        <!-- Tombol Download PDF -->
        <a href="{{ route('pelanggan.pdf', $acara->id) }}"
            class="btn btn-sm btn-danger d-flex align-items-center gap-1" title="Download PDF">
            <i class="fas fa-file-pdf"></i> <span class="d-none d-sm-inline">PDF</span>
        </a>

    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
