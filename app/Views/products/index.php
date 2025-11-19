<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f0f2f5; font-family: 'Segoe UI', sans-serif; }
        .card { border: none; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); }
        .btn-icon { width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center; border-radius: 50%; }
        .table-hover tbody tr:hover { background-color: #f8f9fa; }
        .navbar { background: linear-gradient(to right, #212529, #343a40); }
        .nav-link.active { border-bottom: 2px solid #fff; } /* Highlight menu aktif */
    </style>
</head>
<body>
    
    <!-- NAVBAR ADMIN UPDATED -->
    <nav class="navbar navbar-expand-lg navbar-dark mb-4 shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">
                <i class="fas fa-cogs me-2"></i> ADMIN Z&Z
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- MENU KIRI -->
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active fw-bold" href="<?= base_url('product') ?>">
                            <i class="fas fa-boxes me-1"></i> Stok Barang
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('history') ?>">
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

                <!-- MENU KANAN -->
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
        
        <!-- Header & Tombol Tambah -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold text-dark mb-0">Manajemen Stok</h3>
                <p class="text-muted small mb-0">Kelola data barang dagangan Warung Z&Z</p>
            </div>
            <a href="<?= base_url('product/create') ?>" class="btn btn-primary rounded-pill px-4 shadow-sm">
                <i class="fas fa-plus-circle me-2"></i>Tambah Barang
            </a>
        </div>

        <!-- Notifikasi Sukses -->
        <?php if(session()->getFlashdata('success')): ?>
            <div class="alert alert-success border-0 shadow-sm d-flex align-items-center mb-4">
                <i class="fas fa-check-circle fa-lg me-3"></i>
                <div><?= session()->getFlashdata('success') ?></div>
            </div>
        <?php endif; ?>

        <!-- Tabel Data -->
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-muted small text-uppercase">
                            <tr>
                                <th class="ps-4 py-3">No</th>
                                <th class="py-3">Nama Barang</th>
                                <th class="py-3">Harga Beli</th>
                                <th class="py-3">Harga Jual</th>
                                <th class="py-3 text-center">Stok</th>
                                <th class="pe-4 py-3 text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $nomor = 1; 
                                foreach($products as $p): 
                            ?>
                            <tr>
                                <td class="ps-4 fw-bold text-secondary"><?= $nomor++ ?></td>
                                <td class="fw-semibold text-dark"><?= esc($p['nama_barang']) ?></td>
                                <td class="text-muted">Rp <?= number_format($p['harga_beli'], 0, ',', '.') ?></td>
                                <td class="text-success fw-bold">Rp <?= number_format($p['harga_jual'], 0, ',', '.') ?></td>
                                <td class="text-center">
                                    <?php if($p['stok'] < 5): ?>
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-3">
                                            <i class="fas fa-exclamation-circle me-1"></i> <?= $p['stok'] ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3">
                                            <?= $p['stok'] ?>
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="pe-4 text-end">
                                    <a href="<?= base_url('product/edit/' . $p['id']) ?>" class="btn btn-icon btn-outline-warning btn-sm me-1" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?= base_url('product/delete/' . $p['id']) ?>" class="btn btn-icon btn-outline-danger btn-sm" onclick="return confirm('Yakin ingin menghapus <?= esc($p['nama_barang']) ?>?')" title="Hapus">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>

                            <?php if(empty($products)): ?>
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="text-muted mb-2"><i class="fas fa-box-open fa-3x"></i></div>
                                        <p class="text-muted">Belum ada data barang.</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="mb-5"></div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>