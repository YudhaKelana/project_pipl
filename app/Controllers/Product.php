<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductModel;

class Product extends BaseController
{
    protected $productModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Daftar Stok Barang',
            'products' => $this->productModel->findAll()
        ];
        return view('products/index', $data);
    }

    public function create()
    {
        $data = ['title' => 'Tambah Barang Baru'];
        return view('products/create', $data);
    }

    // --- REVISI FUNGSI STORE (SIMPAN) ---
    public function store()
    {
        $data = [
            'nama_barang' => $this->request->getPost('nama_barang'),
            'harga_beli'  => $this->request->getPost('harga_beli'),
            'harga_jual'  => $this->request->getPost('harga_jual'),
            'stok'        => $this->request->getPost('stok'),
        ];

        // Coba simpan ke Model
        // Jika GAGAL (karena validasi model menolak, misal nama kembar), kembalikan ke form
        if ($this->productModel->save($data) === false) {
            // redirect()->back() = Kembali ke halaman sebelumnya
            // withInput() = Bawa kembali data yang sudah diketik (agar tidak hilang)
            // with('errors') = Bawa pesan error dari model
            return redirect()->back()->withInput()->with('errors', $this->productModel->errors());
        }

        return redirect()->to('/product')->with('success', 'Barang berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $product = $this->productModel->find($id);
        if (!$product) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Barang tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Barang',
            'product' => $product
        ];
        return view('products/edit', $data);
    }

    // --- REVISI FUNGSI UPDATE (EDIT) ---
    public function update($id)
    {
        $data = [
            'id'          => $id, // Penting: ID harus ada agar validasi is_unique tahu ini proses edit
            'nama_barang' => $this->request->getPost('nama_barang'),
            'harga_beli'  => $this->request->getPost('harga_beli'),
            'harga_jual'  => $this->request->getPost('harga_jual'),
            'stok'        => $this->request->getPost('stok'),
        ];

        // Coba update ke Model
        if ($this->productModel->save($data) === false) {
            return redirect()->back()->withInput()->with('errors', $this->productModel->errors());
        }

        return redirect()->to('/product')->with('success', 'Data barang berhasil diperbarui.');
    }

    public function delete($id)
    {
        $this->productModel->delete($id);
        return redirect()->to('/product')->with('success', 'Barang berhasil dihapus.');
    }
}