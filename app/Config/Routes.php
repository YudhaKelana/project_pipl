<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Login::index'); // Default ke login
$routes->get('/login', 'Login::index');
$routes->post('/login/auth', 'Login::auth');
$routes->get('/login/logout', 'Login::logout');

// Grup rute yang butuh Login
$routes->group('', ['filter' => 'auth'], function($routes) {
    $routes->get('/dashboard', 'Dashboard::index');
    
    // Rute Kasir (Lanjutan sesi sebelumnya)
    $routes->get('/kasir', 'Kasir::index');
    $routes->post('/kasir/add', 'Kasir::add');
    $routes->get('/kasir/clear', 'Kasir::clear');
    $routes->get('/kasir/checkout', 'Kasir::checkout');
    
    // Rute Produk
    $routes->get('/produk', 'Produk::index');
    $routes->get('/produk/create', 'Produk::create');
    $routes->post('/produk/store', 'Produk::store');
    $routes->get('/produk/delete/(:num)', 'Produk::delete/$1');
    
    // Rute Laporan
    $routes->get('/laporan', 'Laporan::index');
});