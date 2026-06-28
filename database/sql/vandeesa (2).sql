-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 08, 2026 at 03:45 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vandeesa`
--

-- --------------------------------------------------------

--
-- Table structure for table `delivery`
--

CREATE TABLE `delivery` (
  `no_do` varchar(10) NOT NULL,
  `no_invoice` varchar(10) NOT NULL,
  `id_reseller` varchar(10) NOT NULL,
  `id_pegawai` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `tanggal` date NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `delivery`
--

INSERT INTO `delivery` (`no_do`, `no_invoice`, `id_reseller`, `id_pegawai`, `tanggal`, `status`) VALUES
('DO001', 'INV001', 'RSL001', 'PG001', '2026-06-04', 'Diproses'),
('DO002', 'INV003', 'RSL001', 'PG001', '2026-06-04', 'Selesai'),
('DO003', 'INV002', 'RSL001', 'PG001', '2026-06-04', 'Menunggu'),
('DO004', 'INV004', 'RSL001', 'PG001', '2026-06-04', 'Selesai');

-- --------------------------------------------------------

--
-- Table structure for table `detail_invoice`
--

CREATE TABLE `detail_invoice` (
  `no_invoice` varchar(10) NOT NULL,
  `id_item` varchar(10) NOT NULL,
  `harga_perpcs` decimal(10,0) NOT NULL,
  `quantity` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `detail_invoice`
--

INSERT INTO `detail_invoice` (`no_invoice`, `id_item`, `harga_perpcs`, `quantity`) VALUES
('INV001', 'ITM001', '250000', '1'),
('INV002', 'ITM001', '250000', '6'),
('INV003', 'ITM001', '250000', '1'),
('INV004', 'ITM001', '250000', '2'),
('INV004', 'ITM001', '250000', '1'),
('INV005', 'ITM001', '250000', '1');

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `no_invoice` varchar(10) NOT NULL,
  `id_pelanggan` varchar(10) NOT NULL,
  `id_pegawai` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `id_pg_kasir` varchar(10) NOT NULL,
  `id_member` varchar(10) NOT NULL,
  `tanggal` date NOT NULL,
  `total_harga` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`no_invoice`, `id_pelanggan`, `id_pegawai`, `id_pg_kasir`, `id_member`, `tanggal`, `total_harga`) VALUES
('INV001', 'PLG001', 'PG001', 'PG001', 'MBR001', '2026-06-04', '250000'),
('INV002', 'PLG001', 'PG001', 'PG001', 'MBR001', '2026-06-04', '1500000'),
('INV003', 'PLG001', 'PG001', 'PG001', 'MBR001', '2026-06-04', '250000'),
('INV004', 'PLG001', 'PG001', 'PG001', 'MBR001', '2026-06-04', '750000'),
('INV005', 'PLG001', 'PG001', 'PG001', 'MBR001', '2026-06-05', '250000');

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `id_item` varchar(10) NOT NULL,
  `nama_item` varchar(100) NOT NULL,
  `stok_item` int NOT NULL,
  `harga` varchar(100) NOT NULL,
  `harga_reseller` varchar(100) NOT NULL,
  `gambar` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`id_item`, `nama_item`, `stok_item`, `harga`, `harga_reseller`, `gambar`) VALUES
('ITM001', 'kerudung batik biru', 80, '250000', '', '1780586255_ITM001.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `id_member` varchar(10) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `kategori` enum('online','offline') NOT NULL,
  `no_telp` varchar(20) NOT NULL,
  `tgl_daftar` date NOT NULL,
  `email` varchar(50) NOT NULL,
  `diskon` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`id_member`, `nama`, `kategori`, `no_telp`, `tgl_daftar`, `email`, `diskon`) VALUES
('MBR001', 'Hanaa', 'offline', '08917355145', '2026-06-13', 'hana15@gmail.com', '50000');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pegawai`
--

CREATE TABLE `pegawai` (
  `id_pegawai` varchar(10) NOT NULL,
  `nama_pg` varchar(100) NOT NULL,
  `jabatan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pegawai`
--

INSERT INTO `pegawai` (`id_pegawai`, `nama_pg`, `jabatan`) VALUES
('PG001', 'aabel', 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` varchar(10) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `no_telpn` varchar(13) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `nama`, `no_telpn`) VALUES
('PLG001', 'ichaa', '085172470509');

-- --------------------------------------------------------

--
-- Table structure for table `reseller`
--

CREATE TABLE `reseller` (
  `id_reseller` varchar(10) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `no_telp` varchar(20) NOT NULL,
  `nama_brand` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `alamat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `reseller`
--

INSERT INTO `reseller` (`id_reseller`, `nama`, `no_telp`, `nama_brand`, `email`, `alamat`) VALUES
('RSL001', 'Tere', '08971423167', 'Teresa', 'tere@gmail.com', 'Jakarta');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `role` enum('admin','kasir','owner') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `username`, `password`, `role`) VALUES
(1, 'admin', '$2y$10$kTkP.4/96QMt4W8JJG9v9eYswdxkfi0QbClqKup/8iO.lXAifSJMu', 'admin'),
(2, 'kasir', '$2y$10$hhHok2aJeTawewT2Es6k.uMt28al5nFzr3bxKrYm75Y3l88HjYyP.', 'kasir'),
(3, 'owner', '$2y$10$SipU7ZHk8pvqZRj4bto2puP12mBNTOxOscP6Gh2WjsEJn8YfYfmuG', 'owner');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `delivery`
--
ALTER TABLE `delivery`
  ADD PRIMARY KEY (`no_do`),
  ADD KEY `id_reseller` (`id_reseller`),
  ADD KEY `id_pg` (`id_pegawai`),
  ADD KEY `no_invoice` (`no_invoice`);

--
-- Indexes for table `detail_invoice`
--
ALTER TABLE `detail_invoice`
  ADD KEY `detail_invoice_ibfk_1` (`no_invoice`),
  ADD KEY `id_item` (`id_item`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`no_invoice`),
  ADD KEY `id_member` (`id_member`),
  ADD KEY `id_pelanggan` (`id_pelanggan`),
  ADD KEY `invoice_ibfk_1` (`id_pegawai`),
  ADD KEY `invoice_ibfk_4` (`id_pg_kasir`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`id_item`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`id_member`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`id_pegawai`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indexes for table `reseller`
--
ALTER TABLE `reseller`
  ADD PRIMARY KEY (`id_reseller`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `delivery`
--
ALTER TABLE `delivery`
  ADD CONSTRAINT `delivery_ibfk_1` FOREIGN KEY (`id_reseller`) REFERENCES `reseller` (`id_reseller`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `delivery_ibfk_2` FOREIGN KEY (`id_pegawai`) REFERENCES `pegawai` (`id_pegawai`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `delivery_ibfk_3` FOREIGN KEY (`no_invoice`) REFERENCES `invoice` (`no_invoice`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `detail_invoice`
--
ALTER TABLE `detail_invoice`
  ADD CONSTRAINT `detail_invoice_ibfk_1` FOREIGN KEY (`no_invoice`) REFERENCES `invoice` (`no_invoice`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `detail_invoice_ibfk_2` FOREIGN KEY (`id_item`) REFERENCES `item` (`id_item`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `invoice`
--
ALTER TABLE `invoice`
  ADD CONSTRAINT `invoice_ibfk_1` FOREIGN KEY (`id_pegawai`) REFERENCES `pegawai` (`id_pegawai`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `invoice_ibfk_2` FOREIGN KEY (`id_member`) REFERENCES `member` (`id_member`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `invoice_ibfk_3` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `invoice_ibfk_4` FOREIGN KEY (`id_pg_kasir`) REFERENCES `pegawai` (`id_pegawai`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
