<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-white">
                <h4>Tambah Barang Baru</h4>
            </div>
            <div class="card-body">
                <form action="/products/store" method="post">
                    <?= csrf_field(); ?>
                    
                    <div class="mb-3">
                        <label>Nama Barang</label>
                        <input type="text" name="name" class="form-control" required placeholder="Contoh: Beras 5kg">
                    </div>

                    <div class="mb-3">
                        <label>Kategori</label>
                        <select name="category" class="form-select">
                            <option value="Sembako">Sembako</option>
                            <option value="Minuman">Minuman</option>
                            <option value="Makanan Ringan">Makanan Ringan</option>
                            <option value="Kebersihan">Kebersihan</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Harga Jual (Rp)</label>
                            <input type="number" name="price" class="form-control" required placeholder="15000">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Stok Awal</label>
                            <input type="number" name="stock" class="form-control" required placeholder="10">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Simpan Data</button>
                    <a href="/products" class="btn btn-link w-100 mt-2">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>