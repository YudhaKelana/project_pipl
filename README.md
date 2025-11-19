<<<<<<< HEAD
# CodeIgniter 4 Application Starter

## What is CodeIgniter?

CodeIgniter is a PHP full-stack web framework that is light, fast, flexible and secure.
More information can be found at the [official site](https://codeigniter.com).

This repository holds a composer-installable app starter.
It has been built from the
[development repository](https://github.com/codeigniter4/CodeIgniter4).

More information about the plans for version 4 can be found in [CodeIgniter 4](https://forum.codeigniter.com/forumdisplay.php?fid=28) on the forums.

You can read the [user guide](https://codeigniter.com/user_guide/)
corresponding to the latest version of the framework.

## Installation & updates

`composer create-project codeigniter4/appstarter` then `composer update` whenever
there is a new release of the framework.

When updating, check the release notes to see if there are any changes you might need to apply
to your `app` folder. The affected files can be copied or merged from
`vendor/codeigniter4/framework/app`.

## Setup

Copy `env` to `.env` and tailor for your app, specifically the baseURL
and any database settings.

## Important Change with index.php

`index.php` is no longer in the root of the project! It has been moved inside the *public* folder,
for better security and separation of components.

This means that you should configure your web server to "point" to your project's *public* folder, and
not to the project root. A better practice would be to configure a virtual host to point there. A poor practice would be to point your web server to the project root and expect to enter *public/...*, as the rest of your logic and the
framework are exposed.

**Please** read the user guide for a better explanation of how CI4 works!

## Repository Management

We use GitHub issues, in our main repository, to track **BUGS** and to track approved **DEVELOPMENT** work packages.
We use our [forum](http://forum.codeigniter.com) to provide SUPPORT and to discuss
FEATURE REQUESTS.

This repository is a "distribution" one, built by our release preparation script.
Problems with it can be raised on our forum, or as issues in the main repository.

## Server Requirements

PHP version 8.1 or higher is required, with the following extensions installed:

- [intl](http://php.net/manual/en/intl.requirements.php)
- [mbstring](http://php.net/manual/en/mbstring.installation.php)

> [!WARNING]
> - The end of life date for PHP 7.4 was November 28, 2022.
> - The end of life date for PHP 8.0 was November 26, 2023.
> - If you are still using PHP 7.4 or 8.0, you should upgrade immediately.
> - The end of life date for PHP 8.1 will be December 31, 2025.

Additionally, make sure that the following extensions are enabled in your PHP:

- json (enabled by default - don't turn it off)
- [mysqlnd](http://php.net/manual/en/mysqlnd.install.php) if you plan to use MySQL
- [libcurl](http://php.net/manual/en/curl.requirements.php) if you plan to use the HTTP\CURLRequest library
=======
# Sistem Point of Sale (POS) dan Manajemen Stok - Warung Z&Z

Repositori ini berisi kode sumber untuk Tugas Besar mata kuliah PIPL (T.A Ganjil 2025/2026). Proyek ini bertujuan untuk melakukan digitalisasi pada "Warung Z&Z" melalui sistem berbasis web.

## 📝 Latar Belakang Masalah
Warung Z&Z merupakan UMKM yang berlokasi strategis namun masih menghadapi kendala operasional karena pengelolaan yang sepenuhnya manual. Permasalahan utama yang diselesaikan oleh sistem ini meliputi:
* **Pengambilan keputusan berbasis intuisi:** Pemilik tidak memiliki data akurat untuk operasional harian.
* **Manajemen Stok:** Kesulitan melacak produk *fast-moving* (laku keras) dan *slow-moving* (kurang laku).
* **Inefisiensi Arus Kas:** Tidak adanya pencatatan sistematis menyebabkan inefisiensi keuangan.

## 🚀 Solusi & Fitur Utama
Sistem ini dirancang untuk mengubah manajemen warung dari berbasis intuisi menjadi berbasis data. Fitur unggulan meliputi:
1.  **Point of Sale (POS):** Pencatatan transaksi penjualan secara *real-time*
2.  **Manajemen Stok Otomatis:** Stok berkurang otomatis saat transaksi terjadi
3.  **Laporan Analisis Produk:** Laporan yang membedakan barang *fast-moving* dan *slow-moving* sebagai dasar evaluasi stok.

## 👥 Anggota Kelompok 1
Mahasiswa Teknik Informatika - Universitas Maritim Raja Ali Haji
* **Rizqi Amanullah** (2301020002)
* **Hilman Yazid Ilhamsyah** (2301020056)
* **Dewa Anggar Wijaya** (2301020058)
* **Muhammad Arroyyan Hamel** (2301020117)
* **Yudha Rifal Kelana** (2301020122)

## 🛠️ Teknologi yang Digunakan
* *Framework CI4, MySQL*
* 
>>>>>>> 06b410f311fd7ff2dc2c254a48b9f1f737d7ec67
