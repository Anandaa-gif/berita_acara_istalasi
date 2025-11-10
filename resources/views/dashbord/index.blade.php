<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang - Sistem Berita Acara Instalasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3f37c9;
            --accent: #4cc9f0;
            --light: #f8f9fa;
            --dark: #212529;
            --success: #4bb543;
        }
        
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .welcome-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border: none;
            transition: transform 0.3s ease;
        }
        
        .welcome-card:hover {
            transform: translateY(-5px);
        }
        
        .card-header {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 2rem 1rem;
            text-align: center;
            border-bottom: none;
        }
        
        .welcome-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
            display: block;
        }
        
        .card-body {
            padding: 3rem 2rem;
        }
        
        .lead {
            font-size: 1.2rem;
            color: #555;
            line-height: 1.6;
        }
        
        .feature-list {
            display: flex;
            justify-content: space-around;
            margin: 2rem 0;
            flex-wrap: wrap;
        }
        
        .feature-item {
            text-align: center;
            padding: 1rem;
            flex: 1;
            min-width: 150px;
        }
        
        .feature-icon {
            font-size: 2.5rem;
            color: var(--primary);
            margin-bottom: 0.5rem;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border: none;
            border-radius: 50px;
            padding: 0.8rem 2rem;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
        }
        
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(67, 97, 238, 0.4);
        }
        
        .btn-success {
            background: linear-gradient(135deg, var(--success), #3a9e36);
            border: none;
            border-radius: 50px;
            padding: 0.8rem 2rem;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(75, 181, 67, 0.3);
        }
        
        .btn-success:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(75, 181, 67, 0.4);
        }
        
        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 1.5rem;
            flex-wrap: wrap;
            margin-top: 2rem;
        }
        
        @media (max-width: 768px) {
            .action-buttons {
                flex-direction: column;
                align-items: center;
            }
            
            .action-buttons .btn {
                width: 100%;
                max-width: 250px;
            }
            
            .feature-list {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-md-12">
                <div class="card welcome-card">
                    <div class="card-header">
                        <i class="fas fa-hand-wave welcome-icon"></i>
                        <h1 class="display-4 fw-bold">Selamat Datang</h1>
                    </div>
                    <div class="card-body text-center">
                        <p class="lead mb-4">
                            <strong>Sistem Berita Acara Instalasi</strong><br>
                            Kelola data registrasi, teknisi, dan pelanggan dengan lebih mudah dan efisien.
                        </p>
                        
                        <div class="feature-list">
                            <div class="feature-item">
                                <i class="fas fa-file-alt feature-icon"></i>
                                <h5>Berita Acara</h5>
                                <p class="small">Kelola dokumen instalasi</p>
                            </div>
                            <div class="feature-item">
                                <i class="fas fa-users feature-icon"></i>
                                <h5>Manajemen Teknisi</h5>
                                <p class="small">Atur tim teknisi dengan mudah</p>
                            </div>
                            <div class="feature-item">
                                <i class="fas fa-user-check feature-icon"></i>
                                <h5>Data Pelanggan</h5>
                                <p class="small">Kelola informasi pelanggan</p>
                            </div>
                            <div class="feature-item">
                                <i class="fas fa-chart-line feature-icon"></i>
                                <h5>Laporan</h5>
                                <p class="small">Analisis data instalasi</p>
                            </div>
                        </div>
                        
                        <div class="action-buttons">
                            <a href="{{ url('/berita-acara') }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-list me-2"></i>Lihat Berita Acara
                            </a>
                            <a href="{{ url('/berita-acara/create') }}" class="btn btn-success btn-lg">
                                <i class="fas fa-plus me-2"></i>Tambah Data Baru
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>