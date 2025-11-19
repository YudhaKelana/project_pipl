<?php

namespace App\Controllers;

use App\Models\TransactionDetailModel;

class Reports extends BaseController
{
    protected $transactionDetailModel;

    public function __construct()
    {
        $this->transactionDetailModel = new TransactionDetailModel();
    }

    public function index()
    {
        // Logika Query:
        // 1. Gabungkan tabel detail transaksi dengan tabel produk
        // 2. Hitung total quantity terjual (SUM)
        // 3. Kelompokkan berdasarkan produk (GROUP BY)
        // 4. Urutkan dari yang paling banyak terjual (DESC)
        
        $db = \Config\Database::connect();
        $query = $db->table('transaction_details')
            ->select('products.name, products.category, SUM(transaction_details.quantity) as total_sold')
            ->join('products', 'products.id = transaction_details.product_id')
            ->groupBy('transaction_details.product_id')
            ->orderBy('total_sold', 'DESC') // Urutkan dari yang terlaris
            ->get();

        $results = $query->getResultArray();

        // Pisahkan Fast Moving & Slow Moving (Contoh logika sederhana)
        // Fast Moving: Terjual > 5 pcs (Anda bisa sesuaikan angkanya)
        // Slow Moving: Terjual <= 5 pcs
        
        $data = [
            'title' => 'Laporan Analisis Barang',
            'sales_data' => $results
        ];

        return view('reports/index', $data);
    }
}