<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\TransactionModel;
use App\Models\TransactionDetailModel;

class Pos extends BaseController
{
    protected $productModel;
    protected $transactionModel;
    protected $transactionDetailModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->transactionModel = new TransactionModel();
        $this->transactionDetailModel = new TransactionDetailModel();
    }

    // 1. Halaman Utama Kasir (dengan Search & Filter)
    public function index()
    {
        // Ambil parameter filter
        $search   = $this->request->getGet('q') ?? '';
        $category = $this->request->getGet('category') ?? '';
        $sort     = $this->request->getGet('sort') ?? 'name';
        $order    = $this->request->getGet('order') ?? 'asc';

        // Validasi sort
        $allowedSort = ['name', 'price', 'stock', 'category'];
        if (!in_array($sort, $allowedSort)) $sort = 'name';
        if (!in_array($order, ['asc', 'desc'])) $order = 'asc';

        // Build query
        $builder = $this->productModel->where('stock >', 0)->orderBy($sort, $order);

        if (!empty($search)) {
            $builder->like('name', $search);
        }
        if (!empty($category)) {
            $builder->where('category', $category);
        }

        $products = $builder->findAll();

        // Ambil kategori unik
        $db = \Config\Database::connect();
        $allCategories = $db->table('products')
            ->select('category')->distinct()
            ->where('stock >', 0)
            ->where('deleted_at IS NULL')
            ->orderBy('category', 'ASC')
            ->get()->getResultArray();

        $data = [
            'title'      => 'Kasir Warung Z&Z',
            'products'   => $products,
            'cart'       => session()->get('cart') ?? [],
            'search'     => $search,
            'category'   => $category,
            'sort'       => $sort,
            'order'      => $order,
            'categories' => array_column($allCategories, 'category'),
        ];
        
        return view('pos/index', $data);
    }

    // 2. Tambah ke Keranjang (Session)
    public function addToCart($id)
    {
        $product = $this->productModel->find($id);
        if (!$product) return redirect()->to('/pos');

        $cart = session()->get('cart') ?? [];

        // Cek jika barang sudah ada di cart, tambahkan qty
        if (isset($cart[$id])) {
            $cart[$id]['qty']++;
            $cart[$id]['subtotal'] = $cart[$id]['qty'] * $cart[$id]['price'];
        } else {
            // Jika belum ada, masukkan baru
            $cart[$id] = [
                'id'       => $product['id'],
                'name'     => $product['name'],
                'price'    => $product['price'],
                'qty'      => 1,
                'subtotal' => $product['price']
            ];
        }

        session()->set('cart', $cart);
        return redirect()->to('/pos');
    }

    // 3. Hapus Keranjang
    public function clearCart()
    {
        session()->remove('cart');
        return redirect()->to('/pos');
    }

    // 4. Proses Pembayaran (PENTING)
   // 4. Proses Pembayaran (VERSI FINAL & BERSIH)
    public function process()
    {
        $cart = session()->get('cart');
        if (empty($cart)) {
            return redirect()->to('/pos')->with('error', 'Keranjang kosong!');
        }

        // Hitung Total Belanja
        $totalAmount = 0;
        foreach ($cart as $item) {
            $totalAmount += $item['subtotal'];
        }

        // Gunakan Database Transaction agar aman
        // Jika ada error di tengah jalan, semua data batal disimpan (Rollback)
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // A. Simpan Header Transaksi
            $invoiceNo = 'INV-' . date('YmdHis'); // Contoh: INV-202511192359
            $this->transactionModel->insert([
                'invoice_no'   => $invoiceNo,
                'total_amount' => $totalAmount,
                'created_at'   => date('Y-m-d H:i:s')
            ]);
            
            // Ambil ID transaksi yang baru saja dibuat
            $transactionId = $this->transactionModel->getInsertID();

            // B. Simpan Detail & Kurangi Stok
            foreach ($cart as $item) {
                // 1. Simpan ke transaction_details
                $this->transactionDetailModel->insert([
                    'transaction_id' => $transactionId,
                    'product_id'     => $item['id'],
                    'quantity'       => $item['qty'],
                    'price'          => $item['price'],
                    'subtotal'       => $item['subtotal']
                ]);

                // 2. Kurangi Stok di tabel products
                $currentProduct = $this->productModel->find($item['id']);
                
                // Cek stok cukup atau tidak (Opsional, tapi bagus untuk validasi)
                if ($currentProduct['stock'] < $item['qty']) {
                     // Batalkan transaksi manual jika stok tiba-tiba habis
                     throw new \Exception("Stok untuk " . $item['name'] . " tidak mencukupi!");
                }

                $newStock = $currentProduct['stock'] - $item['qty'];
                $this->productModel->update($item['id'], ['stock' => $newStock]);
            }

            // Selesaikan Transaksi
            $db->transComplete();

            if ($db->transStatus() === FALSE) {
                // Jika database error (misal koneksi putus)
                return redirect()->to('/pos')->with('error', 'Transaksi Gagal Disimpan ke Database.');
            }

            // Hapus session cart setelah sukses
            session()->remove('cart');

            // Kembali ke kasir dengan pesan sukses
            return redirect()->to('/pos')->with('success', "Transaksi Berhasil! Invoice: $invoiceNo");

        } catch (\Exception $e) {
            $db->transRollback();
            // Tangkap error jika ada (misal stok habis tadi)
            return redirect()->to('/pos')->with('error', 'Gagal: ' . $e->getMessage());
        }
    }
}