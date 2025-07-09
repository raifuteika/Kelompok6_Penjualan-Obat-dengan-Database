-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 09, 2025 at 07:43 PM
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
-- Database: `apotek_pintar`
--

-- --------------------------------------------------------

--
-- Table structure for table `obat`
--

CREATE TABLE `obat` (
  `id_obat` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `stok` int(11) DEFAULT 0,
  `harga` decimal(10,2) NOT NULL,
  `kategori` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `obat`
--

INSERT INTO `obat` (`id_obat`, `nama`, `stok`, `harga`, `kategori`) VALUES
(1, 'Amoxicilin', 2, 5000.00, 'tablet'),
(4, 'paracetamol', 2, 30000.00, 'tablet');

-- --------------------------------------------------------

--
-- Table structure for table `obat_sequence`
--

CREATE TABLE `obat_sequence` (
  `next_not_cached_value` bigint(21) NOT NULL,
  `minimum_value` bigint(21) NOT NULL,
  `maximum_value` bigint(21) NOT NULL,
  `start_value` bigint(21) NOT NULL COMMENT 'start value when sequences is created or value if RESTART is used',
  `increment` bigint(21) NOT NULL COMMENT 'increment value',
  `cache_size` bigint(21) UNSIGNED NOT NULL,
  `cycle_option` tinyint(1) UNSIGNED NOT NULL COMMENT '0 if no cycles are allowed, 1 if the sequence should begin a new cycle when maximum_value is passed',
  `cycle_count` bigint(21) NOT NULL COMMENT 'How many cycles have been done'
) ENGINE=InnoDB;

--
-- Dumping data for table `obat_sequence`
--

INSERT INTO `obat_sequence` (`next_not_cached_value`, `minimum_value`, `maximum_value`, `start_value`, `increment`, `cache_size`, `cycle_option`, `cycle_count`) VALUES
(1, 1, 999999, 1, 1, 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sequence`
--

CREATE TABLE `sequence` (
  `name` varchar(50) NOT NULL,
  `current_value` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sequence`
--

INSERT INTO `sequence` (`name`, `current_value`) VALUES
('transaksi_id', 1000);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `tgl_transaksi` date NOT NULL,
  `total_transaksi` decimal(15,2) NOT NULL,
  `id_obat` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `tgl_transaksi`, `total_transaksi`, `id_obat`, `jumlah`) VALUES
(2, '2025-06-18', 5000.00, 1, 1),
(3, '2025-06-26', 150000.00, 4, 5),
(4, '2025-06-26', 10000.00, 1, 2),
(5, '2025-06-27', 5000.00, 1, 1),
(6, '2025-06-28', 5000.00, 1, 1),
(7, '2025-06-29', 5000.00, 1, 1),
(8, '2025-06-29', 30000.00, 4, 1),
(9, '2025-06-30', 5000.00, 1, 1),
(10, '2025-07-01', 5000.00, 1, 1),
(11, '2025-07-03', 60000.00, 4, 2);

--
-- Triggers `transaksi`
--
DELIMITER $$
CREATE TRIGGER `tg_transaksi` AFTER INSERT ON `transaksi` FOR EACH ROW BEGIN
    UPDATE obat
    SET stok = stok - NEW.jumlah
    WHERE id_obat = NEW.id_obat;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_sequence`
--

CREATE TABLE `transaksi_sequence` (
  `next_not_cached_value` bigint(21) NOT NULL,
  `minimum_value` bigint(21) NOT NULL,
  `maximum_value` bigint(21) NOT NULL,
  `start_value` bigint(21) NOT NULL COMMENT 'start value when sequences is created or value if RESTART is used',
  `increment` bigint(21) NOT NULL COMMENT 'increment value',
  `cache_size` bigint(21) UNSIGNED NOT NULL,
  `cycle_option` tinyint(1) UNSIGNED NOT NULL COMMENT '0 if no cycles are allowed, 1 if the sequence should begin a new cycle when maximum_value is passed',
  `cycle_count` bigint(21) NOT NULL COMMENT 'How many cycles have been done'
) ENGINE=InnoDB;

--
-- Dumping data for table `transaksi_sequence`
--

INSERT INTO `transaksi_sequence` (`next_not_cached_value`, `minimum_value`, `maximum_value`, `start_value`, `increment`, `cache_size`, `cycle_option`, `cycle_count`) VALUES
(1, 1, 999999, 1, 1, 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(60) NOT NULL,
  `password` varchar(60) NOT NULL,
  `role` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin', 'admin', 'admin'),
(7, 'www', '$2y$10$4PbTXICTnKgA5Rum1/s.yepQHglCc8JRWxtK1WIhAgSBYTOMX4nte', 'admin'),
(8, 'iki', 'iki', 'admin'),
(9, 'fadlan', 'fadlan', 'admin'),
(10, 'bla', 'bla', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `user_sequence`
--

CREATE TABLE `user_sequence` (
  `next_not_cached_value` bigint(21) NOT NULL,
  `minimum_value` bigint(21) NOT NULL,
  `maximum_value` bigint(21) NOT NULL,
  `start_value` bigint(21) NOT NULL COMMENT 'start value when sequences is created or value if RESTART is used',
  `increment` bigint(21) NOT NULL COMMENT 'increment value',
  `cache_size` bigint(21) UNSIGNED NOT NULL,
  `cycle_option` tinyint(1) UNSIGNED NOT NULL COMMENT '0 if no cycles are allowed, 1 if the sequence should begin a new cycle when maximum_value is passed',
  `cycle_count` bigint(21) NOT NULL COMMENT 'How many cycles have been done'
) ENGINE=InnoDB;

--
-- Dumping data for table `user_sequence`
--

INSERT INTO `user_sequence` (`next_not_cached_value`, `minimum_value`, `maximum_value`, `start_value`, `increment`, `cache_size`, `cycle_option`, `cycle_count`) VALUES
(1, 1, 999999, 1, 1, 1, 0, 0);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_stok_kategori`
-- (See below for the actual view)
--
CREATE TABLE `v_stok_kategori` (
`kategori` varchar(20)
,`total_stok_kategori` decimal(32,0)
);

-- --------------------------------------------------------

--
-- Structure for view `v_stok_kategori`
--
DROP TABLE IF EXISTS `v_stok_kategori`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_stok_kategori`  AS SELECT `obat`.`kategori` AS `kategori`, sum(`obat`.`stok`) AS `total_stok_kategori` FROM `obat` GROUP BY `obat`.`kategori` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `obat`
--
ALTER TABLE `obat`
  ADD PRIMARY KEY (`id_obat`);

--
-- Indexes for table `sequence`
--
ALTER TABLE `sequence`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `id_obat` (`id_obat`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`id_obat`) REFERENCES `obat` (`id_obat`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
