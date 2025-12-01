<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= esc($title) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { background-color: #f0f2f5; font-family: 'Segoe UI', sans-serif; }
        .navbar { background: linear-gradient(to right, #212529, #343a40); }
        .card { border: none; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); }
        .stat-card { 
            padding: 20px; 
            border-left: 5px solid #007bff; 
            background: white;
            margin-bottom: 20px;
        }
        .stat-card.modal { border-left-color: #28a745; }
        .stat-card.pengeluaran { border-left-color: #ffc107; }
        .stat-card.pemasukan { border-left-color: #17a2b8; }
        .stat-card h5 { color: #666; font-size: 14px; font-weight: 600; }
        .stat-card .amount { font-size: 24px; font-weight: bold; color: #333; margin-top: 10px; }
        .chart-container { position: relative; height: 400px; margin-bottom: 30px; }
        .table-responsive { border-radius: 8px; overflow: hidden; }
    </style>
</head>
<body>
    
    <!-- NAVBAR ADMIN -->
    <nav class="navbar navbar-expand-lg navbar-dark mb-4 shadow-sm">
        <div class="container-fluid">
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
                        <a class="nav-link active fw-bold" href="<?= base_url('cash') ?>">Manajemen Kas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('report') ?>">Laporan Analisis</a>
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

    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold text-dark mb-0"><i class="fas fa-money-bill-wave me-2"></i>Manajemen Kas</h3>
                <small class="text-muted">Pantau aliran kas masuk, keluar, dan modal bisnis</small>
            </div>
        </div>

        <!-- SUMMARY CARDS -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="stat-card modal">
                    <h5><i class="fas fa-cubes me-2"></i>Total Modal</h5>
                    <div class="amount">Rp <?= number_format($totalModal, 0, ',', '.') ?></div>
                    <small class="text-muted">20% dari total penjualan</small>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card pengeluaran">
                    <h5><i class="fas fa-arrow-down me-2"></i>Total Pengeluaran</h5>
                    <div class="amount">Rp <?= number_format($totalPengeluaran, 0, ',', '.') ?></div>
                    <small class="text-muted">Rekapan dari modal</small>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card pemasukan">
                    <h5><i class="fas fa-arrow-up me-2"></i>Total Pemasukan</h5>
                    <div class="amount">Rp <?= number_format($totalPemasukan, 0, ',', '.') ?></div>
                    <small class="text-muted">Penjualan - Modal</small>
                </div>
            </div>
        </div>

        <!-- CHART -->
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title fw-bold mb-3"><i class="fas fa-chart-bar me-2"></i>Grafik Aliran Kas</h5>
                <div class="chart-container">
                    <canvas id="cashFlowChart"></canvas>
                </div>
            </div>
        </div>

        <!-- DETAIL TABLE -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-bold mb-3"><i class="fas fa-table me-2"></i>Detail Kas Bulanan</h5>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Bulan</th>
                                <th class="text-end">Modal</th>
                                <th class="text-end">Pengeluaran</th>
                                <th class="text-end">Pemasukan</th>
                                <th class="text-end">Saldo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach (array_reverse($cashFlows) as $flow): 
                                $saldo = $flow['total_pemasukan'] - $flow['total_pengeluaran'];
                                $badgeClass = $saldo >= 0 ? 'bg-success' : 'bg-danger';
                            ?>
                            <tr>
                                <td><?= date('F Y', strtotime($flow['bulan'] . '-01')) ?></td>
                                <td class="text-end">Rp <?= number_format($flow['total_modal'], 0, ',', '.') ?></td>
                                <td class="text-end">Rp <?= number_format($flow['total_pengeluaran'], 0, ',', '.') ?></td>
                                <td class="text-end">Rp <?= number_format($flow['total_pemasukan'], 0, ',', '.') ?></td>
                                <td class="text-end">
                                    <span class="badge <?= $badgeClass ?>">
                                        Rp <?= number_format($saldo, 0, ',', '.') ?>
                                    </span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <!-- SCRIPT CHART.JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Data dari PHP
        const months = <?= $months ?>;
        const modals = <?= json_encode(array_map(function($v) { return (float)$v; }, json_decode($modals, true))); ?>;
        const pengeluaran = <?= json_encode(array_map(function($v) { return (float)$v; }, json_decode($pengeluaran, true))); ?>;
        const pemasukan = <?= json_encode(array_map(function($v) { return (float)$v; }, json_decode($pemasukan, true))); ?>;

        const ctx = document.getElementById('cashFlowChart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: months,
                datasets: [
                    {
                        label: 'Modal',
                        data: modals,
                        borderColor: '#28a745',
                        backgroundColor: 'rgba(40, 167, 69, 0.1)',
                        borderWidth: 2,
                        tension: 0.4,
                        fill: false
                    },
                    {
                        label: 'Pengeluaran',
                        data: pengeluaran,
                        borderColor: '#ffc107',
                        backgroundColor: 'rgba(255, 193, 7, 0.1)',
                        borderWidth: 2,
                        tension: 0.4,
                        fill: false
                    },
                    {
                        label: 'Pemasukan',
                        data: pemasukan,
                        borderColor: '#17a2b8',
                        backgroundColor: 'rgba(23, 162, 184, 0.1)',
                        borderWidth: 2,
                        tension: 0.4,
                        fill: false
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
