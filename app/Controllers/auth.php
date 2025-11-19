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
        $userModel = new UserModel();
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // 1. Cek Username
        $user = $userModel->where('username', $username)->first();

        if ($user) {
            // 2. Cek Password
            if (password_verify($password, $user['password'])) {
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