-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 01 Jan 2022 pada 07.29
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
  `stok_minimum` int(11) DEFAULT NULL,
  `foto` varchar(100) DEFAULT NULL,
  `status` varchar(2) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `barang`
--

INSERT INTO `barang` (`id_barang`, `kode`, `nama`, `deskripsi`, `id_jenis_barang`, `id_satuan`, `harga_beli`, `harga_jual`, `stok`, `stok_minimum`, `foto`, `status`, `created_at`, `updated_at`) VALUES
(1, 'BRG00001', 'Mouse Robot', 'Mouse Robot + Bluetooth', 1, 1, 50000, 65000, 100, NULL, NULL, '1', '2021-11-09 06:54:58', '2021-11-13 05:54:39'),
(2, 'BRG00002', 'Keyboard Thinkpad', 'Keyboard Thinkpad Backlight', 2, 1, 100000, 150000, 300, NULL, NULL, '1', '2021-11-13 06:16:56', '2021-11-13 06:16:56'),
(3, 'BRG00003', 'Laptop Lenovo Thinkpad T440 Ram 8', 'Ram 8, SSD 128, hardisk 500 GB', 17, 8, 3800000, 4200000, 40, NULL, NULL, '1', '2021-12-07 14:53:29', '2021-12-07 14:53:29');

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang_history`
--

CREATE TABLE `barang_history` (
  `id` varchar(50) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `id_barang` int(11) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `harga` double DEFAULT NULL,
  `hpp` double DEFAULT NULL,
  `sumber` varchar(20) DEFAULT NULL,
  `id_transaksi` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Sumber : \r\n1. TBM = Transaksi Barang Masuk\r\n2. TBK = Transaksi Barang Keluar\r\n3. MS = Mutasi Stok\r\n4. MBH = Mutasi Barang Hilang\r\n5. MBR = Mutasi Barang Rusak\r\n\r\n';

--
-- Dumping data untuk tabel `barang_history`
--

INSERT INTO `barang_history` (`id`, `tanggal`, `id_barang`, `keterangan`, `qty`, `harga`, `hpp`, `sumber`, `id_transaksi`, `created_at`, `updated_at`) VALUES
('d5c2e85d-7e6b-4e80-92b7-d2088b0d872a', '2021-12-19', 1, 'Barang Masuk', 100, NULL, NULL, 'TBM', 'fd49187f-1c1f-4d36-b61d-4e6aefb6bc18', '2021-12-19 12:53:46', '2021-12-19 12:53:46'),
('e8ed69a1-b6a4-4df2-93e7-eb33e3f052ee', '2021-12-19', 3, 'Barang Masuk', 10, NULL, NULL, 'TBM', 'fd49187f-1c1f-4d36-b61d-4e6aefb6bc18', '2021-12-19 12:53:46', '2021-12-19 12:53:46'),
('55bf278c-e932-4c81-be91-944dc265c1c3', '2021-12-19', 2, 'Barang Masuk', 20, NULL, NULL, 'TBM', 'fd49187f-1c1f-4d36-b61d-4e6aefb6bc18', '2021-12-19 12:53:46', '2021-12-19 12:53:46'),
('0e05b8ad-3870-4123-830b-98641e9ccafe', '2021-12-19', 1, 'Barang Keluar', -1, NULL, NULL, 'TBK', '9e432c20-945f-4ddc-83c8-30f3bec59bd0', '2021-12-19 12:55:01', '2021-12-19 12:55:01'),
('ce2f7e4b-e2d3-44dc-9f22-e23a5847c2af', '2021-12-19', 3, 'Barang Keluar', -1, NULL, NULL, 'TBK', '9e432c20-945f-4ddc-83c8-30f3bec59bd0', '2021-12-19 12:55:01', '2021-12-19 12:55:01'),
('2ffaa57a-f8f9-4191-9330-858876112aa9', '2021-12-01', 3, 'Barang Masuk', 5, NULL, NULL, 'TBM', '3568f34b-f550-49c3-987f-2073c5da53e2', '2021-12-19 13:23:32', '2021-12-19 13:23:32'),
('84be4d1d-d8da-4b01-9c4f-e41bf5b14680', '2021-12-20', 1, 'Barang Rusak Terjatuh', -4, NULL, NULL, 'MBR', 'e62e7a9a-9217-4440-ac29-9831ebf352db', '2021-12-20 13:57:01', '2021-12-20 14:44:50'),
('203b35f0-f2cb-43a1-a4c9-bb4f9783ffbc', '2021-12-20', 2, 'Barang Hilang', -1, NULL, NULL, 'MBH', '9c783e92-e0cc-413c-9409-d9d813a4ffce', '2021-12-20 14:45:18', '2021-12-20 14:45:18'),
('3ad979a5-5aa2-420a-a0b0-3f83065af86d', '2021-12-20', 3, 'Input Barang Stok Lama Dari Gudang Bulan November 2021', 1, NULL, NULL, 'MS', 'c375fdba-0da5-4960-a7b6-ed90e0eef817', '2021-12-20 14:50:18', '2021-12-20 14:55:52'),
('e38e102a-d003-4d16-99f6-a33cf65fe1fe', '2021-12-31', 1, 'Barang Masuk', 2, 50000, NULL, 'TBM', '08380889-ca73-42d3-8021-37f95c848c61', '2021-12-31 07:31:59', '2021-12-31 07:31:59'),
('f1f686ac-08db-4637-bcb9-11f358bedad9', '2021-12-31', 2, 'Barang Masuk', 2, 120000, NULL, 'TBM', '08380889-ca73-42d3-8021-37f95c848c61', '2021-12-31 07:31:59', '2021-12-31 07:31:59'),
('0cb64a64-5778-40ed-becf-a0b7a3595176', '2021-12-31', 2, 'Barang Keluar', -2, 150000, NULL, 'TBK', 'd3967f6d-7b56-4936-bffb-f1637ad3074b', '2021-12-31 08:52:24', '2021-12-31 08:52:24'),
('c8de6b58-54b5-48ca-a35c-3936efc75952', '2021-12-31', 3, 'Barang Keluar', -1, 4200000, NULL, 'TBK', 'd3967f6d-7b56-4936-bffb-f1637ad3074b', '2021-12-31 08:52:24', '2021-12-31 08:52:24'),
('34354abd-af1d-46ed-8a13-512c0e29dc84', '2021-12-31', 3, 'Barang Keluar', -2, 4200000, NULL, 'TBK', 'b7e6d824-7faa-4f53-aa86-50dbde26014e', '2021-12-31 10:03:54', '2021-12-31 10:03:54');

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang_keluar`
--

CREATE TABLE `barang_keluar` (
  `id` varchar(50) NOT NULL,
  `nomor_transaksi` varchar(20) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `customer` varchar(100) DEFAULT NULL,
  `total` double DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `status` varchar(2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `barang_keluar`
--

INSERT INTO `barang_keluar` (`id`, `nomor_transaksi`, `tanggal`, `customer`, `total`, `id_user`, `keterangan`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
('9e432c20-945f-4ddc-83c8-30f3bec59bd0', 'TRK20211219001', '2021-12-19', NULL, 0, 1, 'Save 1', '1', '2021-12-19 12:55:01', '2021-12-19 12:55:01', NULL),
('b7e6d824-7faa-4f53-aa86-50dbde26014e', 'TRK20211219002', '2021-12-19', 'Bambang Tri', 8400000, 1, 'Pengadaaan HPL 123', '1', '2021-12-19 16:02:13', '2021-12-31 10:03:54', NULL),
('d3967f6d-7b56-4936-bffb-f1637ad3074b', 'TRK20211231001', '2021-12-31', 'Adira Sahara UPDATE', 4490000, 1, 'UPDATE', '1', '2021-12-31 08:34:30', '2021-12-31 08:52:24', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang_keluar_detail`
--

CREATE TABLE `barang_keluar_detail` (
  `id` varchar(50) NOT NULL,
  `id_barang_keluar` varchar(50) DEFAULT NULL,
  `id_barang` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `harga` double DEFAULT NULL,
  `diskon` double DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `barang_keluar_detail`
--

INSERT INTO `barang_keluar_detail` (`id`, `id_barang_keluar`, `id_barang`, `jumlah`, `harga`, `diskon`, `keterangan`, `created_at`, `updated_at`) VALUES
('3ad39b30-cd8a-434d-9c14-ccbec02ce52e', '9e432c20-945f-4ddc-83c8-30f3bec59bd0', 3, 1, NULL, NULL, NULL, '2021-12-19 12:55:01', '2021-12-19 12:55:01'),
('50b35631-e8b4-4b93-9e9c-464d9d358fac', 'd3967f6d-7b56-4936-bffb-f1637ad3074b', 3, 1, 4200000, 0, NULL, '2021-12-31 08:52:24', '2021-12-31 08:52:24'),
('5be2d72c-f569-4e0f-b090-5a2a92475fb6', '9e432c20-945f-4ddc-83c8-30f3bec59bd0', 1, 1, NULL, NULL, NULL, '2021-12-19 12:55:01', '2021-12-19 12:55:01'),
('620bab69-4bb9-4783-8c89-d575fb865549', 'd3967f6d-7b56-4936-bffb-f1637ad3074b', 2, 2, 150000, 10000, NULL, '2021-12-31 08:52:24', '2021-12-31 08:52:24'),
('8f8b0052-ed24-4bb3-adaa-7418c244e40e', 'b7e6d824-7faa-4f53-aa86-50dbde26014e', 3, 2, 4200000, 0, NULL, '2021-12-31 10:03:54', '2021-12-31 10:03:54');

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang_masuk`
--

CREATE TABLE `barang_masuk` (
  `id` varchar(50) NOT NULL,
  `nomor_transaksi` varchar(20) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `id_supplier` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `total` double DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `status` varchar(2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `barang_masuk`
--

INSERT INTO `barang_masuk` (`id`, `nomor_transaksi`, `tanggal`, `id_supplier`, `id_user`, `total`, `keterangan`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
('08380889-ca73-42d3-8021-37f95c848c61', 'TRM20211231001', '2021-12-31', 2, 1, 320000, 'Coba Harga UPDATE', '1', '2021-12-31 06:55:13', '2021-12-31 07:31:59', NULL),
('3568f34b-f550-49c3-987f-2073c5da53e2', 'TRM20211219002', '2021-12-01', 3, 1, NULL, NULL, '1', '2021-12-19 13:23:32', '2021-12-19 13:23:32', NULL),
('fd49187f-1c1f-4d36-b61d-4e6aefb6bc18', 'TRM20211219001', '2021-12-19', 2, 1, NULL, 'Pengadaaan HPL 1', '1', '2021-12-19 12:53:46', '2021-12-19 12:53:46', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang_masuk_detail`
--

CREATE TABLE `barang_masuk_detail` (
  `id` varchar(50) NOT NULL,
  `id_barang_masuk` varchar(50) DEFAULT NULL,
  `id_barang` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `harga` double DEFAULT NULL,
  `diskon` double DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `barang_masuk_detail`
--

INSERT INTO `barang_masuk_detail` (`id`, `id_barang_masuk`, `id_barang`, `jumlah`, `harga`, `diskon`, `keterangan`, `created_at`, `updated_at`) VALUES
('6380e9a1-bc4d-4611-80ae-8146e9e979a3', 'fd49187f-1c1f-4d36-b61d-4e6aefb6bc18', 3, 10, NULL, 0, NULL, '2021-12-19 12:53:46', '2021-12-19 12:53:46'),
('6cd4f35d-99c1-49a7-a634-bfe365f750dc', '08380889-ca73-42d3-8021-37f95c848c61', 2, 2, 120000, 20000, NULL, '2021-12-31 07:31:59', '2021-12-31 07:31:59'),
('92917df7-64dd-453b-99f9-65ed5fabc25f', '3568f34b-f550-49c3-987f-2073c5da53e2', 3, 5, NULL, 0, NULL, '2021-12-19 13:23:32', '2021-12-19 13:23:32'),
('c567c626-b1c3-4b4b-a9f9-6beee4e25b80', 'fd49187f-1c1f-4d36-b61d-4e6aefb6bc18', 2, 20, NULL, 0, NULL, '2021-12-19 12:53:46', '2021-12-19 12:53:46'),
('dde81d32-c972-4528-83c6-29cad6a5d701', 'fd49187f-1c1f-4d36-b61d-4e6aefb6bc18', 1, 100, NULL, 0, NULL, '2021-12-19 12:53:46', '2021-12-19 12:53:46'),
('f1ed3975-f6f3-4f35-8082-cb77296af1e8', '08380889-ca73-42d3-8021-37f95c848c61', 1, 2, 50000, 0, NULL, '2021-12-31 07:31:59', '2021-12-31 07:31:59');

-- --------------------------------------------------------

--
-- Struktur dari tabel `customer`
--

CREATE TABLE `customer` (
  `id` int(11) DEFAULT NULL,
  `kode` varchar(10) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `no_telp` varchar(15) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `status` varchar(2) DEFAULT NULL,
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
(17, 'LP', 'Laptop', '1', '2021-11-01 08:44:43', '2021-12-07 14:53:58');

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
(3, 'Barang', '/master/barangs', 'fa fa-home', '2', NULL, 'Menu Master Barang'),
(4, 'Jenis Barang', '/master/jenis-barang', 'fa fa-home', '2', NULL, 'Menu Master Jenis Barang'),
(5, 'Satuan', '/master/satuan', 'fa fa-home', '2', NULL, 'Menu Master Satuan'),
(6, 'Supplier', '/master/supplier', 'fa fa-home', '2', NULL, 'Menu Master Supplier'),
(7, 'Transaksi', '#', 'fa fa-home', '1', NULL, 'Menu Transaksi'),
(8, 'Pembelian', '/barang-masuk', 'fa fa-home', '2', NULL, 'Menu Transaksi Barang Masuk'),
(9, 'Penjualan', '/barang-keluar', 'fa fa-home', '2', NULL, 'Menu Transaksi Barang Keluar'),
(10, 'Setting', '#', 'fa fa-wrench', '1', NULL, 'Menu Setting'),
(11, 'User', '/setting/user', 'fa fa-home', '2', NULL, 'Menu Setting User'),
(12, 'Mutasi Stok', '/mutasi-stok', 'fa fa-home', '2', NULL, 'Menu Mutasi Stok'),
(13, 'Laporan', '/laporan', 'fa fa-copy', '1', NULL, 'Menu Laporan'),
(14, 'Data Barang', '#', 'fa fa-copy', '1', NULL, 'Menu Data Barang'),
(15, 'Stok Barang', '/barang/stok', 'fa fa-home', '2', NULL, 'Menu Stok Barang');

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
(7, 7, 'HA01', '1', 4, NULL, 1, '2021-12-21 12:45:44', '2021-11-15 14:22:53'),
(8, 8, 'HA01', '1', 1, 7, 2, '2021-11-15 14:24:41', '2021-11-15 14:23:26'),
(9, 9, 'HA01', '1', 2, 7, 2, '2021-11-15 14:24:42', '2021-11-15 14:23:49'),
(10, 10, 'HA01', '1', 6, NULL, 1, '2021-12-21 12:46:34', '2021-11-15 14:24:11'),
(11, 11, 'HA01', '1', 1, 10, 2, '2021-11-15 14:24:47', '2021-11-15 14:24:27'),
(12, 12, 'HA01', '1', 3, 14, 2, '2021-12-21 12:44:23', '2021-12-12 07:52:12'),
(13, 13, 'HA01', '1', 5, NULL, 1, '2021-12-21 12:46:32', '2021-12-12 12:56:03'),
(14, 14, 'HA01', '1', 3, NULL, 1, '2021-12-21 12:43:33', '2021-12-21 12:42:53'),
(15, 15, 'HA01', '1', 1, 14, 2, '2021-12-21 12:43:55', '2021-12-21 12:43:39');

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
-- Struktur dari tabel `mutasi_stok`
--

CREATE TABLE `mutasi_stok` (
  `id` varchar(50) DEFAULT NULL,
  `nomor_transaksi` varchar(20) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `id_barang` int(11) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `jenis` varchar(20) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `status` varchar(2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='jenis : \r\n1. MUTASI\r\n2. RUSAK / CACAT\r\n3. HILANG';

--
-- Dumping data untuk tabel `mutasi_stok`
--

INSERT INTO `mutasi_stok` (`id`, `nomor_transaksi`, `tanggal`, `id_barang`, `keterangan`, `qty`, `jenis`, `id_user`, `status`, `created_at`, `updated_at`) VALUES
('e62e7a9a-9217-4440-ac29-9831ebf352db', 'MUT20211220001', '2021-12-20', 1, 'Barang Rusak Terjatuh', 4, '2', 1, '1', '2021-12-20 13:57:01', '2021-12-20 14:44:50'),
('9c783e92-e0cc-413c-9409-d9d813a4ffce', 'MUT20211220002', '2021-12-20', 2, 'Barang Hilang', 1, '3', 1, '1', '2021-12-20 14:45:18', '2021-12-20 14:45:18'),
('c375fdba-0da5-4960-a7b6-ed90e0eef817', 'MUT20211220003', '2021-12-20', 3, 'Input Barang Stok Lama Dari Gudang Bulan November 2021', 1, '1', 1, '1', '2021-12-20 14:50:18', '2021-12-20 14:55:52');

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
(7, 'Pack', '1', '2021-11-06 21:40:06', '2021-11-06 21:41:14'),
(8, 'Unit', '1', '2021-12-07 14:54:16', '2021-12-07 14:54:16');

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
(1, 'KSB', 'CV. Karunia Sejahtera Bersama', '085334545054', 'Jl Rungkut Tengah No 7', 'HPL', '1', '2021-12-07 21:57:48', '2021-11-07 06:45:50'),
(2, 'ANG', 'CV. Anugerah HPL', '085334545051', 'Jl Kyau Abdul Karim No 6', 'HPL', '1', '2021-12-07 21:57:39', '0000-00-00 00:00:00'),
(3, 'VS', 'CV. Visitama Solusindo', '085335545087', 'Jl Semolowaru Elok No 1', 'Komputer', '1', '2021-12-07 21:58:34', '0000-00-00 00:00:00');

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
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `barang_keluar_detail`
--
ALTER TABLE `barang_keluar_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_barang_keluar_detail_barang_keluar` (`id_barang_keluar`),
  ADD KEY `FK_barang_keluar_detail_barang` (`id_barang`);

--
-- Indeks untuk tabel `barang_masuk`
--
ALTER TABLE `barang_masuk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_supplier` (`id_supplier`);

--
-- Indeks untuk tabel `barang_masuk_detail`
--
ALTER TABLE `barang_masuk_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_barang_masuk` (`id_barang_masuk`),
  ADD KEY `FK_barang_masuk_detail_barang` (`id_barang`);

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
  MODIFY `id_barang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `jenis_barang`
--
ALTER TABLE `jenis_barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `menu`
--
ALTER TABLE `menu`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `menu_user`
--
ALTER TABLE `menu_user`
  MODIFY `id_menu_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `satuan`
--
ALTER TABLE `satuan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `barang_keluar_detail`
--
ALTER TABLE `barang_keluar_detail`
  ADD CONSTRAINT `FK_barang_keluar_detail_barang` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`),
  ADD CONSTRAINT `FK_barang_keluar_detail_barang_keluar` FOREIGN KEY (`id_barang_keluar`) REFERENCES `barang_keluar` (`id`);

--
-- Ketidakleluasaan untuk tabel `barang_masuk`
--
ALTER TABLE `barang_masuk`
  ADD CONSTRAINT `FK_barang_masuk_supplier` FOREIGN KEY (`id_supplier`) REFERENCES `supplier` (`id`);

--
-- Ketidakleluasaan untuk tabel `barang_masuk_detail`
--
ALTER TABLE `barang_masuk_detail`
  ADD CONSTRAINT `FK_barang_masuk_detail_barang` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`),
  ADD CONSTRAINT `FK_barang_masuk_detail_barang_masuk` FOREIGN KEY (`id_barang_masuk`) REFERENCES `barang_masuk` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
