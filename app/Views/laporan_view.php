<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<h3 class="mb-4">Laporan Analisis Penjualan</h3>

<div class="row">
    <div class="col-md-6">
        <div class="card border-success mb-3">
            <div class="card-header bg-success text-white">
                <i class="bi bi-lightning-charge-fill"></i> Produk Fast-Moving (Terlaris)
            </div>
            <div class="card-body">
                <p class="card-text">Produk ini paling cepat habis. Pastikan stok selalu aman.</p>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Terjual</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($fast_moving as $row): ?>
                        <tr>
                            <td><?= $row['name'] ?></td>
                            <td class="fw-bold"><?= $row['total_sold'] ?> pcs</td>
                            <td><span class="badge bg-success">Sangat Laku</span></td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if(empty($fast_moving)): ?>
                            <tr><td colspan="3" class="text-center">Belum ada data transaksi</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card border-danger mb-3">
            <div class="card-header bg-danger text-white">
                <i class="bi bi-hourglass-bottom"></i> Produk Slow-Moving (Kurang Laku)
            </div>
            <div class="card-body">
                <p class="card-text">Produk ini jarang dibeli. Pertimbangkan diskon atau stop restock.</p>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Terjual</th>
                            <th>Sisa Stok</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($slow_moving as $row): ?>
                        <tr>
                            <td><?= $row['name'] ?></td>
                            <td><?= $row['total_sold'] ?> pcs</td>
                            <td class="text-danger"><?= $row['stock'] ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="alert alert-info mt-3">
    <strong>Rekomendasi Sistem:</strong>
    <ul>
        <li>Tingkatkan stok untuk barang di tabel kiri (Hijau).</li>
        <li>Buat promo bundling untuk barang di tabel kanan (Merah) agar stok keluar.</li>
    </ul>
</div>

<?= $this->endSection() ?>