<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<!-- SUMMARY CARDS -->
<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <div class="text-primary mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" viewBox="0 0 16 16"><path d="M0 3a2 2 0 0 1 2-2h13.5a.5.5 0 0 1 0 1H15v2a1 1 0 0 1 1 1v8.5a1.5 1.5 0 0 1-1.5 1.5h-12A2.5 2.5 0 0 1 0 12.5zm1 1.732V12.5A1.5 1.5 0 0 0 2.5 14h12a.5.5 0 0 0 .5-.5V5H2a2 2 0 0 1-1-.268M1 3a1 1 0 0 0 1 1h12V2H2a1 1 0 0 0-1 1"/></svg>
                </div>
                <h3 class="fw-bold mb-0"><?= number_format($totalTransactions); ?></h3>
                <small class="text-muted">Total Transaksi</small>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <div class="text-success mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" viewBox="0 0 16 16"><path d="M1 3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1zm7 8a2 2 0 1 0 0-4 2 2 0 0 0 0 4"/><path d="M0 5a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1zm3 0a2 2 0 0 1-2 2v4a2 2 0 0 1 2 2h10a2 2 0 0 1 2-2V7a2 2 0 0 1-2-2z"/></svg>
                </div>
                <h3 class="fw-bold mb-0 text-success">Rp <?= number_format($totalRevenue, 0, ',', '.'); ?></h3>
                <small class="text-muted">Total Pendapatan</small>
            </div>
        </div>
    </div>
</div>

<!-- FILTER & SEARCH -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <h5 class="fw-bold mb-3">📜 Riwayat Transaksi Penjualan</h5>
        <form action="/history" method="get">
            <input type="hidden" name="sort" value="<?= esc($sort); ?>">
            <input type="hidden" name="order" value="<?= esc($order); ?>">
            <div class="row g-2">
                <div class="col-md-3">
                    <label class="form-label small">Cari Invoice</label>
                    <input type="text" name="q" class="form-control" placeholder="INV-..." value="<?= esc($search); ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label small">Dari Tanggal</label>
                    <input type="date" name="date_from" class="form-control" value="<?= esc($dateFrom); ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label small">Sampai Tanggal</label>
                    <input type="date" name="date_to" class="form-control" value="<?= esc($dateTo); ?>">
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <div class="btn-group w-100">
                        <button type="submit" class="btn btn-primary">🔍 Cari</button>
                        <?php if (!empty($search) || !empty($dateFrom) || !empty($dateTo)) : ?>
                            <a href="/history" class="btn btn-outline-secondary">Reset</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- ACTIVE FILTER INFO -->
<?php if (!empty($search) || !empty($dateFrom) || !empty($dateTo)) : ?>
<div class="mb-3">
    <small class="text-muted">
        Menampilkan hasil
        <?php if (!empty($search)) : ?> untuk invoice "<strong><?= esc($search); ?></strong>"<?php endif; ?>
        <?php if (!empty($dateFrom)) : ?> dari <strong><?= date('d M Y', strtotime($dateFrom)); ?></strong><?php endif; ?>
        <?php if (!empty($dateTo)) : ?> sampai <strong><?= date('d M Y', strtotime($dateTo)); ?></strong><?php endif; ?>
        — <strong><?= count($transactions); ?></strong> transaksi ditemukan
    </small>
</div>
<?php endif; ?>

<?php
// Helper function untuk generate URL sort
function sortUrl($column, $currentSort, $currentOrder, $search, $dateFrom, $dateTo) {
    $newOrder = ($currentSort === $column && $currentOrder === 'asc') ? 'desc' : 'asc';
    $params = ['sort' => $column, 'order' => $newOrder];
    if (!empty($search)) $params['q'] = $search;
    if (!empty($dateFrom)) $params['date_from'] = $dateFrom;
    if (!empty($dateTo)) $params['date_to'] = $dateTo;
    return '/history?' . http_build_query($params);
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
                        <th class="ps-3" style="width: 50px;">No</th>
                        <th style="width: 180px;">
                            <a href="<?= sortUrl('invoice_no', $sort, $order, $search, $dateFrom, $dateTo); ?>" class="text-white text-decoration-none">
                                No. Invoice <?= sortIcon('invoice_no', $sort, $order); ?>
                            </a>
                        </th>
                        <th>
                            <a href="<?= sortUrl('created_at', $sort, $order, $search, $dateFrom, $dateTo); ?>" class="text-white text-decoration-none">
                                Tanggal & Jam <?= sortIcon('created_at', $sort, $order); ?>
                            </a>
                        </th>
                        <th style="width: 180px;">
                            <a href="<?= sortUrl('total_amount', $sort, $order, $search, $dateFrom, $dateTo); ?>" class="text-white text-decoration-none">
                                Total Belanja <?= sortIcon('total_amount', $sort, $order); ?>
                            </a>
                        </th>
                        <th style="width: 120px;" class="text-center pe-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($transactions)): ?>
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="text-muted">
                                    <p class="mb-1 fw-semibold">Belum ada riwayat transaksi</p>
                                    <small>Transaksi akan muncul setelah ada penjualan di kasir.</small>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php
                            $currentPage = $pager->getCurrentPage();
                            $startNo = ($currentPage - 1) * $perPage + 1;
                        ?>
                        <?php foreach ($transactions as $i => $t) : ?>
                        <tr>
                            <td class="ps-3 text-muted"><?= $startNo + $i; ?></td>
                            <td><span class="badge bg-dark fs-6"><?= esc($t['invoice_no']); ?></span></td>
                            <td>
                                <div><?= esc(date('d M Y', strtotime($t['created_at']))); ?></div>
                                <small class="text-muted"><?= esc(date('H:i', strtotime($t['created_at']))); ?> WIB</small>
                            </td>
                            <td class="fw-bold text-success">Rp <?= number_format($t['total_amount'], 0, ',', '.'); ?></td>
                            <td class="text-center pe-3">
                                <a href="/history/<?= $t['id']; ?>" class="btn btn-sm btn-primary">
                                    📄 Detail
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- PAGINATION -->
    <?php if (!empty($transactions)) : ?>
    <div class="card-footer bg-white border-top">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <small class="text-muted">
                    Menampilkan <?= ($pager->getCurrentPage() - 1) * $perPage + 1; ?>–<?= min($pager->getCurrentPage() * $perPage, $pager->getTotal()); ?>
                    dari <strong><?= $pager->getTotal(); ?></strong> transaksi
                </small>
            </div>
            <div class="col-sm-6 d-flex justify-content-end">
                <?= $pager->links('default', 'bootstrap5'); ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<?= $this->endSection(); ?>
