<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<!-- SUMMARY CARDS -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <div class="text-primary mb-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" viewBox="0 0 16 16"><path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1m3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1z"/></svg>
                </div>
                <h3 class="fw-bold mb-0"><?= $totalProducts; ?></h3>
                <small class="text-muted">Total Produk</small>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <div class="text-success mb-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" viewBox="0 0 16 16"><path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1zm3.915 10L3.102 4h10.796l-1.313 7zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0m7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/></svg>
                </div>
                <h3 class="fw-bold mb-0"><?= number_format($totalStock); ?></h3>
                <small class="text-muted">Total Stok</small>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <div class="text-warning mb-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" viewBox="0 0 16 16"><path d="M7.938 2.016A.13.13 0 0 1 8.002 2a.13.13 0 0 1 .063.016.15.15 0 0 1 .054.057l6.857 11.667c.036.06.035.124.002.183a.2.2 0 0 1-.054.06.1.1 0 0 1-.066.017H1.146a.1.1 0 0 1-.066-.017.2.2 0 0 1-.054-.06.18.18 0 0 1 .002-.183L7.884 2.073a.15.15 0 0 1 .054-.057m1.044-.45a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767z"/><path d="M7.002 12a1 1 0 1 1 2 0 1 1 0 0 1-2 0M7.1 5.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0z"/></svg>
                </div>
                <h3 class="fw-bold mb-0"><?= $lowStock; ?></h3>
                <small class="text-muted">Stok Menipis</small>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <div class="text-danger mb-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z"/></svg>
                </div>
                <h3 class="fw-bold mb-0"><?= $outOfStock; ?></h3>
                <small class="text-muted">Stok Habis</small>
            </div>
        </div>
    </div>
</div>

<!-- SEARCH BAR -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <div class="row align-items-center g-3">
            <div class="col-md-3">
                <h5 class="fw-bold mb-0">Daftar Stok Barang</h5>
            </div>
            <div class="col-md-9">
                <form action="/products" method="get" id="searchForm">
                    <!-- Pertahankan sort saat search -->
                    <input type="hidden" name="sort" value="<?= esc($sort); ?>">
                    <input type="hidden" name="order" value="<?= esc($order); ?>">
                    <div class="row g-2 justify-content-end">
                        <div class="col-sm-4">
                            <div class="input-group">
                                <span class="input-group-text bg-white"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/></svg></span>
                                <input type="text" name="q" class="form-control" placeholder="Cari nama barang..." value="<?= esc($search); ?>" id="searchInput">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <select name="category" class="form-select" onchange="document.getElementById('searchForm').submit()">
                                <option value="">Semua Kategori</option>
                                <?php foreach ($categories as $cat) : ?>
                                    <option value="<?= esc($cat); ?>" <?= ($category === $cat) ? 'selected' : ''; ?>><?= esc(ucfirst($cat)); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-sm-auto">
                            <button type="submit" class="btn btn-primary w-100">Cari</button>
                        </div>
                        <?php if (!empty($search) || !empty($category)) : ?>
                        <div class="col-sm-auto">
                            <a href="/products" class="btn btn-outline-secondary w-100">Reset</a>
                        </div>
                        <?php endif; ?>
                        <?php if (session()->get('role') == 'admin') : ?>
                        <div class="col-sm-auto">
                            <a href="/products/create" class="btn btn-success w-100">+ Tambah</a>
                        </div>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- FLASH MESSAGES -->
<?php if (session()->getFlashdata('message')) : ?>
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        <?= session()->getFlashdata('message'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')) : ?>
    <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
        <?= session()->getFlashdata('error'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- ACTIVE FILTER INFO -->
<?php if (!empty($search) || !empty($category)) : ?>
<div class="mb-3">
    <small class="text-muted">
        Menampilkan hasil untuk
        <?php if (!empty($search)) : ?> pencarian "<strong><?= esc($search); ?></strong>"<?php endif; ?>
        <?php if (!empty($category)) : ?> kategori <span class="badge bg-primary"><?= esc(ucfirst($category)); ?></span><?php endif; ?>
        — <strong><?= count($products); ?></strong> item ditemukan
    </small>
</div>
<?php endif; ?>

<?php
// Helper function untuk generate URL sort
function sortUrl($column, $currentSort, $currentOrder, $search, $category) {
    $newOrder = ($currentSort === $column && $currentOrder === 'asc') ? 'desc' : 'asc';
    $params = ['sort' => $column, 'order' => $newOrder];
    if (!empty($search)) $params['q'] = $search;
    if (!empty($category)) $params['category'] = $category;
    return '/products?' . http_build_query($params);
}
function sortIcon($column, $currentSort, $currentOrder) {
    if ($currentSort !== $column) return '⇅';
    return ($currentOrder === 'asc') ? '↑' : '↓';
}
?>

<!-- DATA TABLE -->
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr class="table-dark">
                        <th class="ps-3" style="width: 50px;">No</th>
                        <th>
                            <a href="<?= sortUrl('name', $sort, $order, $search, $category); ?>" class="text-white text-decoration-none">
                                Nama Barang <?= sortIcon('name', $sort, $order); ?>
                            </a>
                        </th>
                        <th style="width: 140px;">
                            <a href="<?= sortUrl('category', $sort, $order, $search, $category); ?>" class="text-white text-decoration-none">
                                Kategori <?= sortIcon('category', $sort, $order); ?>
                            </a>
                        </th>
                        <th style="width: 140px;">
                            <a href="<?= sortUrl('price', $sort, $order, $search, $category); ?>" class="text-white text-decoration-none">
                                Harga <?= sortIcon('price', $sort, $order); ?>
                            </a>
                        </th>
                        <th style="width: 110px;" class="text-center">
                            <a href="<?= sortUrl('stock', $sort, $order, $search, $category); ?>" class="text-white text-decoration-none">
                                Stok <?= sortIcon('stock', $sort, $order); ?>
                            </a>
                        </th>
                        <?php if (session()->get('role') == 'admin') : ?>
                            <th style="width: 150px;" class="text-center pe-3">Aksi</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($products)) : ?>
                        <tr>
                            <td colspan="<?= (session()->get('role') == 'admin') ? '6' : '5'; ?>" class="text-center py-5">
                                <div class="text-muted">
                                    <p class="mb-1 fw-semibold">Tidak ada data barang</p>
                                    <small>Coba ubah kata kunci pencarian atau filter.</small>
                                </div>
                            </td>
                        </tr>
                    <?php else : ?>
                        <?php
                            $currentPage = $pager->getCurrentPage();
                            $startNo = ($currentPage - 1) * $perPage + 1;
                        ?>
                        <?php foreach ($products as $i => $p) : ?>
                        <tr>
                            <td class="ps-3 text-muted"><?= $startNo + $i; ?></td>
                            <td class="fw-semibold"><?= esc($p['name']); ?></td>
                            <td><span class="badge bg-light text-dark border"><?= esc(ucfirst($p['category'])); ?></span></td>
                            <td class="fw-semibold">Rp <?= number_format($p['price'], 0, ',', '.'); ?></td>
                            <td class="text-center">
                                <?php if ($p['stock'] == 0) : ?>
                                    <span class="badge bg-danger rounded-pill px-3">Habis</span>
                                <?php elseif ($p['stock'] < 10) : ?>
                                    <span class="badge bg-warning text-dark rounded-pill px-3"><?= $p['stock']; ?> pcs</span>
                                <?php else : ?>
                                    <span class="badge bg-success rounded-pill px-3"><?= $p['stock']; ?> pcs</span>
                                <?php endif; ?>
                            </td>
                            <?php if (session()->get('role') == 'admin') : ?>
                            <td class="text-center pe-3">
                                <div class="btn-group btn-group-sm">
                                    <a href="/products/edit/<?= $p['id']; ?>" class="btn btn-outline-warning">Edit</a>
                                    <form action="/products/delete/<?= $p['id']; ?>" method="post" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus?')">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-outline-danger">Hapus</button>
                                    </form>
                                </div>
                            </td>
                            <?php endif; ?>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- PAGINATION -->
    <?php if (!empty($products)) : ?>
    <div class="card-footer bg-white border-top">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <small class="text-muted">
                    Menampilkan <?= ($pager->getCurrentPage() - 1) * $perPage + 1; ?>–<?= min($pager->getCurrentPage() * $perPage, $pager->getTotal()); ?>
                    dari <strong><?= $pager->getTotal(); ?></strong> produk
                </small>
            </div>
            <div class="col-sm-6 d-flex justify-content-end">
                <?= $pager->links('default', 'bootstrap5'); ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<script>
document.addEventListener('keydown', function(e) {
    if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
        e.preventDefault();
        document.getElementById('searchInput').focus();
        document.getElementById('searchInput').select();
    }
});
</script>

<?= $this->endSection(); ?>