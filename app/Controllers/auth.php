<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function index()
    {
        // Jika sudah login, lempar ke dashboard
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/products');
        }
        return view('auth/login');
    }

    public function loginProcess()
    {
        // ✅ VALIDASI INPUT
        if (!$this->validate([
            'username' => 'required|min_length[3]|max_length[50]|alpha_numeric',
            'password' => 'required|min_length[6]|max_length[255]'
        ])) {
            return redirect()->back()->with('error', 'Username dan Password wajib diisi dengan benar!');
        }
        
        $userModel = new UserModel();
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // 1. Cek Username
        $user = $userModel->where('username', $username)->first();

        if ($user) {
            // 2. Cek Password
            if (password_verify($password, $user['password'])) {
                // ✅ REGENERATE SESSION untuk mencegah session fixation
                session()->regenerate();
                
                // Login Sukses -> Simpan data ke Session
                $sessData = [
                    'id'         => $user['id'],
                    'username'   => $user['username'],
                    'name'       => $user['name'],
                    'role'       => $user['role'], // PENTING: Simpan Role
                    'isLoggedIn' => true
                ];
                session()->set($sessData);

                return redirect()->to('/products');
            }
        }

        // Login Gagal
        return redirect()->to('/login')->with('error', 'Username atau Password salah!');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}