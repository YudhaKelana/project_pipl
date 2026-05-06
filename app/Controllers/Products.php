<?php

namespace App\Controllers;

use App\Models\ProductModel;

class Products extends BaseController
{
    protected $productModel;

    public function __construct()
    {
        // Memanggil Model saat Controller dijalankan
        $this->productModel = new ProductModel();
    }

    // 1. Menampilkan Daftar Barang (dengan Search, Filter Kategori, Sort, & Pagination)
    public function index()
    {
        // Ambil parameter dari URL
        $search   = $this->request->getGet('q') ?? '';
        $category = $this->request->getGet('category') ?? '';
        $sort     = $this->request->getGet('sort') ?? 'id';
        $order    = $this->request->getGet('order') ?? 'desc';
        $perPage  = 10;

        // Validasi kolom sort yang diizinkan
        $allowedSort = ['id', 'name', 'category', 'price', 'stock'];
        if (!in_array($sort, $allowedSort)) $sort = 'id';
        if (!in_array($order, ['asc', 'desc'])) $order = 'desc';

        // Build query dengan filter
        $builder = $this->productModel->orderBy($sort, $order);

        if (!empty($search)) {
            $builder->like('name', $search);
        }
        if (!empty($category)) {
            $builder->where('category', $category);
        }

        // Jalankan paginate SEBELUM query lain
        $products = $builder->paginate($perPage);
        $pager    = $this->productModel->pager;

        // Ambil semua kategori unik (pakai $db terpisah)
        $db = \Config\Database::connect();
        $allCategories = $db->table('products')
            ->select('category')->distinct()
            ->where('deleted_at IS NULL')
            ->orderBy('category', 'ASC')
            ->get()->getResultArray();

        // Hitung ringkasan stok
        $summary = $db->table('products')
            ->select('COUNT(*) as total_products, SUM(stock) as total_stock')
            ->where('deleted_at IS NULL')
            ->get()->getRowArray();

        $lowStock = $db->table('products')
            ->where('stock <', 10)->where('stock >', 0)
            ->where('deleted_at IS NULL')
            ->countAllResults();

        $outOfStock = $db->table('products')
            ->where('stock', 0)->where('deleted_at IS NULL')
            ->countAllResults();

        $data = [
            'title'         => 'Daftar Produk Warung Z&Z',
            'products'      => $products,
            'pager'         => $pager,
            'search'        => $search,
            'category'      => $category,
            'sort'          => $sort,
            'order'         => $order,
            'categories'    => array_column($allCategories, 'category'),
            'totalProducts' => $summary['total_products'] ?? 0,
            'totalStock'    => $summary['total_stock'] ?? 0,
            'lowStock'      => $lowStock,
            'outOfStock'    => $outOfStock,
            'perPage'       => $perPage,
        ];

        return view('products/index', $data);
    }

    // 2. Menampilkan Form Tambah Barang
    public function create()
    {
        // ✅ MENGGUNAKAN HELPER (Lebih Clean)
        if ($redirect = require_admin()) {
            return $redirect;
        }

        $data = ['title' => 'Tambah Produk Baru'];
        return view('products/create', $data);
    }

    // 3. Proses Simpan Data ke Database
    public function store()
    {
        // ✅ MENGGUNAKAN HELPER
        if ($redirect = require_admin()) {
            return $redirect;
        }
        
        // ✅ VALIDASI INPUT
        if (!$this->validate([
            'name'     => 'required|min_length[3]|max_length[100]',
            'category' => 'required',
            'price'    => 'required|numeric|greater_than[0]',
            'stock'    => 'required|integer|greater_than_equal_to[0]'
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        // ✅ SIMPAN DATA
        $this->productModel->insert([
            'name'     => $this->request->getPost('name'),
            'category' => $this->request->getPost('category'),
            'price'    => $this->request->getPost('price'),
            'stock'    => $this->request->getPost('stock'),
        ]);
        
        return redirect()->to('/products')->with('message', 'Produk berhasil ditambahkan!');
    }

    // 4. Menampilkan Form Edit
    public function edit($id)
    {
        // ✅ MENGGUNAKAN HELPER
        if ($redirect = require_admin()) {
            return $redirect;
        }
        
        $product = $this->productModel->find($id);
        if (!$product) {
            return redirect()->to('/products')->with('error', 'Data produk tidak ditemukan.');
        }

        $data = [
            'title'   => 'Edit Data Produk',
            'product' => $product
        ];

        return view('products/edit', $data);
    }

    // 5. Proses Update Data ke Database
    public function update($id)
    {
        // ✅ MENGGUNAKAN HELPER
        if ($redirect = require_admin()) {
            return $redirect;
        }
        
        // Validasi input
        if (!$this->validate([
            'name'  => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer'
        ])) {
            return redirect()->back()->withInput();
        }

        // Proses Update
        $this->productModel->update($id, [
            'name'     => $this->request->getPost('name'),
            'category' => $this->request->getPost('category'),
            'price'    => $this->request->getPost('price'),
            'stock'    => $this->request->getPost('stock'),
        ]);

        return redirect()->to('/products')->with('message', 'Data produk berhasil diperbarui!');
    }

    // 6. Proses Hapus Data (Versi Final: Soft Deletes + Cek Admin)
    public function delete($id)
    {
        // ✅ MENGGUNAKAN HELPER
        if ($redirect = require_admin('Akses Ditolak! Anda bukan Admin.')) {
            return $redirect;
        }

        // Proses Hapus
        $product = $this->productModel->find($id);

        if ($product) {
            // Hapus (Soft Delete otomatis karena model sudah disetting)
            $this->productModel->delete($id);
            return redirect()->to('/products')->with('message', 'Produk berhasil dihapus (diarsipkan).');
        }

        return redirect()->to('/products')->with('error', 'Data produk tidak ditemukan.');
    }
}
