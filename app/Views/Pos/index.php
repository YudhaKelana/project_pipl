<!DOCTYPE html>
<html lang="id">
<head>
    <title><?= esc($title) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body { background-color: #f0f2f5; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #ccc; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #aaa; }
        .product-card { cursor: pointer; transition: all 0.2s ease-in-out; border: 1px solid #e0e0e0; border-radius: 10px; background: #fff; overflow: hidden; }
        .product-card:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.08); border-color: #0d6efd; }
        .product-card:active { transform: scale(0.98); }
        .product-price { color: #0d6efd; font-weight: 700; font-size: 1.1rem; }
        .scroll-area { max-height: calc(100vh - 180px); overflow-y: auto; padding-right: 5px; }
        .cart-container { border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border: none; }
        .cart-item-title { font-size: 0.95rem; font-weight: 600; color: #333; margin-bottom: 4px; }
        .btn-qty { width: 30px; height: 30px; padding: 0; display: flex; align-items: center; justify-content: center; border-radius: 6px; font-weight: bold; }
        .qty-display { width: 40px; text-align: center; border: none; background: transparent; font-weight: bold; }
        .btn-admin-nav { background: rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.3); backdrop-filter: blur(5px); }
        .btn-admin-nav:hover { background: rgba(255,255,255,0.3); color: white; }
    </style>
</head>
<body>
    
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm sticky-top mb-3" style="background: linear-gradient(to right, #0d6efd, #0a58ca);">
        <div class="container-fluid px-4">
            <a class="navbar-brand fw-bold d-flex align-items-center" href="#">
                <i class="fas fa-store me-2"></i> WARUNG Z&Z
            </a>
            
            <div class="navbar-nav ms-auto flex-row align-items-center">
                <?php if(session()->get('isLoggedIn')): ?>
                    <span class="navbar-text text-white me-3 d-none d-md-block small">
                        <i class="fas fa-user-circle"></i> <?= esc(session()->get('username')) ?>
                    </span>
                    <a class="btn btn-sm btn-admin-nav text-white me-2 rounded-pill px-3" href="<?= base_url('product') ?>">
                        <i class="fas fa-boxes"></i> Stok
                    </a>
                    <a class="btn btn-sm btn-danger rounded-pill px-3 shadow-sm" href="<?= base_url('logout') ?>">
                        <i class="fas fa-sign-out-alt"></i>
                    </a>
                <?php else: ?>
                    <a class="btn btn-sm btn-admin-nav text-white rounded-pill px-3" href="<?= base_url('login') ?>">
                        <i class="fas fa-lock"></i> Login
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <div class="container-fluid px-4">
        <div class="row g-4">
            
            <!-- KOLOM KIRI: PRODUK -->
            <div class="col-lg-8 col-md-7">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0 text-secondary"><i class="fas fa-th-large me-2"></i>Daftar Produk</h5>
                    <span class="badge bg-secondary rounded-pill"><?= count($products) ?> Item</span>
                </div>
                <div class="scroll-area pe-2">
                    <div class="row g-3">
                        <?php foreach($products as $p): ?>
                        <div class="col-xl-3 col-lg-4 col-md-6 col-6">
                            <form action="<?= base_url('pos/add') ?>" method="post" class="h-100">
                                <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
                                <input type="hidden" name="qty" value="1">
                                <button type="submit" class="btn p-0 w-100 h-100 border-0 text-start">
                                    <div class="product-card h-100 p-3 d-flex flex-column justify-content-between">
                                        <div>
                                            <h6 class="card-title text-dark mb-1 lh-sm"><?= esc($p['nama_barang']) ?></h6>
                                            <small class="text-muted" style="font-size: 0.8rem;">Stok: <?= $p['stok'] ?></small>
                                        </div>
                                        <div class="mt-3 d-flex justify-content-between align-items-end">
                                            <span class="product-price">Rp <?= number_format($p['harga_jual'],0,',','.') ?></span>
                                            <span class="btn btn-sm btn-primary rounded-circle" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-plus"></i>
                                            </span>
                                        </div>
                                    </div>
                                </button>
                            </form>
                        </div>
                        <?php endforeach; ?>
                        <?php if(empty($products)): ?>
                            <div class="col-12 text-center py-5">
                                <p class="text-muted">Stok barang kosong.</p>
                                <a href="<?= base_url('product/create') ?>" class="btn btn-primary rounded-pill px-4">Isi Stok Sekarang</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- KOLOM KANAN: KERANJANG -->
            <div class="col-lg-4 col-md-5">
                <div class="card cart-container h-100 d-flex flex-column bg-white">
                    <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center sticky-top">
                        <h6 class="mb-0 fw-bold"><i class="fas fa-shopping-cart me-2 text-primary"></i>Keranjang</h6>
                        <?php if(!empty($cart)): ?>
                            <a href="<?= base_url('pos/clear') ?>" class="text-danger text-decoration-none small fw-bold" onclick="return confirm('Kosongkan semua keranjang?')">
                                <i class="fas fa-trash-alt"></i> Reset
                            </a>
                        <?php endif; ?>
                    </div>
                    
                    <div class="card-body p-0 scroll-area" style="max-height: 50vh; flex-grow: 1;">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light small text-muted">
                                    <tr>
                                        <th class="ps-3" style="width: 45%;">Item</th>
                                        <th class="text-center" style="width: 25%;">Qty</th>
                                        <th class="text-end pe-3" style="width: 30%;">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $grandTotal = 0; ?>
                                    <?php foreach($cart as $item): ?>
                                    <?php $subtotal = $item['price'] * $item['qty']; ?>
                                    <?php $grandTotal += $subtotal; ?>
                                    <tr>
                                        <td class="ps-3">
                                            <div class="cart-item-title text-truncate" style="max-width: 140px;" title="<?= esc($item['name']) ?>">
                                                <?= esc($item['name']) ?>
                                            </div>
                                            <small class="text-muted">@ <?= number_format($item['price'], 0, ',', '.') ?></small>
                                            <br>
                                            <a href="<?= base_url('pos/remove/'.$item['id']) ?>" class="text-danger text-decoration-none" style="font-size: 0.75rem;">
                                                <i class="fas fa-times-circle"></i> Hapus
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center align-items-center bg-light rounded p-1" style="width: fit-content; margin: 0 auto;">
                                                <a href="<?= base_url('pos/decrease/'.$item['id']) ?>" class="btn btn-qty btn-white text-danger shadow-sm">
                                                    <i class="fas fa-minus" style="font-size: 0.7rem;"></i>
                                                </a>
                                                <span class="qty-display mx-1"><?= $item['qty'] ?></span>
                                                <a href="<?= base_url('pos/increase/'.$item['id']) ?>" class="btn btn-qty btn-primary shadow-sm">
                                                    <i class="fas fa-plus" style="font-size: 0.7rem;"></i>
                                                </a>
                                            </div>
                                        </td>
                                        <td class="text-end pe-3 fw-bold text-dark">
                                            <?= number_format($subtotal, 0, ',', '.') ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php if(empty($cart)): ?>
                                        <tr>
                                            <td colspan="3" class="text-center py-5">
                                                <p class="text-muted mt-3 small">Belum ada barang dipilih.</p>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card-footer bg-white border-top p-4 shadow-lg" style="z-index: 10;">
                        <div class="d-flex justify-content-between align-items-end mb-3">
                            <div>
                                <small class="text-muted">Total Tagihan</small>
                                <h3 class="mb-0 fw-bold text-dark">Rp <?= number_format($grandTotal, 0, ',', '.') ?></h3>
                            </div>
                        </div>

                        <form action="<?= base_url('pos/pay') ?>" method="post">
                            <button type="submit" class="btn btn-success w-100 btn-lg rounded-pill fw-bold shadow" <?= empty($cart) ? 'disabled' : '' ?>>
                                <i class="fas fa-money-bill-wave me-2"></i> BAYAR SEKARANG
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Alerts -->
                <?php if(session()->getFlashdata('success')): ?>
                    <div class="alert alert-success mt-3 shadow-sm border-0 rounded-3 fade show">
                        <i class="fas fa-check-circle me-2"></i> <?= session()->getFlashdata('success') ?>
                    </div>
                <?php endif; ?>
                <?php if(session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger mt-3 shadow-sm border-0 rounded-3 fade show">
                        <i class="fas fa-exclamation-triangle me-2"></i> <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- MODAL STRUK (POP-UP DALAM HALAMAN) -->
    <div class="modal fade" id="receiptModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-sm"> 
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title fw-bold"><i class="fas fa-receipt me-2"></i>Struk Belanja</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0" style="height: 400px; background: #fff;">
                    <!-- Iframe untuk memuat struk -->
                    <iframe id="receiptFrame" style="width: 100%; height: 100%; border: none;"></iframe>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                    <!-- Tombol Cetak Ulang -->
                    <button type="button" class="btn btn-primary btn-sm" onclick="document.getElementById('receiptFrame').contentWindow.print()">
                        <i class="fas fa-print me-1"></i> Cetak
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- LOGIKA POP-UP OTOMATIS -->
    <script>
        <?php if(session()->getFlashdata('last_trans_id')): ?>
            document.addEventListener("DOMContentLoaded", function() {
                // 1. Siapkan Modal
                var myModal = new bootstrap.Modal(document.getElementById('receiptModal'));
                
                // 2. Set URL Iframe ke Halaman Struk
                var iframe = document.getElementById('receiptFrame');
                iframe.src = "<?= base_url('pos/print/' . session()->getFlashdata('last_trans_id')) ?>";
                
                // 3. Tampilkan Modal
                myModal.show();

                // 4. (Opsional) Otomatis print setelah iframe loading selesai
                // iframe.onload = function() { iframe.contentWindow.print(); }
            });
        <?php endif; ?>
    </script>

</body>
</html>