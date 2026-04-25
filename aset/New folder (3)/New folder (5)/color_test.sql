-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 25, 2026 at 11:56 AM
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
  `barcode_serial_number` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`kode_barang`, `nama_barang`, `kode_divisi_barang`, `nama_divisi_barang`, `kode_jenis_barang`, `nama_jenis_barang`, `kode_brand_barang`, `nama_brand_barang`, `barcode`, `barcode_serial_number`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`, `id`) VALUES
('BRG001', 'Cat Tembok 5Kg', 'DIV01', 'Cat', 'JNS01', 'Interior', 'BRD01', 'Nippon Paint', '111111', 'SN001', '2026-04-25 13:21:42', NULL, NULL, NULL, NULL, NULL, 1),
('BRG002', 'Cat Kayu 1Kg', 'DIV01', 'Cat', 'JNS02', 'Kayu', 'BRD02', 'Avian', '222222', 'SN002', '2026-04-25 13:21:42', NULL, NULL, NULL, NULL, NULL, 2),
('tes ubah', 'tes ubah', 'tes ubah', 'tes ubah', 'tes ubah', 'tes ubah', 'tes ubah', 'tes ubah', 'tes ubah', 'tes ubah', '2026-04-25 15:23:36', '2026-04-25 15:24:17', '2026-04-25 15:24:17', 1, 1, 1, 3);

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
  `harga_jual` decimal(12,0) NOT NULL,
  `qty` int(11) NOT NULL,
  `jenis_kendaraan` enum('COLT-DIESEL','APV','L-300','GRANDMAX','EKSPEDISI LUAR','MOTOR') NOT NULL,
  `kode_sales` varchar(100) NOT NULL,
  `nama_sales` varchar(255) NOT NULL,
  `pembayaran` enum('CBS','KREDIT') NOT NULL,
  `lama_pembayaran` varchar(50) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `status_delivery_order` enum('ACCEPT','REJECT','CANCELLED') NOT NULL,
  `keterangan_status` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `delivery_order_jkt`
--

INSERT INTO `delivery_order_jkt` (`no_delivery_order`, `tgl_delivery_order`, `no_sales_order`, `tgl_sales_order`, `kode_pelanggan`, `nama_pelanggan`, `alamat_pelanggan`, `no_npwp_pelanggan`, `group_gudang`, `kode_gudang`, `nama_gudang`, `nota_kanvas`, `kode_barang`, `nama_barang`, `kode_divisi_barang`, `nama_divisi_barang`, `kode_jenis_barang`, `nama_jenis_barang`, `kode_brand_barang`, `nama_brand_barang`, `barcode`, `barcode_serial_number`, `satuan`, `fraksi`, `harga_jual`, `qty`, `jenis_kendaraan`, `kode_sales`, `nama_sales`, `pembayaran`, `lama_pembayaran`, `keterangan`, `status_delivery_order`, `keterangan_status`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`, `id`) VALUES
('DO001', '2026-04-02', 'SO001', '2026-04-01', 'CUST001', 'Toko Maju Jaya', 'Jakarta', 'NPWP001', 'PUSAT', 'GDG001', 'Gudang Jakarta', 'KANVAS001', 'BRG001', 'Cat Tembok 5Kg', 'DIV01', 'Cat', 'JNS01', 'Interior', 'BRD01', 'Nippon Paint', '111111', 'SN001', 'PCS', 1, 75000, 10, 'COLT-DIESEL', 'SLS001', 'Budi', 'KREDIT', '30 Hari', 'Dikirim', 'ACCEPT', '-', '2026-04-25 13:29:20', NULL, NULL, NULL, NULL, NULL, 1);

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
  `qty` int(11) NOT NULL,
  `tgl_masuk_barang` date NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gudang_jkt`
--

INSERT INTO `gudang_jkt` (`group_gudang`, `kode_gudang`, `nama_gudang`, `kode_supplier`, `kode_barang`, `nama_barang`, `kode_divisi_barang`, `nama_divisi_barang`, `kode_jenis_barang`, `nama_jenis_barang`, `kode_brand_barang`, `nama_brand_barang`, `barcode`, `barcode_serial_number`, `satuan`, `fraksi`, `harga_beli`, `qty`, `tgl_masuk_barang`, `keterangan`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`, `id`) VALUES
('PUSAT', 'GDG001', 'Gudang Jakarta', 'SUP001', 'BRG001', 'Cat Tembok 5Kg', 'DIV01', 'Cat', 'JNS01', 'Interior', 'BRD01', 'Nippon Paint', '111111', 'SN001', 'PCS', 1, 50000, 100, '2026-01-05', 'Stok awal', '2026-04-25 13:26:54', NULL, NULL, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `invoice_jkt`
--

CREATE TABLE `invoice_jkt` (
  `no_invoice` varchar(100) NOT NULL,
  `tgl_invoice` date NOT NULL,
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
  `harga_jual` decimal(12,0) NOT NULL,
  `qty` int(11) NOT NULL,
  `kode_sales` varchar(100) NOT NULL,
  `nama_sales` varchar(255) NOT NULL,
  `pembayaran` enum('CBS','KREDIT') NOT NULL,
  `lama_pembayaran` varchar(50) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `status_invoice` enum('ACCEPT','REJECT','CANCELLED') NOT NULL,
  `keterangan_status` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoice_jkt`
--

INSERT INTO `invoice_jkt` (`no_invoice`, `tgl_invoice`, `no_delivery_order`, `tgl_delivery_order`, `no_sales_order`, `tgl_sales_order`, `kode_pelanggan`, `nama_pelanggan`, `alamat_pelanggan`, `no_npwp_pelanggan`, `group_gudang`, `kode_gudang`, `nama_gudang`, `kode_barang`, `nama_barang`, `kode_divisi_barang`, `nama_divisi_barang`, `kode_jenis_barang`, `nama_jenis_barang`, `kode_brand_barang`, `nama_brand_barang`, `barcode`, `barcode_serial_number`, `satuan`, `fraksi`, `harga_jual`, `qty`, `kode_sales`, `nama_sales`, `pembayaran`, `lama_pembayaran`, `keterangan`, `status_invoice`, `keterangan_status`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`, `id`) VALUES
('INV001', '2026-04-03', 'DO001', '2026-04-02', 'SO001', '2026-04-01', 'CUST001', 'Toko Maju Jaya', 'Jakarta', 'NPWP001', 'PUSAT', 'GDG001', 'Gudang Jakarta', 'BRG001', 'Cat Tembok 5Kg', 'DIV01', 'Cat', 'JNS01', 'Interior', 'BRD01', 'Nippon Paint', '111111', 'SN001', 'PCS', 1, 75000, 10, 'SLS001', 'Budi', 'KREDIT', '30 Hari', 'Invoice pertama', 'ACCEPT', '-', '2026-04-25 13:30:04', NULL, NULL, NULL, NULL, NULL, 1);

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
  `no_npwp_pelanggan` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pelanggan_jkt`
--

INSERT INTO `pelanggan_jkt` (`kode_divisi_pelanggan`, `nama_divisi_pelanggan`, `kode_pelanggan`, `nama_pelanggan`, `alamat_pelanggan`, `telp_pelanggan`, `no_ktp_pelanggan`, `no_npwp_pelanggan`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`, `id`) VALUES
('DIVP01', 'Retail', 'CUST001', 'Toko Maju Jaya', 'Jakarta', '0811111111', '123456', 'NPWP001', '2026-04-25 13:22:28', NULL, NULL, NULL, NULL, NULL, 1),
('DIVP02', 'Proyek', 'CUST002', 'CV Bangun Jaya', 'Bekasi', '0822222222', '654321', 'NPWP002', '2026-04-25 13:22:28', NULL, NULL, NULL, NULL, NULL, 2);

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
  `daerah_penjualan` varchar(50) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales_jkt`
--

INSERT INTO `sales_jkt` (`kode_sales`, `nama_sales`, `alamat_sales`, `telp_sales`, `tgl_mulai_kerja`, `wilayah_penjualan`, `daerah_penjualan`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`, `id`) VALUES
('SLS001', 'Budi', 'Jakarta', '08123456789', '2023-01-01', 'JAKARTA', 'PUSAT', '2026-04-25 13:22:52', NULL, NULL, NULL, NULL, NULL, 1),
('SLS002', 'Andi', 'Bekasi', '08234567890', '2023-02-01', 'BEKASI', 'TIMUR', '2026-04-25 13:22:52', NULL, NULL, NULL, NULL, NULL, 2);

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
  `harga_jual` decimal(12,0) NOT NULL,
  `qty` int(11) NOT NULL,
  `kode_sales` varchar(100) NOT NULL,
  `nama_sales` varchar(255) NOT NULL,
  `pembayaran` enum('CBS','KREDIT') NOT NULL,
  `lama_pembayaran` varchar(50) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `status_sales_order` enum('ACCEPT','REJECT','CANCELLED') NOT NULL,
  `keterangan_status` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales_order_jkt`
--

INSERT INTO `sales_order_jkt` (`no_sales_order`, `tgl_sales_order`, `kode_pelanggan`, `nama_pelanggan`, `alamat_pelanggan`, `no_npwp_pelanggan`, `group_gudang`, `kode_gudang`, `nama_gudang`, `kode_barang`, `nama_barang`, `kode_divisi_barang`, `nama_divisi_barang`, `kode_jenis_barang`, `nama_jenis_barang`, `kode_brand_barang`, `nama_brand_barang`, `barcode`, `barcode_serial_number`, `satuan`, `fraksi`, `harga_jual`, `qty`, `kode_sales`, `nama_sales`, `pembayaran`, `lama_pembayaran`, `keterangan`, `status_sales_order`, `keterangan_status`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`, `id`) VALUES
('SO001', '2026-04-01', 'CUST001', 'Toko Maju Jaya', 'Jakarta', 'NPWP001', 'PUSAT', 'GDG001', 'Gudang Jakarta', 'BRG001', 'Cat Tembok 5Kg', 'DIV01', 'Cat', 'JNS01', 'Interior', 'BRD01', 'Nippon Paint', '111111', 'SN001', 'PCS', 1, 75000, 10, 'SLS001', 'Budi', 'KREDIT', '30 Hari', 'Order pertama', 'ACCEPT', '-', '2026-04-25 13:28:17', NULL, NULL, NULL, NULL, NULL, 1);

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
  `keterangan` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier_jkt`
--

INSERT INTO `supplier_jkt` (`kode_supplier`, `nama_supplier`, `divisi_supplier`, `no_bukti`, `no_invoice`, `tgl_invoice`, `no_purchase_order`, `tgl_purchase_order`, `no_delivery_order`, `tgl_delivery_order`, `npwp_supplier`, `nama_npwp_supplier`, `alamat_npwp_supplier`, `telp_supplier`, `saldo_awal_hutang`, `lama_kredit`, `ledger_account`, `no_pkp`, `tgl_pkp`, `alamat_supplier`, `status`, `keterangan`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`, `id`) VALUES
('SUP001', 'PT Sumber Warna', 'TOKO', 'BKT001', 'INV001', '2026-01-01', 'PO001', '2025-12-25', 'DO001', '2025-12-28', 'NPWP-SUP1', 'PT Sumber Warna', 'Jakarta', '081111111', 10000000, 30, 'ACC001', 'PKP001', '2020-01-01', 'Jakarta', 'AKTIF', 'Supplier utama', '2026-04-25 13:25:36', NULL, NULL, NULL, NULL, NULL, 1);

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
(1, 'admin', 'admin@gmail.com', '$2y$10$CB0yDT1OhYvy0uh8GSZxz.rSi4h6GBdkRaasCBmmegy8L4ePlB9Ti', 'admin', 'ADMIN', 1, '2026-04-25 13:43:25', '2026-04-24 09:44:57', '2026-04-25 13:43:25', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_barang` (`kode_barang`);

--
-- Indexes for table `delivery_order_jkt`
--
ALTER TABLE `delivery_order_jkt`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `no_delivery_order` (`no_delivery_order`),
  ADD KEY `fk_do_so` (`no_sales_order`);

--
-- Indexes for table `gudang_jkt`
--
ALTER TABLE `gudang_jkt`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_gudang_supplier` (`kode_supplier`);

--
-- Indexes for table `invoice_jkt`
--
ALTER TABLE `invoice_jkt`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_invoice_do` (`no_delivery_order`);

--
-- Indexes for table `pelanggan_jkt`
--
ALTER TABLE `pelanggan_jkt`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_pelanggan` (`kode_pelanggan`);

--
-- Indexes for table `sales_jkt`
--
ALTER TABLE `sales_jkt`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_sales` (`kode_sales`);

--
-- Indexes for table `sales_order_jkt`
--
ALTER TABLE `sales_order_jkt`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `no_sales_order` (`no_sales_order`),
  ADD KEY `fk_so_pelanggan` (`kode_pelanggan`),
  ADD KEY `fk_so_sales` (`kode_sales`),
  ADD KEY `fk_so_barang` (`kode_barang`);

--
-- Indexes for table `supplier_jkt`
--
ALTER TABLE `supplier_jkt`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_supplier` (`kode_supplier`);

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
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `delivery_order_jkt`
--
ALTER TABLE `delivery_order_jkt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `gudang_jkt`
--
ALTER TABLE `gudang_jkt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `invoice_jkt`
--
ALTER TABLE `invoice_jkt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pelanggan_jkt`
--
ALTER TABLE `pelanggan_jkt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sales_jkt`
--
ALTER TABLE `sales_jkt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sales_order_jkt`
--
ALTER TABLE `sales_order_jkt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `supplier_jkt`
--
ALTER TABLE `supplier_jkt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `delivery_order_jkt`
--
ALTER TABLE `delivery_order_jkt`
  ADD CONSTRAINT `fk_do_so` FOREIGN KEY (`no_sales_order`) REFERENCES `sales_order_jkt` (`no_sales_order`);

--
-- Constraints for table `gudang_jkt`
--
ALTER TABLE `gudang_jkt`
  ADD CONSTRAINT `fk_gudang_supplier` FOREIGN KEY (`kode_supplier`) REFERENCES `supplier_jkt` (`kode_supplier`);

--
-- Constraints for table `invoice_jkt`
--
ALTER TABLE `invoice_jkt`
  ADD CONSTRAINT `fk_invoice_do` FOREIGN KEY (`no_delivery_order`) REFERENCES `delivery_order_jkt` (`no_delivery_order`);

--
-- Constraints for table `sales_order_jkt`
--
ALTER TABLE `sales_order_jkt`
  ADD CONSTRAINT `fk_so_barang` FOREIGN KEY (`kode_barang`) REFERENCES `barang` (`kode_barang`),
  ADD CONSTRAINT `fk_so_pelanggan` FOREIGN KEY (`kode_pelanggan`) REFERENCES `pelanggan_jkt` (`kode_pelanggan`),
  ADD CONSTRAINT `fk_so_sales` FOREIGN KEY (`kode_sales`) REFERENCES `sales_jkt` (`kode_sales`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
