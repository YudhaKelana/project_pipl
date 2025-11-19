<?php namespace App\Controllers;
use App\Models\UserModel; // Pastikan Anda buat UserModel nanti jika perlu, atau pakai query builder
use CodeIgniter\Controller;

class Login extends Controller
{
    public function index()
    {
        return view('login_view');
    }

    public function auth()
    {
        $session = session();
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');

        $db = \Config\Database::connect();
        // Ambil user dari tabel users
        $user = $db->table('users')->where('username', $username)->get()->getRowArray();

        if ($user) {
            // Verifikasi password (gunakan password_verify jika di hash, untuk skrg kita plain text dulu demi kecepatan)
            // Idealnya: if(password_verify($password, $user['password']))
            if ($password == $user['password']) { 
                $ses_data = [
                    'id'       => $user['id'],
                    'username' => $user['username'],
                    'role'     => $user['role'],
                    'logged_in' => TRUE
                ];
                $session->set($ses_data);
                return redirect()->to('/dashboard');
            } else {
                $session->setFlashdata('msg', 'Password Salah');
                return redirect()->to('/login');
            }
        } else {
            $session->setFlashdata('msg', 'Username tidak ditemukan');
            return redirect()->to('/login');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}