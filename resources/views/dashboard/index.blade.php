@extends('layout.index')

@section('content')
    <style>
        :root {
            --primary: #0d6efd;
            --success: #20c997;
            --light: #f8f9fa;
            --white: #ffffff;
            --dark: #212529;
            --gray: #6c757d;
            --border: #dee2e6;
            --shadow: 0 8px 32px rgba(13, 110, 253, 0.12);
            --glass: rgba(255, 255, 255, 0.85);
        }

        .dashboard-container {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .page-title {
            background: linear-gradient(135deg, var(--primary), var(--success));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 800;
            font-size: 2rem;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .stat-card {
            background: var(--glass);
            backdrop-filter: blur(12px);
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: var(--shadow);
            padding: 1.5rem;
            transition: all 0.3s ease;
            text-align: center;
            height: 100%;
        }

        .stat-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 16px 40px rgba(13, 110, 253, 0.2);
        }

        .stat-card h6 {
            color: var(--gray);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 1px;
            margin-bottom: 0.75rem;
        }

        .stat-card h2 {
            background: linear-gradient(135deg, var(--primary), var(--success));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 800;
            font-size: 2.5rem;
            margin: 0;
        }

        .chart-card,
        .table-card {
            background: var(--glass);
            backdrop-filter: blur(12px);
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: var(--shadow);
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .chart-card:hover,
        .table-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 16px 40px rgba(13, 110, 253, 0.2);
        }

        .card-title {
            color: var(--dark);
            font-weight: 700;
            font-size: 1.2rem;
            margin-bottom: 1rem;
            text-align: center;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid var(--success);
            display: inline-block;
            left: 50%;
            transform: translateX(-50%);
            position: relative;
        }

        .table-elegant {
            margin-bottom: 0;
            font-size: 0.95rem;
        }

        .table-elegant thead {
            background: linear-gradient(135deg, var(--primary), var(--success));
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
        }

        .table-elegant thead th {
            border: none;
            padding: 1rem;
            text-align: center;
        }

        .table-elegant tbody td {
            padding: 1rem;
            text-align: center;
            vertical-align: middle;
            border-color: rgba(0, 0, 0, 0.05);
        }

        .table-elegant tbody tr:hover {
            background-color: rgba(13, 110, 253, 0.05);
        }

        .empty-row {
            color: var(--gray);
            font-style: italic;
            padding: 2rem;
            background: rgba(248, 249, 250, 0.6);
        }

        .chart-container {
            position: relative;
            height: 350px;
            padding: 1rem;
        }

        @media (max-width: 768px) {
            .page-title {
                font-size: 1.6rem;
            }

            .stat-card h2 {
                font-size: 2rem;
            }

            .chart-container {
                height: 280px;
            }
        }
    </style>

    <div class="container dashboard-container mt-4 mt-md-5">

        <!-- Judul Dashboard -->
        <h2 class="page-title">Dashboard Pemasangan</h2>

        <!-- Statistik Kartu -->
        <div class="row mb-4 g-4">
            <div class="col-md-6">
                <div class="stat-card">
                    <h6>Total Semua Pemasangan</h6>
                    <h2>{{ $total_semua }}</h2>
                </div>
            </div>
            <div class="col-md-6">
                <div class="stat-card">
                    <h6>Pemasangan Bulan Ini ({{ \Carbon\Carbon::now()->translatedFormat('F Y') }})</h6>
                    <h2>{{ $total_bulan_ini }}</h2>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Grafik Kiri -->
            <div class="col-md-6 mb-4">
                <div class="chart-card h-100">
                    <div class="card-body p-4">
                        <h5 class="card-title">
                            <i class="fas fa-chart-line me-2"></i> Grafik Pemasangan Per Bulan
                        </h5>
                        <div class="chart-container">
                            <canvas id="chartPemasangan"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Riwayat Login Kanan -->
            <div class="col-md-6 mb-4">
                <div class="table-card h-100">
                    <div class="card-body p-4">
                        <h5 class="card-title">
                            <i class="fas fa-clock-rotate-left me-2"></i> Riwayat Login Terakhir
                        </h5>
                        <div class="table-responsive" style="max-height: 320px; overflow-y: auto;">
                            <table class="table table-elegant mb-0">
                                <thead>
                                    <tr>
                                        <th>Nama Pengguna</th>
                                        <th>Email</th>
                                        <th>Waktu Login</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($riwayat_login as $log)
                                        <tr>
                                            <td class="fw-medium">{{ $log->user->name ?? '-' }}</td>
                                            <td>{{ $log->email }}</td>
                                            <td>{{ \Carbon\Carbon::parse($log->login_time)->translatedFormat('d F Y H:i') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center text-muted">
                                                <i class="fas fa-info-circle me-2"></i> Belum ada data login pengguna
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Teknisi Teraktif -->
        <div class="table-card mb-4">
            <div class="card-body p-4">
                <h5 class="card-title">
                    <i class="fas fa-medal me-2"></i> Daftar Teknisi Bulan Ini
                </h5>
                <div class="table-responsive">
                    <table class="table table-elegant">
                        <thead>
                            <tr>
                                <th>Nama Teknisi</th>
                                <th>Total Pemasangan Bulan Ini</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($teknisi_teraktif as $nama => $jumlah)
                                <tr>
                                    <td class="fw-medium">{{ $nama }}</td>
                                    <td>
                                        <span class="badge bg-success rounded-pill px-3 py-2">
                                            {{ $jumlah }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="empty-row text-center">
                                        <i class="fas fa-info-circle me-2"></i>
                                        Belum ada pemasangan bulan ini
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js + Font Awesome (DIPINDAH KE ATAS SCRIPT) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Pastikan DOM sudah siap
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('chartPemasangan');
            if (!ctx) {
                console.error('Canvas dengan ID chartPemasangan tidak ditemukan!');
                return;
            }

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($bulan_labels ?? []) !!},
                    datasets: [{
                        label: 'Jumlah Pemasangan',
                        data: {!! json_encode($bulan_values ?? []) !!},
                        backgroundColor: 'rgba(13, 110, 253, 0.7)',
                        borderColor: '#0d6efd',
                        borderWidth: 2,
                        borderRadius: 8,
                        borderSkipped: false,
                        barThickness: 30,
                        maxBarThickness: 40,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: 'rgba(13, 110, 253, 0.9)',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            cornerRadius: 8,
                            displayColors: false,
                            padding: 12,
                            titleFont: { weight: 'bold' },
                            callbacks: {
                                label: function(context) {
                                    return ` ${context.parsed.y} pemasangan`;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: { color: '#495057', font: { weight: 600 } }
                        },
                        y: {
                            beginAtZero: true,
                            grid: { color: 'rgba(0, 0, 0, 0.05)', drawBorder: false },
                            ticks: { color: '#495057', stepSize: 1, padding: 10 }
                        }
                    },
                    animation: {
                        duration: 1800,
                        easing: 'easeOutQuart'
                    }
                }
            });
        });
    </script>
@endsection