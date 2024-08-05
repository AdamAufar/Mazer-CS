-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 05, 2024 at 08:00 AM
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
-- Database: `db_cleaning_service`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensi`
--

CREATE TABLE `absensi` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `filename` varchar(100) NOT NULL,
  `absen_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `absensi`
--

INSERT INTO `absensi` (`id`, `user_id`, `filename`, `absen_at`) VALUES
(51, 3, '../uploads/absensi/66b04b2a91f9c.jpg', '2024-08-05 10:46:50');

-- --------------------------------------------------------

--
-- Table structure for table `image_tugas_harian`
--

CREATE TABLE `image_tugas_harian` (
  `id` int(11) NOT NULL,
  `tugas_id` int(11) DEFAULT NULL,
  `filename` varchar(100) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL COMMENT '0 = sebelum,\r\n1 = sesudah,\r\n2 = komplain',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `submitted_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `image_tugas_harian`
--

INSERT INTO `image_tugas_harian` (`id`, `tugas_id`, `filename`, `status`, `created_at`, `submitted_by`) VALUES
(21, 1, '../uploads/tugasHarian/66b0657a872bf.jpg', 0, '2024-08-05 12:39:06', 3),
(22, 3, '../uploads/tugasHarian/66b06589ea1c8.jpg', 0, '2024-08-05 12:39:21', 3),
(23, 3, '../uploads/tugasHarian/66b06594a1cbe.jpg', 1, '2024-08-05 12:39:32', 3);

-- --------------------------------------------------------

--
-- Table structure for table `komplain`
--

CREATE TABLE `komplain` (
  `id` int(11) NOT NULL,
  `nama` varchar(200) NOT NULL,
  `tugas_id` int(11) NOT NULL,
  `filename` varchar(100) NOT NULL,
  `followup` varchar(100) NOT NULL DEFAULT '-',
  `status` tinyint(1) NOT NULL COMMENT '0 = bersih,\r\n1 = kurang bersih,\r\n2 = kotor',
  `catatan` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `komplain`
--

INSERT INTO `komplain` (`id`, `nama`, `tugas_id`, `filename`, `followup`, `status`, `catatan`, `created_at`) VALUES
(17, 'hono', 3, '../uploads/komplain/66b068dd8c823.jpg', '-', 2, 'gjvkbcf', '2024-08-05 12:53:33'),
(18, 'honi', 3, '../uploads/komplain/66b0698da1213.jpg', '-', 1, 'fkgmkh', '2024-08-05 12:56:29'),
(19, 'honi', 3, '../uploads/komplain/66b0699260e1d.jpg', '-', 1, 'fkgmkh', '2024-08-05 12:56:34');

-- --------------------------------------------------------

--
-- Table structure for table `lokasi`
--

CREATE TABLE `lokasi` (
  `id` int(11) NOT NULL,
  `lokasi` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lokasi`
--

INSERT INTO `lokasi` (`id`, `lokasi`) VALUES
(1, 'Melawai 10 Lt.2'),
(2, 'Melawai 10 Lt.3');

-- --------------------------------------------------------

--
-- Table structure for table `tugas_harian`
--

CREATE TABLE `tugas_harian` (
  `id` int(11) NOT NULL,
  `lokasi` int(11) NOT NULL,
  `details` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tugas_harian`
--

INSERT INTO `tugas_harian` (`id`, `lokasi`, `details`, `status`) VALUES
(1, 2, 'Lantai sudah di pel dengan bersih', 1),
(2, 2, 'Semua Air Minum karyawan sudah terisi', 0),
(3, 2, 'Jendela sudah di lap', 1),
(4, 2, 'Semua tempat sampah dibuang', 0),
(5, 1, 'Pel Lantai', 1),
(6, 1, 'Isi dispenser', 1),
(7, 1, 'Sapu lantai', 1),
(8, 1, 'Lap jendela', 1),
(9, 2, 'Bersihin meja', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` text NOT NULL,
  `nik` varchar(60) NOT NULL,
  `jabatan` text NOT NULL,
  `status` tinyint(1) NOT NULL COMMENT '0 = tidak aktif, 1 = aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `nama`, `nik`, `jabatan`, `status`) VALUES
(1, 'petugas1', 'pass1', 'Fathan Petugas', '123456489', 'Cleaning Service', 0),
(2, 'petugas2', 'pass2', 'Petugas Dua', '23465789', 'Cleaning Service', 0),
(3, 'admin1', 'admin1', 'Admin Satu', '987678912', 'Admin', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `image_tugas_harian`
--
ALTER TABLE `image_tugas_harian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tugas_id` (`tugas_id`);

--
-- Indexes for table `komplain`
--
ALTER TABLE `komplain`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lokasi`
--
ALTER TABLE `lokasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tugas_harian`
--
ALTER TABLE `tugas_harian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_tugasharian_lokasiid` (`lokasi`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `nik` (`nik`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `image_tugas_harian`
--
ALTER TABLE `image_tugas_harian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `komplain`
--
ALTER TABLE `komplain`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `lokasi`
--
ALTER TABLE `lokasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tugas_harian`
--
ALTER TABLE `tugas_harian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `absensi`
--
ALTER TABLE `absensi`
  ADD CONSTRAINT `absensi_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `image_tugas_harian`
--
ALTER TABLE `image_tugas_harian`
  ADD CONSTRAINT `image_tugas_harian_ibfk_1` FOREIGN KEY (`tugas_id`) REFERENCES `tugas_harian` (`id`);

--
-- Constraints for table `tugas_harian`
--
ALTER TABLE `tugas_harian`
  ADD CONSTRAINT `FK_tugasharian_lokasiid` FOREIGN KEY (`lokasi`) REFERENCES `lokasi` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
