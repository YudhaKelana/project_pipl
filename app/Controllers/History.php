<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TransactionModel;
use App\Models\TransactionDetailModel;

class History extends BaseController
{
    public function index()
    {
        $model = new TransactionModel();
        
        // Ambil semua transaksi, urutkan dari yang terbaru (DESC)
        $data = [
            'title' => 'Riwayat Penjualan',
            'transactions' => $model->orderBy('tanggal', 'DESC')->findAll()
        ];

        return view('history/index', $data);
    }

    public function detail($id)
    {
        $transModel = new TransactionModel();
        $transaksi = $transModel->find($id);

        if (!$transaksi) {
            return redirect()->to('/history')->with('error', 'Transaksi tidak ditemukan.');
        }

        // Ambil detail barang menggunakan Query Builder (Join ke tabel products)
        $db = \Config\Database::connect();
        $details = $db->table('transaction_details')
                      ->select('transaction_details.*, products.nama_barang')
                      ->join('products', 'products.id = transaction_details.product_id')
                      ->where('transaction_id', $id)
                      ->get()
                      ->getResultArray();

        $data = [
            'title' => 'Detail Transaksi - ' . $transaksi['no_faktur'],
            'transaksi' => $transaksi,
            'details' => $details
        ];

        return view('history/detail', $data);
    }
}