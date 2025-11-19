<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="row">
    <div class="col-md-7">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Katalog Barang</h5>
            </div>
            <div class="card-body">
                <?php if (session()->getFlashdata('success')) : ?>
                    <div class="alert alert-success"><?= session()->getFlashdata('success'); ?></div>
                <?php endif; ?>
                <?php if (session()->getFlashdata('error')) : ?>
                    <div class="alert alert-danger"><?= session()->getFlashdata('error'); ?></div>
                <?php endif; ?>

                <div class="row">
                    <?php foreach ($products as $p) : ?>
                    <div class="col-md-4 mb-3">
                        <div class="card h-100 border-primary">
                            <div class="card-body text-center d-flex flex-column justify-content-between">
                                <div>
                                    <h6 class="card-title"><?= esc($p['name']); ?></h6>
                                    <p class="card-text text-muted small"><?= esc($p['category']); ?></p>
                                    <h5 class="text-success">Rp <?= number_format($p['price'], 0, ',', '.'); ?></h5>
                                    <small class="text-secondary">Stok: <?= $p['stock']; ?></small>
                                </div>
                                <a href="/pos/add/<?= $p['id']; ?>" class="btn btn-outline-primary btn-sm mt-2 w-100">
                                    + Tambah
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-5">
        <div class="card">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Keranjang Belanja</h5>
                <a href="/pos/clear" class="btn btn-danger btn-sm" onclick="return confirm('Kosongkan keranjang?')">Reset</a>
            </div>
            <div class="card-body">
                <table class="table table-sm table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Item</th>
                            <th>Qty</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $grandTotal = 0;
                        if (!empty($cart)) : 
                            foreach ($cart as $item) : 
                            $grandTotal += $item['subtotal'];
                        ?>
                        <tr>
                            <td><?= esc($item['name']); ?></td>
                            <td><?= $item['qty']; ?></td>
                            <td class="text-end">Rp <?= number_format($item['subtotal'], 0, ',', '.'); ?></td>
                        </tr>
                        <?php endforeach; 
                        else : ?>
                        <tr>
                            <td colspan="3" class="text-center text-muted">Keranjang kosong...</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                    <tfoot class="table-dark">
                        <tr>
                            <td colspan="2"><strong>TOTAL BAYAR</strong></td>
                            <td class="text-end"><strong>Rp <?= number_format($grandTotal, 0, ',', '.'); ?></strong></td>
                        </tr>
                    </tfoot>
                </table>

                <?php if (!empty($cart)) : ?>
                <form action="/pos/process" method="post">
                    <?= csrf_field(); ?>
                    <div class="d-grid gap-2 mt-3">
                        <button type="submit" class="btn btn-success btn-lg block">PROSES TRANSAKSI</button>
                    </div>
                </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>