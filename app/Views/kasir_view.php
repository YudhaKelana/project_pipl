<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<?php if(session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Berhasil!</strong> <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if(session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Gagal!</strong> <?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="row">
    <div class="col-md-7 mb-3">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">Daftar Barang</div>
            <div class="card-body">
                <div class="row">
                    <?php if(empty($products)): ?>
                        <div class="col-12 text-center text-muted">
                            <p>Belum ada barang di stok.</p>
                            <a href="<?= base_url('produk/create') ?>" class="btn btn-sm btn-outline-primary">Input Barang Dulu</a>
                        </div>
                    <?php else: ?>
                        <?php foreach($products as $p): ?>
                        <div class="col-6 col-sm-4 col-md-4 mb-3">
                            <div class="card h-100 border-primary">
                                <div class="card-body text-center p-2">
                                    <h6 class="card-title text-truncate"><?= $p['name'] ?></h6>
                                    <p class="card-text text-success fw-bold small">Rp <?= number_format($p['price'],0,',','.') ?></p>
                                    <small class="text-muted d-block mb-2">Stok: <?= $p['stock'] ?></small>
                                    
                                    <form action="<?= base_url('kasir/add') ?>" method="post">
                                        <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
                                        <button type="submit" class="btn btn-sm btn-primary w-100" <?= $p['stock'] <= 0 ? 'disabled' : '' ?>>
                                            <?= $p['stock'] > 0 ? '+ Keranjang' : 'Habis' ?>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-5">
        <div class="card shadow">
            <div class="card-header bg-dark text-white">
                <i class="bi bi-cart-fill"></i> Keranjang Belanja
            </div>
            <div class="card-body">
                <table class="table table-sm table-striped">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Qty</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $grand_total = 0;
                        if(empty($cart)): 
                        ?>
                            <tr><td colspan="3" class="text-center text-muted">Keranjang Kosong</td></tr>
                        <?php else: ?>
                            <?php foreach($cart as $item): 
                                $subtotal = $item['price'] * $item['qty'];
                                $grand_total += $subtotal;
                            ?>
                            <tr>
                                <td><?= $item['name'] ?></td>
                                <td><?= $item['qty'] ?></td>
                                <td>Rp <?= number_format($subtotal, 0, ',', '.') ?></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                    <tfoot>
                        <tr class="fw-bold fs-5">
                            <td colspan="2">TOTAL</td>
                            <td>Rp <?= number_format($grand_total, 0, ',', '.') ?></td>
                        </tr>
                    </tfoot>
                </table>

                <div class="d-grid gap-2 mt-3">
                    <?php if(!empty($cart)): ?>
                        <a href="<?= base_url('kasir/checkout') ?>" class="btn btn-success btn-lg">BAYAR SEKARANG</a>
                        <a href="<?= base_url('kasir/clear') ?>" class="btn btn-outline-danger btn-sm">Reset Keranjang</a>
                    <?php else: ?>
                        <button class="btn btn-secondary btn-lg" disabled>BAYAR SEKARANG</button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>