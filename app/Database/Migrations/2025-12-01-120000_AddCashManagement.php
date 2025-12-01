<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCashManagement extends Migration
{
    public function up()
    {
        // 1. Tambah kolom low_stock_threshold ke tabel products (jika belum ada)
        try {
            $this->forge->addColumn('products', [
                'low_stock_threshold' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'default' => 5,
                    'null' => false,
                    'comment' => 'Batas minimum stok sebelum muncul reminder'
                ]
            ]);
        } catch (\Exception $e) {
            // Column already exists, skip
        }

        // 2. Buat tabel cash_flows untuk mencatat aliran kas bulanan
        // Modal = Harga Jual - (Harga Jual * 20%)
        // Pengeluaran = Rekapan bulanan dari modal
        // Pemasukan = Total penjualan - Total modal
        try {
            $this->forge->addField([
                'id' => ['type' => 'INT', 'auto_increment' => true],
                'bulan' => ['type' => 'VARCHAR', 'constraint' => 20, 'comment' => 'Format: YYYY-MM'],
                'total_modal' => [
                    'type' => 'DECIMAL',
                    'constraint' => '15,2',
                    'default' => 0,
                    'comment' => 'Harga Jual - (Harga Jual * 20%)'
                ],
                'total_pengeluaran' => [
                    'type' => 'DECIMAL',
                    'constraint' => '15,2',
                    'default' => 0,
                    'comment' => 'Rekapan pengeluaran bulanan'
                ],
                'total_pemasukan' => [
                    'type' => 'DECIMAL',
                    'constraint' => '15,2',
                    'default' => 0,
                    'comment' => 'Total penjualan - Total modal'
                ],
                'created_at datetime default current_timestamp',
                'updated_at datetime default current_timestamp on update current_timestamp',
            ]);
            $this->forge->addKey('id', true);
            $this->forge->addKey('bulan');
            $this->forge->createTable('cash_flows');
        } catch (\Exception $e) {
            // Table already exists, skip
        }

        // 3. Buat tabel untuk track produk dengan stok menipis
        try {
            $this->forge->addField([
                'id' => ['type' => 'INT', 'auto_increment' => true],
                'product_id' => ['type' => 'INT'],
                'stok_saat_ini' => ['type' => 'INT'],
                'status' => ['type' => 'VARCHAR', 'constraint' => 20, 'comment' => 'menipis atau habis'],
                'tanggal_alert' => ['type' => 'DATETIME', 'null' => false, 'comment' => 'Waktu alert dibuat'],
                'sudah_dibaca' => ['type' => 'BOOLEAN', 'default' => false]
            ]);
            $this->forge->addKey('id', true);
            $this->forge->addKey('product_id');
            $this->forge->createTable('stock_alerts');
            
            // Set default CURRENT_TIMESTAMP untuk tanggal_alert
            $this->db->query("ALTER TABLE stock_alerts MODIFY tanggal_alert DATETIME DEFAULT CURRENT_TIMESTAMP");
        } catch (\Exception $e) {
            // Table already exists, skip
        }
    }

    public function down()
    {
        $this->forge->dropTable('stock_alerts', true);
        $this->forge->dropTable('cash_flows', true);
        $this->forge->dropColumn('products', 'low_stock_threshold');
    }
}
