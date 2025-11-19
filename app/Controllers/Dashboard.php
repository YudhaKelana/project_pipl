<?php namespace App\Controllers;
use App\Models\ProductModel;
use App\Models\TransactionModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $prodModel = new ProductModel();
        $transModel = new TransactionModel();
        $db = \Config\Database::connect();

        // Hitung data ringkas untuk dashboard
        $data = [
            'total_produk' => $prodModel->countAll(),
            'stok_tipis'   => $prodModel->where('stock <', 10)->countAllResults(), // Warning stok
            'penjualan_hari_ini' => $db->table('transactions')
                                       ->where('DATE(created_at)', date('Y-m-d'))
                                       ->countAllResults(),
            'omset_hari_ini' => $db->table('transactions')
                                   ->selectSum('total_amount')
                                   ->where('DATE(created_at)', date('Y-m-d'))
                                   ->get()->getRow()->total_amount ?? 0
        ];

        return view('dashboard_view', $data);
    }
}