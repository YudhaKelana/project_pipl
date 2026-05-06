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
        // ✅ MENGGUNAKAN HELPER
        if ($redirect = require_admin('Akses Ditolak! Hanya Admin yang boleh melihat laporan.')) {
            return $redirect;
        }
        
        // Ambil parameter filter
        $filter   = $this->request->getGet('filter') ?? 'all'; // all, fast, slow
        $category = $this->request->getGet('category') ?? '';
        $sort     = $this->request->getGet('sort') ?? 'total_sold';
        $order    = $this->request->getGet('order') ?? 'desc';
        $perPage  = 20;

        // Validasi
        $allowedFilter = ['all', 'fast', 'slow'];
        if (!in_array($filter, $allowedFilter)) $filter = 'all';
        $allowedSort = ['total_sold', 'name', 'category'];
        if (!in_array($sort, $allowedSort)) $sort = 'total_sold';
        if (!in_array($order, ['asc', 'desc'])) $order = 'desc';
        
        // Build query
        $db = \Config\Database::connect();
        $builder = $db->table('transaction_details')
            ->select('products.id, products.name, products.category, SUM(transaction_details.quantity) as total_sold')
            ->join('products', 'products.id = transaction_details.product_id')
            ->groupBy('transaction_details.product_id');

        // Filter by category
        if (!empty($category)) {
            $builder->where('products.category', $category);
        }

        // Get all results first untuk filtering fast/slow
        $allResults = $builder->get()->getResultArray();

        // Apply fast/slow filter
        $filteredResults = [];
        foreach ($allResults as $row) {
            $isFast = $row['total_sold'] > 5;
            
            if ($filter === 'all') {
                $filteredResults[] = $row;
            } elseif ($filter === 'fast' && $isFast) {
                $filteredResults[] = $row;
            } elseif ($filter === 'slow' && !$isFast) {
                $filteredResults[] = $row;
            }
        }

        // Manual sorting
        usort($filteredResults, function($a, $b) use ($sort, $order) {
            $valA = $a[$sort];
            $valB = $b[$sort];
            
            if ($order === 'asc') {
                return $valA <=> $valB;
            } else {
                return $valB <=> $valA;
            }
        });

        // Manual pagination
        $total = count($filteredResults);
        $currentPage = $this->request->getGet('page') ?? 1;
        $offset = ($currentPage - 1) * $perPage;
        $paginatedResults = array_slice($filteredResults, $offset, $perPage);

        // Get categories
        $allCategories = $db->table('products')
            ->select('category')->distinct()
            ->where('deleted_at IS NULL')
            ->orderBy('category', 'ASC')
            ->get()->getResultArray();

        // Calculate summary
        $fastCount = count(array_filter($allResults, fn($r) => $r['total_sold'] > 5));
        $slowCount = count(array_filter($allResults, fn($r) => $r['total_sold'] <= 5));
        
        $data = [
            'title'         => 'Laporan Analisis Barang',
            'sales_data'    => $paginatedResults,
            'filter'        => $filter,
            'category'      => $category,
            'sort'          => $sort,
            'order'         => $order,
            'categories'    => array_column($allCategories, 'category'),
            'total'         => $total,
            'perPage'       => $perPage,
            'currentPage'   => $currentPage,
            'totalPages'    => ceil($total / $perPage),
            'fastCount'     => $fastCount,
            'slowCount'     => $slowCount,
        ];

        return view('reports/index', $data);
    }
}
