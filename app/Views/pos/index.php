<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="row g-4">
    <!-- KOLOM KIRI: KATALOG BARANG -->
    <div class="col-md-7">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">🛒 Katalog Barang</h5>
            </div>
            <div class="card-body">
                <!-- FLASH MESSAGES -->
                <?php if (session()->getFlashdata('success')) : ?>
                    <div class="alert alert-success alert-dismissible fade show">
                        ✅ <?= session()->getFlashdata('success'); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                <?php if (session()->getFlashdata('error')) : ?>
                    <div class="alert alert-danger alert-dismissible fade show">
                        ❌ <?= session()->getFlashdata('error'); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <!-- FILTER & SEARCH -->
                <form action="/pos" method="get" class="mb-4">
                    <input type="hidden" name="sort" value="<?= esc($sort); ?>">
                    <input type="hidden" name="order" value="<?= esc($order); ?>">
                    <div class="row g-2">
                        <div class="col-md-5">
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-search"></i>🔍</span>
                                <input type="text" name="q" class="form-control" placeholder="Cari barang..." value="<?= esc($search); ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <select name="category" class="form-select">
                                <option value="">Semua Kategori</option>
                                <?php foreach ($categories as $cat) : ?>
                                    <option value="<?= esc($cat); ?>" <?= ($category === $cat) ? 'selected' : ''; ?>><?= esc(ucfirst($cat)); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <div class="btn-group w-100">
                                <button type="submit" class="btn btn-primary">Cari</button>
                                <?php if (!empty($search) || !empty($category)) : ?>
                                    <a href="/pos" class="btn btn-outline-secondary">Reset</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- SORTING BUTTONS -->
                <div class="mb-3 d-flex gap-2 flex-wrap">
                    <small class="text-muted align-self-center">Urutkan:</small>
                    <?php
                    function sortLink($col, $label, $currentSort, $currentOrder, $search, $category) {
                        $newOrder = ($currentSort === $col && $currentOrder === 'asc') ? 'desc' : 'asc';
                        $icon = ($currentSort === $col) ? ($currentOrder === 'asc' ? '↑' : '↓') : '';
                        $params = ['sort' => $col, 'order' => $newOrder];
                        if (!empty($search)) $params['q'] = $search;
                        if (!empty($category)) $params['category'] = $category;
                        $active = ($currentSort === $col) ? 'btn-primary' : 'btn-outline-primary';
                        return '<a href="/pos?' . http_build_query($params) . '" class="btn btn-sm ' . $active . '">' . $label . ' ' . $icon . '</a>';
                    }
                    ?>
                    <?= sortLink('name', 'Nama', $sort, $order, $search, $category); ?>
                    <?= sortLink('price', 'Harga', $sort, $order, $search, $category); ?>
                    <?= sortLink('stock', 'Stok', $sort, $order, $search, $category); ?>
                    <?= sortLink('category', 'Kategori', $sort, $order, $search, $category); ?>
                </div>

                <!-- KATALOG GRID -->
                <div class="row g-3" style="max-height: 500px; overflow-y: auto;">
                    <?php if (empty($products)) : ?>
                        <div class="col-12 text-center py-5">
                            <p class="text-muted">Tidak ada barang yang tersedia.</p>
                        </div>
                    <?php else : ?>
                        <?php foreach ($products as $p) : ?>
                        <div class="col-md-4 col-sm-6">
                            <div class="card h-100 border-primary shadow-sm">
                                <div class="card-body text-center d-flex flex-column justify-content-between">
                                    <div>
                                        <h6 class="card-title fw-bold"><?= esc($p['name']); ?></h6>
                                        <p class="card-text text-muted small mb-1">
                                            <span class="badge bg-light text-dark border"><?= esc($p['category']); ?></span>
                                        </p>
                                        <h5 class="text-success mb-1">Rp <?= number_format($p['price'], 0, ',', '.'); ?></h5>
                                        <small class="text-secondary">Stok: <strong><?= $p['stock']; ?></strong></small>
                                    </div>
                                    <a href="/pos/add/<?= $p['id']; ?>" class="btn btn-outline-primary btn-sm mt-2 w-100">
                                        ➕ Tambah ke Keranjang
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- KOLOM KANAN: KERANJANG BELANJA -->
    <div class="col-md-5">
        <div class="card shadow-sm sticky-top" style="top: 20px;">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">🛍️ Keranjang Belanja</h5>
                <?php if (!empty($cart)) : ?>
                    <a href="/pos/clear" class="btn btn-danger btn-sm" onclick="return confirm('Kosongkan keranjang?')">
                        🗑️ Reset
                    </a>
                <?php endif; ?>
            </div>
            <div class="card-body p-0">
                <div style="max-height: 400px; overflow-y: auto;">
                    <table class="table table-sm table-hover mb-0">
                        <thead class="table-light sticky-top">
                            <tr>
                                <th>Item</th>
                                <th class="text-center">Qty</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $grandTotal = 0;
                            if (!empty($cart)) : 
                                foreach ($cart as $item) : 
                                $grandTotal += $item['subtotal'];
                            ?>
                            <tr>
                                <td>
                                    <div class="fw-semibold"><?= esc($item['name']); ?></div>
                                    <small class="text-muted">@ Rp <?= number_format($item['price'], 0, ',', '.'); ?></small>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-primary rounded-pill"><?= $item['qty']; ?></span>
                                </td>
                                <td class="text-end fw-bold">Rp <?= number_format($item['subtotal'], 0, ',', '.'); ?></td>
                            </tr>
                            <?php endforeach; 
                            else : ?>
                            <tr>
                                <td colspan="3" class="text-center text-muted py-5">
                                    <p class="mb-0">Keranjang masih kosong</p>
                                    <small>Pilih barang dari katalog</small>
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">TOTAL BAYAR</h5>
                    <h4 class="mb-0 text-success fw-bold">Rp <?= number_format($grandTotal, 0, ',', '.'); ?></h4>
                </div>

                <?php if (!empty($cart)) : ?>
                <form action="/pos/process" method="post">
                    <?= csrf_field(); ?>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-success btn-lg fw-bold">
                            💳 PROSES TRANSAKSI
                        </button>
                    </div>
                </form>
                <?php else : ?>
                    <button class="btn btn-secondary btn-lg w-100" disabled>
                        💳 PROSES TRANSAKSI
                    </button>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
