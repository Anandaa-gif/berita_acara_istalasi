<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | Sistem Berita Acara</title>
    <link rel="icon" type="image/png" href="{{ asset('storage/images/mgdt.png') }}">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        html, body {
            height: 100%;
            margin: 0;
            background-color: #f8f9fa;

            /* FIX: izinkan HP scroll kiri–kanan */
            overflow-x: auto !important;
        }

        .wrapper {
            min-height: 100%;
            display: flex;
            flex-direction: column;

            /* FIX: jangan kunci lebar */
            max-width: 100% !important;
            overflow-x: visible !important;
        }

        main {
            flex: 1;

            /* FIX: konten bisa scroll */
            overflow-x: auto !important;
            max-width: 100% !important;
        }

        /* FIX PENTING: semua tabel di semua halaman responsif scroll */
        .table-responsive {
            width: 100% !important;
            display: block !important;
            overflow-x: auto !important;
            -webkit-overflow-scrolling: touch !important;
        }

        /* Fix untuk tabel yang lebarnya melebihi layar HP */
        table {
            width: max-content !important;
            min-width: 600px;
            white-space: nowrap !important;
        }

        footer {
            background-color: #fff;
            border-top: 1px solid #e9ecef;
            padding: 1rem 0;
            margin-top: auto;
        }

        .navbar {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>

    <div class="wrapper">

        <!-- NAVBAR -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="container">
                <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="{{ route('user.index') }}">
                    <i class="fa-solid fa-file-contract"></i> Berita Acara
                </a>
            </div>
        </nav>

        <!-- KONTEN -->
        <main class="container py-4">
            @yield('content')
        </main>

        <!-- FOOTER -->
        <footer class="text-center">
            <div class="container">
                <small class="text-muted">
                    &copy; {{ date('Y') }} Sistem Berita Acara Instalasi Pelanggan
                </small>
            </div>
        </footer>

    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
