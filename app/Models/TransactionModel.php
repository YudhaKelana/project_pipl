<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $table            = 'transactions';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'no_faktur', 'total_bayar', 'tanggal'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function generateNoFaktur()
    {
        $date = date('Ymd');
        // Cari transaksi terakhir hari ini
        $lastTrans = $this->where('DATE(tanggal)', date('Y-m-d'))->orderBy('id', 'DESC')->first();
        
        if($lastTrans){
            // Jika ada, ambil nomor urut terakhir + 1
            $lastNo = explode('-', $lastTrans['no_faktur']);
            $number = intval(end($lastNo)) + 1;
        } else {
            // Jika belum ada transaksi hari ini, mulai dari 1
            $number = 1;
        }
        
        return 'INV-' . $date . '-' . str_pad($number, 4, '0', STR_PAD_LEFT);
    }

    /**
     * ✅ BUSINESS LOGIC: Process Checkout
     * Simpan transaksi, detail, dan update stok dalam satu transaksi database
     * 
     * @param array $cart Keranjang belanja
     * @return int Transaction ID yang baru dibuat
     * @throws \Exception jika terjadi error
     */
    public function processCheckout(array $cart): int
    {
        if (empty($cart)) {
            throw new \Exception('Keranjang masih kosong!');
        }

        $db = \Config\Database::connect();
        
        // Mulai Database Transaction untuk memastikan atomicity
        $db->transStart();

        try {
            // 1. Hitung Total
            $totalBayar = 0;
            foreach ($cart as $item) {
                $totalBayar += $item['price'] * $item['qty'];
            }

            // 2. Simpan Transaksi Header
            $noFaktur = $this->generateNoFaktur();
            $this->insert([
                'no_faktur' => $noFaktur,
                'total_bayar' => $totalBayar,
                'tanggal' => date('Y-m-d H:i:s')
            ]);
            
            $transID = $this->getInsertID();

            // 3. Simpan Detail & Update Stok
            $detailModel = new TransactionDetailModel();
            $productModel = new ProductModel();

            foreach ($cart as $item) {
                // Simpan detail transaksi
                $detailModel->insert([
                    'transaction_id' => $transID,
                    'product_id' => $item['id'],
                    'qty' => $item['qty'],
                    'harga_saat_itu' => $item['price']
                ]);

                // Update stok produk
                $currentProduct = $productModel->find($item['id']);
                if (!$currentProduct) {
                    throw new \Exception("Produk ID {$item['id']} tidak ditemukan");
                }
                
                $newStock = $currentProduct['stok'] - $item['qty'];
                
                // Validasi stok tidak boleh negatif
                if ($newStock < 0) {
                    throw new \Exception("Stok {$currentProduct['nama_barang']} tidak mencukupi");
                }
                
                $productModel->update($item['id'], ['stok' => $newStock]);
            }

            // Commit transaction
            $db->transComplete();

            if ($db->transStatus() === false) {
                throw new \Exception('Gagal menyimpan transaksi');
            }

            return $transID;

        } catch (\Exception $e) {
            $db->transRollback();
            throw $e;
        }
    }
}
