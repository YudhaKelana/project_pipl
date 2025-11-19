<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'username' => 'admin',
                'password' => password_hash('admin123', PASSWORD_DEFAULT), // Password: admin123
                'name'     => 'Bos Zhanny',
                'role'     => 'admin',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'username' => 'kasir',
                'password' => password_hash('kasir123', PASSWORD_DEFAULT), // Password: kasir123
                'name'     => 'Pegawai Teladan',
                'role'     => 'kasir',
                'created_at' => date('Y-m-d H:i:s')
            ]
        ];

        // Masukkan data ke tabel users
        $this->db->table('users')->insertBatch($data);
    }
}