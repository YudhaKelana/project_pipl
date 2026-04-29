<?php

namespace App\Models;

use CodeIgniter\Model;

class CashFlowModel extends Model
{
    protected $table            = 'cash_flows';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'bulan', 'total_modal', 'total_pengeluaran', 'total_pemasukan'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    /**
     * Hitung modal dari seluruh penjualan sebulan
     * Modal = Harga Jual - (Harga Jual * 20%)
     */
    public function calculateMonthlyModal($bulan)
    {
        $db = \Config\Database::connect();
        
        // ✅ GUNAKAN QUERY BUILDER untuk keamanan
        $builder = $db->table('transactions t');
        $builder->select('SUM(td.harga_saat_itu * td.qty) as total_bayar');
        $builder->join('transaction_details td', 't.id = td.transaction_id');
        $builder->where('DATE_FORMAT(t.tanggal, "%Y-%m")', $bulan);
        
        $result = $builder->get()->getRow();
        $totalBayar = $result->total_bayar ?? 0;
        
        // Modal = 20% dari total bayar
        return $totalBayar * 0.2;
    }

    /**
     * Hitung pemasukan bulanan
     * Pemasukan = Total Penjualan - Total Modal
     */
    public function calculateMonthlyIncome($bulan)
    {
        $db = \Config\Database::connect();
        
        // ✅ GUNAKAN QUERY BUILDER untuk keamanan
        $builder = $db->table('transactions t');
        $builder->select('SUM(t.total_bayar) as total_penjualan');
        $builder->where('DATE_FORMAT(t.tanggal, "%Y-%m")', $bulan);
        
        $result = $builder->get()->getRow();
        $totalPenjualan = $result->total_penjualan ?? 0;
        
        $modal = $this->calculateMonthlyModal($bulan);
        
        return $totalPenjualan - $modal;
    }

    /**
     * Hitung pengeluaran bulanan
     * Pengeluaran = Jumlah dari seluruh modal yang disisihkan
     */
    public function calculateMonthlyExpense($bulan)
    {
        // Pengeluaran diambil dari modal yang telah dikumpulkan
        return $this->calculateMonthlyModal($bulan);
    }

    /**
     * Generate atau update data cash flow untuk bulan tertentu
     */
    public function updateMonthlyFlow($bulan)
    {
        $modal = $this->calculateMonthlyModal($bulan);
        $pemasukan = $this->calculateMonthlyIncome($bulan);
        $pengeluaran = $this->calculateMonthlyExpense($bulan);

        $existing = $this->where('bulan', $bulan)->first();

        if ($existing) {
            $this->update($existing['id'], [
                'total_modal' => $modal,
                'total_pengeluaran' => $pengeluaran,
                'total_pemasukan' => $pemasukan
            ]);
        } else {
            $this->insert([
                'bulan' => $bulan,
                'total_modal' => $modal,
                'total_pengeluaran' => $pengeluaran,
                'total_pemasukan' => $pemasukan
            ]);
        }

        return [
            'bulan' => $bulan,
            'total_modal' => $modal,
            'total_pengeluaran' => $pengeluaran,
            'total_pemasukan' => $pemasukan
        ];
    }

    /**
     * Ambil cash flow untuk range periode
     */
    public function getCashFlowByPeriod($startBulan, $endBulan)
    {
        return $this->where('bulan >=', $startBulan)
                    ->where('bulan <=', $endBulan)
                    ->orderBy('bulan', 'ASC')
                    ->findAll();
    }
}
