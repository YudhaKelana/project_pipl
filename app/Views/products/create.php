<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= esc($title) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f0f2f5; font-family: 'Segoe UI', sans-serif; }
        .card { border: none; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); }
        .form-control:focus { border-color: #0d6efd; box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15); }
        .header-gradient { background: linear-gradient(135deg, #0d6efd, #0043a8); color: white; border-radius: 15px 15px 0 0; padding: 20px; }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                
                <div class="card">
                    <!-- Header Gradasi Biru -->
                    <div class="header-gradient text-center">
                        <h4 class="mb-0 fw-bold"><i class="fas fa-box-open me-2"></i>Tambah Barang</h4>
                    </div>
                    
                    <div class="card-body p-4">
                        
                        <!-- Error Alert jika ada input yang salah/kurang -->
                        <?php if (session()->getFlashdata('errors')) : ?>
                            <div class="alert alert-danger border-0 bg-danger-subtle text-danger shadow-sm">
                                <ul class="mb-0 ps-3">
                                <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach ?>
                                </ul>
                            </div>
                        <?php endif ?>

                        <form action="<?= base_url('product/store') ?>" method="post">
                            <?= csrf_field() ?>
                            
                            <!-- INPUT NAMA BARANG -->
                            <div class="mb-3">
                                <label class="form-label fw-bold text-secondary small">NAMA BARANG</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-tag text-muted"></i></span>
                                    <input type="text" name="nama_barang" class="form-control border-start-0 ps-0" placeholder="Contoh: Indomie Goreng" value="<?= old('nama_barang') ?>" required autofocus>
                                </div>
                            </div>
                            
                            <div class="row">
                                <!-- INPUT HARGA BELI -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold text-secondary small">HARGA BELI</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">Rp</span>
                                        <input type="number" name="harga_beli" class="form-control border-start-0 ps-0" placeholder="0" value="<?= old('harga_beli') ?>" required>
                                    </div>
                                </div>
                                <!-- INPUT HARGA JUAL -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold text-secondary small">HARGA JUAL</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">Rp</span>
                                        <input type="number" name="harga_jual" class="form-control border-start-0 ps-0" placeholder="0" value="<?= old('harga_jual') ?>" required>
                                    </div>
                                </div>
                            </div>

                            <!-- INPUT STOK -->
                            <div class="mb-4">
                                <label class="form-label fw-bold text-secondary small">STOK AWAL</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-cubes text-muted"></i></span>
                                    <input type="number" name="stok" class="form-control border-start-0 ps-0" placeholder="0" value="<?= old('stok') ?>" required>
                                </div>
                            </div>
                            
                            <!-- TOMBOL AKSI -->
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg rounded-pill shadow-sm fw-bold">
                                    <i class="fas fa-save me-2"></i>SIMPAN DATA
                                </button>
                                <a href="<?= base_url('product') ?>" class="btn btn-light btn-lg rounded-pill text-muted fw-bold">
                                    BATAL
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</body>
</html>