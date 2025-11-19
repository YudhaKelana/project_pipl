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
        .nav-link.active { border-bottom: 2px solid #fff; }
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
                        <a class="nav-link" href="<?= base_url('product') ?>">
                            <i class="fas fa-boxes me-1"></i> Stok Barang
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active fw-bold" href="<?= base_url('history') ?>">
                            <i class="fas fa-history me-1"></i> Riwayat Penjualan
                        </a>
                    </li>
                    <!-- MENU BARU: LAPORAN -->
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('report') ?>">
                            <i class="fas fa-chart-line me-1"></i> Laporan Analisis
                        </a>
                    </li>
                </ul>
                <div class="navbar-nav ms-auto">
                    <a class="nav-link btn btn-outline-secondary text-white px-3 me-2 border-0" href="<?= base_url('pos') ?>">
                        <i class="fas fa-cash-register me-1"></i> Ke Kasir
                    </a>
                    <a class="nav-link text-danger fw-bold" href="<?= base_url('logout') ?>">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container">
        <h3 class="fw-bold text-dark mb-4"><i class="fas fa-history me-2"></i>Riwayat Penjualan</h3>

        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4 py-3">No</th>
                                <th class="py-3">No Faktur</th>
                                <th class="py-3">Tanggal & Jam</th>
                                <th class="py-3">Total Belanja</th>
                                <th class="pe-4 py-3 text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach($transactions as $t): ?>
                            <tr>
                                <td class="ps-4"><?= $no++ ?></td>
                                <td class="fw-bold text-primary"><?= $t['no_faktur'] ?></td>
                                <td>
                                    <i class="far fa-calendar-alt me-1 text-muted"></i> <?= date('d M Y', strtotime($t['tanggal'])) ?>
                                    <small class="text-muted ms-2"><?= date('H:i', strtotime($t['tanggal'])) ?></small>
                                </td>
                                <td class="fw-bold text-success">Rp <?= number_format($t['total_bayar'], 0, ',', '.') ?></td>
                                <td class="pe-4 text-end">
                                    <a href="<?= base_url('history/detail/' . $t['id']) ?>" class="btn btn-sm btn-info text-white rounded-pill px-3">
                                        <i class="fas fa-eye me-1"></i> Detail
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            
                            <?php if(empty($transactions)): ?>
                                <tr><td colspan="5" class="text-center py-5 text-muted">Belum ada riwayat transaksi.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>