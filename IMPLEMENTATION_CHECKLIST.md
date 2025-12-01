# CHECKLIST IMPLEMENTASI - Fitur Manajemen Kas & Reminder Stok

## ✅ PERSIAPAN

- [ ] Backup database sebelum menjalankan migrasi
- [ ] Pastikan folder `app/Views/cash/` terbuat
- [ ] Pastikan folder `app/Views/components/` terbuat

## ✅ DATABASE

- [ ] Jalankan migrasi: `php spark migrate`
- [ ] Verifikasi tabel `cash_flows` terbuat
- [ ] Verifikasi tabel `stock_alerts` terbuat
- [ ] Verifikasi kolom `low_stock_threshold` ada di tabel `products`

## ✅ MODEL LAYER

- [ ] File `app/Models/CashFlowModel.php` terbuat dan berfungsi
- [ ] File `app/Models/StockAlertModel.php` terbuat dan berfungsi
- [ ] `ProductModel::$allowedFields` sudah update dengan `low_stock_threshold`
- [ ] `ProductModel::$validationRules` sudah update dengan validasi threshold

## ✅ CONTROLLER LAYER

- [ ] File `app/Controllers/Cash.php` terbuat dengan 3 methods:
  - [ ] `index()` - dashboard kas
  - [ ] `updateCashFlow()` - AJAX update
  - [ ] `getDetail()` - AJAX detail
- [ ] `Auth::process()` sudah diupdate dengan `checkLowStockProducts()`
- [ ] `Report::index()` sudah support 3 periode (monthly, quarterly, semi-annual)
- [ ] `Report::getChartDataByPeriod()` method terbuat

## ✅ ROUTING

- [ ] `Config/Routes.php` sudah tambah routes:
  - [ ] GET `/cash` → Cash::index
  - [ ] POST `/cash/update` → Cash::updateCashFlow
  - [ ] GET `/cash/detail/(:any)` → Cash::getDetail

## ✅ VIEW LAYER

### Create / Edit Produk:
- [ ] `products/create.php` sudah tambah field `low_stock_threshold`
- [ ] `products/edit.php` sudah tambah field `low_stock_threshold`

### Dashboard:
- [ ] `cash/index.php` terbuat dengan:
  - [ ] 3 stat cards (Modal, Pengeluaran, Pemasukan)
  - [ ] Line chart dengan 3 series
  - [ ] Detail tabel bulanan
- [ ] `components/stock_reminder.php` terbuat dengan modal popup

### Navbar Update:
- [ ] `products/index.php` navbar sudah tambah link ke Cash
- [ ] `products/index.php` sudah include `stock_reminder.php`
- [ ] `history/index.php` navbar sudah tambah link ke Cash
- [ ] `report/index.php` navbar sudah tambah link ke Cash
- [ ] `report/index.php` sudah tambah period filter buttons

## ✅ TESTING - MANAJEMEN KAS

**Login sebagai Admin:**
```
Username: admin (atau sesuai config)
Password: (sesuai dengan database)
```

**Test Kas:**
1. [ ] Buka menu "Manajemen Kas" di navbar
2. [ ] Verifikasi 3 stat cards muncul (Modal, Pengeluaran, Pemasukan)
3. [ ] Verifikasi chart line muncul dengan 3 series
4. [ ] Verifikasi tabel detail bulanan muncul
5. [ ] Periksa nilai perhitungan modal = 20% dari total bayar

## ✅ TESTING - LAPORAN FLEKSIBEL

**Test Periode Filter:**
1. [ ] Buka menu "Laporan Analisis"
2. [ ] Klik tombol "Bulanan" → chart update menampilkan 12 bulan
3. [ ] Klik tombol "Kuartal" → chart update menampilkan Q1-Q4
4. [ ] Klik tombol "6 Bulan" → chart update menampilkan H1-H2
5. [ ] Label chart berubah sesuai periode
6. [ ] Query string berubah ke `/report?period=quarterly` dll

## ✅ TESTING - REMINDER STOK

**Persiapan Test:**
1. [ ] Login sebagai admin
2. [ ] Buka "Stok Barang"
3. [ ] Edit beberapa produk:
   - [ ] Produk A: Set `Batas Stok Menipis` = 20, Stok = 10
   - [ ] Produk B: Set `Batas Stok Menipis` = 5, Stok = 2
   - [ ] Produk C: Set `Batas Stok Menipis` = 3, Stok = 3
4. [ ] Logout

**Test Modal Reminder:**
1. [ ] Login kembali
2. [ ] Modal popup "Peringatan Stok Produk" harus muncul otomatis
3. [ ] Verifikasi list produk yang alertnya tampil (A, B, C)
4. [ ] Verifikasi badge status: "menipis" atau "habis"
5. [ ] Klik "Perbarui Stok" → redirect ke halaman `/product`
6. [ ] Klik "Tutup" → modal hilang

## ✅ TESTING - INTEGRASI

**Cek Integrasi dengan Existing Features:**
1. [ ] Buat transaksi di POS (penjualan normal)
2. [ ] Cek apakah data kas otomatis terupdate di dashboard kas
3. [ ] Verifikasi modal dihitung = 20% dari total penjualan
4. [ ] Verifikasi pemasukan = total penjualan - modal
5. [ ] Edit stok produk di halaman Produk
6. [ ] Logout-Login kembali
7. [ ] Verifikasi reminder alert update sesuai stok terbaru

## ✅ QUALITY ASSURANCE

**Performance:**
- [ ] Halaman `/cash` loading < 2 detik
- [ ] Chart tidak lag saat render
- [ ] Filter periode chart responsive

**UI/UX:**
- [ ] Semua tombol navbar berfungsi
- [ ] Responsive di mobile (max-width: 768px)
- [ ] Warna & styling konsisten dengan design sebelumnya

**Errors:**
- [ ] Tidak ada console error di browser
- [ ] Tidak ada PHP warning/error di server logs
- [ ] AJAX request berhasil (status 200)

## ✅ PRODUCTION CHECKLIST

Sebelum go-live:
- [ ] Database sudah di-backup
- [ ] Migrasi sudah dijalankan di production
- [ ] Testing sudah lengkap
- [ ] Dokumentasi sudah dibaca
- [ ] Admin sudah ditraining tentang fitur baru
- [ ] Monitor logs 24 jam pertama

## 📝 NOTES

### Jika Ada Error:

**Error: "Unknown column 'low_stock_threshold' in 'where clause'"**
- Solusi: Jalankan `php spark migrate` untuk update schema

**Error: "Table 'stock_alerts' doesn't exist"**
- Solusi: Jalankan `php spark migrate` untuk buat table

**Modal reminder tidak muncul:**
- Cek apakah ada produk dengan stok ≤ threshold
- Cek file `app/Views/components/stock_reminder.php` sudah di-include
- Cek session variable di Auth controller

**Chart periode kosong:**
- Normal jika belum ada transaksi
- Buat transaksi dummy untuk test

---

**Last Updated**: December 1, 2025
**Status**: ✅ READY FOR IMPLEMENTATION
