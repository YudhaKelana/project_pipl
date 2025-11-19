<?php namespace App\Controllers;

use App\Models\ProductModel;

class Produk extends BaseController
{
    public function index()
    {
        $model = new ProductModel();
        $data['products'] = $model->findAll();
        return view('produk/index', $data);
    }

    public function create()
    {
        return view('produk/create');
    }

    public function store()
    {
        $model = new ProductModel();
        
        // Validasi Duplikat Nama
        $name = $this->request->getPost('name');
        $existingItem = $model->where('name', $name)->first();
        
        if ($existingItem) {
            return redirect()->back()->with('error', "Gagal! Barang dengan nama '$name' sudah ada.");
        }

        $data = [
            'barcode' => $this->request->getPost('barcode'),
            'name'    => $name,
            'category'=> $this->request->getPost('category'),
            'price'   => $this->request->getPost('price'),
            'stock'   => $this->request->getPost('stock'),
        ];
        $model->insert($data);
        return redirect()->to(base_url('produk'))->with('success', 'Barang berhasil ditambahkan.');
    }

    // --- FUNGSI EDIT YANG HILANG TADI ---
    public function edit($id)
    {
        $model = new ProductModel();
        $data['product'] = $model->find($id);

        if (!$data['product']) {
            return redirect()->to(base_url('produk'))->with('error', 'Data barang tidak ditemukan.');
        }

        return view('produk/edit', $data);
    }

    // --- FUNGSI UPDATE ---
    public function update($id)
    {
        $model = new ProductModel();
        
        $data = [
            'barcode' => $this->request->getPost('barcode'),
            'name'    => $this->request->getPost('name'),
            'category'=> $this->request->getPost('category'),
            'price'   => $this->request->getPost('price'),
            'stock'   => $this->request->getPost('stock'),
        ];

        $model->update($id, $data);
        return redirect()->to(base_url('produk'))->with('success', 'Data barang berhasil diperbarui.');
    }

    public function delete($id)
    {
        $model = new ProductModel();
        $model->delete($id);
        return redirect()->to(base_url('produk'));
    }
}