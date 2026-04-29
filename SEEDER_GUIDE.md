# 📦 Panduan Database Seeder - Warung Z&Z

## 🎯 Deskripsi
Seeder ini berisi data produk-produk yang umum dijual di warung kelontong di wilayah **Kepulauan Riau, Batam, dan sekitarnya**. Total ada **90+ produk** dengan merek-merek populer yang beredar di wilayah tersebut.

---

## 📋 Kategori Produk

### 1. **Mie Instan** (9 produk)
- Indomie (Goreng, Soto, Ayam Bawang, Rendang)
- Mie Sedaap (Goreng, Kari Spesial)
- Sarimi, Pop Mie, Mie Gelas

### 2. **Minuman Kemasan** (14 produk)
- Air Mineral: Aqua
- Teh: Teh Botol Sosro, Teh Pucuk Harum, Fruit Tea
- Soda: Coca Cola, Fanta, Sprite
- Isotonik: Pocari Sweat, Mizone
- Minuman Serbuk: Nutrisari, Good Day, Kapal Api, Energen

### 3. **Snack & Keripik** (12 produk)
- Keripik: Chitato, Lays, Taro, Cheetos, Qtela, Maicih
- Coklat: Beng Beng, SilverQueen
- Biskuit: Oreo, Better, Roma Kelapa

### 4. **Bumbu Dapur** (11 produk)
- Penyedap: Royco, Masako
- Kecap: Bango, ABC
- Sambal: Indofood, ABC
- Minyak Goreng: Bimoli, Sania
- Gula & Garam: Gulaku, Refina

### 5. **Susu & Dairy** (6 produk)
- Susu Bubuk: Bendera, Dancow
- Susu Cair: Indomilk, Ultra Milk, Frisian Flag, Bear Brand

### 6. **Kebutuhan Rumah Tangga** (7 produk)
- Detergen: Rinso
- Pelembut: Molto
- Sabun Cuci Piring: Sunlight, Mama Lemon
- Obat Nyamuk: Baygon, Hit
- Pengharum: Stella

### 7. **Personal Care** (7 produk)
- Pasta Gigi: Pepsodent, Close Up
- Sabun: Lifebuoy, Dettol
- Shampoo: Pantene, Clear
- Deodorant: Rexona

### 8. **Rokok** (4 produk)
- Gudang Garam Filter, Sampoerna Mild, Djarum Super, Marlboro

### 9. **Sembako** (4 produk)
- Beras Ramos, Telur Ayam, Tepung Terigu, Tepung Beras

### 10. **Frozen Food** (3 produk)
- Nugget Fiesta, Sosis So Nice, Bakso So Good

### 11. **Lain-lain** (3 produk)
- Gas Elpiji 3kg, Korek Api, Tissue Paseo

---

## 🚀 Cara Menjalankan Seeder

### **Opsi 1: Jalankan Semua Seeder Sekaligus**
```bash
php spark db:seed DatabaseSeeder
```

### **Opsi 2: Jalankan Seeder Produk Saja**
```bash
php spark db:seed WarungProductSeeder
```

### **Opsi 3: Jalankan Seeder User Saja**
```bash
php spark db:seed UserSeeder
```

---

## 👥 Data User yang Dibuat

Setelah menjalankan seeder, Anda bisa login dengan:

### **Admin**
- Username: `admin`
- Password: `admin123`
- Role: Admin (Full Access)

### **Kasir**
- Username: `kasir`
- Password: `kasir123`
- Role: Kasir (Terbatas)

---

## 💰 Rentang Harga Produk

| Kategori | Harga Terendah | Harga Tertinggi |
|----------|----------------|-----------------|
| Mie Instan | Rp 3.500 | Rp 6.000 |
| Minuman | Rp 1.500 | Rp 7.000 |
| Snack | Rp 3.000 | Rp 12.000 |
| Bumbu Dapur | Rp 1.000 | Rp 18.000 |
| Susu | Rp 6.000 | Rp 65.000 |
| Rumah Tangga | Rp 14.000 | Rp 35.000 |
| Personal Care | Rp 4.000 | Rp 25.000 |
| Rokok | Rp 22.000 | Rp 32.000 |
| Sembako | Rp 8.000 | Rp 75.000 |
| Frozen Food | Rp 32.000 | Rp 38.000 |

---

## 📊 Stok Awal

Setiap produk memiliki stok awal yang bervariasi:
- **Produk Fast-Moving** (Mie, Minuman): 70-150 pcs
- **Produk Medium** (Snack, Bumbu): 40-100 pcs
- **Produk Slow-Moving** (Frozen, Sembako): 15-40 pcs

---

## 🔄 Reset Database & Seed Ulang

Jika ingin reset database dan isi ulang:

```bash
# 1. Rollback semua migration
php spark migrate:rollback

# 2. Jalankan migration lagi
php spark migrate

# 3. Jalankan seeder
php spark db:seed DatabaseSeeder
```

---

## 📝 Catatan Penting

1. **Harga Realistis**: Harga disesuaikan dengan harga pasar Batam/Kepri tahun 2024-2025
2. **Merek Lokal**: Semua merek yang tercantum adalah merek yang umum beredar di wilayah tersebut
3. **Stok Dinamis**: Stok akan berkurang otomatis saat ada transaksi penjualan
4. **Soft Delete**: Produk yang dihapus tidak benar-benar hilang, hanya diarsipkan

---

## 🛠️ Troubleshooting

### Error: "Table 'products' doesn't exist"
**Solusi:** Jalankan migration terlebih dahulu
```bash
php spark migrate
```

### Error: "Duplicate entry for key 'PRIMARY'"
**Solusi:** Truncate table products terlebih dahulu
```bash
php spark db:seed DatabaseSeeder --truncate
```

### Ingin menambah produk sendiri?
Edit file: `app/Database/Seeds/WarungProductSeeder.php`

---

## 📞 Support

Jika ada pertanyaan atau ingin menambah produk khusus wilayah Batam/Kepri, silakan hubungi developer.

---

**Happy Coding! 🚀**
