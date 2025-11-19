<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class TransactionSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();
        
        // Ambil daftar ID produk yang ada biar datanya valid
        $products = $db->table('products')->get()->getResultArray();
        
        if (empty($products)) {
            echo "Tidak ada produk! Jalankan ProductSeeder dulu.\n";
            return;
        }

        // Loop mundur 14 hari ke belakang
        for ($i = 14; $i >= 0; $i--) {
            // Tentukan tanggal (Hari ini - $i hari)
            $tanggal = Time::now()->subDays($i)->toDateTimeString();
            
            // Random jumlah transaksi per hari (misal 3 sampai 8 transaksi sehari)
            $jumlahTransaksiHarian = rand(3, 8);

            for ($x = 0; $x < $jumlahTransaksiHarian; $x++) {
                
                // 1. Generate Barang Belanjaan (Random 1-5 jenis barang per struk)
                $itemCount = rand(1, 5);
                $totalBayar = 0;
                $detailData = [];

                // Acak jam transaksi agar tidak numpuk di jam yang sama
                $jamAcak = rand(8, 21); // Jam 8 pagi - 9 malam
                $menitAcak = rand(0, 59);
                $waktuFinal = date('Y-m-d H:i:s', strtotime("$tanggal + $jamAcak hours + $menitAcak minutes"));

                for ($k = 0; $k < $itemCount; $k++) {
                    $randomProduct = $products[array_rand($products)];
                    $qty = rand(1, 3); // Beli 1-3 pcs
                    $harga = $randomProduct['harga_jual'];
                    $subtotal = $qty * $harga;
                    
                    $totalBayar += $subtotal;

                    $detailData[] = [
                        'product_id' => $randomProduct['id'],
                        'qty' => $qty,
                        'harga_saat_itu' => $harga
                    ];
                }

                // 2. Simpan Header Transaksi
                $noFaktur = 'INV-' . date('Ymd', strtotime($waktuFinal)) . '-' . rand(1000, 9999);
                
                $db->table('transactions')->insert([
                    'no_faktur' => $noFaktur,
                    'total_bayar' => $totalBayar,
                    'tanggal' => $waktuFinal
                ]);

                $transID = $db->insertID();

                // 3. Simpan Detail Transaksi
                foreach ($detailData as &$detail) {
                    $detail['transaction_id'] = $transID;
                }
                $db->table('transaction_details')->insertBatch($detailData);
            }
        }
    }
}