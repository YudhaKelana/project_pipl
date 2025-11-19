<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Input Barang Baru</div>
            <div class="card-body">
                <form action="<?= base_url('produk/store') ?>" method="post">
                    <div class="mb-3">
                        <label>Nama Barang</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Kategori</label>
                        <select name="category" class="form-select">
                            <option value="Sembako">Sembako</option>
                            <option value="Minuman">Minuman</option>
                            <option value="Snack">Snack</option>
                            <option value="Rokok">Rokok</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Harga Jual (Rp)</label>
                            <input type="number" name="price" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Stok Awal</label>
                            <input type="number" name="stock" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label>Barcode (Opsional)</label>
                        <input type="text" name="barcode" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-success w-100">Simpan Barang</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>