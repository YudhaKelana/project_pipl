# SQL VERIFICATION SCRIPTS

Gunakan script-script berikut untuk verifikasi database setelah migrasi.

## 1. VERIFIKASI TABEL CASH_FLOWS

```sql
-- Lihat struktur tabel
DESCRIBE cash_flows;

-- Hasil yang diharapkan:
-- +---------------------+----------------+
-- | Field               | Type           |
-- +---------------------+----------------+
-- | id                  | int(11)        |
-- | bulan               | varchar(20)    |
-- | total_modal         | decimal(15,2)  |
-- | total_pengeluaran   | decimal(15,2)  |
-- | total_pemasukan     | decimal(15,2)  |
-- | created_at          | datetime       |
-- | updated_at          | datetime       |
-- +---------------------+----------------+

-- Lihat sample data
SELECT * FROM cash_flows ORDER BY bulan DESC LIMIT 12;

-- Count data per bulan
SELECT bulan, COUNT(*) as jumlah FROM cash_flows GROUP BY bulan;
```

## 2. VERIFIKASI TABEL STOCK_ALERTS

```sql
-- Lihat struktur tabel
DESCRIBE stock_alerts;

-- Hasil yang diharapkan:
-- +----------------+---------------+
-- | Field          | Type          |
-- +----------------+---------------+
-- | id             | int(11)       |
-- | product_id     | int(11)       |
-- | stok_saat_ini  | int(11)       |
-- | status         | varchar(20)   |
-- | tanggal_alert  | datetime      |
-- | sudah_dibaca   | tinyint(1)    |
-- +----------------+---------------+

-- Lihat semua alert
SELECT 
    sa.id, 
    p.nama_barang, 
    sa.stok_saat_ini, 
    sa.status, 
    sa.tanggal_alert
FROM stock_alerts sa
LEFT JOIN products p ON sa.product_id = p.id
ORDER BY sa.tanggal_alert DESC;

-- Lihat alert belum dibaca
SELECT COUNT(*) as unread_alerts FROM stock_alerts WHERE sudah_dibaca = 0;
```

## 3. VERIFIKASI KOLOM PRODUCTS

```sql
-- Lihat struktur tabel products
DESCRIBE products;

-- Verifikasi kolom low_stock_threshold ada
SELECT COLUMN_NAME, DATA_TYPE, COLUMN_DEFAULT 
FROM INFORMATION_SCHEMA.COLUMNS 
WHERE TABLE_NAME = 'products' AND COLUMN_NAME = 'low_stock_threshold';

-- Hasil yang diharapkan:
-- +--------------------+-----------+----------------+
-- | COLUMN_NAME        | DATA_TYPE | COLUMN_DEFAULT |
-- +--------------------+-----------+----------------+
-- | low_stock_threshold| int       | 5              |
-- +--------------------+-----------+----------------+

-- Lihat sample produk dengan threshold
SELECT id, nama_barang, stok, low_stock_threshold 
FROM products 
LIMIT 10;

-- Lihat produk dengan stok menipis (stok <= threshold)
SELECT id, nama_barang, stok, low_stock_threshold
FROM products
WHERE stok <= low_stock_threshold
ORDER BY stok ASC;
```

## 4. QUERY CASH FLOW CALCULATION

```sql
-- Calculate Modal untuk bulan tertentu
-- Modal = Harga Jual * 20%
SELECT 
    DATE_FORMAT(t.tanggal, '%Y-%m') as bulan,
    SUM(td.harga_saat_itu * td.qty) as total_penjualan,
    SUM(td.harga_saat_itu * td.qty) * 0.2 as total_modal
FROM transactions t
JOIN transaction_details td ON t.id = td.transaction_id
WHERE DATE_FORMAT(t.tanggal, '%Y-%m') = '2025-12'
GROUP BY DATE_FORMAT(t.tanggal, '%Y-%m');

-- Calculate Pemasukan untuk bulan tertentu
-- Pemasukan = Total Penjualan - Total Modal
SELECT 
    DATE_FORMAT(t.tanggal, '%Y-%m') as bulan,
    SUM(t.total_bayar) as total_penjualan,
    SUM(t.total_bayar) * 0.2 as total_modal,
    SUM(t.total_bayar) - (SUM(t.total_bayar) * 0.2) as total_pemasukan
FROM transactions t
WHERE DATE_FORMAT(t.tanggal, '%Y-%m') = '2025-12'
GROUP BY DATE_FORMAT(t.tanggal, '%Y-%m');

-- Lihat cash flow per bulan
SELECT 
    cf.bulan,
    cf.total_modal,
    cf.total_pengeluaran,
    cf.total_pemasukan,
    (cf.total_pemasukan - cf.total_pengeluaran) as saldo
FROM cash_flows cf
ORDER BY cf.bulan DESC;
```

## 5. QUERY CHART DATA

```sql
-- Data untuk chart monthly (per bulan, 12 bulan)
SELECT 
    DATE_FORMAT(t.tanggal, '%Y-%m') as bulan,
    DATE_FORMAT(t.tanggal, '%b %Y') as label,
    SUM(t.total_bayar) as omzet
FROM transactions t
WHERE t.tanggal >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH)
GROUP BY DATE_FORMAT(t.tanggal, '%Y-%m')
ORDER BY bulan ASC;

-- Data untuk chart quarterly (per kuartal)
SELECT 
    YEAR(t.tanggal) as tahun,
    QUARTER(t.tanggal) as kuartal,
    CONCAT(YEAR(t.tanggal), '-Q', QUARTER(t.tanggal)) as quarter,
    SUM(t.total_bayar) as omzet
FROM transactions t
WHERE t.tanggal >= DATE_SUB(CURDATE(), INTERVAL 1 YEAR)
GROUP BY YEAR(t.tanggal), QUARTER(t.tanggal)
ORDER BY tahun ASC, kuartal ASC;

-- Data untuk chart semi-annual (per 6 bulan)
SELECT 
    YEAR(t.tanggal) as tahun,
    IF(MONTH(t.tanggal) <= 6, 1, 2) as setengah_tahun,
    CONCAT(YEAR(t.tanggal), '-H', IF(MONTH(t.tanggal) <= 6, 1, 2)) as half_year,
    SUM(t.total_bayar) as omzet
FROM transactions t
WHERE t.tanggal >= DATE_SUB(CURDATE(), INTERVAL 2 YEAR)
GROUP BY YEAR(t.tanggal), IF(MONTH(t.tanggal) <= 6, 1, 2)
ORDER BY tahun ASC, setengah_tahun ASC;
```

## 6. VALIDATION CHECKS

```sql
-- Check: Pastikan semua produk punya threshold value
SELECT COUNT(*) as total_products,
       SUM(CASE WHEN low_stock_threshold IS NULL THEN 1 ELSE 0 END) as null_threshold
FROM products;

-- Expected: null_threshold = 0 (tidak ada NULL)

-- Check: Pastikan tidak ada duplicate cash_flows per bulan
SELECT bulan, COUNT(*) as count
FROM cash_flows
GROUP BY bulan
HAVING count > 1;

-- Expected: No rows (tidak ada hasil = tidak ada duplikat)

-- Check: Count transaksi yang berkontribusi ke cash flow
SELECT 
    DATE_FORMAT(t.tanggal, '%Y-%m') as bulan,
    COUNT(DISTINCT t.id) as jumlah_transaksi,
    SUM(t.total_bayar) as total_omzet
FROM transactions t
WHERE t.tanggal >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH)
GROUP BY DATE_FORMAT(t.tanggal, '%Y-%m')
ORDER BY bulan DESC;
```

## 7. CLEANUP / RESET DATA (JIKA DIPERLUKAN)

⚠️ **HATI-HATI**: Script berikut akan menghapus data!

```sql
-- Hapus semua data stock_alerts (jika perlu reset)
DELETE FROM stock_alerts;

-- Hapus semua data cash_flows dan reset auto-increment
TRUNCATE TABLE cash_flows;

-- Update semua products menjadi threshold default
UPDATE products SET low_stock_threshold = 5 WHERE low_stock_threshold IS NULL;

-- Verifikasi setelah cleanup
SELECT COUNT(*) as total_alerts FROM stock_alerts;
SELECT COUNT(*) as total_cash_flows FROM cash_flows;
SELECT COUNT(*) as null_threshold FROM products WHERE low_stock_threshold IS NULL;
```

---

## QUICK REFERENCE

| Tabel | Rows | Purpose |
|-------|------|---------|
| `cash_flows` | 12 (per bulan) | Simpan kalkulasi kas per bulan |
| `stock_alerts` | Variable | Track notifikasi stok rendah |
| `products` | Existing + 1 col | Tambah threshold untuk alert |

## KOLOM BARU

| Table | Column | Type | Default |
|-------|--------|------|---------|
| products | low_stock_threshold | INT | 5 |
| cash_flows | (table baru) | - | - |
| stock_alerts | (table baru) | - | - |

---

**Generated**: December 1, 2025
