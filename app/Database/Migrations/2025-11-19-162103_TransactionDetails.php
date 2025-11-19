<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TransactionDetails extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'transaction_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'product_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'quantity' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'price' => [
                'type'       => 'DECIMAL', // Harga satuan SAAT transaksi terjadi
                'constraint' => '12,0',
            ],
            'subtotal' => [
                'type'       => 'DECIMAL', // quantity * price
                'constraint' => '12,0',
            ],
        ]);

        $this->forge->addKey('id', true);

        // Menambahkan Foreign Key agar integritas data terjaga
        // Jika transaksi dihapus, detailnya ikut terhapus (CASCADE)
        $this->forge->addForeignKey('transaction_id', 'transactions', 'id', 'CASCADE', 'CASCADE');
        
        // Jika produk dihapus, data penjualan tetap ada atau ditolak (RESTRICT) agar laporan tidak rusak
        $this->forge->addForeignKey('product_id', 'products', 'id', 'RESTRICT', 'RESTRICT');

        $this->forge->createTable('transaction_details');
    }

    public function down()
    {
        $this->forge->dropTable('transaction_details');
    }
}