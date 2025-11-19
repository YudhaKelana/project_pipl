<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Halaman utama langsung ke daftar produk (sementara)
$routes->get('/', 'Products::index');

// Grouping routes untuk produk
$routes->group('products', function($routes) {
    $routes->get('/', 'Products::index');       // Menampilkan tabel
    $routes->get('create', 'Products::create'); // Menampilkan form
    $routes->post('store', 'Products::store');  // Proses simpan
});
$routes->group('pos', function($routes) {
    $routes->get('/', 'Pos::index');             // Halaman Kasir
    $routes->get('add/(:num)', 'Pos::addToCart/$1'); // Tambah barang
    $routes->get('clear', 'Pos::clearCart');     // Hapus keranjang
    $routes->post('process', 'Pos::process');    // Bayar
});
$routes->group('products', function($routes) {
    $routes->get('/', 'Products::index');
    $routes->get('create', 'Products::create');
    $routes->post('store', 'Products::store');
    
    // === TAMBAHAN BARU ===
    $routes->get('edit/(:num)', 'Products::edit/$1');   // Form Edit
    $routes->post('update/(:num)', 'Products::update/$1'); // Proses Update
    $routes->get('delete/(:num)', 'Products::delete/$1'); // Proses Hapus
});
$routes->get('reports', 'Reports::index'); // Laporan Analisis Barang
// Halaman Login
$routes->get('/login', 'Auth::index');
$routes->post('/auth/loginProcess', 'Auth::loginProcess');
$routes->get('/logout', 'Auth::logout');

// Halaman Utama jika dibuka, arahkan ke login
$routes->get('/', 'Auth::index');