Terminal close -- exit!
- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 07, 2022 at 12:33 AM
-- Server version: 8.0.28-0ubuntu0.20.04.3
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bendot`
--

-- --------------------------------------------------------

--
-- Table structure for table `anggota`
--

CREATE TABLE `anggota` (
  `id` int NOT NULL,
  `nama` varchar(255) NOT NULL,
  `role` enum('Anggota','Bendahara','Admin') NOT NULL DEFAULT 'Anggota',
  `id_tele` varchar(32) DEFAULT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(255) NOT NULL
);

--
-- Dumping data for table `anggota`
--

INSERT INTO `anggota` (`id`, `nama`, `role`, `id_tele`, `username`, `password`) VALUES
(1, 'Aditya Rachman', 'Admin', '6621345', 'admin', '$2y$10$eUPDY5rPmIn6rtJeHtwnueHqiDJuUokoKcAdtbrzwyN5V/tiZrNiC'),
(7, 'Anastasya KH', 'Bendahara', '22431232', 'bendahara', '$2y$10$iaScGehBG1bwVU38olZAoe5rdgnrV3YRd59cYDX8YTNRWJNbgSp.q');

-- --------------------------------------------------------

--
-- Table structure for table `bulanan`
--

CREATE TABLE `bulanan` (
  `id` int NOT NULL,
  `id_anggota` int NOT NULL,
  `month` int NOT NULL,
  `year` int NOT NULL,
  `waktu` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
);

--
-- Dumping data for table `bulanan`
--

INSERT INTO `bulanan` (`id`, `id_anggota`, `month`, `year`, `waktu`) VALUES
(1, 1, 4, 2022, '2022-04-06 16:29:14'),
(2, 7, 4, 2022, '2022-04-06 17:23:13'),
(4, 1, 3, 2022, '2022-04-06 17:25:02');

-- --------------------------------------------------------

--
-- Table structure for table `himpunan`
--

CREATE TABLE `himpunan` (
  `id` int NOT NULL,
  `tipe` enum('Pemasukan','Pengeluaran') NOT NULL DEFAULT 'Pemasukan',
  `nama` varchar(255) NOT NULL,
  `waktu` datetime NOT NULL,
  `jumlah` int NOT NULL,
  `total` int NOT NULL
);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `anggota`
--
ALTER TABLE `anggota`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bulanan`
--
ALTER TABLE `bulanan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `himpunan`
--
ALTER TABLE `himpunan`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `anggota`
--
ALTER TABLE `anggota`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `bulanan`
--
ALTER TABLE `bulanan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `himpunan`
--
ALTER TABLE `himpunan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
