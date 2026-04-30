<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container">
    <a href="/history" class="btn btn-secondary mb-3">&laquo; Kembali ke Riwayat</a>
    
    <div class="card shadow-sm" style="max-width: 600px; margin: 0 auto;">
        <div class="card-body">
            <div class="text-center mb-4">
                <h3>Warung Z&Z</h3>
                <p class="text-muted mb-1">Jl. Raya Sembako No. 123, Tanjungpinang</p>
                <small class="text-muted">Telp: 0812-3456-7890</small>
            </div>
            
            <hr class="border-dashed">

            <div class="row mb-3">
                <div class="col-6">
                    <small class="text-muted">No Invoice:</small><br>
                    <strong><?= $trx['invoice_no']; ?></strong>
                </div>
                <div class="col-6 text-end">
                    <small class="text-muted">Tanggal:</small><br>
                    <span><?= date('d M Y, H:i', strtotime($trx['created_at'])); ?></span>
                </div>
            </div>

            <table class="table table-sm table-borderless">
                <thead class="border-bottom">
                    <tr>
                        <th>Item</th>
                        <th class="text-center">Qty</th>
                        <th class="text-end">Harga</th>
                        <th class="text-end">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item) : ?>
                    <tr>
                        <td><?= esc($item['product_name']); ?></td>
                        <td class="text-center"><?= $item['quantity']; ?></td>
                        <td class="text-end"><?= number_format($item['price'], 0, ',', '.'); ?></td>
                        <td class="text-end"><?= number_format($item['subtotal'], 0, ',', '.'); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot class="border-top mt-2">
                    <tr>
                        <td colspan="3" class="text-end fw-bold pt-3">TOTAL BAYAR</td>
                        <td class="text-end fw-bold pt-3 fs-5">Rp <?= number_format($trx['total_amount'], 0, ',', '.'); ?></td>
                    </tr>
                </tfoot>
            </table>

            <div class="mt-4 text-center">
                <p class="small text-muted">Terima kasih telah berbelanja di Warung Z&Z!</p>
                
                <button onclick="window.print()" class="btn btn-outline-primary d-print-none">
                    🖨️ Cetak Struk
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        /* Sembunyikan elemen lain saat ngeprint (Navbar, tombol, dll) */
        nav, .btn, footer { display: none !important; }
        body { background-color: white; }
        .card { border: none !important; box-shadow: none !important; }
    }
</style>

<?= $this->endSection(); ?>