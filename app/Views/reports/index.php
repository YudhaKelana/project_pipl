<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<!-- SUMMARY CARDS -->
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <div class="text-info mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" viewBox="0 0 16 16"><path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/><path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/></svg>
                </div>
                <h3 class="fw-bold mb-0"><?= number_format($total); ?></h3>
                <small class="text-muted">Total Produk Terjual</small>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <div class="text-success mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M6.79 5.093A.5.5 0 0 0 6 5.5v5a.5.5 0 0 0 .79.407l3.5-2.5a.5.5 0 0 0 0-.814z"/></svg>
                </div>
                <h3 class="fw-bold mb-0 text-success"><?= number_format($fastCount); ?></h3>
                <small class="text-muted">Fast Moving (>5 pcs)</small>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <div class="text-warning mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" viewBox="0 0 16 16"><path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/><path d="M5 6.5A1.5 1.5 0 0 1 6.5 5h3A1.5 1.5 0 0 1 11 6.5v3A1.5 1.5 0 0 1 9.5 11h-3A1.5 1.5 0 0 1 5 9.5z"/></svg>
                </div>
                <h3 class="fw-bold mb-0 text-warning"><?= number_format($slowCount); ?></h3>
                <small class="text-muted">Slow Moving (≤5 pcs)</small>
            </div>
        </div>
    </div>
</div>

<!-- FILTER & INFO -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <h5 class="fw-bold mb-3">Laporan Analisis Barang Fast/Slow Moving</h5>
        
        <div class="alert alert-light border mb-3">
            <strong>Keterangan:</strong><br>
            <span class="badge bg-success">Fast-Moving</span> : Barang sangat laku (Terjual <strong>> 5 pcs</strong>)<br>
            <span class="badge bg-warning text-dark">Slow-Moving</span> : Barang kurang laku (Terjual <strong>≤ 5 pcs</strong>)
        </div>

        <form action="/reports" method="get">
            <input type="hidden" name="sort" value="<?= esc($sort); ?>">
            <input type="hidden" name="order" value="<?= esc($order); ?>">
            <div class="row g-2">
                <div class="col-md-4">
                    <label class="form-label small">Filter Status</label>
                    <select name="filter" class="form-select" onchange="this.form.submit()">
                        <option value="all" <?= ($filter === 'all') ? 'selected' : ''; ?>>Semua Barang</option>
                        <option value="fast" <?= ($filter === 'fast') ? 'selected' : ''; ?>>Fast Moving Saja</option>
                        <option value="slow" <?= ($filter === 'slow') ? 'selected' : ''; ?>>Slow Moving Saja</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small">Filter Kategori</label>
                    <select name="category" class="form-select" onchange="this.form.submit()">
                        <option value="">Semua Kategori</option>
                        <?php foreach ($categories as $cat) : ?>
                            <option value="<?= esc($cat); ?>" <?= ($category === $cat) ? 'selected' : ''; ?>><?= esc(ucfirst($cat)); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <?php if (!empty($category) || $filter !== 'all') : ?>
                        <a href="/reports" class="btn btn-outline-secondary w-100">Reset Filter</a>
                    <?php endif; ?>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- ACTIVE FILTER INFO -->
<?php if ($filter !== 'all' || !empty($category)) : ?>
<div class="mb-3">
    <small class="text-muted">
        Menampilkan
        <?php if ($filter === 'fast') : ?> <span class="badge bg-success">Fast Moving</span><?php endif; ?>
        <?php if ($filter === 'slow') : ?> <span class="badge bg-warning text-dark">Slow Moving</span><?php endif; ?>
        <?php if (!empty($category)) : ?> kategori <span class="badge bg-primary"><?= esc(ucfirst($category)); ?></span><?php endif; ?>
        — <strong><?= $total; ?></strong> produk ditemukan
    </small>
</div>
<?php endif; ?>

<?php
// Helper function untuk generate URL sort
function sortUrl($column, $currentSort, $currentOrder, $filter, $category) {
    $newOrder = ($currentSort === $column && $currentOrder === 'asc') ? 'desc' : 'asc';
    $params = ['sort' => $column, 'order' => $newOrder];
    if ($filter !== 'all') $params['filter'] = $filter;
    if (!empty($category)) $params['category'] = $category;
    return '/reports?' . http_build_query($params);
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
                <thead class="table-dark">
                    <tr>
                        <th class="ps-3" style="width: 80px;">Peringkat</th>
                        <th>
                            <a href="<?= sortUrl('name', $sort, $order, $filter, $category); ?>" class="text-white text-decoration-none">
                                Nama Barang <?= sortIcon('name', $sort, $order); ?>
                            </a>
                        </th>
                        <th style="width: 150px;">
                            <a href="<?= sortUrl('category', $sort, $order, $filter, $category); ?>" class="text-white text-decoration-none">
                                Kategori <?= sortIcon('category', $sort, $order); ?>
                            </a>
                        </th>
                        <th style="width: 150px;" class="text-center">
                            <a href="<?= sortUrl('total_sold', $sort, $order, $filter, $category); ?>" class="text-white text-decoration-none">
                                Total Terjual <?= sortIcon('total_sold', $sort, $order); ?>
                            </a>
                        </th>
                        <th style="width: 180px;" class="text-center pe-3">Status Analisis</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($sales_data)): ?>
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="text-muted">
                                    <p class="mb-1 fw-semibold">Belum ada data transaksi penjualan</p>
                                    <small>Data akan muncul setelah ada transaksi di kasir.</small>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php
                            $startNo = ($currentPage - 1) * $perPage + 1;
                        ?>
                        <?php foreach ($sales_data as $i => $row) : ?>
                        <tr>
                            <td class="ps-3 text-center">
                                <span class="badge bg-secondary fs-6">#<?= $startNo + $i; ?></span>
                            </td>
                            <td class="fw-semibold"><?= esc($row['name']); ?></td>
                            <td><span class="badge bg-light text-dark border"><?= esc(ucfirst($row['category'])); ?></span></td>
                            <td class="text-center">
                                <span class="badge bg-primary rounded-pill fs-6"><?= $row['total_sold']; ?> pcs</span>
                            </td>
                            <td class="text-center pe-3">
                                <?php if($row['total_sold'] > 5): ?>
                                    <span class="badge bg-success fs-6 px-3 py-2">
                                        FAST MOVING
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-warning text-dark fs-6 px-3 py-2">
                                        SLOW MOVING
                                    </span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- MANUAL PAGINATION -->
    <?php if (!empty($sales_data) && $totalPages > 1) : ?>
    <div class="card-footer bg-white border-top">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <small class="text-muted">
                    Menampilkan <?= ($currentPage - 1) * $perPage + 1; ?>–<?= min($currentPage * $perPage, $total); ?>
                    dari <strong><?= $total; ?></strong> produk
                </small>
            </div>
            <div class="col-sm-6 d-flex justify-content-end">
                <nav>
                    <ul class="pagination pagination-sm mb-0">
                        <?php
                        $params = [];
                        if ($filter !== 'all') $params['filter'] = $filter;
                        if (!empty($category)) $params['category'] = $category;
                        if ($sort !== 'total_sold') $params['sort'] = $sort;
                        if ($order !== 'desc') $params['order'] = $order;
                        ?>
                        
                        <!-- Previous -->
                        <?php if ($currentPage > 1) : ?>
                            <li class="page-item">
                                <a class="page-link" href="/reports?<?= http_build_query(array_merge($params, ['page' => $currentPage - 1])); ?>">‹</a>
                            </li>
                        <?php else : ?>
                            <li class="page-item disabled"><span class="page-link">‹</span></li>
                        <?php endif; ?>

                        <!-- Pages -->
                        <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                            <?php if ($i == $currentPage) : ?>
                                <li class="page-item active"><span class="page-link"><?= $i; ?></span></li>
                            <?php else : ?>
                                <li class="page-item">
                                    <a class="page-link" href="/reports?<?= http_build_query(array_merge($params, ['page' => $i])); ?>"><?= $i; ?></a>
                                </li>
                            <?php endif; ?>
                        <?php endfor; ?>

                        <!-- Next -->
                        <?php if ($currentPage < $totalPages) : ?>
                            <li class="page-item">
                                <a class="page-link" href="/reports?<?= http_build_query(array_merge($params, ['page' => $currentPage + 1])); ?>">›</a>
                            </li>
                        <?php else : ?>
                            <li class="page-item disabled"><span class="page-link">›</span></li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<?= $this->endSection(); ?>
