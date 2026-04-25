-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 24, 2026 at 07:43 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `colorlink_test`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `kode_barang` varchar(100) NOT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `kode_divisi_barang` varchar(100) NOT NULL,
  `nama_divisi_barang` varchar(255) NOT NULL,
  `kode_jenis_barang` varchar(100) NOT NULL,
  `nama_jenis_barang` varchar(255) NOT NULL,
  `kode_brand_barang` varchar(100) NOT NULL,
  `nama_brand_barang` varchar(255) NOT NULL,
  `barcode` varchar(100) NOT NULL,
  `barcode_serial_number` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `delivery_order_jkt`
--

CREATE TABLE `delivery_order_jkt` (
  `no_delivery_order` varchar(100) NOT NULL,
  `tgl_delivery_order` date NOT NULL,
  `no_sales_order` varchar(100) NOT NULL,
  `tgl_sales_order` date NOT NULL,
  `kode_pelanggan` varchar(100) NOT NULL,
  `nama_pelanggan` varchar(255) NOT NULL,
  `alamat_pelanggan` varchar(255) NOT NULL,
  `no_npwp_pelanggan` varchar(100) NOT NULL,
  `group_gudang` enum('PUSAT','CANVASSING') NOT NULL,
  `kode_gudang` varchar(100) NOT NULL,
  `nama_gudang` varchar(255) NOT NULL,
  `nota_kanvas` varchar(100) NOT NULL,
  `jenis_kendaraan` enum('COLT-DIESEL','APV','L-300','GRANDMAX','EKSPEDISI LUAR','MOTOR') NOT NULL,
  `kode_sales` varchar(100) NOT NULL,
  `nama_sales` varchar(255) NOT NULL,
  `pembayaran` enum('CBS','KREDIT') NOT NULL,
  `lama_pembayaran` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gudang_jkt`
--

CREATE TABLE `gudang_jkt` (
  `group_gudang` enum('PUSAT','CANVASSING') NOT NULL,
  `kode_gudang` varchar(100) NOT NULL,
  `nama_gudang` varchar(255) NOT NULL,
  `kode_supplier` varchar(100) NOT NULL,
  `kode_barang` varchar(100) NOT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `kode_divisi_barang` varchar(100) NOT NULL,
  `nama_divisi_barang` varchar(255) NOT NULL,
  `kode_jenis_barang` varchar(100) NOT NULL,
  `nama_jenis_barang` varchar(255) NOT NULL,
  `kode_brand_barang` varchar(100) NOT NULL,
  `nama_brand_barang` varchar(255) NOT NULL,
  `barcode` varchar(100) NOT NULL,
  `barcode_serial_number` varchar(100) NOT NULL,
  `satuan` enum('PCS','SET','DUS/BOX','RIM','PAK','ROLL') NOT NULL,
  `fraksi` decimal(10,0) NOT NULL,
  `harga_beli` decimal(12,0) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan_jkt`
--

CREATE TABLE `pelanggan_jkt` (
  `kode_divisi_pelanggan` varchar(100) NOT NULL,
  `nama_divisi_pelanggan` varchar(255) NOT NULL,
  `kode_pelanggan` varchar(100) NOT NULL,
  `nama_pelanggan` varchar(255) NOT NULL,
  `alamat_pelanggan` varchar(255) NOT NULL,
  `telp_pelanggan` varchar(50) NOT NULL,
  `no_ktp_pelanggan` varchar(50) NOT NULL,
  `no_npwp_pelanggan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales_jkt`
--

CREATE TABLE `sales_jkt` (
  `kode_sales` varchar(100) NOT NULL,
  `nama_sales` varchar(255) NOT NULL,
  `alamat_sales` varchar(255) NOT NULL,
  `telp_sales` varchar(50) NOT NULL,
  `tgl_mulai_kerja` date NOT NULL,
  `wilayah_penjualan` varchar(50) NOT NULL,
  `daerah_penjualan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales_order_jkt`
--

CREATE TABLE `sales_order_jkt` (
  `no_sales_order` varchar(100) NOT NULL,
  `tgl_sales_order` date NOT NULL,
  `kode_pelanggan` varchar(100) NOT NULL,
  `nama_pelanggan` varchar(255) NOT NULL,
  `alamat_pelanggan` varchar(255) NOT NULL,
  `no_npwp_pelanggan` varchar(100) NOT NULL,
  `group_gudang` enum('PUSAT','CANVASSING') NOT NULL,
  `kode_gudang` varchar(100) NOT NULL,
  `nama_gudang` varchar(255) NOT NULL,
  `kode_sales` varchar(100) NOT NULL,
  `nama_sales` varchar(255) NOT NULL,
  `pembayaran` enum('CBS','KREDIT') NOT NULL,
  `lama_pembayaran` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `supplier_jkt`
--

CREATE TABLE `supplier_jkt` (
  `kode_supplier` varchar(100) NOT NULL,
  `nama_supplier` varchar(255) NOT NULL,
  `divisi_supplier` enum('RETAILER','KONTRAKTOR','RUMAH TANGGA','PEMBORONG/TUKANG','TOKO','PROYEK','END USER') NOT NULL,
  `no_bukti` varchar(100) NOT NULL,
  `no_invoice` varchar(100) NOT NULL,
  `tgl_invoice` date NOT NULL,
  `no_purchase_order` varchar(100) NOT NULL,
  `tgl_purchase_order` date NOT NULL,
  `no_delivery_order` varchar(100) NOT NULL,
  `tgl_delivery_order` date NOT NULL,
  `npwp_supplier` varchar(100) NOT NULL,
  `nama_npwp_supplier` varchar(255) NOT NULL,
  `alamat_npwp_supplier` varchar(255) NOT NULL,
  `telp_supplier` varchar(50) NOT NULL,
  `saldo_awal_hutang` decimal(12,0) NOT NULL,
  `lama_kredit` int(11) NOT NULL,
  `ledger_account` varchar(100) NOT NULL,
  `no_pkp` varchar(100) NOT NULL,
  `tgl_pkp` date NOT NULL,
  `alamat_supplier` varchar(255) NOT NULL,
  `status` enum('AKTIF','TIDAK AKTIF') NOT NULL,
  `catatan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(150) DEFAULT NULL,
  `role` enum('ADMIN','USER') NOT NULL DEFAULT 'USER',
  `is_active` tinyint(1) DEFAULT 1,
  `last_login` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_expired` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `full_name`, `role`, `is_active`, `last_login`, `created_at`, `updated_at`, `deleted_at`, `reset_token`, `reset_expired`) VALUES
(1, 'admin', 'admin@gmail.com', '$2y$10$CB0yDT1OhYvy0uh8GSZxz.rSi4h6GBdkRaasCBmmegy8L4ePlB9Ti', 'admin', 'ADMIN', 1, '2026-04-24 09:45:02', '2026-04-24 09:44:57', '2026-04-24 09:45:02', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
