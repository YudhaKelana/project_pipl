<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // Data Dummy 50 Produk Warung Z&Z
        $data = [
            // --- SEMBAKO & BAHAN POKOK ---
            ['nama_barang' => 'Beras Premium 5kg', 'harga_beli' => 62000, 'harga_jual' => 68000, 'stok' => 20],
            ['nama_barang' => 'Beras Eceran 1kg', 'harga_beli' => 12000, 'harga_jual' => 13500, 'stok' => 100],
            ['nama_barang' => 'Minyak Goreng Sania 2L', 'harga_beli' => 32000, 'harga_jual' => 35000, 'stok' => 24],
            ['nama_barang' => 'Minyak Goreng Bimoli 1L', 'harga_beli' => 17000, 'harga_jual' => 19000, 'stok' => 30],
            ['nama_barang' => 'Gula Pasir Gulaku 1kg', 'harga_beli' => 14500, 'harga_jual' => 16500, 'stok' => 50],
            ['nama_barang' => 'Gula Pasir Curah 1/2kg', 'harga_beli' => 7000, 'harga_jual' => 8000, 'stok' => 40],
            ['nama_barang' => 'Telur Ayam 1kg', 'harga_beli' => 24000, 'harga_jual' => 27000, 'stok' => 15],
            ['nama_barang' => 'Tepung Terigu Segitiga Biru 1kg', 'harga_beli' => 11000, 'harga_jual' => 13000, 'stok' => 20],
            ['nama_barang' => 'Blueband Margarin 200g', 'harga_beli' => 9000, 'harga_jual' => 10500, 'stok' => 25],
            ['nama_barang' => 'Santan Kara 65ml', 'harga_beli' => 3000, 'harga_jual' => 4000, 'stok' => 60],

            // --- MIE INSTAN ---
            ['nama_barang' => 'Indomie Goreng Original', 'harga_beli' => 2800, 'harga_jual' => 3500, 'stok' => 200],
            ['nama_barang' => 'Indomie Ayam Bawang', 'harga_beli' => 2700, 'harga_jual' => 3500, 'stok' => 150],
            ['nama_barang' => 'Indomie Soto Mie', 'harga_beli' => 2700, 'harga_jual' => 3500, 'stok' => 150],
            ['nama_barang' => 'Mie Sedaap Goreng', 'harga_beli' => 2800, 'harga_jual' => 3500, 'stok' => 100],
            ['nama_barang' => 'Mie Sedaap Soto', 'harga_beli' => 2700, 'harga_jual' => 3500, 'stok' => 80],
            ['nama_barang' => 'Pop Mie Ayam', 'harga_beli' => 4500, 'harga_jual' => 6000, 'stok' => 40],

            // --- MINUMAN ---
            ['nama_barang' => 'Aqua Botol 600ml', 'harga_beli' => 3000, 'harga_jual' => 4000, 'stok' => 48],
            ['nama_barang' => 'Aqua Gelas (Dus)', 'harga_beli' => 28000, 'harga_jual' => 35000, 'stok' => 10],
            ['nama_barang' => 'Le Minerale 600ml', 'harga_beli' => 3000, 'harga_jual' => 4000, 'stok' => 48],
            ['nama_barang' => 'Teh Pucuk Harum 350ml', 'harga_beli' => 3200, 'harga_jual' => 4000, 'stok' => 50],
            ['nama_barang' => 'Floridina Orange', 'harga_beli' => 2800, 'harga_jual' => 3500, 'stok' => 40],
            ['nama_barang' => 'Kopi Golda', 'harga_beli' => 2800, 'harga_jual' => 3500, 'stok' => 45],
            ['nama_barang' => 'Susu Bear Brand', 'harga_beli' => 9500, 'harga_jual' => 11000, 'stok' => 20],
            ['nama_barang' => 'Pocari Sweat 500ml', 'harga_beli' => 6500, 'harga_jual' => 8000, 'stok' => 15],
            ['nama_barang' => 'Coca Cola 390ml', 'harga_beli' => 4500, 'harga_jual' => 6000, 'stok' => 24],
            ['nama_barang' => 'Sprite 390ml', 'harga_beli' => 4500, 'harga_jual' => 6000, 'stok' => 24],
            
            // --- KOPI SACHET ---
            ['nama_barang' => 'Kopi Kapal Api (Renceng)', 'harga_beli' => 11000, 'harga_jual' => 13000, 'stok' => 30],
            ['nama_barang' => 'Kopi Good Day Cappuccino', 'harga_beli' => 18000, 'harga_jual' => 21000, 'stok' => 25],
            ['nama_barang' => 'Luwak White Koffie', 'harga_beli' => 12000, 'harga_jual' => 14000, 'stok' => 20],
            ['nama_barang' => 'Energen Coklat (Renceng)', 'harga_beli' => 18000, 'harga_jual' => 21000, 'stok' => 15],

            // --- SABUN & KEBERSIHAN ---
            ['nama_barang' => 'Sabun Lifebuoy Merah', 'harga_beli' => 3500, 'harga_jual' => 4500, 'stok' => 50],
            ['nama_barang' => 'Sabun Giv Putih', 'harga_beli' => 3000, 'harga_jual' => 4000, 'stok' => 40],
            ['nama_barang' => 'Shampo Clear Sachet (Renceng)', 'harga_beli' => 10000, 'harga_jual' => 12000, 'stok' => 30],
            ['nama_barang' => 'Shampo Pantene Botol Kecil', 'harga_beli' => 12000, 'harga_jual' => 15000, 'stok' => 10],
            ['nama_barang' => 'Pasta Gigi Pepsodent 190g', 'harga_beli' => 11000, 'harga_jual' => 13500, 'stok' => 20],
            ['nama_barang' => 'Sabun Cuci Rinso Sachet', 'harga_beli' => 900, 'harga_jual' => 1000, 'stok' => 100],
            ['nama_barang' => 'Daia Deterjen 850g', 'harga_beli' => 16000, 'harga_jual' => 19000, 'stok' => 15],
            ['nama_barang' => 'Sunlight Jeruk Nipis 210ml', 'harga_beli' => 4500, 'harga_jual' => 5500, 'stok' => 40],
            ['nama_barang' => 'Pewangi Molto Sachet', 'harga_beli' => 900, 'harga_jual' => 1000, 'stok' => 100],
            
            // --- BUMBU & PELENGKAP ---
            ['nama_barang' => 'Kecap Bango 220ml', 'harga_beli' => 11000, 'harga_jual' => 13000, 'stok' => 24],
            ['nama_barang' => 'Saus Sambal ABC 135ml', 'harga_beli' => 6500, 'harga_jual' => 8000, 'stok' => 24],
            ['nama_barang' => 'Royco Sapi (Renceng)', 'harga_beli' => 5000, 'harga_jual' => 6000, 'stok' => 50],
            ['nama_barang' => 'Garam Dapur Refina', 'harga_beli' => 2500, 'harga_jual' => 3500, 'stok' => 30],
            
            // --- JAJANAN / SNACK ---
            ['nama_barang' => 'Beng-beng', 'harga_beli' => 2000, 'harga_jual' => 2500, 'stok' => 60],
            ['nama_barang' => 'Better', 'harga_beli' => 2000, 'harga_jual' => 2500, 'stok' => 60],
            ['nama_barang' => 'Chitato Sapi Panggang', 'harga_beli' => 6000, 'harga_jual' => 7500, 'stok' => 20],
            ['nama_barang' => 'Qtela Singkong', 'harga_beli' => 5000, 'harga_jual' => 6500, 'stok' => 20],
            ['nama_barang' => 'Roti Aoka Coklat', 'harga_beli' => 2500, 'harga_jual' => 3000, 'stok' => 40],
            ['nama_barang' => 'Oreo Vanilla', 'harga_beli' => 8000, 'harga_jual' => 9500, 'stok' => 15],
            ['nama_barang' => 'Tisu Nice 180 sheets', 'harga_beli' => 9000, 'harga_jual' => 11000, 'stok' => 20],
        ];

        // Fungsi Insert Batch (Langsung masukkan semua sekaligus)
        // Menggunakan Query Builder agar lebih cepat daripada Model save() satu per satu
        $this->db->table('products')->insertBatch($data);
    }
}