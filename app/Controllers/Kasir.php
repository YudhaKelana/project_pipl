<?php namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\TransactionModel;
use App\Models\TransactionDetailModel;

class Kasir extends BaseController
{
    public function index()
    {
        $productModel = new ProductModel();
        
        // Ambil semua produk untuk ditampilkan di daftar
        $data['products'] = $productModel->findAll();
        
        // Ambil keranjang dari session (jika ada)
        $data['cart'] = session()->get('cart') ?? [];
        
        // Hitung Total Belanja
        $data['grand_total'] = 0;
        foreach ($data['cart'] as $item) {
            $data['grand_total'] += $item['price'] * $item['qty'];
        }

        return view('kasir_view', $data);
    }

    // 1. Tambah Barang ke Keranjang
    public function add()
    {
        $productId = $this->request->getPost('product_id');
        $productModel = new ProductModel();
        $product = $productModel->find($productId);

        if ($product) {
            $cart = session()->get('cart') ?? [];
            
            // Cek jika barang sudah ada di cart, tambahkan qty
            if (isset($cart[$productId])) {
                $cart[$productId]['qty']++;
            } else {
                $cart[$productId] = [
                    'id' => $product['id'],
                    'name' => $product['name'],
                    'price' => $product['price'],
                    'qty' => 1
                ];
            }
            session()->set('cart', $cart);
        }
        return redirect()->to('/kasir');
    }

    // 2. Reset Keranjang
    public function clear()
    {
        session()->remove('cart');
        return redirect()->to('/kasir');
    }

    // 3. Proses Pembayaran (Checkout)
    public function checkout()
    {
        $cart = session()->get('cart');
        if (empty($cart)) return redirect()->to('/kasir');

        $db = \Config\Database::connect();
        $transModel = new TransactionModel();
        $detailModel = new TransactionDetailModel();
        $productModel = new ProductModel();

        // Gunakan Database Transaction agar aman (Semua sukses atau batal semua)
        $db->transStart();

        // A. Simpan Header Transaksi
        $grandTotal = 0;
        foreach ($cart as $item) $grandTotal += $item['price'] * $item['qty'];

        $transId = $transModel->insert([
            'invoice_no' => 'INV-' . date('YmdHis'),
            'total_amount' => $grandTotal
        ]);

        // B. Simpan Detail & Kurangi Stok
        foreach ($cart as $item) {
            $detailModel->insert([
                'transaction_id' => $transId,
                'product_id' => $item['id'],
                'qty' => $item['qty'],
                'price' => $item['price']
            ]);

            // Kurangi stok di tabel produk
            $currentProduct = $productModel->find($item['id']);
            $newStock = $currentProduct['stock'] - $item['qty'];
            $productModel->update($item['id'], ['stock' => $newStock]);
        }

        $db->transComplete();

        if ($db->transStatus() === FALSE) {
            // Jika gagal
            return redirect()->to('/kasir')->with('error', 'Transaksi Gagal');
        } else {
            // Jika sukses, kosongkan keranjang
            session()->remove('cart');
            return redirect()->to('/kasir')->with('success', 'Transaksi Berhasil! Kembalian: ...');
        }
    }
}