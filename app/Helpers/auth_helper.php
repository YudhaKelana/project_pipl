<?php

/**
 * Auth Helper
 * Helper functions untuk autentikasi dan otorisasi
 */

if (!function_exists('is_logged_in')) {
    /**
     * Cek apakah user sudah login
     * @return bool
     */
    function is_logged_in(): bool
    {
        return session()->get('isLoggedIn') === true;
    }
}

if (!function_exists('is_admin')) {
    /**
     * Cek apakah user adalah admin
     * @return bool
     */
    function is_admin(): bool
    {
        return session()->get('role') === 'admin';
    }
}

if (!function_exists('is_kasir')) {
    /**
     * Cek apakah user adalah kasir
     * @return bool
     */
    function is_kasir(): bool
    {
        return session()->get('role') === 'kasir';
    }
}

if (!function_exists('require_admin')) {
    /**
     * Redirect jika bukan admin
     * @param string $message Pesan error
     * @return \CodeIgniter\HTTP\RedirectResponse|null
     */
    function require_admin(string $message = 'Akses Ditolak! Hanya Admin yang diizinkan.')
    {
        if (!is_admin()) {
            return redirect()->to('/products')->with('error', $message);
        }
        return null;
    }
}

if (!function_exists('current_user')) {
    /**
     * Ambil data user yang sedang login
     * @return array
     */
    function current_user(): array
    {
        return [
            'id' => session()->get('id'),
            'username' => session()->get('username'),
            'name' => session()->get('name'),
            'role' => session()->get('role'),
        ];
    }
}
