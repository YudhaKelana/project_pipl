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
}
