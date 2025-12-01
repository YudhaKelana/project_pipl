<!-- STOCK REMINDER MODAL -->
<?php 
$lowStockAlerts = session()->get('lowStockAlerts') ?? [];
if (!empty($lowStockAlerts)): 
?>
<div class="modal fade" id="stockReminder" tabindex="-1" aria-labelledby="stockReminderLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-warning">
            <div class="modal-header bg-warning">
                <h5 class="modal-title fw-bold" id="stockReminderLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i>Peringatan Stok Produk
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-muted mb-3">Produk berikut memiliki stok yang menipis atau habis:</p>
                <div class="list-group">
                    <?php foreach ($lowStockAlerts as $alert): ?>
                    <div class="list-group-item <?= $alert['status'] == 'habis' ? 'list-group-item-danger' : 'list-group-item-warning' ?>">
                        <div class="d-flex w-100 justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1 fw-bold">
                                    <i class="fas fa-<?= $alert['status'] == 'habis' ? 'ban' : 'triangle-exclamation' ?> me-2"></i>
                                    <?= esc($alert['nama_barang']) ?>
                                </h6>
                                <small class="text-muted">Stok: <?= $alert['stok'] ?> unit</small>
                            </div>
                            <span class="badge bg-<?= $alert['status'] == 'habis' ? 'danger' : 'warning' ?>">
                                <?= ucfirst($alert['status']) ?>
                            </span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Auto show modal saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function() {
        const stockReminderModal = new bootstrap.Modal(document.getElementById('stockReminder'));
        stockReminderModal.show();
    });
</script>
<?php endif; ?>
