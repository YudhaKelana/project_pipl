<?php namespace App\Controllers;

class Laporan extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        
        // 1. Query Fast Moving (Terlaris)
        // Mengambil produk yang terjual, dijumlahkan qty-nya, diurutkan tertinggi
        $fastQuery = $db->table('transaction_details')
                        ->select('products.name, products.category, SUM(transaction_details.qty) as total_sold')
                        ->join('products', 'products.id = transaction_details.product_id')
                        ->groupBy('transaction_details.product_id')
                        ->orderBy('total_sold', 'DESC')
                        ->limit(5) // Ambil 5 teratas
                        ->get()
                        ->getResultArray();

        // 2. Query Slow Moving (Kurang Laku)
        // Logikanya: Produk yang stoknya masih ada TAPI penjualan sedikit atau 0
        // Untuk kesederhanaan malam ini, kita ambil dari tabel produk yang stoknya > 0
        // Dan kita cek penjualannya (Left Join)
        $slowQuery = $db->query("
            SELECT p.name, p.stock, COALESCE(SUM(td.qty), 0) as total_sold 
            FROM products p 
            LEFT JOIN transaction_details td ON p.id = td.product_id 
            GROUP BY p.id 
            ORDER BY total_sold ASC, p.stock DESC 
            LIMIT 5
        ")->getResultArray();

        $data = [
            'fast_moving' => $fastQuery,
            'slow_moving' => $slowQuery
        ];

        return view('laporan_view', $data);
    }
}