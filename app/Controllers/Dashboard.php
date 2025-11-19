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
        
        // Ambil Tanggal Hari Ini (Format: 2023-11-20)
        $today = date('Y-m-d');

        // Hitung data ringkas untuk dashboard
        $data = [
            'total_produk' => $prodModel->countAll(),
            
            'stok_tipis'   => $prodModel->where('stock <', 10)->countAllResults(),
            
            // FIX: Gunakan LIKE agar mencocokkan semua jam di tanggal hari ini
            'penjualan_hari_ini' => $db->table('transactions')
                                       ->like('created_at', $today, 'after') 
                                       ->countAllResults(),
                                       
            // FIX: Gunakan LIKE juga untuk Omset
            'omset_hari_ini' => $db->table('transactions')
                                   ->selectSum('total_amount')
                                   ->like('created_at', $today, 'after')
                                   ->get()->getRow()->total_amount ?? 0
        ];

        return view('dashboard_view', $data);
    }
}