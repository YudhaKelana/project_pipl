<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        echo "\n🚀 Memulai Database Seeding...\n\n";
        
        // 1. Seed Users (Admin & Kasir)
        echo "📝 Seeding Users...\n";
        $this->call('UserSeeder');
        
        // 2. Seed Products (Barang Warung)
        echo "\n📦 Seeding Products...\n";
        $this->call('WarungProductSeeder');
        
        echo "\n✅ Database Seeding Selesai!\n";
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        echo "📊 Ringkasan:\n";
        echo "   - Users: Admin & Kasir sudah dibuat\n";
        echo "   - Products: 90+ produk warung kelontong\n";
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
    }
}
