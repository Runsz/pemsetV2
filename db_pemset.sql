-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 29, 2024 at 04:41 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_pemset`
--

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id` int(11) NOT NULL,
  `peminjam` varchar(300) NOT NULL,
  `aset` varchar(300) NOT NULL,
  `jml_aset` int(11) NOT NULL,
  `tgl_pinjam` date NOT NULL,
  `tgl_rencana_kembali` date NOT NULL,
  `tgl_pengembalian` date DEFAULT NULL,
  `peruntukkan` varchar(500) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `peminjaman`
--

INSERT INTO `peminjaman` (`id`, `peminjam`, `aset`, `jml_aset`, `tgl_pinjam`, `tgl_rencana_kembali`, `tgl_pengembalian`, `peruntukkan`, `status`) VALUES
(3, 'Arun', 'Kamera', 3, '2024-01-24', '2024-01-26', '2024-01-24', 'Arun', 3),
(4, 'Inggil', 'HP', 1, '2024-01-24', '2024-02-10', '2024-01-29', 'Inggil', 3),
(5, 'Ilyas', 'Laptop', 5, '2024-01-24', '2024-01-25', NULL, 'Ilyas', 2),
(6, 'Muham', 'Wifi', 2, '2024-01-29', '2024-01-30', NULL, 'Muham', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
