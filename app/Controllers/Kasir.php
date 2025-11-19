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
        return redirect()->to(base_url('kasir'));
    }

    // 2. Reset Keranjang
    public function clear()
    {
        session()->remove('cart');
        return redirect()->to(base_url('kasir'));
    }

    // 3. Proses Pembayaran (Checkout) - VERSI PERBAIKAN
    public function checkout()
    {
        $cart = session()->get('cart');
        
        // Cek keranjang kosong
        if (empty($cart)) {
            return redirect()->to(base_url('kasir'))->with('error', 'Keranjang masih kosong!');
        }

        $db = \Config\Database::connect();
        $transModel = new TransactionModel();
        $detailModel = new TransactionDetailModel();
        $productModel = new ProductModel();

        // --- MULAI TRANSAKSI DATABASE ---
        $db->transStart();

        // A. Hitung Total
        $grandTotal = 0;
        foreach ($cart as $item) {
            $grandTotal += $item['price'] * $item['qty'];
        }

        // B. Simpan Header Transaksi
        // Kita matikan timestamp otomatis di Model, jadi kita isi created_at manual disini
        $transData = [
            'invoice_no'   => 'INV-' . date('YmdHis'),
            'total_amount' => $grandTotal,
            'created_at'   => date('Y-m-d H:i:s')
        ];
        
        $transId = $transModel->insert($transData);

        // C. Simpan Detail & Potong Stok
        foreach ($cart as $item) {
            // Simpan detail item
            $detailModel->insert([
                'transaction_id' => $transId,
                'product_id'     => $item['id'],
                'qty'            => $item['qty'],
                'price'          => $item['price']
            ]);

            // Potong Stok di Master Barang
            $currentProduct = $productModel->find($item['id']);
            if ($currentProduct) {
                $newStock = $currentProduct['stock'] - $item['qty'];
                $productModel->update($item['id'], ['stock' => $newStock]);
            }
        }

        // --- SELESAI TRANSAKSI ---
        $db->transComplete();

        // Cek apakah Transaksi Sukses atau Gagal
        if ($db->transStatus() === FALSE) {
            // JIKA GAGAL
            return redirect()->to(base_url('kasir'))->with('error', 'Transaksi Gagal Disimpan (Database Error)');
        } else {
            // JIKA SUKSES
            session()->remove('cart'); // Kosongkan keranjang
            return redirect()->to(base_url('kasir'))->with('success', 'Pembayaran Berhasil! Stok telah dikurangi.');
        }
    }
}