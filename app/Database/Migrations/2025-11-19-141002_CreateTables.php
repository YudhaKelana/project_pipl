<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTables extends Migration
{
    public function up()
    {
        // 1. Tabel Produk (Menyimpan Stok)
    $this->forge->addField([
        'id' => ['type' => 'INT', 'auto_increment' => true],
        'nama_barang' => ['type' => 'VARCHAR', 'constraint' => 100],
        'harga_beli'  => ['type' => 'DECIMAL', 'constraint' => '10,2'],
        'harga_jual'  => ['type' => 'DECIMAL', 'constraint' => '10,2'],
        'stok'        => ['type' => 'INT', 'constraint' => 11],
        'created_at datetime default current_timestamp',
        'updated_at datetime default current_timestamp on update current_timestamp',
    ]);
    $this->forge->addKey('id', true);
    $this->forge->createTable('products');

    // 2. Tabel Transaksi (Header Struk)
    $this->forge->addField([
        'id' => ['type' => 'INT', 'auto_increment' => true],
        'no_faktur' => ['type' => 'VARCHAR', 'constraint' => 50],
        'total_bayar' => ['type' => 'DECIMAL', 'constraint' => '10,2'],
        'tanggal' => ['type' => 'DATETIME'],
    ]);
    $this->forge->addKey('id', true);
    $this->forge->createTable('transactions');

    // 3. Tabel Detail Transaksi (Item yang dibeli)
    $this->forge->addField([
        'id' => ['type' => 'INT', 'auto_increment' => true],
        'transaction_id' => ['type' => 'INT'],
        'product_id' => ['type' => 'INT'],
        'qty' => ['type' => 'INT'],
        'harga_saat_itu' => ['type' => 'DECIMAL', 'constraint' => '10,2'],
    ]);
    $this->forge->addKey('id', true);
    $this->forge->createTable('transaction_details');
    }

    public function down()
    {
        //
    }
}
