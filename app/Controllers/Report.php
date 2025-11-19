<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Report extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();

        // =====================================================================
        // QUERY 1: ANALISIS FAST/SLOW MOVING (Untuk Tabel)
        // =====================================================================
        $builder = $db->table('products p');
        $builder->select('p.id, p.nama_barang, p.harga_beli, p.harga_jual, p.stok, SUM(td.qty) as total_terjual');
        $builder->join('transaction_details td', 'td.product_id = p.id', 'left');
        $builder->groupBy('p.id');
        $builder->orderBy('total_terjual', 'DESC');
        
        $products = $builder->get()->getResultArray();

        // Logika penentuan status Fast/Slow Moving
        foreach ($products as &$p) {
            $terjual = (int)$p['total_terjual'];
            
            if ($terjual >= 10) {
                $p['status'] = 'FAST MOVING';
                $p['badge'] = 'success'; // Hijau
                $p['desc'] = 'Sangat Laris';
            } elseif ($terjual >= 3) {
                $p['status'] = 'MODERATE';
                $p['badge'] = 'warning'; // Kuning
                $p['desc'] = 'Lumayan';
            } else {
                $p['status'] = 'SLOW MOVING';
                $p['badge'] = 'danger'; // Merah
                $p['desc'] = 'Kurang Diminati';
            }
        }

        // =====================================================================
        // QUERY 2: DATA GRAFIK PENJUALAN 14 HARI TERAKHIR (Untuk Chart.js)
        // =====================================================================
        // Kita gunakan raw query agar lebih fleksibel dengan fungsi tanggal MySQL
        $chartQuery = $db->query("
            SELECT 
                DATE(tanggal) as tgl, 
                SUM(total_bayar) as omzet
            FROM transactions
            WHERE tanggal >= DATE_SUB(CURDATE(), INTERVAL 14 DAY)
            GROUP BY DATE(tanggal)
            ORDER BY tgl ASC
        ");
        
        $chartData = $chartQuery->getResultArray();

        // Format data agar siap dibaca oleh Chart.js (Butuh Array terpisah untuk Label dan Value)
        $labels = [];
        $values = [];

        // Trik: Kita buat array kosong dulu untuk 14 hari agar grafik tidak bolong jika ada hari tanpa penjualan
        $period = new \DatePeriod(
             new \DateTime('-14 days'),
             new \DateInterval('P1D'),
             new \DateTime('+1 day')
        );

        // Siapkan array template data (Tanggal => 0)
        $finalChartData = [];
        foreach ($period as $date) {
            $finalChartData[$date->format('Y-m-d')] = 0;
        }

        // Isi dengan data asli dari database
        foreach ($chartData as $row) {
            $tglDb = date('Y-m-d', strtotime($row['tgl']));
            if (isset($finalChartData[$tglDb])) {
                $finalChartData[$tglDb] = (int)$row['omzet'];
            }
        }

        // Pisahkan ke Label dan Values untuk dikirim ke View
        foreach ($finalChartData as $tgl => $omzet) {
            $labels[] = date('d M', strtotime($tgl)); // Format: 20 Nov
            $values[] = $omzet;
        }

        // =====================================================================
        // KIRIM DATA KE VIEW
        // =====================================================================
        $data = [
            'title' => 'Laporan Analisis Stok & Penjualan',
            'reports' => $products,
            // json_encode diperlukan agar array PHP bisa dibaca oleh JavaScript di View
            'chartLabels' => json_encode($labels),
            'chartValues' => json_encode($values)
        ];

        return view('report/index', $data);
    }
}