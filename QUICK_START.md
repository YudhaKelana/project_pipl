# QUICK START GUIDE - Fitur Baru

Panduan cepat untuk mengaktifkan dan menggunakan 3 fitur baru sistem.

---

## 🚀 STEP 1: SETUP (5 menit)

### Terminal Commands
```bash
# Masuk ke project
cd c:\laragon\www\ProjectPIPL

# Jalankan migrasi
php spark migrate

# (Optional) Buat data dummy jika belum ada
php spark db:seed ProductSeeder
php spark db:seed TransactionSeeder
```

### Verifikasi
```bash
# Cek migrasi berhasil
php spark migrate:status

# Seharusnya ada 3 migrations:
# ✓ CreateTables
# ✓ Users
# ✓ AddCashManagement
```

---

## 🔓 STEP 2: LOGIN (1 menit)

1. Buka: `http://localhost/ProjectPIPL/login`
2. Username: `admin`
3. Password: `admin123` (atau sesuai data di database)
4. Klik LOGIN

**Hasil**: Jika ada stok menipis, modal reminder otomatis muncul ✅

---

## 💰 STEP 3: MANAJEMEN KAS (3 menit)

Setelah login, klik menu **Manajemen Kas** di sidebar

### Dashboard Kas menampilkan:
- 📊 **Stat Cards**: Modal | Pengeluaran | Pemasukan
- 📈 **Chart Line**: 3 series untuk 12 bulan
- 📋 **Tabel Detail**: Breakdown kas per bulan

### Rumus Perhitungan:
```
Modal        = Total Penjualan × 20%
Pengeluaran  = Total Modal per bulan
Pemasukan    = Total Penjualan - Modal
Saldo        = Pemasukan - Pengeluaran
```

### Contoh Angka:
```
Bulan: Desember 2025
Total Penjualan: Rp 1.000.000
Modal (20%):     Rp 200.000
Pemasukan:       Rp 800.000
Pengeluaran:     Rp 200.000
Saldo:           Rp 600.000
```

---

## 📈 STEP 4: LAPORAN ANALISIS FLEKSIBEL (2 menit)

Klik menu **Laporan Analisis** di sidebar

### Filter Periode Chart
Klik salah satu tombol:
- **Bulanan** (12 bulan) - Data detail per bulan
- **Kuartal** (Q1-Q4) - Grouping per 3 bulan
- **6 Bulan** (H1-H2) - Grouping per 6 bulan

### Kegunaan:
- Bulanan: Lihat trend harian lebih detail
- Kuartal: Lihat tren per musim bisnis
- 6 Bulan: Lihat tren setengah tahunan

---

## 🔔 STEP 5: REMINDER STOK (5 menit)

### Mengatur Threshold Produk

**Dari Menu Stok Barang:**
1. Klik **Tambah Barang** atau **Edit Produk**
2. Lihat field baru: **"Batas Stok Menipis (Reminder)"**
3. Input angka threshold (default: 5)
4. Simpan

**Contoh Setting:**
- Produk A (Indomie): Threshold = 50 unit
- Produk B (Sabun): Threshold = 10 unit
- Produk C (Air): Threshold = 20 unit

### Trigger Reminder

Reminder otomatis muncul saat:
1. Admin **logout**
2. Admin **login kembali**
3. Sistem cek produk: `stok ≤ threshold`
4. Jika ada, **modal popup** ditampilkan

### Modal Reminder menampilkan:
- ⚠️ List produk stok menipis
- 📊 Badge status: "Menipis" atau "Habis"
- 📝 Stok saat ini untuk setiap produk
- 🔗 Tombol "Perbarui Stok" (langsung ke halaman Stok)

---

## 🧪 TEST FITUR (5 menit)

### Test Manajemen Kas
```
1. Buat transaksi di POS (penjualan)
2. Buka menu Manajemen Kas
3. Lihat angka di dashboard terupdate
4. Filter chart dengan tombol periode
```

### Test Reminder Stok
```
1. Edit produk, set threshold = 20, stok = 10
2. Edit lagi threshold = 5, stok = 3
3. Logout
4. Login kembali
5. Verifikasi modal reminder muncul
6. Klik "Perbarui Stok"
```

### Test Laporan Fleksibel
```
1. Buka Laporan Analisis
2. Klik filter "Kuartal"
3. Verifikasi chart berubah menampilkan Q1-Q4
4. Klik "6 Bulan"
5. Verifikasi chart berubah menampilkan H1-H2
```

---

## 🗂️ FILE YANG PERLU DIKETAHUI

### Bacaan Wajib:
1. **README_FITUR_BARU.md** - Overview lengkap
2. **FITUR_BARU.md** - Penjelasan detail
3. **IMPLEMENTATION_CHECKLIST.md** - Checklist implementasi

### Referensi Developer:
- **SQL_VERIFICATION.md** - Query untuk verifikasi database
- Source code di folder `app/Controllers/`, `app/Models/`, `app/Views/`

---

## ❌ TROUBLESHOOTING

### Problem: Modal reminder tidak muncul
**Solusi:**
```
1. Edit produk, set threshold = 5, stok = 2
2. Logout
3. Login lagi
4. Verifikasi modal muncul
```

### Problem: Chart kosong di Manajemen Kas
**Solusi:**
```
1. Buat transaksi POS dulu (minimal 1 transaksi)
2. Buka Manajemen Kas
3. Chart akan ada data
```

### Problem: Filter periode tidak bekerja
**Solusi:**
```
1. Hard refresh browser (Ctrl+F5)
2. Atau buka langsung URL: /report?period=quarterly
```

### Problem: "Unknown column 'low_stock_threshold'"
**Solusi:**
```bash
php spark migrate
# Jalankan ulang migrasi
```

---

## 💡 TIPS & TRICKS

### Tip 1: Cepat Akses Menu
- Bookmark 3 menu baru: `/cash`, `/report`, `/product`

### Tip 2: Update Stok dari Reminder
- Klik tombol "Perbarui Stok" di modal reminder
- Langsung ke halaman edit stok
- Lebih cepat dari cari manual

### Tip 3: Analisis Trend
- Gunakan filter "6 Bulan" untuk lihat trend setengah tahunan
- Gunakan filter "Kuartal" untuk analisis musiman

### Tip 4: Set Threshold Bijak
- Produk fast-moving: Threshold tinggi (50+)
- Produk slow-moving: Threshold rendah (5-10)
- Produk seasonal: Sesuaikan per musim

### Tip 5: Monitor Kas Rutin
- Buka Manajemen Kas seminggu sekali
- Lihat trend pemasukan vs pengeluaran
- Identifikasi bulan dengan performa baik/buruk

---

## 🎯 DAILY WORKFLOW

### Pagi (Admin login)
```
1. Login
2. Cek reminder modal (jika ada stok menipis)
3. Klik "Perbarui Stok" jika perlu
4. Tutup modal → Lanjut kerja
```

### Siang/Sore (Monitoring)
```
1. Buka Manajemen Kas
2. Lihat performa kas hari ini
3. Buka Laporan Analisis
4. Cek trend penjualan
```

### Akhir Bulan (Reporting)
```
1. Buka Manajemen Kas
2. Lihat rangkuman kas bulanan
3. Export data (manual copy-paste ke Excel)
4. Buat laporan untuk owner
```

---

## 📞 BANTUAN CEPAT

**Pertanyaan**: Bagaimana modal dihitung?  
**Jawab**: Modal = 20% dari total penjualan bulanan

**Pertanyaan**: Bisa ubah persentase 20%?  
**Jawab**: Ya, edit file `app/Models/CashFlowModel.php` baris 60

**Pertanyaan**: Reminder stok bisa diatur per produk?  
**Jawab**: Ya, set field "Batas Stok Menipis" saat edit produk

**Pertanyaan**: Chart laporan bisa periode custom?  
**Jawab**: Ada 3 periode: Bulanan, Kuartal, 6 Bulan

---

## 📊 CHEAT SHEET

### URL Shortcuts
```
/cash              → Dashboard Kas
/report            → Laporan Analisis (default bulanan)
/report?period=quarterly   → Laporan per Kuartal
/report?period=semi-annual → Laporan per 6 Bulan
/product           → Kelola Stok
```

### Rumus Cepat
```
Modal        = Total Jual × 20%
Pemasukan    = Total Jual - Modal
Pengeluaran  = Modal
Saldo        = Pemasukan - Pengeluaran
```

### Threshold Tips
```
Stok Kritis      < 5 unit    → Threshold 5
Stok Rendah      5-20 unit   → Threshold 10-15
Stok Normal      20-50 unit  → Threshold 30-40
Stok Banyak      50+ unit    → Threshold 50+
```

---

## ✅ SELESAI!

Anda sudah siap menggunakan 3 fitur baru:
- ✅ Manajemen Kas
- ✅ Laporan Fleksibel  
- ✅ Reminder Stok

**Untuk pertanyaan lebih detail**, baca **FITUR_BARU.md**

---

**Last Updated**: December 1, 2025  
**Quick Start Version**: 1.0
