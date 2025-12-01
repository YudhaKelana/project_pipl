<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class HistoricalTransactionSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();
        
        // Ambil daftar ID produk yang ada
        $products = $db->table('products')->get()->getResultArray();
        
        if (empty($products)) {
            echo "Tidak ada produk! Jalankan ProductSeeder dulu.\n";
            return;
        }

        // Generate data 6 bulan ke belakang dari November 2025
        // May (5) -> June (6) -> July (7) -> August (8) -> September (9) -> October (10) -> November (11)
        $months = [5, 6, 7, 8, 9, 10]; // May sampai October 2025
        
        foreach ($months as $month) {
            // Tentukan jumlah hari dalam bulan
            $firstDay = "2025-{$month}-01";
            $lastDay = date('t', strtotime($firstDay)); // Jumlah hari dalam bulan
            
            // Loop setiap hari dalam bulan
            for ($day = 1; $day <= $lastDay; $day++) {
                $tanggal = sprintf("2025-%02d-%02d", $month, $day);
                
                // Random jumlah transaksi per hari (2-6 transaksi sehari)
                $jumlahTransaksiHarian = rand(2, 6);

                for ($x = 0; $x < $jumlahTransaksiHarian; $x++) {
                    
                    // Generate item belanjaan (1-4 jenis barang per struk)
                    $itemCount = rand(1, 4);
                    $totalBayar = 0;
                    $detailData = [];

                    // Acak jam transaksi (8 pagi - 9 malam)
                    $jamAcak = rand(8, 21);
                    $menitAcak = rand(0, 59);
                    $waktuFinal = date('Y-m-d H:i:s', strtotime("$tanggal $jamAcak:$menitAcak:00"));

                    for ($k = 0; $k < $itemCount; $k++) {
                        $randomProduct = $products[array_rand($products)];
                        $qty = rand(1, 3);
                        $harga = $randomProduct['harga_jual'];
                        $subtotal = $qty * $harga;
                        
                        $totalBayar += $subtotal;

                        $detailData[] = [
                            'product_id' => $randomProduct['id'],
                            'qty' => $qty,
                            'harga_saat_itu' => $harga
                        ];
                    }

                    // Simpan Header Transaksi
                    $noFaktur = 'INV-' . date('Ymd', strtotime($waktuFinal)) . '-' . rand(1000, 9999);
                    
                    $db->table('transactions')->insert([
                        'no_faktur' => $noFaktur,
                        'total_bayar' => $totalBayar,
                        'tanggal' => $waktuFinal
                    ]);

                    $transID = $db->insertID();

                    // Simpan Detail Transaksi
                    foreach ($detailData as &$detail) {
                        $detail['transaction_id'] = $transID;
                    }
                    $db->table('transaction_details')->insertBatch($detailData);
                }
            }
        }
        
        echo "✅ Historical transaction data generated successfully!\n";
        echo "📅 Data generated for: May - October 2025\n";
    }
}
