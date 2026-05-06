<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ============================================================
// PUBLIC ROUTES (Tidak Perlu Login)
// ============================================================

// Redirect root ke login
$routes->get('/', 'Auth::index');

// Auth Routes
$routes->get('/login', 'Auth::index');
$routes->post('/auth/loginProcess', 'Auth::loginProcess');

// ============================================================
// PROTECTED ROUTES (Wajib Login) - Menggunakan Auth Filter
// ============================================================
$routes->group('', ['filter' => 'auth'], function($routes) {
    
    // Logout (harus login dulu baru bisa logout)
    $routes->get('/logout', 'Auth::logout');
    
    // ========================================
    // PRODUCTS MANAGEMENT
    // ========================================
    $routes->group('products', function($routes) {
        $routes->get('/', 'Products::index');                    // Daftar Produk
        $routes->get('create', 'Products::create');              // Form Tambah
        $routes->post('store', 'Products::store');               // Proses Simpan
        $routes->get('edit/(:num)', 'Products::edit/$1');        // Form Edit
        $routes->post('update/(:num)', 'Products::update/$1');   // Proses Update
        $routes->post('delete/(:num)', 'Products::delete/$1');    // Proses Hapus
    });
    
    // ========================================
    // POS (KASIR)
    // ========================================
    $routes->group('pos', function($routes) {
        $routes->get('/', 'Pos::index');                         // Halaman Kasir
        $routes->get('add/(:num)', 'Pos::addToCart/$1');         // Tambah ke Keranjang
        $routes->get('clear', 'Pos::clearCart');                 // Hapus Keranjang
        $routes->post('process', 'Pos::process');                // Proses Bayar
    });
    
    // ========================================
    // HISTORY (RIWAYAT TRANSAKSI)
    // ========================================
    $routes->group('history', function($routes) {
        $routes->get('/', 'History::index');                     // Daftar Transaksi
        $routes->get('(:num)', 'History::show/$1');              // Detail Invoice
    });
    
    // ========================================
    // REPORTS (LAPORAN - Khusus Admin)
    // ========================================
    $routes->get('reports', 'Reports::index');                   // Laporan Analisis
});
