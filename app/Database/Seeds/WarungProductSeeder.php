<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class WarungProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            // ============================================================
            // KATEGORI: MIE INSTAN
            // ============================================================
            [
                'name' => 'Indomie Goreng',
                'category' => 'Mie Instan',
                'price' => 3500,
                'stock' => 100,
            ],
            [
                'name' => 'Indomie Soto',
                'category' => 'Mie Instan',
                'price' => 3500,
                'stock' => 80,
            ],
            [
                'name' => 'Indomie Ayam Bawang',
                'category' => 'Mie Instan',
                'price' => 3500,
                'stock' => 75,
            ],
            [
                'name' => 'Indomie Goreng Rendang',
                'category' => 'Mie Instan',
                'price' => 4000,
                'stock' => 60,
            ],
            [
                'name' => 'Mie Sedaap Goreng',
                'category' => 'Mie Instan',
                'price' => 3500,
                'stock' => 70,
            ],
            [
                'name' => 'Mie Sedaap Kari Spesial',
                'category' => 'Mie Instan',
                'price' => 3500,
                'stock' => 65,
            ],
            [
                'name' => 'Sarimi Isi 2 Ayam Bawang',
                'category' => 'Mie Instan',
                'price' => 4500,
                'stock' => 50,
            ],
            [
                'name' => 'Pop Mie Rasa Ayam',
                'category' => 'Mie Instan',
                'price' => 6000,
                'stock' => 40,
            ],
            [
                'name' => 'Mie Gelas Rasa Soto',
                'category' => 'Mie Instan',
                'price' => 5500,
                'stock' => 35,
            ],

            // ============================================================
            // KATEGORI: MINUMAN KEMASAN
            // ============================================================
            [
                'name' => 'Aqua 600ml',
                'category' => 'Minuman',
                'price' => 4000,
                'stock' => 120,
            ],
            [
                'name' => 'Aqua 1500ml',
                'category' => 'Minuman',
                'price' => 7000,
                'stock' => 80,
            ],
            [
                'name' => 'Teh Botol Sosro 450ml',
                'category' => 'Minuman',
                'price' => 5000,
                'stock' => 90,
            ],
            [
                'name' => 'Teh Pucuk Harum 350ml',
                'category' => 'Minuman',
                'price' => 4000,
                'stock' => 85,
            ],
            [
                'name' => 'Coca Cola 390ml',
                'category' => 'Minuman',
                'price' => 6000,
                'stock' => 70,
            ],
            [
                'name' => 'Fanta Orange 390ml',
                'category' => 'Minuman',
                'price' => 6000,
                'stock' => 65,
            ],
            [
                'name' => 'Sprite 390ml',
                'category' => 'Minuman',
                'price' => 6000,
                'stock' => 60,
            ],
            [
                'name' => 'Pocari Sweat 350ml',
                'category' => 'Minuman',
                'price' => 7000,
                'stock' => 55,
            ],
            [
                'name' => 'Mizone Apple Guava 500ml',
                'category' => 'Minuman',
                'price' => 6500,
                'stock' => 50,
            ],
            [
                'name' => 'Fruit Tea Freeze 350ml',
                'category' => 'Minuman',
                'price' => 5000,
                'stock' => 75,
            ],
            [
                'name' => 'Nutrisari Jeruk (Sachet)',
                'category' => 'Minuman',
                'price' => 1500,
                'stock' => 100,
            ],
            [
                'name' => 'Good Day Cappuccino',
                'category' => 'Minuman',
                'price' => 2500,
                'stock' => 80,
            ],
            [
                'name' => 'Kapal Api Special Mix',
                'category' => 'Minuman',
                'price' => 2000,
                'stock' => 90,
            ],
            [
                'name' => 'Energen Coklat (Sachet)',
                'category' => 'Minuman',
                'price' => 3000,
                'stock' => 70,
            ],

            // ============================================================
            // KATEGORI: SNACK & KERIPIK
            // ============================================================
            [
                'name' => 'Chitato Rasa Sapi Panggang',
                'category' => 'Snack',
                'price' => 10000,
                'stock' => 60,
            ],
            [
                'name' => 'Chitato Rasa Ayam Bakar',
                'category' => 'Snack',
                'price' => 10000,
                'stock' => 55,
            ],
            [
                'name' => 'Lays Rumput Laut',
                'category' => 'Snack',
                'price' => 11000,
                'stock' => 50,
            ],
            [
                'name' => 'Taro Net Rumput Laut',
                'category' => 'Snack',
                'price' => 9000,
                'stock' => 65,
            ],
            [
                'name' => 'Cheetos Jagung Bakar',
                'category' => 'Snack',
                'price' => 8000,
                'stock' => 70,
            ],
            [
                'name' => 'Qtela Singkong Balado',
                'category' => 'Snack',
                'price' => 9500,
                'stock' => 55,
            ],
            [
                'name' => 'Maicih Level 5',
                'category' => 'Snack',
                'price' => 12000,
                'stock' => 40,
            ],
            [
                'name' => 'Beng Beng Coklat',
                'category' => 'Snack',
                'price' => 3000,
                'stock' => 100,
            ],
            [
                'name' => 'SilverQueen Chunky Bar',
                'category' => 'Snack',
                'price' => 12000,
                'stock' => 45,
            ],
            [
                'name' => 'Oreo Vanilla 137g',
                'category' => 'Snack',
                'price' => 11000,
                'stock' => 50,
            ],
            [
                'name' => 'Better Biskuit Kelapa',
                'category' => 'Snack',
                'price' => 6000,
                'stock' => 60,
            ],
            [
                'name' => 'Roma Kelapa 300g',
                'category' => 'Snack',
                'price' => 9000,
                'stock' => 55,
            ],

            // ============================================================
            // KATEGORI: BUMBU DAPUR & MASAK
            // ============================================================
            [
                'name' => 'Royco Ayam (Sachet)',
                'category' => 'Bumbu Dapur',
                'price' => 1000,
                'stock' => 150,
            ],
            [
                'name' => 'Royco Sapi (Sachet)',
                'category' => 'Bumbu Dapur',
                'price' => 1000,
                'stock' => 140,
            ],
            [
                'name' => 'Masako Ayam (Sachet)',
                'category' => 'Bumbu Dapur',
                'price' => 1000,
                'stock' => 130,
            ],
            [
                'name' => 'Bango Kecap Manis 220ml',
                'category' => 'Bumbu Dapur',
                'price' => 12000,
                'stock' => 40,
            ],
            [
                'name' => 'ABC Kecap Manis 275ml',
                'category' => 'Bumbu Dapur',
                'price' => 13000,
                'stock' => 35,
            ],
            [
                'name' => 'Indofood Sambal Botol 340ml',
                'category' => 'Bumbu Dapur',
                'price' => 15000,
                'stock' => 30,
            ],
            [
                'name' => 'ABC Sambal Asli 335ml',
                'category' => 'Bumbu Dapur',
                'price' => 14000,
                'stock' => 28,
            ],
            [
                'name' => 'Bimoli Minyak Goreng 1L',
                'category' => 'Bumbu Dapur',
                'price' => 18000,
                'stock' => 50,
            ],
            [
                'name' => 'Sania Minyak Goreng 1L',
                'category' => 'Bumbu Dapur',
                'price' => 17000,
                'stock' => 45,
            ],
            [
                'name' => 'Gulaku Premium 1kg',
                'category' => 'Bumbu Dapur',
                'price' => 16000,
                'stock' => 40,
            ],
            [
                'name' => 'Garam Refina 250g',
                'category' => 'Bumbu Dapur',
                'price' => 3000,
                'stock' => 80,
            ],

            // ============================================================
            // KATEGORI: SUSU & PRODUK DAIRY
            // ============================================================
            [
                'name' => 'Susu Bendera Putih 400g',
                'category' => 'Susu',
                'price' => 45000,
                'stock' => 25,
            ],
            [
                'name' => 'Dancow Putih 800g',
                'category' => 'Susu',
                'price' => 65000,
                'stock' => 20,
            ],
            [
                'name' => 'Indomilk UHT Coklat 250ml',
                'category' => 'Susu',
                'price' => 6000,
                'stock' => 70,
            ],
            [
                'name' => 'Ultra Milk UHT Full Cream 250ml',
                'category' => 'Susu',
                'price' => 6500,
                'stock' => 65,
            ],
            [
                'name' => 'Frisian Flag Purefarm 900ml',
                'category' => 'Susu',
                'price' => 18000,
                'stock' => 35,
            ],
            [
                'name' => 'Bear Brand 189ml',
                'category' => 'Susu',
                'price' => 10000,
                'stock' => 50,
            ],

            // ============================================================
            // KATEGORI: KEBUTUHAN RUMAH TANGGA
            // ============================================================
            [
                'name' => 'Rinso Detergen Cair 800ml',
                'category' => 'Rumah Tangga',
                'price' => 22000,
                'stock' => 30,
            ],
            [
                'name' => 'Molto Ultra Sekali Bilas 900ml',
                'category' => 'Rumah Tangga',
                'price' => 18000,
                'stock' => 28,
            ],
            [
                'name' => 'Sunlight Jeruk Nipis 800ml',
                'category' => 'Rumah Tangga',
                'price' => 15000,
                'stock' => 35,
            ],
            [
                'name' => 'Mama Lemon 800ml',
                'category' => 'Rumah Tangga',
                'price' => 14000,
                'stock' => 32,
            ],
            [
                'name' => 'Baygon Aerosol 600ml',
                'category' => 'Rumah Tangga',
                'price' => 35000,
                'stock' => 20,
            ],
            [
                'name' => 'Hit Aerosol 600ml',
                'category' => 'Rumah Tangga',
                'price' => 32000,
                'stock' => 22,
            ],
            [
                'name' => 'Stella Pengharum Ruangan',
                'category' => 'Rumah Tangga',
                'price' => 18000,
                'stock' => 25,
            ],

            // ============================================================
            // KATEGORI: PERSONAL CARE
            // ============================================================
            [
                'name' => 'Pepsodent 190g',
                'category' => 'Personal Care',
                'price' => 12000,
                'stock' => 40,
            ],
            [
                'name' => 'Close Up 160g',
                'category' => 'Personal Care',
                'price' => 13000,
                'stock' => 35,
            ],
            [
                'name' => 'Lifebuoy Sabun Batang',
                'category' => 'Personal Care',
                'price' => 4000,
                'stock' => 60,
            ],
            [
                'name' => 'Dettol Sabun Cair 250ml',
                'category' => 'Personal Care',
                'price' => 25000,
                'stock' => 25,
            ],
            [
                'name' => 'Pantene Shampoo 170ml',
                'category' => 'Personal Care',
                'price' => 18000,
                'stock' => 30,
            ],
            [
                'name' => 'Clear Shampoo Anti Ketombe 170ml',
                'category' => 'Personal Care',
                'price' => 19000,
                'stock' => 28,
            ],
            [
                'name' => 'Rexona Roll On 50ml',
                'category' => 'Personal Care',
                'price' => 16000,
                'stock' => 35,
            ],

            // ============================================================
            // KATEGORI: ROKOK (Umum di Warung)
            // ============================================================
            [
                'name' => 'Gudang Garam Filter (Bungkus)',
                'category' => 'Rokok',
                'price' => 23000,
                'stock' => 50,
            ],
            [
                'name' => 'Sampoerna Mild (Bungkus)',
                'category' => 'Rokok',
                'price' => 28000,
                'stock' => 45,
            ],
            [
                'name' => 'Djarum Super (Bungkus)',
                'category' => 'Rokok',
                'price' => 22000,
                'stock' => 40,
            ],
            [
                'name' => 'Marlboro Merah (Bungkus)',
                'category' => 'Rokok',
                'price' => 32000,
                'stock' => 35,
            ],

            // ============================================================
            // KATEGORI: SEMBAKO
            // ============================================================
            [
                'name' => 'Beras Ramos 5kg',
                'category' => 'Sembako',
                'price' => 75000,
                'stock' => 20,
            ],
            [
                'name' => 'Telur Ayam (per 10 butir)',
                'category' => 'Sembako',
                'price' => 28000,
                'stock' => 30,
            ],
            [
                'name' => 'Tepung Terigu Segitiga Biru 1kg',
                'category' => 'Sembako',
                'price' => 12000,
                'stock' => 35,
            ],
            [
                'name' => 'Tepung Beras Rose Brand 500g',
                'category' => 'Sembako',
                'price' => 8000,
                'stock' => 40,
            ],

            // ============================================================
            // KATEGORI: FROZEN FOOD (Populer di Batam)
            // ============================================================
            [
                'name' => 'Nugget Fiesta 500g',
                'category' => 'Frozen Food',
                'price' => 35000,
                'stock' => 25,
            ],
            [
                'name' => 'Sosis So Nice 500g',
                'category' => 'Frozen Food',
                'price' => 32000,
                'stock' => 28,
            ],
            [
                'name' => 'Bakso Sapi So Good 500g',
                'category' => 'Frozen Food',
                'price' => 38000,
                'stock' => 22,
            ],

            // ============================================================
            // KATEGORI: LAIN-LAIN
            // ============================================================
            [
                'name' => 'Gas Elpiji 3kg',
                'category' => 'Lain-lain',
                'price' => 22000,
                'stock' => 15,
            ],
            [
                'name' => 'Korek Api Getek (per pak)',
                'category' => 'Lain-lain',
                'price' => 2000,
                'stock' => 100,
            ],
            [
                'name' => 'Tissue Paseo 250 sheets',
                'category' => 'Lain-lain',
                'price' => 15000,
                'stock' => 40,
            ],
        ];

        // Insert data ke database
        foreach ($products as $product) {
            $this->db->table('products')->insert($product);
        }

        echo "✅ Berhasil menambahkan " . count($products) . " produk warung kelontong!\n";
    }
}
