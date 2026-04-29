<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\StockAlertModel;

class Auth extends BaseController
{
    // 1. Tampilkan Halaman Login
    public function login()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/product');
        }
        return view('auth/login');
    }

    // 2. Proses Login
    public function process()
    {
        // ✅ VALIDASI INPUT
        $validation = \Config\Services::validation();
        $validation->setRules([
            'username' => 'required|min_length[3]|max_length[50]|alpha_numeric',
            'password' => 'required|min_length[6]|max_length[255]'
        ], [
            'username' => [
                'required' => 'Username wajib diisi',
                'min_length' => 'Username minimal 3 karakter',
                'alpha_numeric' => 'Username hanya boleh huruf dan angka'
            ],
            'password' => [
                'required' => 'Password wajib diisi',
                'min_length' => 'Password minimal 6 karakter'
            ]
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->with('error', implode(', ', $validation->getErrors()));
        }

        $model = new UserModel();
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');
        
        $dataUser = $model->where('username', $username)->first();

        if ($dataUser) {
            // Cek Password
            if (password_verify($password, $dataUser['password'])) {
                // ✅ REGENERATE SESSION ID untuk mencegah session fixation
                session()->regenerate();
                
                // Cek stok produk yang menipis
                $stockAlertModel = new StockAlertModel();
                $lowStockAlerts = $stockAlertModel->checkLowStockProducts();

                // Set Session
                session()->set([
                    'username' => $dataUser['username'],
                    'isLoggedIn' => true,
                    'lowStockAlerts' => $lowStockAlerts
                ]);

                return redirect()->to('/product');
            }
        }

        return redirect()->back()->with('error', 'Username atau Password Salah');
    }

    // 3. Logout
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}