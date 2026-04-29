<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ============================================================
// PUBLIC ROUTES (Tidak Perlu Login)
// ============================================================
$routes->get('/login', 'Auth::index');
$routes->post('/auth/loginProcess', 'Auth::loginProcess');

// Redirect root ke login
$routes->get('/', 'Auth::index');

// ============================================================
// PROTECTED ROUTES (Wajib Login) - ✅ MENGGUNAKAN AUTH FILTER
// ============================================================
$routes->group('', ['filter' => 'auth'], function($routes) {
    
    // Logout
    $routes->get('/logout', 'Auth::logout');
    
    // Products Management
    $routes->group('products', function($routes) {
        $routes->get('/', 'Products::index');
        $routes->get('create', 'Products::create');
        $routes->post('store', 'Products::store');
        $routes->get('edit/(:num)', 'Products::edit/$1');
        $routes->post('update/(:num)', 'Products::update/$1');
        $routes->get('delete/(:num)', 'Products::delete/$1');
    });
    
    // POS (Kasir)
    $routes->group('pos', function($routes) {
        $routes->get('/', 'Pos::index');
        $routes->get('add/(:num)', 'Pos::addToCart/$1');
        $routes->get('clear', 'Pos::clearCart');
        $routes->post('process', 'Pos::process');
    });
    
    // History (Riwayat Transaksi)
    $routes->group('history', function($routes) {
        $routes->get('/', 'History::index');
        $routes->get('(:num)', 'History::show/$1');
    });
    
    // Reports (Laporan - Khusus Admin, tapi cek di controller)
    $routes->get('reports', 'Reports::index');
});
