<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionDetailModel extends Model
{
    // PERBAIKAN UTAMA: Nama tabel harus pakai underscore (_)
    protected $table            = 'transaction_details'; 
    
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    
    // Kolom yang boleh diisi (Wajib ada untuk mengatasi error "Allowed fields")
    protected $allowedFields    = [
        'transaction_id', 
        'product_id', 
        'qty', 
        'harga_saat_itu'
    ];

    // Config lainnya
    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Matikan timestamps karena tabel detail biasanya tidak butuh created_at/updated_at
    protected $useTimestamps = false;
    
    // Sisa konfigurasi default (Boleh dibiarkan atau dihapus)
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
    protected $allowCallbacks       = true;
}