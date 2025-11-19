<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-warning text-dark">
                <h4>Edit Produk</h4>
            </div>
            <div class="card-body">
                <form action="/products/update/<?= $product['id']; ?>" method="post">
                    <?= csrf_field(); ?>
                    
                    <div class="mb-3">
                        <label>Nama Barang</label>
                        <input type="text" name="name" class="form-control" required 
                               value="<?= esc($product['name']); ?>">
                    </div>

                    <div class="mb-3">
                        <label>Kategori</label>
                        <select name="category" class="form-select">
                            <option value="Sembako" <?= $product['category'] == 'Sembako' ? 'selected' : ''; ?>>Sembako</option>
                            <option value="Minuman" <?= $product['category'] == 'Minuman' ? 'selected' : ''; ?>>Minuman</option>
                            <option value="Makanan Ringan" <?= $product['category'] == 'Makanan Ringan' ? 'selected' : ''; ?>>Makanan Ringan</option>
                            <option value="Kebersihan" <?= $product['category'] == 'Kebersihan' ? 'selected' : ''; ?>>Kebersihan</option>
                            <option value="Lainnya" <?= $product['category'] == 'Lainnya' ? 'selected' : ''; ?>>Lainnya</option>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Harga Jual (Rp)</label>
                            <input type="number" name="price" class="form-control" required 
                                   value="<?= esc($product['price']); ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Stok Saat Ini</label>
                            <input type="number" name="stock" class="form-control" required 
                                   value="<?= esc($product['stock']); ?>">
                            <small class="text-muted">Ubah angka ini untuk menambah/mengurangi stok.</small>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Update Data</button>
                    <a href="/products" class="btn btn-link w-100 mt-2">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>