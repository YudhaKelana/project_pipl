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
        // QUERY 2: DATA GRAFIK PENJUALAN DENGAN FILTER PERIODE
        // =====================================================================
        $period = $this->request->getGet('period') ?? 'monthly'; // monthly, quarterly, semi-annual
        
        $chartData = $this->getChartDataByPeriod($db, $period);

        // =====================================================================
        // KIRIM DATA KE VIEW
        // =====================================================================
        $data = [
            'title' => 'Laporan Analisis Stok & Penjualan',
            'reports' => $products,
            'chartLabels' => json_encode($chartData['labels']),
            'chartValues' => json_encode($chartData['values']),
            'period' => $period,
            'periodName' => $this->getPeriodName($period)
        ];

        return view('report/index', $data);
    }

    /**
     * Ambil data chart berdasarkan periode
     * @param $db Database connection
     * @param $period 'monthly' | 'quarterly' | 'semi-annual'
     */
    private function getChartDataByPeriod($db, $period)
    {
        $labels = [];
        $values = [];

        switch ($period) {
            case 'quarterly':
                // Per 3 bulan
                $chartData = $db->query("
                    SELECT 
                        DATE_FORMAT(tanggal, '%Y-%m') as bulan,
                        SUM(total_bayar) as omzet
                    FROM transactions
                    WHERE tanggal >= DATE_SUB(CURDATE(), INTERVAL 1 YEAR)
                    GROUP BY DATE_FORMAT(tanggal, '%Y-%m')
                    ORDER BY bulan ASC
                ")->getResultArray();

                // Group per 3 bulan
                $quarterlyData = [];
                foreach ($chartData as $row) {
                    $month = (int)date('m', strtotime($row['bulan']));
                    $year = date('Y', strtotime($row['bulan']));
                    $quarter = ceil($month / 3);
                    $key = $year . '-Q' . $quarter;

                    if (!isset($quarterlyData[$key])) {
                        $quarterlyData[$key] = 0;
                    }
                    $quarterlyData[$key] += (int)$row['omzet'];
                }

                foreach ($quarterlyData as $quarter => $omzet) {
                    $labels[] = $quarter;
                    $values[] = $omzet;
                }
                break;

            case 'semi-annual':
                // Per 6 bulan
                $chartData = $db->query("
                    SELECT 
                        DATE_FORMAT(tanggal, '%Y-%m') as bulan,
                        SUM(total_bayar) as omzet
                    FROM transactions
                    WHERE tanggal >= DATE_SUB(CURDATE(), INTERVAL 2 YEAR)
                    GROUP BY DATE_FORMAT(tanggal, '%Y-%m')
                    ORDER BY bulan ASC
                ")->getResultArray();

                // Group per 6 bulan
                $semiAnnualData = [];
                foreach ($chartData as $row) {
                    $month = (int)date('m', strtotime($row['bulan']));
                    $year = date('Y', strtotime($row['bulan']));
                    $half = $month <= 6 ? 1 : 2;
                    $key = $year . '-H' . $half;

                    if (!isset($semiAnnualData[$key])) {
                        $semiAnnualData[$key] = 0;
                    }
                    $semiAnnualData[$key] += (int)$row['omzet'];
                }

                foreach ($semiAnnualData as $half => $omzet) {
                    $labels[] = $half;
                    $values[] = $omzet;
                }
                break;

            case 'monthly':
            default:
                // Per bulan (default, 14 hari pertama diubah menjadi per bulan)
                $chartData = $db->query("
                    SELECT 
                        DATE_FORMAT(tanggal, '%Y-%m') as bulan,
                        SUM(total_bayar) as omzet
                    FROM transactions
                    WHERE tanggal >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH)
                    GROUP BY DATE_FORMAT(tanggal, '%Y-%m')
                    ORDER BY bulan ASC
                ")->getResultArray();

                // Buat template untuk 12 bulan terakhir
                $finalChartData = [];
                for ($i = 11; $i >= 0; $i--) {
                    $bulan = date('Y-m', strtotime('-' . $i . ' months'));
                    $finalChartData[$bulan] = 0;
                }

                // Isi dengan data asli
                foreach ($chartData as $row) {
                    if (isset($finalChartData[$row['bulan']])) {
                        $finalChartData[$row['bulan']] = (int)$row['omzet'];
                    }
                }

                // Format label
                foreach ($finalChartData as $bulan => $omzet) {
                    $labels[] = date('M Y', strtotime($bulan . '-01'));
                    $values[] = $omzet;
                }
                break;
        }

        return [
            'labels' => $labels,
            'values' => $values
        ];
    }

    /**
     * Get human-readable period name
     */
    private function getPeriodName($period)
    {
        $names = [
            'monthly' => 'Per Bulan (12 bulan)',
            'quarterly' => 'Per Kuartal (1 tahun)',
            'semi-annual' => 'Per 6 Bulan (2 tahun)'
        ];
        
        return $names[$period] ?? 'Per Bulan';
    }
}