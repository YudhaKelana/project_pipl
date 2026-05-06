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

    // 1. Menampilkan Daftar Semua Transaksi (dengan Pagination, Search, & Filter)
    public function index()
    {
        // Ambil parameter
        $search    = $this->request->getGet('q') ?? '';
        $dateFrom  = $this->request->getGet('date_from') ?? '';
        $dateTo    = $this->request->getGet('date_to') ?? '';
        $sort      = $this->request->getGet('sort') ?? 'created_at';
        $order     = $this->request->getGet('order') ?? 'desc';
        $perPage   = 15;

        // Validasi sort
        $allowedSort = ['created_at', 'invoice_no', 'total_amount'];
        if (!in_array($sort, $allowedSort)) $sort = 'created_at';
        if (!in_array($order, ['asc', 'desc'])) $order = 'desc';

        // Build query
        $builder = $this->transactionModel->orderBy($sort, $order);

        // Filter by invoice number
        if (!empty($search)) {
            $builder->like('invoice_no', $search);
        }

        // Filter by date range
        if (!empty($dateFrom)) {
            $builder->where('DATE(created_at) >=', $dateFrom);
        }
        if (!empty($dateTo)) {
            $builder->where('DATE(created_at) <=', $dateTo);
        }

        // Paginate
        $transactions = $builder->paginate($perPage);
        $pager = $this->transactionModel->pager;

        // Hitung total transaksi dan total pendapatan
        $db = \Config\Database::connect();
        $summaryBuilder = $db->table('transactions');
        
        if (!empty($search)) {
            $summaryBuilder->like('invoice_no', $search);
        }
        if (!empty($dateFrom)) {
            $summaryBuilder->where('DATE(created_at) >=', $dateFrom);
        }
        if (!empty($dateTo)) {
            $summaryBuilder->where('DATE(created_at) <=', $dateTo);
        }

        $summary = $summaryBuilder->select('COUNT(*) as total_transactions, SUM(total_amount) as total_revenue')
            ->get()->getRowArray();

        $data = [
            'title'             => 'Riwayat Penjualan',
            'transactions'      => $transactions,
            'pager'             => $pager,
            'search'            => $search,
            'dateFrom'          => $dateFrom,
            'dateTo'            => $dateTo,
            'sort'              => $sort,
            'order'             => $order,
            'perPage'           => $perPage,
            'totalTransactions' => $summary['total_transactions'] ?? 0,
            'totalRevenue'      => $summary['total_revenue'] ?? 0,
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