<?php

namespace App\Models;

use CodeIgniter\Model;

class StockAlertModel extends Model
{
    protected $table            = 'stock_alerts';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'product_id', 'stok_saat_ini', 'status', 'tanggal_alert', 'sudah_dibaca'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';

    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    /**
     * Ambil semua alert yang belum dibaca
     */
    public function getUnreadAlerts()
    {
        return $this->select('sa.*, p.nama_barang')
                    ->join('products p', 'p.id = sa.product_id', 'left')
                    ->where('sa.sudah_dibaca', false)
                    ->orderBy('sa.tanggal_alert', 'DESC')
                    ->findAll();
    }

    /**
     * Cek produk dengan stok rendah dan buat alert jika belum ada
     */
    public function checkLowStockProducts()
    {
        $db = \Config\Database::connect();
        $productModel = new ProductModel();

        $lowStockProducts = $productModel->select('id, nama_barang, stok, low_stock_threshold')
                                        ->where('stok <=', 'low_stock_threshold', false)
                                        ->findAll();

        $alerts = [];

        foreach ($lowStockProducts as $product) {
            $status = $product['stok'] == 0 ? 'habis' : 'menipis';

            // Cek apakah sudah ada alert hari ini untuk produk ini
            $existingAlert = $this->where('product_id', $product['id'])
                                 ->where('status', $status)
                                 ->where('DATE(tanggal_alert) = DATE(NOW())', null, false)
                                 ->first();

            if (!$existingAlert) {
                $this->insert([
                    'product_id' => $product['id'],
                    'stok_saat_ini' => $product['stok'],
                    'status' => $status,
                    'tanggal_alert' => date('Y-m-d H:i:s'),
                    'sudah_dibaca' => false
                ]);
            }

            $alerts[] = [
                'id' => $existingAlert['id'] ?? null,
                'product_id' => $product['id'],
                'nama_barang' => $product['nama_barang'],
                'stok' => $product['stok'],
                'status' => $status
            ];
        }

        return $alerts;
    }

    /**
     * Mark alert sebagai sudah dibaca
     */
    public function markAsRead($alertId)
    {
        return $this->update($alertId, ['sudah_dibaca' => true]);
    }
}
