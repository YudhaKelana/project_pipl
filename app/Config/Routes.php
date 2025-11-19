<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Halaman depan langsung ke Kasir
$routes->get('/', 'Pos::index');

// --------------------------------------------------------------------
// 1. ROUTE AUTH (LOGIN/LOGOUT)
// --------------------------------------------------------------------
$routes->get('/login', 'Auth::login');              // Halaman Login
$routes->post('/auth/process', 'Auth::process');    // Proses Login
$routes->get('/logout', 'Auth::logout');            // Proses Logout

// --------------------------------------------------------------------
// 2. ROUTE KASIR (Bebas Akses / Public)
// --------------------------------------------------------------------
$routes->get('/pos', 'Pos::index');                         // Halaman Utama Kasir
$routes->post('/pos/add', 'Pos::add');                      // Aksi Tambah ke Keranjang
$routes->get('/pos/increase/(:num)', 'Pos::increase/$1');   // Tambah Qty (+1)
$routes->get('/pos/decrease/(:num)', 'Pos::decrease/$1');   // Kurang Qty (-1)
$routes->get('/pos/remove/(:num)', 'Pos::removeItem/$1');   // Hapus Item
$routes->get('/pos/clear', 'Pos::clear');                   // Reset Keranjang
$routes->post('/pos/pay', 'Pos::pay');                      // Aksi Bayar
$routes->get('/pos/print/(:num)', 'Pos::printStruk/$1');    // Cetak Struk

// --------------------------------------------------------------------
// 3. ROUTE ADMIN (DILINDUNGI AUTH FILTER)
// --------------------------------------------------------------------
// Semua route di dalam grup ini WAJIB Login dulu
$routes->group('', ['filter' => 'auth'], function($routes) {
    
    // A. Kelola Produk (Stok)
    $routes->group('product', function($routes) {
        $routes->get('/', 'Product::index');
        $routes->get('create', 'Product::create');
        $routes->post('store', 'Product::store');
        $routes->get('edit/(:num)', 'Product::edit/$1');
        $routes->post('update/(:num)', 'Product::update/$1');
        $routes->get('delete/(:num)', 'Product::delete/$1');
    });

    // B. Riwayat Penjualan (BARU)
    $routes->group('history', function($routes) {
        $routes->get('/', 'History::index');                 // Halaman Daftar Riwayat
        $routes->get('detail/(:num)', 'History::detail/$1'); // Halaman Detail Transaksi
    });

     // C. Laporan Analisis (BARU)
    $routes->get('report', 'Report::index');
});