<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= esc($title) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f0f2f5; font-family: 'Segoe UI', sans-serif; }
        .navbar { background: linear-gradient(to right, #212529, #343a40); }
        .card { border: none; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); }
    </style>
</head>
<body>
    
    <!-- NAVBAR ADMIN -->
    <nav class="navbar navbar-expand-lg navbar-dark mb-4 shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">
                <i class="fas fa-cogs me-2"></i> ADMIN Z&Z
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('product') ?>">Stok Barang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('history') ?>">Riwayat Penjualan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active fw-bold" href="<?= base_url('report') ?>">Laporan Analisis</a>
                    </li>
                </ul>
                <div class="navbar-nav ms-auto">
                    <a class="nav-link btn btn-outline-secondary text-white px-3 me-2 border-0" href="<?= base_url('pos') ?>">
                        <i class="fas fa-cash-register me-1"></i> Ke Kasir
                    </a>
                    <a class="nav-link text-danger fw-bold" href="<?= base_url('logout') ?>">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold text-dark mb-0"><i class="fas fa-chart-line me-2"></i>Dashboard & Analisis</h3>
                <p class="text-muted small mb-0">Pantau omzet dan evaluasi stok barang</p>
            </div>
            <button onclick="window.print()" class="btn btn-outline-dark rounded-pill">
                <i class="fas fa-print me-2"></i>Cetak Laporan
            </button>
        </div>

        <!-- BAGIAN 1: GRAFIK PENJUALAN (OMZET) -->
        <div class="card mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold text-primary"><i class="fas fa-chart-bar me-2"></i>Tren Omzet 2 Minggu Terakhir</h5>
            </div>
            <div class="card-body">
                <!-- Canvas untuk Chart.js -->
                <canvas id="omzetChart" style="max-height: 400px;"></canvas>
            </div>
        </div>

        <!-- BAGIAN 2: TABEL ANALISIS STOK -->
        <div class="card">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold text-success"><i class="fas fa-boxes me-2"></i>Analisis Fast & Slow Moving</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-uppercase small">
                            <tr>
                                <th class="ps-4 py-3">Ranking</th>
                                <th class="py-3">Nama Barang</th>
                                <th class="py-3 text-center">Sisa Stok</th>
                                <th class="py-3 text-center">Total Terjual</th>
                                <th class="py-3 text-center">Status Analisis</th>
                                <th class="pe-4 py-3 text-end">Estimasi Omzet</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $rank = 1; foreach($reports as $r): ?>
                            <tr>
                                <td class="ps-4 fw-bold text-secondary">#<?= $rank++ ?></td>
                                <td class="fw-semibold"><?= esc($r['nama_barang']) ?></td>
                                
                                <td class="text-center">
                                    <?php if($r['stok'] < 5): ?>
                                        <span class="text-danger fw-bold"><?= $r['stok'] ?> (Kritis)</span>
                                    <?php else: ?>
                                        <span class="text-dark"><?= $r['stok'] ?></span>
                                    <?php endif; ?>
                                </td>

                                <td class="text-center fw-bold fs-5">
                                    <?= number_format($r['total_terjual']) ?>
                                </td>

                                <td class="text-center">
                                    <span class="badge bg-<?= $r['badge'] ?> rounded-pill px-3 py-2">
                                        <?= $r['status'] ?>
                                    </span>
                                    <div class="small text-muted mt-1"><?= $r['desc'] ?></div>
                                </td>

                                <td class="pe-4 text-end fw-bold text-success">
                                    Rp <?= number_format($r['total_terjual'] * $r['harga_jual'], 0, ',', '.') ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>

                            <?php if(empty($reports)): ?>
                                <tr><td colspan="6" class="text-center py-5">Belum ada data transaksi.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="mb-5"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- IMPORT CHART.JS DARI CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Ambil data dari Controller (PHP)
        const labels = <?= $chartLabels ?>;
        const dataValues = <?= $chartValues ?>;

        // Konfigurasi Chart
        const ctx = document.getElementById('omzetChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar', // Jenis Grafik: Bar Chart
            data: {
                labels: labels,
                datasets: [{
                    label: 'Omzet Harian (Rp)',
                    data: dataValues,
                    backgroundColor: 'rgba(13, 110, 253, 0.7)', // Warna Biru Bootstrap
                    borderColor: 'rgba(13, 110, 253, 1)',
                    borderWidth: 1,
                    borderRadius: 5
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            // Format Rupiah di sumbu Y
                            callback: function(value) {
                                return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                            }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(context.parsed.y);
                                }
                                return label;
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>