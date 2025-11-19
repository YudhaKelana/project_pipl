<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= esc($title) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>body { background-color: #f0f2f5; font-family: 'Segoe UI', sans-serif; }</style>
</head>
<body>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                
                <!-- Tombol Kembali -->
                <a href="<?= base_url('history') ?>" class="btn btn-outline-secondary mb-3 rounded-pill">
                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Riwayat
                </a>

                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-header bg-primary text-white p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-0 fw-bold">Detail Transaksi</h5>
                                <small class="opacity-75">Faktur: <?= $transaksi['no_faktur'] ?></small>
                            </div>
                            <div class="text-end">
                                <h4 class="mb-0 fw-bold">Rp <?= number_format($transaksi['total_bayar'], 0, ',', '.') ?></h4>
                                <small class="opacity-75"><?= date('d F Y H:i', strtotime($transaksi['tanggal'])) ?></small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-striped mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4 py-3">Nama Barang</th>
                                    <th class="text-center py-3">Harga Satuan</th>
                                    <th class="text-center py-3">Qty</th>
                                    <th class="pe-4 text-end py-3">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($details as $item): ?>
                                <tr>
                                    <td class="ps-4 align-middle fw-semibold"><?= $item['nama_barang'] ?></td>
                                    <td class="text-center align-middle">Rp <?= number_format($item['harga_saat_itu'], 0, ',', '.') ?></td>
                                    <td class="text-center align-middle">
                                        <span class="badge bg-secondary rounded-pill"><?= $item['qty'] ?></span>
                                    </td>
                                    <td class="pe-4 text-end align-middle fw-bold">
                                        Rp <?= number_format($item['harga_saat_itu'] * $item['qty'], 0, ',', '.') ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <td colspan="3" class="text-end py-3 fw-bold">TOTAL BAYAR</td>
                                    <td class="pe-4 text-end py-3 fw-bold text-success fs-5">
                                        Rp <?= number_format($transaksi['total_bayar'], 0, ',', '.') ?>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="card-footer bg-white p-3 text-end">
                        <!-- Tombol Cetak Ulang Struk -->
                        <a href="#" onclick="window.open('<?= base_url('pos/print/' . $transaksi['id']) ?>', 'Struk', 'width=400,height=600'); return false;" class="btn btn-primary rounded-pill">
                            <i class="fas fa-print me-2"></i>Cetak Struk
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>

</body>
</html>