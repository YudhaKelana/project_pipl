<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Daftar Stok Barang</h3>
    
    <?php if (session()->get('role') == 'admin') : ?>
        <a href="/products/create" class="btn btn-success">+ Tambah Barang</a>
    <?php endif; ?>
    
</div>

<?php if (session()->getFlashdata('message')) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('message'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')) : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('error'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card">
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead class="table-dark"> <tr>
                    <th>No</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th style="width: 15%;">Aksi</th> </tr>
            </thead>
            <tbody>
                <?php if(empty($products)): ?>
                    <tr><td colspan="6" class="text-center">Belum ada data barang.</td></tr>
                <?php else: ?>
                    <?php $i = 1; foreach ($products as $p) : ?>
                    <tr>
                        <td><?= $i++; ?></td>
                        <td><?= esc($p['name']); ?></td>
                        <td><?= esc($p['category']); ?></td>
                        <td>Rp <?= number_format($p['price'], 0, ',', '.'); ?></td>
                        <td>
                            <span class="badge <?= $p['stock'] < 10 ? 'bg-danger' : 'bg-info'; ?>">
                                <?= $p['stock']; ?>
                            </span>
                        </td>
                        <td>
                            <div class="d-flex gap-2"> <a href="/products/edit/<?= $p['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                
                                <?php if(session()->get('role') == 'admin'): ?>
                                    <a href="/products/delete/<?= $p['id']; ?>" class="btn btn-danger btn-sm" 
                                       onclick="return confirm('Yakin ingin menghapus?')">
                                       Hapus
                                    </a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection(); ?>