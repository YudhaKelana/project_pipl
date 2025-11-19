<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="card">
    <div class="card-header bg-info text-white">
        <h4 class="mb-0">Laporan Barang Fast-Moving/Slow-Moving</h4>
    </div>
    <div class="card-body">
        <div class="alert alert-light border">
            <strong>Keterangan:</strong><br>
            <span class="badge bg-success">Fast-Moving</span> : Barang sangat laku (Terjual > 5 pcs)<br>
            <span class="badge bg-warning text-dark">Slow-Moving</span> : Barang kurang laku (Terjual <= 5 pcs)
        </div>

        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Peringkat</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Total Terjual</th>
                    <th>Status Analisis</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($sales_data)): ?>
                    <tr><td colspan="5" class="text-center">Belum ada data transaksi penjualan.</td></tr>
                <?php else: ?>
                    <?php $i = 1; foreach ($sales_data as $row) : ?>
                    <tr>
                        <td>#<?= $i++; ?></td>
                        <td><?= esc($row['name']); ?></td>
                        <td><?= esc($row['category']); ?></td>
                        <td class="fw-bold"><?= $row['total_sold']; ?> pcs</td>
                        <td>
                            <?php if($row['total_sold'] > 5): ?>
                                <span class="badge bg-success">FAST MOVING</span>
                            <?php else: ?>
                                <span class="badge bg-warning text-dark">SLOW MOVING</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection(); ?>