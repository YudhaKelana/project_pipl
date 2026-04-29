<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\TransactionModel;
use App\Models\TransactionDetailModel;

class Pos extends BaseController
{
    // 1. Halaman Utama Kasir
    public function index()
    {
        $productModel = new ProductModel();
        
        $data = [
            'title' => 'Kasir Warung Z&Z',
            // Hanya tampilkan barang yang stoknya ada
            'products' => $productModel->where('stok >', 0)->findAll(), 
            'cart' => session()->get('cart') ?? [] 
        ];

        return view('pos/index', $data);
    }

    // 2. Tambah Barang
    public function add()
    {
        $id = $this->request->getPost('product_id');
        $qty = (int)$this->request->getPost('qty');

        $this->addToCartLogic($id, $qty);

        return redirect()->to('/pos');
    }

    // --- LOGIKA UPDATE QUANTITY ---
    public function increase($id) {
        $this->addToCartLogic($id, 1);
        return redirect()->to('/pos');
    }

    public function decrease($id) {
        $cart = session()->get('cart');
        if (isset($cart[$id])) {
            $cart[$id]['qty']--;
            if ($cart[$id]['qty'] <= 0) unset($cart[$id]);
            session()->set('cart', $cart);
        }
        return redirect()->to('/pos');
    }

    public function removeItem($id) {
        $cart = session()->get('cart');
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->set('cart', $cart);
        }
        return redirect()->to('/pos');
    }

    // Helper Logic
    private function addToCartLogic($id, $qty) {
        $productModel = new ProductModel();
        $product = $productModel->find($id);

        if ($product) {
            $cart = session()->get('cart') ?? [];
            $currentQtyInCart = isset($cart[$id]) ? $cart[$id]['qty'] : 0;
            
            if (($currentQtyInCart + $qty) > $product['stok']) {
                session()->setFlashdata('error', 'Stok tidak mencukupi!');
                return;
            }

            if (isset($cart[$id])) {
                $cart[$id]['qty'] += $qty;
            } else {
                $cart[$id] = [
                    'id' => $product['id'],
                    'name' => $product['nama_barang'],
                    'price' => $product['harga_jual'],
                    'qty' => $qty
                ];
            }
            session()->set('cart', $cart);
        }
    }

    // 3. Reset Keranjang
    public function clear()
    {
        session()->remove('cart');
        return redirect()->to('/pos');
    }

    // 4. Bayar (Checkout) -- ✅ REFACTORED: Thin Controller
    public function pay()
    {
        $cart = session()->get('cart');

        if (empty($cart)) {
            return redirect()->to('/pos')->with('error', 'Keranjang masih kosong!');
        }

        try {
            // ✅ BUSINESS LOGIC dipindah ke Model
            $transModel = new TransactionModel();
            $transID = $transModel->processCheckout($cart);

            // Bersihkan Keranjang
            session()->remove('cart');
            
            // Redirect dengan membawa ID Transaksi untuk dicetak
            return redirect()->to('/pos')
                ->with('success', "Transaksi Berhasil!")
                ->with('last_trans_id', $transID);

        } catch (\Exception $e) {
            return redirect()->to('/pos')->with('error', $e->getMessage());
        }
    }

    // 5. Fitur Cetak Struk (BARU)
    public function printStruk($id)
    {
        $transModel = new TransactionModel();
        $transaksi = $transModel->find($id);

        if (!$transaksi) {
            return "Transaksi tidak ditemukan!";
        }

        // Ambil detail barang (Join tabel products untuk ambil nama barang)
        $db = \Config\Database::connect();
        $detail = $db->table('transaction_details')
                     ->join('products', 'products.id = transaction_details.product_id')
                     ->where('transaction_id', $id)
                     ->get()
                     ->getResultArray();

        $data = [
            'transaksi' => $transaksi,
            'detail' => $detail
        ];

        // Tampilkan view khusus struk (tanpa navbar/footer)
        return view('pos/struk', $data);
    }
}