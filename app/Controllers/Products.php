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

    // 1. Menampilkan Daftar Barang
    public function index()
    {
        $data = [
            'title' => 'Daftar Produk Warung Z&Z',
            // Mengambil semua data dari tabel products, urutkan dari yang terbaru
            'products' => $this->productModel->orderBy('id', 'DESC')->findAll()
        ];

        return view('products/index', $data);
    }

   // 2. Menampilkan Form Tambah Barang
    public function create()
    {
        // --- PROTEKSI TAMBAHAN ---
        if (session()->get('role') != 'admin') {
            return redirect()->to('/products')->with('error', 'Akses Ditolak! Hanya Admin yang boleh menambah barang.');
        }
        // -------------------------

        $data = ['title' => 'Tambah Produk Baru'];
        return view('products/create', $data);
    }

    // 3. Proses Simpan Data ke Database
    public function store()
    {
        // --- PROTEKSI TAMBAHAN ---
        if (session()->get('role') != 'admin') {
            return redirect()->to('/products')->with('error', 'Akses Ditolak!');
        }
    }
    // 4. Menampilkan Form Edit
    public function edit($id)
    {
        $product = $this->productModel->find($id);
        if (!session()->get('role') == 'admin') {
            return redirect()->to('/products')->with('error', 'Akses Ditolak! Hanya Admin yang boleh mengedit barang.');
        }
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
        // --- PROTEKSI TAMBAHAN ---
        if (session()->get('role') != 'admin') {
            return redirect()->to('/products')->with('error', 'Akses Ditolak!');
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
            'stock'    => $this->request->getPost('stock'), // Ini fitur tambah/kurang stok manual
        ]);

        return redirect()->to('/products')->with('message', 'Data produk berhasil diperbarui!');
    }

   // 6. Proses Hapus Data (Versi Final: Soft Deletes + Cek Admin)
    public function delete($id)
    {
        // --- BAGIAN 1: CEK ROLE (KEAMANAN) ---
        // Jika role di session BUKAN admin, tendang keluar.
        if (session()->get('role') != 'admin') {
            return redirect()->to('/products')->with('error', 'Akses Ditolak! Anda bukan Admin.');
        }

        // --- BAGIAN 2: PROSES HAPUS ---
        $product = $this->productModel->find($id);

        if ($product) {
            // Hapus (Soft Delete otomatis karena model sudah disetting)
            $this->productModel->delete($id);
            return redirect()->to('/products')->with('message', 'Produk berhasil dihapus (diarsipkan).');
        }

        return redirect()->to('/products')->with('error', 'Data produk tidak ditemukan.');
    }
}