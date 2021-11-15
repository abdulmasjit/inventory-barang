-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 15 Nov 2021 pada 14.40
-- Versi server: 10.5.9-MariaDB-log
-- Versi PHP: 7.4.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_inventory`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `app_config`
--

CREATE TABLE `app_config` (
  `id` varchar(10) NOT NULL,
  `nama_sistem` varchar(100) DEFAULT NULL,
  `tagline` varchar(100) DEFAULT NULL,
  `instansi` varchar(100) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  `favicon` varchar(150) DEFAULT NULL,
  `logo` varchar(150) DEFAULT NULL,
  `child_logo` varchar(150) DEFAULT NULL,
  `email_instansi` varchar(50) DEFAULT NULL,
  `pass_instansi` varchar(50) DEFAULT NULL,
  `url_root` varchar(100) DEFAULT NULL,
  `jalan` varchar(100) DEFAULT NULL,
  `kelurahan` varchar(50) DEFAULT NULL,
  `kecamatan` varchar(50) DEFAULT NULL,
  `kabupaten` varchar(50) DEFAULT NULL,
  `provinsi` varchar(50) DEFAULT NULL,
  `kode_pos` varchar(10) DEFAULT NULL,
  `telp` varchar(20) DEFAULT NULL,
  `fax` varchar(20) DEFAULT NULL,
  `akronim_nama_sistem` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `app_config`
--

INSERT INTO `app_config` (`id`, `nama_sistem`, `tagline`, `instansi`, `status`, `favicon`, `logo`, `child_logo`, `email_instansi`, `pass_instansi`, `url_root`, `jalan`, `kelurahan`, `kecamatan`, `kabupaten`, `provinsi`, `kode_pos`, `telp`, `fax`, `akronim_nama_sistem`) VALUES
('CONF1', 'Point Of Sales', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
--

CREATE TABLE `barang` (
  `id_barang` int(11) NOT NULL,
  `kode` varchar(50) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `id_jenis_barang` int(11) DEFAULT NULL,
  `id_satuan` int(11) DEFAULT NULL,
  `harga_beli` int(11) DEFAULT NULL,
  `harga_jual` int(11) DEFAULT NULL,
  `stok` int(11) DEFAULT NULL,
  `foto` varchar(100) DEFAULT NULL,
  `status` varchar(2) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `barang`
--

INSERT INTO `barang` (`id_barang`, `kode`, `nama`, `deskripsi`, `id_jenis_barang`, `id_satuan`, `harga_beli`, `harga_jual`, `stok`, `foto`, `status`, `created_at`, `updated_at`) VALUES
(1, 'B003', 'Mouse Robot', 'Mouse Robot + Bluetooth', 1, 1, 50000, 65000, 100, NULL, '1', '2021-11-09 06:54:58', '2021-11-13 05:54:39'),
(2, 'B001', 'Keyboard Thinkpad', 'Keyboard Thinkpad Backlight', 2, 1, 100000, 150000, 300, NULL, '1', '2021-11-13 06:16:56', '2021-11-13 06:16:56');

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang_keluar`
--

CREATE TABLE `barang_keluar` (
  `id` varchar(50) NOT NULL,
  `nomor_transaksi` varchar(50) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `id_barang` varchar(50) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` varchar(50) DEFAULT NULL,
  `updated_at` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang_masuk`
--

CREATE TABLE `barang_masuk` (
  `id` varchar(50) NOT NULL,
  `nomor_transaksi` varchar(50) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `id_barang` int(11) DEFAULT NULL,
  `id_supplier` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis_barang`
--

CREATE TABLE `jenis_barang` (
  `id` int(11) NOT NULL,
  `kode` varchar(50) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `status` varchar(2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `jenis_barang`
--

INSERT INTO `jenis_barang` (`id`, `kode`, `nama`, `status`, `created_at`, `updated_at`) VALUES
(1, 'MS', 'Mouse', '1', '2021-10-16 07:29:02', '2021-10-17 04:37:43'),
(2, 'KBR', 'Keyboard', '1', '2021-10-16 07:33:23', '2021-10-16 07:33:23'),
(3, 'FD', 'Flash Disk', '1', '2021-10-16 07:50:02', '2021-10-16 07:50:02'),
(4, 'CG', 'Charger', NULL, NULL, NULL),
(5, 'USB', 'USB', NULL, NULL, NULL),
(6, 'LCD', 'LCD', NULL, NULL, NULL),
(15, 'PCR', 'Processor', '1', '2021-10-27 07:38:10', '2021-10-27 07:38:10'),
(17, 'CB 123', 'Coba Barang 123', '1', '2021-11-01 08:44:43', '2021-11-01 08:45:14');

-- --------------------------------------------------------

--
-- Struktur dari tabel `menu`
--

CREATE TABLE `menu` (
  `id_menu` int(11) NOT NULL,
  `nama_menu` varchar(50) DEFAULT NULL,
  `link_menu` varchar(100) DEFAULT NULL,
  `class_icon` varchar(50) DEFAULT NULL,
  `is_parent` varchar(2) DEFAULT NULL,
  `id_parent` varchar(100) DEFAULT NULL,
  `keterangan` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `menu`
--

INSERT INTO `menu` (`id_menu`, `nama_menu`, `link_menu`, `class_icon`, `is_parent`, `id_parent`, `keterangan`) VALUES
(1, 'Dashboard', '/home', 'fa fa-home', '1', NULL, 'Menu Dashboard'),
(2, 'Master Data', '#', 'fa fa-home', '1', NULL, 'Menu Master Data'),
(3, 'Barang', '/master/barang', 'fa fa-home', '2', NULL, 'Menu Master Barang'),
(4, 'Jenis Barang', '/master/jenis-barang', 'fa fa-home', '2', NULL, 'Menu Master Jenis Barang'),
(5, 'Satuan', '/master/satuan', 'fa fa-home', '2', NULL, 'Menu Master Satuan'),
(6, 'Supplier', '/master/supplier', 'fa fa-home', '2', NULL, 'Menu Master Supplier'),
(7, 'Transaksi', '#', 'fa fa-home', '1', NULL, 'Menu Transaksi'),
(8, 'Barang Masuk', '/barang-masuk', 'fa fa-home', '2', NULL, 'Menu Transaksi Barang Masuk'),
(9, 'Barang Keluar', '/barang-keluar', 'fa fa-home', '2', NULL, 'Menu Transaksi Barang Keluar'),
(10, 'Setting', '#', 'fa fa-wrench', '1', NULL, 'Menu Setting'),
(11, 'User', '/setting/user', 'fa fa-home', '2', NULL, 'Menu Setting User');

-- --------------------------------------------------------

--
-- Struktur dari tabel `menu_user`
--

CREATE TABLE `menu_user` (
  `id_menu_user` int(11) NOT NULL,
  `id_menu` int(11) DEFAULT NULL,
  `id_role` varchar(10) DEFAULT NULL,
  `id_posisi` varchar(10) DEFAULT NULL,
  `urutan` smallint(6) DEFAULT NULL,
  `id_parent_menu` int(11) DEFAULT NULL,
  `level` smallint(6) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `menu_user`
--

INSERT INTO `menu_user` (`id_menu_user`, `id_menu`, `id_role`, `id_posisi`, `urutan`, `id_parent_menu`, `level`, `created_at`, `updated_at`) VALUES
(1, 1, 'HA01', '1', 1, NULL, 1, '2021-10-10 12:24:02', '2021-10-10 12:23:49'),
(2, 2, 'HA01', '1', 2, NULL, 1, '2021-10-10 12:24:50', '2021-10-10 12:24:13'),
(3, 3, 'HA01', '1', 1, 2, 2, '2021-10-10 12:25:03', '2021-10-10 12:24:42'),
(4, 4, 'HA01', '1', 2, 2, 2, '2021-10-16 13:09:15', '2021-10-16 13:07:19'),
(5, 5, 'HA01', '1', 3, 2, 2, '2021-10-16 13:09:16', '2021-10-16 13:07:22'),
(6, 6, 'HA01', '1', 4, 2, 2, '2021-10-16 13:09:17', '2021-10-16 13:07:26'),
(7, 7, 'HA01', '1', 3, NULL, 1, '2021-11-15 14:23:20', '2021-11-15 14:22:53'),
(8, 8, 'HA01', '1', 1, 7, 2, '2021-11-15 14:24:41', '2021-11-15 14:23:26'),
(9, 9, 'HA01', '1', 2, 7, 2, '2021-11-15 14:24:42', '2021-11-15 14:23:49'),
(10, 10, 'HA01', '1', 4, NULL, 1, '2021-11-15 14:24:23', '2021-11-15 14:24:11'),
(11, 11, 'HA01', '1', 1, 10, 2, '2021-11-15 14:24:47', '2021-11-15 14:24:27');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `roles`
--

CREATE TABLE `roles` (
  `id_role` varchar(20) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `keterangan` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `roles`
--

INSERT INTO `roles` (`id_role`, `nama`, `keterangan`) VALUES
('HA01', 'Superadmin', 'Role Superadmin'),
('HA02', 'Kasir', 'Role Kasir'),
('HA03', 'Manager', 'Role Manager / Kepala');

-- --------------------------------------------------------

--
-- Struktur dari tabel `satuan`
--

CREATE TABLE `satuan` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `status` varchar(2) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `satuan`
--

INSERT INTO `satuan` (`id`, `nama`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Pcs', '1', '2021-11-06 21:38:44', '2021-11-06 21:38:44'),
(2, 'Kardus', '1', '2021-11-06 21:38:53', '2021-11-06 21:38:53'),
(3, 'Kodi', '1', '2021-11-06 21:39:08', '2021-11-06 21:39:08'),
(4, 'Lusin', '1', '2021-11-06 21:39:16', '2021-11-06 21:39:16'),
(5, 'Rim', '1', '2021-11-06 21:39:28', '2021-11-06 21:39:28'),
(6, 'Roll', '1', '2021-11-06 21:39:34', '2021-11-06 21:39:34'),
(7, 'Pack', '1', '2021-11-06 21:40:06', '2021-11-06 21:41:14');

-- --------------------------------------------------------

--
-- Struktur dari tabel `supplier`
--

CREATE TABLE `supplier` (
  `id` int(11) NOT NULL,
  `kode` varchar(50) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `no_telp` varchar(20) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `status` varchar(2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `supplier`
--

INSERT INTO `supplier` (`id`, `kode`, `nama`, `no_telp`, `alamat`, `keterangan`, `status`, `created_at`, `updated_at`) VALUES
(1, 'KSB', 'Karunia Sejahtera Bersama', '085334545054', 'Jl Rungkut Tengah No 7', 'HPL', '1', '2021-11-07 13:45:50', '2021-11-07 06:45:50');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_role` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `email_verified_at`, `password`, `remember_token`, `status`, `id_role`, `created_at`, `updated_at`) VALUES
(1, 'Muhammad Alkautsar', 'superadmin', 'superadmin@gmail.com', '2021-10-09 13:12:22', '$2y$10$eOAWlmMxjez5Cp1GFHTx0ewfrkifNU3JX6k7Ph407pJ7umSybEtvu', '', '1', 'HA01', '2021-10-09 13:12:04', '2021-10-09 13:12:07');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `app_config`
--
ALTER TABLE `app_config`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`);

--
-- Indeks untuk tabel `barang_keluar`
--
ALTER TABLE `barang_keluar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_barang` (`id_barang`);

--
-- Indeks untuk tabel `barang_masuk`
--
ALTER TABLE `barang_masuk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_barang` (`id_barang`),
  ADD KEY `id_supplier` (`id_supplier`);

--
-- Indeks untuk tabel `jenis_barang`
--
ALTER TABLE `jenis_barang`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indeks untuk tabel `menu_user`
--
ALTER TABLE `menu_user`
  ADD PRIMARY KEY (`id_menu_user`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_role`);

--
-- Indeks untuk tabel `satuan`
--
ALTER TABLE `satuan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `barang`
--
ALTER TABLE `barang`
  MODIFY `id_barang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `jenis_barang`
--
ALTER TABLE `jenis_barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `menu`
--
ALTER TABLE `menu`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `menu_user`
--
ALTER TABLE `menu_user`
  MODIFY `id_menu_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `satuan`
--
ALTER TABLE `satuan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
