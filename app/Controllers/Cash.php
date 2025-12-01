<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CashFlowModel;

class Cash extends BaseController
{
    protected $cashFlowModel;

    public function __construct()
    {
        $this->cashFlowModel = new CashFlowModel();
    }

    /**
     * Dashboard Manajemen Kas
     * Tampilkan: Modal, Pengeluaran, Pemasukan per bulan
     */
    public function index()
    {
        // Ambil data 12 bulan terakhir
        $endDate = date('Y-m');
        $startDate = date('Y-m', strtotime('-11 months'));

        // Perbarui semua bulan dalam range jika belum ada
        $currentDate = $startDate;
        while ($currentDate <= $endDate) {
            $this->cashFlowModel->updateMonthlyFlow($currentDate);
            $currentDate = date('Y-m', strtotime($currentDate . ' +1 month'));
        }

        // Ambil data cash flow
        $cashFlows = $this->cashFlowModel->getCashFlowByPeriod($startDate, $endDate);

        // Siapkan data untuk chart
        $months = [];
        $modals = [];
        $pengeluaran = [];
        $pemasukan = [];

        foreach ($cashFlows as $flow) {
            $bulanFormatted = date('M Y', strtotime($flow['bulan'] . '-01'));
            $months[] = $bulanFormatted;
            $modals[] = (float)$flow['total_modal'];
            $pengeluaran[] = (float)$flow['total_pengeluaran'];
            $pemasukan[] = (float)$flow['total_pemasukan'];
        }

        // Hitung total untuk summary
        $totalModal = array_sum($modals);
        $totalPengeluaran = array_sum($pengeluaran);
        $totalPemasukan = array_sum($pemasukan);

        $data = [
            'title' => 'Manajemen Kas',
            'months' => json_encode($months),
            'modals' => json_encode($modals),
            'pengeluaran' => json_encode($pengeluaran),
            'pemasukan' => json_encode($pemasukan),
            'totalModal' => $totalModal,
            'totalPengeluaran' => $totalPengeluaran,
            'totalPemasukan' => $totalPemasukan,
            'cashFlows' => $cashFlows
        ];

        return view('cash/index', $data);
    }

    /**
     * API endpoint untuk update cash flow berdasarkan bulan
     */
    public function updateCashFlow()
    {
        if ($this->request->isAJAX()) {
            $bulan = $this->request->getPost('bulan');

            if (!$bulan) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Bulan harus diisi'
                ]);
            }

            $result = $this->cashFlowModel->updateMonthlyFlow($bulan);

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Data kas berhasil diperbarui',
                'data' => $result
            ]);
        }

        return $this->response->setStatusCode(405);
    }

    /**
     * API endpoint untuk get detail cash flow
     */
    public function getDetail($bulan)
    {
        $cashFlow = $this->cashFlowModel->where('bulan', $bulan)->first();

        if (!$cashFlow) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Data kas tidak ditemukan'
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'data' => $cashFlow
        ]);
    }
}
