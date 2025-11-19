<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<h3>Manajemen Stok Barang</h3>

<a href="<?= base_url('produk/create') ?>" class="btn btn-primary mb-3">
    <i class="bi bi-plus-circle"></i> Tambah Barang Baru
</a>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($products)): ?>
                        <tr>
                            <td colspan="5" class="text-center">Belum ada data barang. Silakan tambah baru.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($products as $p): ?>
                        <tr>
                            <td><?= $p['name'] ?></td>
                            <td><span class="badge bg-secondary"><?= $p['category'] ?></span></td>
                            <td>Rp <?= number_format($p['price'],0,',','.') ?></td>
                            
                            <td class="<?= $p['stock'] < 10 ? 'text-danger fw-bold' : '' ?>">
                                <?= $p['stock'] ?>
                            </td>
                            <td>
                                <a href="<?= base_url('produk/edit/'.$p['id']) ?>" class="btn btn-sm btn-warning me-1">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <a href="<?= base_url('produk/delete/'.$p['id']) ?>" 
                                onclick="return confirm('Yakin hapus <?= $p['name'] ?>?')" 
                                class="btn btn-sm btn-danger">
                                <i class="bi bi-trash"></i> Hapus
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>