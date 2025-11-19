<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="card">
    <div class="card-header bg-secondary text-white">
        <h4 class="mb-0">Riwayat Transaksi Penjualan</h4>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>No. Invoice</th>
                    <th>Tanggal & Jam</th>
                    <th>Total Belanja</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($transactions)): ?>
                    <tr><td colspan="5" class="text-center">Belum ada riwayat transaksi.</td></tr>
                <?php else: ?>
                    <?php $i = 1; foreach ($transactions as $t) : ?>
                    <tr>
                        <td><?= $i++; ?></td>
                        <td><span class="badge bg-dark"><?= esc($t['invoice_no']); ?></span></td>
                        <td><?= date('d M Y, H:i', strtotime($t['created_at'])); ?> WIB</td>
                        <td class="fw-bold">Rp <?= number_format($t['total_amount'], 0, ',', '.'); ?></td>
                        <td>
                            <a href="/history/<?= $t['id']; ?>" class="btn btn-primary btn-sm">
                                Lihat Invoice
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection(); ?>