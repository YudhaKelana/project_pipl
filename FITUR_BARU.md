# Dokumentasi Fitur Baru - Sistem Manajemen Kas & Reminder Stok

## 🎯 RINGKASAN FITUR YANG DITAMBAHKAN

Sistem ini telah diperbarui dengan tiga fitur utama:
1. **Manajemen Kas (Cash Management)**
2. **Laporan Analisis Fleksibel (Flexible Report Charts)**
3. **Reminder Stok Menipis (Low Stock Reminder)**

---

## 1️⃣ FITUR MANAJEMEN KAS

### A. Konsep Perhitungan

#### Modal (Capital)
- **Rumus**: Harga Jual × 20%
- **Deskripsi**: Uang modal yang disisihkan dari setiap penjualan
- **Contoh**: Jika harga jual Rp 10.000, modal = Rp 2.000

#### Pengeluaran (Expenses)
- **Rumus**: Total Modal per bulan
- **Deskripsi**: Rekapan keseluruhan modal yang terkumpul dalam sebulan
- **Contoh**: Jika penjualan total Rp 1.000.000, modal pengeluaran = Rp 200.000

#### Pemasukan (Income)
- **Rumus**: Total Penjualan - Total Modal
- **Deskripsi**: Uang bersih yang masuk setelah dikurangi modal
- **Contoh**: Total penjualan Rp 1.000.000 - Modal Rp 200.000 = Pemasukan Rp 800.000

### B. Akses Dashboard Kas

**URL**: `/cash`
**Menu**: Sidebar → "Manajemen Kas"
**Fitur**:
- Tampilan dashboard dengan summary kartu (Modal, Pengeluaran, Pemasukan)
- Grafik line chart untuk visualisasi 3 parameter kas
- Tabel detail kas bulanan dengan saldo
- Data otomatis terupdate berdasarkan transaksi penjualan

### C. Database Schema

**Tabel**: `cash_flows`
```
- id (INT, AUTO_INCREMENT)
- bulan (VARCHAR 20) - Format: YYYY-MM
- total_modal (DECIMAL 15,2)
- total_pengeluaran (DECIMAL 15,2)
- total_pemasukan (DECIMAL 15,2)
- created_at (DATETIME)
- updated_at (DATETIME)
```

### D. Model & Controller

**Model**: `App\Models\CashFlowModel`
- `calculateMonthlyModal($bulan)` - Hitung modal bulanan
- `calculateMonthlyIncome($bulan)` - Hitung pemasukan bulanan
- `calculateMonthlyExpense($bulan)` - Hitung pengeluaran bulanan
- `updateMonthlyFlow($bulan)` - Update/create data kas bulanan
- `getCashFlowByPeriod($start, $end)` - Ambil data periode tertentu

**Controller**: `App\Controllers\Cash`
- `index()` - Dashboard kas dengan data 12 bulan terakhir
- `updateCashFlow()` - AJAX endpoint untuk update kas
- `getDetail($bulan)` - AJAX endpoint untuk detail kas

---

## 2️⃣ FITUR LAPORAN ANALISIS FLEKSIBEL

### A. Periode Laporan

Admin dapat memilih periode laporan omzet:
1. **Bulanan** (Monthly) - 12 bulan terakhir
2. **Kuartal** (Quarterly) - Per 3 bulan, 1 tahun terakhir
3. **Setengah Tahunan** (Semi-Annual) - Per 6 bulan, 2 tahun terakhir

### B. Akses & Penggunaan

**URL**: `/report`
**Default**: Menampilkan periode Bulanan
**Filter**: Klik tombol di header chart (Bulanan | Kuartal | 6 Bulan)
**Query String**: `/report?period=quarterly` atau `/report?period=semi-annual`

### C. Logika Filtering

- **Bulanan**: Grouping per bulan, memunculkan 12 label
- **Kuartal**: Grouping per 3 bulan (Q1, Q2, Q3, Q4), menampilkan 4 label
- **Semi-Annual**: Grouping per 6 bulan (H1, H2), menampilkan hingga 4 label

Data hanya ditampilkan jika ada transaksi. Jika tidak ada data untuk periode tertentu, chart tetap responsif tanpa error.

### D. Database Query

Chart menggunakan raw SQL query dengan GROUP BY date functions MySQL:
```sql
SELECT DATE_FORMAT(tanggal, '%Y-%m') as bulan, SUM(total_bayar) as omzet
FROM transactions
WHERE tanggal >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH)
GROUP BY DATE_FORMAT(tanggal, '%Y-%m')
ORDER BY bulan ASC
```

---

## 3️⃣ FITUR REMINDER STOK MENIPIS

### A. Konsep

- **Trigger**: Admin login
- **Kondisi**: Stok produk ≤ Batas Stok Menipis (low_stock_threshold)
- **Tampilan**: Modal popup otomatis
- **Informasi**: Nama produk, stok saat ini, status (menipis/habis)

### B. Pengaturan Batas Stok

**Di Halaman Tambah/Edit Produk**:
- Field baru: "Batas Stok Menipis (Reminder)"
- Default value: 5 unit
- Admin dapat mengubah sesuai kebutuhan per produk

**Contoh**:
- Produk A: Threshold = 5 → Alert ketika stok ≤ 5
- Produk B: Threshold = 2 → Alert ketika stok ≤ 2

### C. Alur Reminder

1. Admin login via `/login`
2. Sistem otomatis cek produk dengan stok rendah
3. Jika ada, modal popup ditampilkan
4. Admin bisa langsung klik "Perbarui Stok" → ke halaman `/product`
5. Admin tutup modal setelah membaca

### D. Database Schema

**Tabel**: `products` (kolom baru)
```
- low_stock_threshold (INT, DEFAULT 5)
```

**Tabel**: `stock_alerts` (untuk tracking alert)
```
- id (INT, AUTO_INCREMENT)
- product_id (INT)
- stok_saat_ini (INT)
- status (VARCHAR 20) - 'menipis' atau 'habis'
- tanggal_alert (DATETIME)
- sudah_dibaca (BOOLEAN, DEFAULT FALSE)
```

### E. Model & Controller

**Model**: `App\Models\StockAlertModel`
- `getUnreadAlerts()` - Ambil alert belum dibaca
- `checkLowStockProducts()` - Cek stok rendah dan buat alert
- `markAsRead($alertId)` - Tandai alert sudah dibaca

**Controller**: `App\Controllers\Auth`
- `process()` - Diperbaharui untuk cek stok saat login

### F. View Component

**File**: `app/Views/components/stock_reminder.php`
- Modal popup dengan styling Bootstrap
- List produk dengan stok menipis
- Badge untuk status (menipis/habis)
- Tombol action untuk update stok

---

## 📋 PERUBAHAN FILE

### File Dibuat:
1. ✅ `app/Database/Migrations/2025-12-01-120000_AddCashManagement.php`
2. ✅ `app/Models/CashFlowModel.php`
3. ✅ `app/Models/StockAlertModel.php`
4. ✅ `app/Controllers/Cash.php`
5. ✅ `app/Views/cash/index.php`
6. ✅ `app/Views/components/stock_reminder.php`

### File Dimodifikasi:
1. ✅ `app/Models/ProductModel.php` - Tambah field validasi low_stock_threshold
2. ✅ `app/Controllers/Report.php` - Tambah filter periode chart
3. ✅ `app/Controllers/Auth.php` - Tambah cek stok saat login
4. ✅ `app/Config/Routes.php` - Tambah routes untuk cash management
5. ✅ `app/Views/products/index.php` - Tambah navbar link cash + stock reminder
6. ✅ `app/Views/products/create.php` - Tambah field low_stock_threshold
7. ✅ `app/Views/products/edit.php` - Tambah field low_stock_threshold
8. ✅ `app/Views/report/index.php` - Tambah navbar link cash + period filter buttons
9. ✅ `app/Views/history/index.php` - Tambah navbar link cash

---

## 🚀 PANDUAN IMPLEMENTASI

### Step 1: Jalankan Migrasi
```bash
php spark migrate
```

### Step 2: Verifikasi Database
Pastikan tabel baru terbuat:
- `cash_flows`
- `stock_alerts`

Pastikan kolom baru ada di `products`:
- `low_stock_threshold`

### Step 3: Test Fitur

#### Test Manajemen Kas:
1. Login sebagai admin
2. Buka menu "Manajemen Kas"
3. Verifikasi chart dan tabel kas muncul
4. Ubah filter periode (Bulanan → Kuartal → 6 Bulan)

#### Test Laporan Fleksibel:
1. Buka menu "Laporan Analisis"
2. Klik tombol period filter
3. Verifikasi chart berubah sesuai filter

#### Test Reminder Stok:
1. Logout
2. Edit beberapa produk, set threshold rendah (misal 20 unit)
3. Edit stok produk menjadi di bawah threshold (misal 10 unit)
4. Login kembali
5. Verifikasi modal reminder popup muncul

---

## 🔄 INTEGRASI DENGAN EXISTING FEATURES

### Transaksi Penjualan
- Data kas otomatis terhitung dari tabel `transactions` dan `transaction_details`
- Setiap penjualan berkontribusi pada perhitungan modal & pemasukan

### Stok Produk
- Field `low_stock_threshold` ada di setiap produk
- Reminder otomatis trigger saat login jika stok rendah
- Admin edit langsung dari modal reminder

### Laporan & Analisis
- Chart omzet sekarang lebih fleksibel dengan filter periode
- Fast/Slow Moving analysis tetap berjalan normal
- Modal kas bisa diintegrasikan ke dashboard analisis di masa depan

---

## 💾 BACKUP DATABASE

Sebelum menjalankan migrasi, sangat disarankan untuk backup database:
```bash
# Backup MySQL
mysqldump -u username -p database_name > backup_database.sql
```

---

## 📞 TROUBLESHOOTING

### Error: "Unknown column 'low_stock_threshold'"
**Solusi**: Pastikan migrasi sudah dijalankan dengan `php spark migrate`

### Error: "Table 'cash_flows' doesn't exist"
**Solusi**: Jalankan migrasi: `php spark migrate`

### Modal reminder tidak muncul setelah login
**Solusi**:
1. Pastikan ada produk dengan stok ≤ threshold
2. Pastikan `stock_alerts` table terbuat
3. Cek session variable `lowStockAlerts` di view

### Chart periode menampilkan label kosong
**Solusi**: Ini normal jika tidak ada data. Gunakan data dummy atau buat transaksi test.

---

## 🎨 CUSTOMIZATION

### Mengubah Persentase Modal
**File**: `app/Models/CashFlowModel.php`, baris `$totalBayar * 0.2`
```php
// Ubah 0.2 (20%) menjadi nilai lain, misal 0.25 (25%)
return $totalBayar * 0.25;
```

### Mengubah Default Threshold
**File**: `app/Database/Migrations/2025-12-01-120000_AddCashManagement.php`
```php
'low_stock_threshold' => [
    'type' => 'INT',
    'default' => 5, // Ubah value default di sini
    ...
]
```

### Mengubah Warna Chart
**File**: `app/Views/cash/index.php`, dalam section `<script>` bagian `Chart`
```javascript
borderColor: '#28a745', // Ubah warna border
backgroundColor: 'rgba(40, 167, 69, 0.1)', // Ubah background
```

---

## 📊 SUMMARY

| Fitur | Status | Akses | Database |
|-------|--------|-------|----------|
| Manajemen Kas | ✅ Live | `/cash` | `cash_flows` |
| Laporan Fleksibel | ✅ Live | `/report?period=X` | Existing |
| Reminder Stok | ✅ Live | Login → Modal | `stock_alerts`, `products.low_stock_threshold` |

**Total Fitur Baru**: 3
**Total Database Table Baru**: 2 (cash_flows, stock_alerts)
**Total Database Column Baru**: 1 (low_stock_threshold di products)
**Total File Baru**: 6
**Total File Modified**: 9

---

Generated: December 1, 2025
