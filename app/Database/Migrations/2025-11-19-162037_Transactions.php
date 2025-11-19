<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Transactions extends Migration
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
            'invoice_no' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'unique'     => true, // Nomor struk harus unik (misal: INV-20251119-001)
            ],
            'total_amount' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,0',
            ],
            'created_at' => [ // Ini berfungsi sebagai tanggal transaksi
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('transactions');
    }

    public function down()
    {
        $this->forge->dropTable('transactions');
    }
}