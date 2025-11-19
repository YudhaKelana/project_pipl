<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table            = 'products';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nama_barang', 'harga_beli', 'harga_jual', 'stok'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // -------------------------------------------------------------------
    // VALIDASI DATA (ANTI DUPLIKAT)
    // -------------------------------------------------------------------
    protected $validationRules = [
        // Rule: Wajib isi | Minimal 3 huruf | Harus Unik di tabel products kolom nama_barang
        // ",id,{id}" artinya: Kecuali ID barang itu sendiri (agar saat edit tidak error)
        'nama_barang' => 'required|min_length[3]|is_unique[products.nama_barang,id,{id}]',
        
        'harga_beli'  => 'required|numeric',
        'harga_jual'  => 'required|numeric',
        'stok'        => 'required|integer'
    ];

    protected $validationMessages = [
        'nama_barang' => [
            'required'   => 'Nama barang wajib diisi.',
            'min_length' => 'Nama barang terlalu pendek.',
            'is_unique'  => 'Gagal: Nama barang ini sudah ada di database.'
        ],
        'stok' => [
            'integer'    => 'Stok harus berupa angka bulat.'
        ]
    ];
    
    protected $skipValidation = false;
    protected $cleanValidationRules = true;
}