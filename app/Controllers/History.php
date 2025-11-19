<?php

namespace App\Controllers;

use App\Models\TransactionModel;
use App\Models\TransactionDetailModel;

class History extends BaseController
{
    protected $transactionModel;
    protected $transactionDetailModel;

    public function __construct()
    {
        $this->transactionModel = new TransactionModel();
        $this->transactionDetailModel = new TransactionDetailModel();
    }

    // 1. Menampilkan Daftar Semua Transaksi
    public function index()
    {
        $data = [
            'title' => 'Riwayat Penjualan',
            // Ambil semua transaksi, urutkan dari yang terbaru
            'transactions' => $this->transactionModel->orderBy('created_at', 'DESC')->findAll()
        ];

        return view('history/index', $data);
    }

    // 2. Menampilkan Detail Satu Transaksi (Invoice)
    public function show($id)
    {
        // Ambil Header Transaksi
        $transaction = $this->transactionModel->find($id);

        if (!$transaction) {
            return redirect()->to('/history')->with('error', 'Transaksi tidak ditemukan.');
        }

        // Ambil Detail Barang (Join dengan tabel products agar dapat nama barangnya)
        $db = \Config\Database::connect();
        $items = $db->table('transaction_details')
            ->select('transaction_details.*, products.name as product_name')
            ->join('products', 'products.id = transaction_details.product_id')
            ->where('transaction_id', $id)
            ->get()
            ->getResultArray();

        $data = [
            'title' => 'Detail Invoice',
            'trx'   => $transaction,
            'items' => $items
        ];

        return view('history/detail', $data);
    }
}