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
                'name'     => 'Kasir Teladan',
                'role'     => 'kasir',
                'created_at' => date('Y-m-d H:i:s')
            ]
        ];

        // ✅ Cek apakah user sudah ada, jika belum baru insert
        foreach ($data as $user) {
            $exists = $this->db->table('users')
                ->where('username', $user['username'])
                ->countAllResults();
            
            if ($exists == 0) {
                $this->db->table('users')->insert($user);
                echo "✅ User '{$user['username']}' berhasil dibuat\n";
            } else {
                echo "⚠️  User '{$user['username']}' sudah ada, skip...\n";
            }
        }
    }
}