<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0">Edit Barang: <?= $product['name'] ?></h5>
            </div>
            <div class="card-body">
                <form action="<?= base_url('produk/update/' . $product['id']) ?>" method="post">
                    
                    <div class="mb-3">
                        <label>Nama Barang</label>
                        <input type="text" name="name" class="form-control" value="<?= $product['name'] ?>" required>
                    </div>

                    <div class="mb-3">
                        <label>Kategori</label>
                        <select name="category" class="form-select">
                            <option value="Sembako" <?= $product['category'] == 'Sembako' ? 'selected' : '' ?>>Sembako</option>
                            <option value="Minuman" <?= $product['category'] == 'Minuman' ? 'selected' : '' ?>>Minuman</option>
                            <option value="Snack" <?= $product['category'] == 'Snack' ? 'selected' : '' ?>>Snack</option>
                            <option value="Rokok" <?= $product['category'] == 'Rokok' ? 'selected' : '' ?>>Rokok</option>
                            <option value="Lainnya" <?= $product['category'] == 'Lainnya' ? 'selected' : '' ?>>Lainnya</option>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Harga Jual (Rp)</label>
                            <input type="number" name="price" class="form-control" value="<?= $product['price'] ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Stok Saat Ini</label>
                            <input type="number" name="stock" class="form-control" value="<?= $product['stock'] ?>" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>Barcode (Opsional)</label>
                        <input type="text" name="barcode" class="form-control" value="<?= $product['barcode'] ?>">
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="<?= base_url('produk') ?>" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-warning">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>