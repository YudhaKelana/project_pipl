<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="row mb-4">
    <div class="col-12">
        <h3>Selamat Datang, <?= session()->get('username') ?>!</h3>
        <p class="text-muted">Berikut ringkasan performa Warung Z&Z hari ini.</p>
    </div>
</div>

<div class="row">
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-primary h-100">
            <div class="card-body">
                <h5 class="card-title">Omset Hari Ini</h5>
                <h2>Rp <?= number_format($omset_hari_ini ?? 0, 0, ',', '.') ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-success h-100">
            <div class="card-body">
                <h5 class="card-title">Transaksi</h5>
                <h2><?= $penjualan_hari_ini ?? 0 ?> <small class="fs-6">Struk</small></h2>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-warning h-100">
            <div class="card-body">
                <h5 class="card-title">Total Produk</h5>
                <h2><?= $total_produk ?? 0 ?> <small class="fs-6">Item</small></h2>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-danger h-100">
            <div class="card-body">
                <h5 class="card-title">Stok Menipis</h5>
                <h2><?= $stok_tipis ?? 0 ?> <small class="fs-6">Item</small></h2>
                <small>Segera restock!</small>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Aksi Cepat</div>
            <div class="card-body d-grid gap-2">
                <a href="<?= base_url('kasir') ?>" class="btn btn-lg btn-outline-primary">Buka Mesin Kasir</a>
                <a href="<?= base_url('produk/create') ?>" class="btn btn-lg btn-outline-success">Tambah Barang Baru</a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>