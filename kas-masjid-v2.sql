-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 02, 2022 at 02:05 PM
-- Server version: 8.0.30-0ubuntu0.20.04.2
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kas-masjid-v2`
--

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int NOT NULL,
  `nama_kategori` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb3;
-- ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`) VALUES
(1, 'Kategori 1'),
(2, 'Kategori 2'),
(3, 'Kategori 3');

-- --------------------------------------------------------

--
-- Table structure for table `rekapitulasi`
--

CREATE TABLE `rekapitulasi` (
  `kode` int NOT NULL,
  `id_user` varchar(255) NOT NULL,
  `id_kategori` int DEFAULT NULL,
  `keterangan` text NOT NULL,
  `jenis` enum('masuk','keluar') NOT NULL,
  `jumlah` int NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `rekapitulasi`
--

INSERT INTO `rekapitulasi` (`kode`, `id_user`, `id_kategori`, `keterangan`, `jenis`, `jumlah`, `tanggal`) VALUES
(101, '600550e6cfc59', 1, 'Infaq Jumat ', 'masuk', 500000, '2021-01-08'),
(102, '600550e6cfc59', 2, 'Shodaqoh', 'masuk', 500000, '2021-01-10'),
(103, '600550e6cfc59', 1, 'Membeli alat-alat kebersihan masjid', 'keluar', 400000, '2021-01-11'),
(109, '600550e6cfc59', 2, 'Pembelian peralatan kebersihan masjid', 'keluar', 700000, '2021-01-10'),
(112, '600550e6cfc59', 1, 'Pemberian yatim piyatu c', 'keluar', 900000, '2021-01-18'),
(117, '600550e6cfc59', 1, 'Sumbangan pak Budi\r\n', 'masuk', 500000, '2021-01-16'),
(121, '600550e6cfc59', 1, 'Acara amal masjid', 'keluar', 500000, '2021-01-11'),
(122, '600550e6cfc59', 2, 'Infaq jumat', 'masuk', 550000, '2021-01-15'),
(124, '600550e6cfc59', 2, 'Qurban', 'keluar', 1000000, '2021-01-21'),
(128, '600550e6cfc59', 1, 'Hadiah', 'masuk', 1000000, '2021-01-23'),
(142, '600550e6cfc59', 2, 'Infaq sholat Jumat', 'masuk', 750000, '2022-08-02'),
(144, '600550e6cfc59', 1, 'Untuk Biaya Pengajian', 'keluar', 50000, '2022-08-02'),
(146, '600550e6cfc59', 1, 'test masuk katergori', 'masuk', 10000, '2022-08-02'),
(148, '600550e6cfc59', 2, 'test keluar kategori', 'keluar', 20000, '2022-08-02');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `foto_profile` varchar(255) NOT NULL DEFAULT 'profile.jpg',
  `level` enum('admin','takmir','jamaah') NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `foto_profile`, `level`, `email`) VALUES
('600550e6cfc59', 'admin', '$2y$10$jFkHcedMKvO0yXZJflQUVOIMD5mZUHHEUlZuDoiPEj27Rz75PAdPW', 'profile.jpg', 'admin', 'adminWeb99@gmail.com'),
('600550e6cfc65', 'takmir', '$2y$10$K/Hohba9ThWKodel9G.YnOOBmVqwDt3QRNCGYEo01zi5OdMRi6tOK', '60197f0dea8dc.jpg', 'takmir', 'Takmir@mail.com'),
('600550e6cfc67', 'jamaah', '$2y$10$wZkf4mS35WmWYEBaV9pQsetmYLbc8jAkmAtTZ/NPpb63oznzyGjly', 'profile.jpg', 'jamaah', 'jamaah@gmail.com'),
('601a0ada7d752', 'user1', '$2y$10$RbIQrUyTUcwL6PXPNA2kXOsJJOVM7gcwGEhrDdlRxQQLHquqi1gGq', 'profile.jpg', 'jamaah', 'user1@mail.com'),
('60225299ddf9d', 'User5', '$2y$10$2h2mWnNg86PhTG.WL82Yc.itcyvnej5sHmbk66XidMEUodgTUx/BW', '60225302b8d1e.jpg', 'jamaah', 'user5@gmail.com'),
('60441d09b488d', 'Hn n', '$2y$10$/umOjEHnI2PLtHkYPOUVl.f.H/Ms4.2P3WDs8bE6GVLsKgWsYsAdW', '60441d09b788c.jpg', 'jamaah', 'jana@mama');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `rekapitulasi`
--
ALTER TABLE `rekapitulasi`
  ADD PRIMARY KEY (`kode`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `rekapitulasi`
--
ALTER TABLE `rekapitulasi`
  MODIFY `kode` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=151;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `rekapitulasi`
--
ALTER TABLE `rekapitulasi`
  ADD CONSTRAINT `rekapitulasi_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rekapitulasi_ibfk_2` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
