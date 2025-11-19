<?php namespace App\Models;
use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $allowedFields = ['barcode', 'name', 'category', 'price', 'stock'];

    // Fungsi Khusus untuk Laporan Fast Moving (Sesuai Proposal)
    public function getFastMovingProducts($limit = 5)
    {
        // Query menggabungkan produk dengan detail transaksi
        return $this->select('products.name, SUM(transaction_details.qty) as total_sold')
                    ->join('transaction_details', 'transaction_details.product_id = products.id')
                    ->groupBy('products.id')
                    ->orderBy('total_sold', 'DESC') // Urutkan dari yang terlaris
                    ->findAll($limit);
    }
}