<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

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
        $model = new UserModel();
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');
        
        $dataUser = $model->where('username', $username)->first();

        if ($dataUser) {
            // Cek Password
            if (password_verify($password, $dataUser['password'])) {
                // Set Session
                session()->set([
                    'username' => $dataUser['username'],
                    'isLoggedIn' => true
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