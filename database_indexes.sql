-- ============================================================
-- DATABASE INDEXES untuk Optimasi Query
-- Warung Z&Z - CodeIgniter 4
-- ============================================================

-- Indexes untuk tabel PRODUCTS
-- Mempercepat sorting dan filtering
ALTER TABLE `products` ADD INDEX `idx_name` (`name`);
ALTER TABLE `products` ADD INDEX `idx_category` (`category`);
ALTER TABLE `products` ADD INDEX `idx_price` (`price`);
ALTER TABLE `products` ADD INDEX `idx_stock` (`stock`);
ALTER TABLE `products` ADD INDEX `idx_deleted_at` (`deleted_at`);

-- Indexes untuk tabel TRANSACTIONS
-- Mempercepat pencarian dan sorting transaksi
ALTER TABLE `transactions` ADD INDEX `idx_invoice_no` (`invoice_no`);
ALTER TABLE `transactions` ADD INDEX `idx_created_at` (`created_at`);
ALTER TABLE `transactions` ADD INDEX `idx_total_amount` (`total_amount`);

-- Indexes untuk tabel TRANSACTION_DETAILS
-- Mempercepat JOIN dan GROUP BY
ALTER TABLE `transaction_details` ADD INDEX `idx_transaction_id` (`transaction_id`);
ALTER TABLE `transaction_details` ADD INDEX `idx_product_id` (`product_id`);
ALTER TABLE `transaction_details` ADD INDEX `idx_quantity` (`quantity`);

-- Composite Index untuk query yang sering digunakan
-- Mempercepat query dengan multiple WHERE conditions
ALTER TABLE `products` ADD INDEX `idx_category_stock` (`category`, `stock`);
ALTER TABLE `products` ADD INDEX `idx_stock_deleted` (`stock`, `deleted_at`);

-- ============================================================
-- CARA MENJALANKAN:
-- ============================================================
-- 1. Buka phpMyAdmin atau MySQL client
-- 2. Pilih database warung_zz
-- 3. Copy-paste SQL di atas
-- 4. Klik "Go" atau "Execute"
-- 
-- ATAU via command line:
-- mysql -u root -p warung_zz < database_indexes.sql
-- ============================================================

-- ============================================================
-- CEK INDEXES YANG SUDAH ADA:
-- ============================================================
-- SHOW INDEX FROM products;
-- SHOW INDEX FROM transactions;
-- SHOW INDEX FROM transaction_details;
-- ============================================================
