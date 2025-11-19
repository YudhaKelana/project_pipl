<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk Belanja</title>
    <style>
        /* Style khusus untuk struk termal */
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 12px;
            margin: 0;
            padding: 10px;
            /* Hapus width fixed agar responsif di dalam iframe */
            width: 100%; 
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .bold { font-weight: bold; }
        .line { border-bottom: 1px dashed #000; margin: 5px 0; }
        
        table { width: 100%; border-collapse: collapse; }
        td { vertical-align: top; }
        
        /* Saat diprint, hilangkan margin */
        @media print {
            @page { margin: 0; }
            body { margin: 0; padding: 5px; }
        }
    </style>
</head>
<body> <!-- HAPUS onload="window.print()" DI SINI -->

    <div class="text-center">
        <h3 style="margin-bottom: 5px;">WARUNG Z&Z</h3>
        <p style="margin: 0;">Jl. Menuju Sukses No. 1<br>Tanjungpinang</p>
    </div>

    <div class="line"></div>

    <table>
        <tr>
            <td>No. Faktur</td>
            <td class="text-right"><?= $transaksi['no_faktur'] ?></td>
        </tr>
        <tr>
            <td>Tanggal</td>
            <td class="text-right"><?= date('d/m/Y H:i', strtotime($transaksi['tanggal'])) ?></td>
        </tr>
    </table>

    <div class="line"></div>

    <table>
        <?php foreach($detail as $item): ?>
        <tr>
            <td colspan="2" class="bold"><?= $item['nama_barang'] ?></td>
        </tr>
        <tr>
            <td><?= $item['qty'] ?> x <?= number_format($item['harga_saat_itu'], 0, ',', '.') ?></td>
            <td class="text-right"><?= number_format($item['qty'] * $item['harga_saat_itu'], 0, ',', '.') ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <div class="line"></div>

    <table>
        <tr class="bold" style="font-size: 14px;">
            <td>TOTAL</td>
            <td class="text-right">Rp <?= number_format($transaksi['total_bayar'], 0, ',', '.') ?></td>
        </tr>
        <tr>
            <td>Tunai</td>
            <td class="text-right">Rp <?= number_format($transaksi['total_bayar'], 0, ',', '.') ?></td>
        </tr>
        <tr>
            <td>Kembali</td>
            <td class="text-right">Rp 0</td>
        </tr>
    </table>

    <div class="line"></div>

    <div class="text-center" style="margin-top: 10px;">
        <p>Terima Kasih<br>Silakan Datang Kembali</p>
        <small>-- Layanan Konsumen --</small>
    </div>

</body>
</html>