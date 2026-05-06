<?php

/**
 * Helper: Cek apakah user yang sedang login adalah Admin.
 * Jika bukan, redirect kembali ke halaman sebelumnya dengan pesan error.
 *
 * @param string $message Pesan error yang ditampilkan jika bukan admin
 * @return \CodeIgniter\HTTP\RedirectResponse|null
 */
function require_admin(string $message = 'Akses Ditolak! Hanya Admin yang dapat mengakses fitur ini.'): ?\CodeIgniter\HTTP\RedirectResponse
{
    if (session()->get('role') !== 'admin') {
        return redirect()->back()->with('error', $message);
    }

    return null;
}
